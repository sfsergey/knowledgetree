<?php

// TODO: search criteria module, scheduled task module - must add registerSearchCriteria and registerScheduledTask into Plugin and update Base_PluginModule.
// TODO: when enabling a module with dependencies, we should provide a forceOverwrite option to allow dependencies to be enabled too.
// TODO: double check the validateRelations() function is working correctly

/**
 * The plugin manager defines the foundation functions used to manage plugins.
 *
 * The application may access plugins stored in different plugin locations. The plugin location does not require
 * plugins to be at the root level only, but may be nested deaper within the plugin location.
 *
 * The requirement for a plugin is that a plugin must be named as follows: ClassNamePlugin.inc.php, where the plugin
 * file includes a class named ClassName.
 *
 */
final class PluginManager
{
    const DISABLED_STATUS = 'Disabled';
    const ENABLED_STATUS = 'Enabled';
    const UNAVAILABLE_STATUS = 'Unavailable';

    /**
     * Locations where plugins may be stored
     *
     * @var array
     */
    private static $pluginLocations = array();

    /**
     * Initialises the plugin manager.
     *
     * @return PluginManager
     */
    private
    function __construct()
    {
        throw new KTapiException('Cannot instantiate a static utility class!');
    }

    /**
     * Register a plugin location with the plugin manager. When calling readAllPluginLocations, all locations added will be scanned.
     *
     * @param string $location
     * @return void
     */
    public static
    function addPluginLocation($location)
    {
        if (strpos($location, KT_ROOT_DIR) === false)
        {
            $location = KT_ROOT_DIR . $location . DIRECTORY_SEPARATOR;
        }

        if (!is_dir($location))
        {
            throw new KTapiException(_kt('Plugin location does not exist: %s', $location));
        }

        self::$pluginLocations[] = $location;
    }

    /**
     * Clears current plugin locations and sets the default.
     *
     * @return void
     */
    public static
    function clearPluginLocations()
    {
        self::$pluginLocations = array();
    }

    /**
     * Scans the plugin locations and registers plugins listed in the different locations.
     *
     * @return void
     */
    public static
    function readAllPluginLocations()
    {
        $logger = LoggerManager::getLogger('plugin.manager');
        $plugins = self::probeAllPluginLocations();
        foreach($plugins as $plugin)
        {
            try
            {
                self::installPlugin($plugin, false);
            }
            catch(Doctrine_Exception $ex)
            {
                $logger->error(_str('Exception: %s', $ex->getMessage()));
                throw $ex;
            }
            catch(Exception $ex)
            {
                 $logger->warn(_str('Exception: %s', $ex->getMessage()));
            }
        }

        self::validateRelations();
    }

    /**
     * Validates relations between plugins and plugin modules.
     * If dependencies on a plugin or plugin module is not available, then the plugin or plugin module is disabled.
     *
     * @return int Returns the number of disabled modules/plugins
     */
    private static
    function validateRelations()
    {
        $disabled = 0;
        $logger = LoggerManager::getLogger('plugin.manager');

        // find plugin modules where related module is not available or is not enabled
        $query = Doctrine_Query::create();
        $rows = $query->select('pmr.plugin_module_namespace as namespace')
                ->from('Base_PluginModuleRelation pmr')
                ->leftJoin('pmr.PluginModule pm')
                ->where('pm.namespace IS NULL OR pm.status != :status')
                ->execute(array(':status' => PluginManager::ENABLED_STATUS ));

        $namespaces = _extractArray($rows, 'namespace');

        if (!empty($namespaces))
        {
            // DOCTRINE BUG: is seems that the where clause is ignored when the whereIn array is empty

            $query = Doctrine_Query::create();
            $rows = $query->update('Base_PluginModule bpm')
                ->set('bpm.status', ':status', array(':status'=>PluginManager::DISABLED_STATUS ))
                ->whereIn('bpm.namespace',$namespaces)
                ->execute();
            $disabled += $rows->count();
        }

        // find plugins where related plugin is not available or is not enabled
        $query = Doctrine_Query::create();
        $rows = $query->select('pr.plugin_namespace as namespace')
                ->from('Base_PluginRelation pr')
                ->leftJoin('pr.Plugin p ')
                ->where('p.namespace IS NULL OR p.status != :status')
                ->execute(array(':status' => PluginManager::ENABLED_STATUS ));

        $namespaces = _extractArray($rows, 'namespace');

        if (!empty($namespaces))
        {
            $query = Doctrine_Query::create();
            $rows = $query->update('Base_Plugin bp')
                ->set('bp.status', ':status', array(':status'=>PluginManager::DISABLED_STATUS ))
                ->whereIn('bpm.namespace',$namespaces)
                ->execute();
            $disabled += $rows->count();
        }

        if ($disabled != 0)
        {
            self::validateRelations();
        }

        return $disabled;
    }

    /**
     * Probes plugin locations looking for plugins.
     *
     * @return array
     */
    public static
    function probeAllPluginLocations()
    {
        $plugins = array();
        foreach(self::$pluginLocations as $location)
        {
            $plugins = array_merge($plugins, self::probePluginLocation($location));
        }

        return $plugins;
    }

    /**
     * Probes a specific plugin location for plugins.
     *
     * @param string $location
     * @return array
     */
    private static
    function probePluginLocation($location)
    {
        $logger = LoggerManager::getLogger('plugin.manager');

        if (strpos($location, KT_ROOT_DIR) === false)
        {
            $location = KT_ROOT_DIR . $location . DIRECTORY_SEPARATOR;
        }

        if (substr($location, -1) != DIRECTORY_SEPARATOR)
        {
            $location .= DIRECTORY_SEPARATOR;
        }

        if ($logger->isDebugEnabled())
        {
            $logger->debug(_str('Probing location %s', $location));
        }

        if (!is_dir($location))
        {
            $logger->error(_str('Plugin location does not exist: %s', $location));
            throw new KTapiException(_kt('Plugin location does not exist: %s', $location));
        }

        $probe = glob($location . '*Plugin.inc.php');
        $plugins = array();
        foreach($probe as $pluginPath)
        {
            require_once($pluginPath);

            $className = substr(basename($pluginPath), 0, -8); // .inc.php

            if (!class_exists($className))
            {
                $logger->warn(_str('Plugin class %s does not exist in %s', $className, $pluginPath));
                continue;
            }

            $plugin = new $className();

            if (!$plugin instanceof Plugin)
            {
                $logger->warn(_str('Class %s is expected to be derived from Plugin in %s', $className, $pluginPath));
                continue;
            }

            $plugins[] = $pluginPath;
        }

        $subdirs = glob($location . '*', GLOB_ONLYDIR);
        foreach($subdirs as $dir)
        {
            $plugins = array_merge($plugins, self::probePluginLocation($dir));
        }

        return $plugins;
    }

    private static
    function removePluginRelations($namespace)
    {
        // remove items from plugin module relation table that are tied to the new plugin

        $query = Doctrine_Query::create();
        $rows = $query->delete()
                ->from('Base_PluginModuleRelation pmr')
                ->where('pmr.plugin_module_namespace IN (SELECT bpm.namespace FROM Base_PluginModule bpm INNER JOIN bpm.Plugin p WHERE p.namespace = :namespace)')
                ->execute(array(':namespace'=>$namespace));

        // remove existing plugin modules linked to new plugin

        $query = Doctrine_Query::create();
        $rows = $query->delete()
                ->from('Base_PluginModule bpm')
                ->where('bpm.plugin_id = (SELECT bp.id FROM Base_Plugin bp WHERE bp.namespace = :namespace)')
                ->execute(array(':namespace'=>$namespace));

        // remove existing plugin relations linked to new plugin

        $rows = $query->delete()
                ->from('Base_PluginRelation pr')
                ->where('pr.plugin_namespace = :namespace')
                ->execute(array(':namespace'=>$namespace));
    }

    /**
     * Install a plugin calling the plugin->register() method.
     *
     * @param string $path Path to the plugin php file.
     * @param boolean $validateRelations Optional. Defaults to true.
     * @return Plugin
     */
    public static
    function installPlugin($path, $validateRelations = true)
    {
        $logger = LoggerManager::getLogger('plugin.manager');
        if ($logger->isDebugEnabled())
        {
            $logger->debug(_str('Installing plugin: %s', $path));
        }

        if (!file_exists($path))
        {
            throw new KTapiException(_kt('Plugin path does not exist: %s', $path));
        }
        require_once($path);

        $pluginClass = basename(substr($path, 0, -8)); // stripping .inc.php
        if (!class_exists($pluginClass))
        {
            throw new KTapiException(_kt('Class does not exist: %s', $pluginClass));
        }
        $class = new $pluginClass();

        if (!$class instanceof Plugin)
        {
            // TODO: possible consider compatability with KTPlugin
            throw new KTapiException(_kt('Plugin is not compatible. The class passed is %s', get_class($class)));
        }

        $namespace = $class->getNamespace();

        // get existing state of modules

        $query = Doctrine_Query::create();
        $modulesState = $query->select('bpm.namespace, bpm.status, bpm.ordering')
                ->from('Base_PluginModule bpm')
                ->where('bpm.plugin_id = (SELECT bp.id FROM Base_Plugin bp WHERE bp.namespace = :namespace)')
                ->execute(array(':namespace'=>$namespace));

        self::removePluginRelations($namespace);

        $class->register();

        // restore the state of existing modules

        // TODO: ideally, this state can be part of the register().
        // this implementation implies that an insert may happen, followed by an update.
        // ideally the insert can just take the old state.
        // however, the code is clean like this, and realistically, this function does not have
        // to be totally optimal as it is used very seldom.

        foreach($modulesState as $state)
        {
            $query = Doctrine_Query::create();
            $rows = $query->update('Base_PluginModule bpm')
                ->set('bpm.status', ':status', array(':status'=>$state->status))
                ->set('bpm.ordering', ':ordering', array(':ordering'=>$state->ordering))
                ->where('bpm.namespace = :namespace')
                ->execute(array(':namespace'=>$namespace));
        }

        if ($validateRelations)
        {
            self::validateRelations();
        }

        return $class;
    }

    /**
     * Uninstalls the plugin by removing database entries.
     *
     * The option 'force_overwrite' must be true to uninstall a plugin where the can_delete setting blocks the uninstall.
     *
     * @param string $namespace
     * @param array $options
     */
    public static
    function uninstallPlugin($namespace, $options = array())
    {
        $condition = ' AND bp.can_delete = :can_delete';
        $conditionParams = array(':namespace'=>$namespace, ':can_delete'=> 1);

        $overwrite = (isset($options['force_overwrite']) && $options['force_overwrite']);

        if ($overwrite)
        {
            $condition = '';
            unset($conditionParams[':can_delete']);
        }

        $query = Doctrine_Query::create();
        $rows = $query->delete('Base_Plugin')
                ->from('Base_Plugin bp')
                ->where('bp.namespace = :namespace' . $condition)
                ->execute($conditionParams);

        if ($overwrite && ($rows === 0))
        {
            if (isset($options['silent']) && !$options['silent'])
            {
                throw new KTapiException(_kt('No effect by uninstall of plugin with namespace: %s', $namespace));
            }
        }
        self::removePluginRelations($namespace);
        self::validateRelations();
    }

    /**
     * Sets the module status.
     *
     * When disabling, 'force_overwrite' option may be set in case the 'can_disable' setting blocks the action.
     *
     * @param string $namespace
     * @param string $status
     * @param array $options
     * @return int Number of plugins/modules disabled by validation
     */
    private static
    function setModuleStatus($namespace, $status, $options=array())
    {
        if (is_string($namespace))
        {
            $namespace = array($namespace);
        }
        if (!is_array($namespace))
        {
            throw new Exception('Array of namespaces expected');
        }
        if (!in_array($status, array(PluginManager::ENABLED_STATUS, PluginManager::DISABLED_STATUS)))
        {
            throw  new Exception('Status must be Enabled or Disabled.');
        }

        $condition = ' AND bpm.can_disable = :can_disable';
        $conditionParams = array(':can_disable'=> 1);

        $overwrite = ($status == PluginManager::DISABLED_STATUS && isset($options['force_overwrite']) && $options['force_overwrite']);

        if ($overwrite)
        {
            $condition = '';
            $conditionParams = array();
        }
        $namespace = "'" . implode("','", $namespace) . "'";

        $logMessage = (($status == PluginManager::DISABLED_STATUS)? 'Disabling' : 'Enabling') . ' plugins with namespaces: ';
        if (isset($options['logMessage']))
        {
            $logMessage = $options['logMessage'];
        }

        $logger = LoggerManager::getLogger('plugin.manager');
        $logger->info($logMessage . $namespace);

        $query = Doctrine_Query::create();
        $rows = $query->update('Base_PluginModule bpm')
                ->set('bpm.status', ':status', array(':status'=>$status))
                ->where("bpm.namespace in ($namespace)" . $condition)
                ->execute($conditionParams);

        if ($overwrite && $rows === 0)
        {
            throw new KTapiException(_kt('No effect by when changing status to %s on module with namespace: %s', $status, $namespace));
        }

        if (isset($options['noValidate']) && $options['noValidate'])
            return 0;
        else
            return self::validateRelations();
    }

    public static
    function getModule($namespace)
    {
        if (empty($namespace) || !is_string($namespace))
        {
            throw new Exception('Namespace not specified.');
        }

        try
        {
            $module = Util_Doctrine::simpleOneQuery('Base_PluginModule', array('namespace'=> $namespace));
        }
        catch(Exception $ex)
        {
            throw new Exception('Module not found');
        }

        $path = $module->path;

        if (!empty($path))
        {
            require_once(_ktpath($path));
        }

        $classname = $module->classname;

        if (empty($classname))
        {
            // TODO: test this
            throw new Exception('Class expected!');
        }
        if (!class_exists($classname))
        {
            throw new Exception('Class could not be resolved.');
        }

        $obj = new $classname($module);

        return $obj;
    }


    /**
     * Enables a plugin module.
     *
     * @param string $namespace
     * @param string $status
     * @param array $options Optional. Reserved
     * @return int Number of plugins/modules disabled by validation
     */
    public static
    function enableModule($namespace, $options=array())
    {
        return self::setModuleStatus($namespace,PluginManager::ENABLED_STATUS,$options);
    }

    /**
     * Disables a plugin module.
     *
     * 'force_overwrite' option may be set in case the 'can_disable' setting blocks the action.
     *
     * @param string $namespace
     * @param string $status
     * @param array $options
     * @return int Number of plugins/modules disabled by validation
     */
    public static
    function disableModule($namespace, $options=array())
    {
        return self::setModuleStatus($namespace,PluginManager::DISABLED_STATUS,$options);
    }

    /**
     * Indicates if the module is enabled.
     * Returns false if the module is not installed or not enabled.
     *
     * @param string $namespace
     * @return boolean
     */
    public static
    function isModuleEnabled($namespace)
    {
        $query = Doctrine_Query::create();
        $rows = $query->select('bpm.status')
                ->from('Base_PluginModule bpm')
                ->innerJoin('bpm.Plugin bp')
                ->where('bpm.namespace = :namespace AND bpm.status = :status AND bp.status = :status')
                ->limit(1)
                ->execute(array(':namespace'=>$namespace, ':status'=>PluginManager::ENABLED_STATUS ));
        return ($rows->count() > 0);
    }

    /**
     * Set the module order.
     *
     * @param string $namespace
     * @param int $order
     */
    public static
    function setModuleOrder($namespace, $order)
    {
        $query = Doctrine_Query::create();
        $rows = $query->update('Base_PluginModule bpm')
                ->set('bpm.ordering', ':ordering', array(':ordering'=>$order))
                ->where('bpm.namespace = :namespace)')
                ->execute(array(':namespace'=>$namespace));

        if ($rows === 0)
        {
            throw new KTapiException(_kt('No effect when changing ordering to %d on module with namespace: %s', $order, $namespace));
        }
    }

    /**
     * Sets the plugin status.
     *
     * When disabling, 'force_overwrite' option may be set in case the 'can_disable' setting blocks the action.
     *
     * @param string $namespace
     * @param string $status
     * @param array $options
     * @return int Number of plugins/modules disabled by validation
     */
    private static
    function setPluginStatus($namespace, $status, $options = array())
    {
        if (is_string($namespace))
        {
            $namespace = array($namespace);
        }
        if (!is_array($namespace))
        {
            throw new Exception('Array of namespaces expected');
        }
        if (!in_array($status, array(PluginManager::ENABLED_STATUS, PluginManager::DISABLED_STATUS)))
        {
            throw  new Exception('Status must be Enabled or Disabled.');
        }

        $condition = ' AND bp.can_disable = :can_disable';
        $conditionParams = array(':can_disable'=> 1);

        $overwrite = ($status == PluginManager::DISABLED_STATUS && isset($options['force_overwrite']) && $options['force_overwrite']);

        if ($overwrite)
        {
            $condition = '';
            $conditionParams = array();
        }

        $namespace = "'" . implode("','", $namespace) . "'";

        $logMessage = (($status == PluginManager::DISABLED_STATUS)? 'Disabling' : 'Enabling') . ' plugins with namespaces: ';
        if (isset($options['logMessage']))
        {
            $logMessage = $options['logMessage'];
        }
        $logger = LoggerManager::getLogger('plugin.manager');
        $logger->info($logMessage  . $namespace);

        $query = Doctrine_Query::create();
        $rows = $query->update('Base_Plugin bp')
                ->set('bp.status', ':status', array(':status'=>$status))
                ->where("bp.namespace in ($namespace)" . $condition)
                ->execute($conditionParams);

        if ($overwrite && $rows === 0)
        {
            throw new KTapiException(_kt('No effect when changing status to %s on plugin with namespace: %s', $status, $namespace));
        }

        if (isset($options['noValidate']) && $options['noValidate'])
            return 0;
        else
            return self::validateRelations();
    }

    /**
     * Disables a plugin.
     *
     * 'force_overwrite' option may be set in case the 'can_disable' setting blocks the action.
     *
     * @param string $namespace
     * @param string $status
     * @param array $options
     * @return int Number of plugins/modules disabled by validation
     */
    public static
    function disablePlugin($namespace, $options = array())
    {
        return self::setPluginStatus($namespace, PluginManager::DISABLED_STATUS, $options);
    }

    /**
     * Enables a plugin.
     *
     * @param string $namespace
     * @param string $status
     * @param array $options Optional. Reserved
     * @return int Number of plugins/modules disabled by validation
     */
    public static
    function enablePlugin($namespace, $options = array())
    {
        return self::setPluginStatus($namespace, PluginManager::ENABLED_STATUS , $options);
    }

    /**
     * Indicates if the plugin is installed.
     *
     * @param string $namespace
     * @return boolean
     */
    public static
    function isPluginRegistered($namespace)
    {
        $query = Doctrine_Query::create();
        $rows = $query->select('status')
                ->from('Base_Plugin bp')
                ->where('bp.namespace = :namespace')
                ->limit(1)
                ->execute(array(':namespace'=>$namespace));

        return $rows->count() == 1;
    }

    /**
     * Indicates if the plugin is enabled.
     * Returns false if the module is not installed or not enabled.
     *
     * @param string $namespace
     * @return boolean
     */
    public static
    function isPluginEnabled($namespace)
    {
        $query = Doctrine_Query::create();
        $rows = $query->select('status')
                ->from('Base_Plugin bp')
                ->where('bp.namespace = :namespace AND bp.status = :status')
                ->limit(1)
                ->execute(array(':namespace'=>$namespace, ':status'=>PluginManager::ENABLED_STATUS ));
        return ($rows->count() > 0);
    }

    /**
     * Sets the plugin order.
     *
     * @param string $namespace
     * @param int $order
     */
    public static
    function setPluginOrder($namespace, $order)
    {
        $query = Doctrine_Query::create();
        $rows = $query->update('Base_Plugin bp')
                ->set('bp.ordering', ':ordering', array(':ordering'=>$order))
                ->where('bp.namespace = :namespace)')
                ->execute(array(':namespace'=>$namespace));

        if ($rows === 0)
        {
            throw new KTapiException(_kt('No effect when changing ordering to %d on plugin with namespace: %s', $order, $namespace));
        }
    }

    /**
     * Get a filtered list of plugin modules based on namespaces.
     *
     * If not null, the status is tested against the plugin module and plugin.
     *
     * @param string $filter
     * @param string $status Optional. Defaults to null.
     * @return array of (namespace, display_name, status, module_type, plugin_name, plugin_status)
     */
    public static
    function getPluginModules($namespaceFilter = '', $status = null)
    {
        $query = Doctrine_Query::create();
        $query->select('pm.namespace, pm.display_name, pm.status, pm.module_type, p.display_name as plugin_name, p.status as plugin_status')
          ->from('Plugin_Module pm')
          ->innerJoin('pm.Plugin p')
          ->where('pm.namespace LIKE :name')
          ->orderBy('pm.display_name');

        if (isset($status))
        {
            $query->addWhere(' AND pm.status = :status', array(':status'=>$status));
            $query->addWhere(' AND p.status = :status', array(':status'=>$status));
        }

        return _flattenArray($query->fetchArray(array(':name' => $namespaceFilter.'%')));
    }

    /**
     * Get a filtered list of plugins based on namespaces.
     *
     * @param string $filter
     * @param string $status
     * @return array of (namespace, display_name, status)
     */
    public static
    function getPlugins($filter = '', $status = null)
    {
        $query = Doctrine_Query::create();
        $query->select('p.namespace, p.display_name, p.status')
          ->from('Base_Plugin p')
          ->where('p.namespace LIKE :name')
          ->orderBy('p.display_name');

        if (isset($status))
        {
            $query->addWhere(' AND p.status = :status', array(':status' => $status));
        }

        return $query->fetchArray(array(':name' => $namespaceFilter.'%'));
    }

    /**
     * Lists new plugins that are in the plugin locations but have not been installed.
     *
     * @return array of (namespace, display_name, path)
     */
    public static
    function getNewPlugins()
    {
        $plugins = self::probeAllPluginLocations();

        $query = Doctrine_Query::create();
        $rows = $query->select('p.path')
          ->from('Base_Plugin p')
          ->execute();
        $existingPaths = array();
        foreach($rows as $row)
        {
            $existingPaths[] = $row->path;
        }

        foreach($plugins as $i=>$pluginPath)
        {
            $plugins[$i] = _relativepath($pluginPath);
        }

        $newPaths = array_diff($plugins, $existingPaths);

        $plugins = array();

        foreach($newPaths as $path)
        {
            // NOTE: probeAllPluginLocations() returns a list of 'validated' and included plugins
            $className = substr(basename($path), 0, -8); // .inc.php

            $plugin = new $className();

            $plugins[] = array( 'namespace' => $plugin->getNamespace(), 'display_name' => $plugin->getDisplayName(), 'path' => $path);
        }

        return $plugins;
    }



    /**
     * Get an action by its namespace
     *
     * @param string $namespace
     * @return Action
     */
    public static
    function getAction($namespace)
    {
        $table = Doctrine::getTable('Plugin_Module');
        $action = $table->findOneByNamespace($namespace);
        return $action;
    }

    /**
     * Get a trigger by its namespace
     *
     * @param string $namespace
     * @return Trigger
     */
    public static
    function getTrigger($namespace)
    {
        $table = Doctrine::getTable('Plugin_Module');
        $trigger = $table->findOneByNamespace($namespace);
        return $trigger;
    }

    public static
    function getActionsByCategory($namespace)
    {
    }

    public static
    function getGroupingProperties($classname)
    {
        static $properties = array();

        if (isset($properties[$classname]))
        {
            return $properties[$classname];
        }

        $query = Doctrine_Query::create();
        $rows = $query->select('m.*')
                    ->from('Plugin_Module m')
                    ->where('m.classname = :classname AND m.module_type = :module_type',
                                array(':classname'=>$classname,':module_type'=>'GroupingProperty'))
//                    ->useResultCache(true)
                    ->execute();

        $groupProperties  = Util_Doctrine::getObjectArrayFromCollection($rows, 'GroupingPropertyModule');
        $ns = array();
        $funcs = array();
        $props = array();

        foreach($groupProperties as $p)
        {
            $namespace = $p->getNamespace();
            $property = $p->getProperty();
            $getter = $p->getGetter();
            $setter = $p->getSetter();
            $ns[$namespace] = $p;

            if (!empty($property))
            {
                $props[$property] = $namespace;
            }

            if (!empty($getter))
            {
                $funcs[$getter] = $namespace;
            }
            if (!empty($setter))
            {
                $funcs[$setter] = $namespace;
            }

        }

        $properties[$classname] = array('namespaces'=>$ns, 'funcs' =>$funcs, 'properties'=>$props);

        return $properties[$classname];
    }
}
?>