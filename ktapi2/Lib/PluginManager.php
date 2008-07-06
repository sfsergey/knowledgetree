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
        ValidationUtil::staticClass();
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

        ValidationUtil::directoryExists($location);

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
                throw new KTAPI_Database_DoctrineException($ex);
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
                ->execute(array(':status' => PluginStatus::ENABLED ));

        $namespaces = _extractArray($rows, 'namespace');

        if (!empty($namespaces))
        {
            // DOCTRINE BUG: is seems that the where clause is ignored when the whereIn array is empty

            $query = Doctrine_Query::create();
            $rows = $query->update('Base_PluginModule bpm')
                ->set('bpm.status', ':status', array(':status'=>PluginStatus::DISABLED ))
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
                ->execute(array(':status' => PluginStatus::ENABLED ));

        $namespaces = _extractArray($rows, 'namespace');

        if (!empty($namespaces))
        {
            $query = Doctrine_Query::create();
            $rows = $query->update('Base_Plugin bp')
                ->set('bp.status', '?', array(PluginStatus::DISABLED))
                ->whereIn('bp.namespace',$namespaces)
                ->execute();
            $disabled += $rows;
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

        return array_unique($plugins);
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

        $plugins = array();
        if (!is_dir($location))
        {
            $logger->error(_str('Plugin location does not exist: %s', $location));
            return $plugins;
        }

        $probe = glob($location . '*Plugin.inc.php');

        foreach($probe as $pluginPath)
        {
            require_once($pluginPath);

            $className = substr(basename($pluginPath), 0, -8); // .inc.php

            if (!class_exists($className))
            {
                $logger->warn(_str('Plugin class %s does not exist in %s.', $className, $pluginPath));
                continue;
            }

            $plugin = new $className();

            if (!$plugin instanceof Plugin)
            {
                $logger->warn(_str('Class %s is expected to be derived from Plugin in %s.', $className, $pluginPath));
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

        ValidationUtil::fileExists($path, 'plugin path');

        require_once($path);

        $pluginClass = basename(substr($path, 0, -8)); // stripping .inc.php

        ValidationUtil::classExists($pluginClass, $path);

        $class = new $pluginClass();

        // TODO: possible consider compatability with KTPlugin
        ValidationUtil::validateType($class, 'Plugin');

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
                throw new KTAPI_Database_ChangeExpectedException();
//                throw new KTAPI_Database_ChangeExpectedException('No effect by uninstall of plugin with namespace: %s', $namespace);
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
        ValidationUtil::arrayExpected($namespace, 'namespace');
        ValidationUtil::arrayValueExpected($status, array(PluginStatus::ENABLED, PluginStatus::DISABLED),'status');

        $condition = ' AND bpm.can_disable = :can_disable';
        $conditionParams = array(':can_disable'=> 1);

        $overwrite = ($status == PluginStatus::DISABLED && isset($options['force_overwrite']) && $options['force_overwrite']);

        if ($overwrite)
        {
            $condition = '';
            $conditionParams = array();
        }
        $namespace = "'" . implode("','", $namespace) . "'";

        $logMessage = (($status == PluginStatus::DISABLED)? 'Disabling' : 'Enabling') . ' plugins with namespaces: ';
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
            throw new KTAPI_Database_ChangeExpectedException();
            //throw new KTapiException(_kt('No effect by when changing status to %s on module with namespace: %s', $status, $namespace));
        }

        if (isset($options['noValidate']) && $options['noValidate'])
            return 0;
        else
            return self::validateRelations();
    }

    /**
     * Instanciate a module.
     *
     * @param string $namespace
     * @return mixed A class derived from PluginModule.
     */
    public static
    function getModule($namespace, $expectedType = null)
    {
        ValidationUtil::stringExpected($namespace, 'namespace');

        try
        {
            $module = DoctrineUtil::simpleOneQuery('Base_PluginModule', array('namespace'=> $namespace));
        }
        catch(Exception $ex)
        {
            throw new KTAPI_UnknownModuleException($namespace);
        }

        $path = $module->path;

        if (!empty($path))
        {
            require_once(_ktpath($path));
        }

        $classname = $module->classname;

        ValidationUtil::stringExpected($classname, 'classname');
        ValidationUtil::classExists($classname, $path);

        $obj = new $classname($module);

        ValidationUtil::validateType($obj, $classname);

        if (isset($expectedType))
        {
            ValidationUtil::validateType($obj, $expectedType);
        }

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
        return self::setModuleStatus($namespace,PluginStatus::ENABLED,$options);
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
        return self::setModuleStatus($namespace,PluginStatus::DISABLED,$options);
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
        $count = Doctrine_Query::create()
                ->from('Base_PluginModule bpm')
                ->innerJoin('bpm.Plugin bp')
                ->where('bpm.namespace = :namespace AND bpm.status = :status AND bp.status = :status',
                    array(':namespace'=>$namespace, ':status'=>PluginStatus::ENABLED ))
                ->count();
        return ($count > 0);
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
            throw new KTAPI_Database_ChangeExpectedException();
//            throw new KTapiException(_kt('No effect when changing ordering to %d on module with namespace: %s', $order, $namespace));
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
        ValidationUtil::arrayExpected($namespace, 'namespace');
        ValidationUtil::arrayValueExpected($status, array(PluginStatus::ENABLED, PluginStatus::DISABLED));

        $condition = ' AND bp.can_disable = :can_disable';
        $conditionParams = array(':can_disable'=> 1);

        $overwrite = ($status == PluginStatus::DISABLED  && isset($options['force_overwrite']) && $options['force_overwrite']);

        if ($overwrite)
        {
            $condition = '';
            $conditionParams = array();
        }

        $namespace = "'" . implode("','", $namespace) . "'";

        $logMessage = (($status == PluginStatus::DISABLED )? 'Disabling' : 'Enabling') . ' plugins with namespaces: ';
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
            throw new KTAPI_Database_ChangeExpectedException();
//            throw new KTapiException(_kt('No effect when changing status to %s on plugin with namespace: %s', $status, $namespace));
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
        return self::setPluginStatus($namespace, PluginStatus::DISABLED, $options);
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
        return self::setPluginStatus($namespace, PluginStatus::ENABLED , $options);
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
                ->execute(array(':namespace'=>$namespace, ':status'=>PluginStatus::ENABLED ));
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
     * This is used as part of the reflective
     *
     * @param unknown_type $classname
     * @return unknown
     */
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
                                array(':classname'=>$classname,':module_type'=>'Property'))
                    ->execute();

        $groupProperties  = DoctrineUtil::getObjectArrayFromCollection($rows, 'MemberPropertyModule');
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

    public static
    function getAllActions()
    {
        $actions = DoctrineUtil::simpleQuery('Base_PluginModule',
                        array('module_type'=>'Action', 'status'=>PluginStatus::ENABLED));

        foreach($actions as $idx => $action)
        {
            $path = KT_ROOT_DIR . $action->path;
            if (!file_exists($path))
            {
                continue;
            }

            require_once($path);

            $classname = $action->classname;
            ValidationUtil::classExists($classname, $path);

            $action = new $classname($action);
            ValidationUtil::validateType($action, $classname);

            $actions[$idx] = $action;
        }


        return $actions;
    }

}
?>