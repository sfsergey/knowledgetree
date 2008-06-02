<?php
class PluginManager
{
    private static $pluginLocations = array(); // 'plugins'

    private $plugins;
    private $modules;

    private
    function __construct()
    {
        $this->plugins = array();
        $this->modules = array();

        PluginManager::clearPluginLocations();

        $this->load();
    }

    /**
     * Enter description here...
     *
     * @return PluginManager
     */
    public static
    function get()
    {
        static $singleton;
        if(is_null($singleton)){
            $singleton = new PluginManager();
        }
        return $singleton;
    }

    public
    function load($activeOnly = true)
    {
        $db = KTapi::getDb();

        $dql = 'FROM Base_Plugin bp WHERE bp.status = :status AND bp.PluginModules.status = :status';

        $plugins = $db->query($dql, array('status'=>'Enabled'));

        foreach($plugins as $plugin)
        {
            print "{$plugin->namespace}\n";
            foreach($plugin->PluginModules as $module)
            {
                print "\t{$module->namespace}\n";
            }
        }
    }

    /**
     * Register a plugin location with the plugin manager. When calling readAllPluginLocations, all locations added will be scanned.
     *
     * @param string $location
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

    public static
    function clearPluginLocations()
    {
        self::$pluginLocations = array();
    }

    public static
    function readAllPluginLocations()
    {
        foreach(self::$pluginLocations as $location)
        {
            self::readPluginLocation($location);
        }

        self::validateRelations();
    }

    private static
    function validateRelations()
    {
        $query = Doctrine_Query::create();
        $rows = $query->select('pmr.plugin_module_namespace AS namespace')
                ->distinct()
                ->from('Base_PluginModuleRelation pmr')
                ->leftJoin('pmr.PluginModule pm')
                ->where('pm.namespace IS NULL')
                ->execute();
        if ($rows->count() > 0)
        {
           $namespaces = array();
           foreach($rows as $row)
           {
                $namespaces[] = $row->namespace;
           }
           self::disableModule($namespaces);
        }

        $query = Doctrine_Query::create();
        $rows = $query->select('pr.plugin_namespace AS namespace')
                ->distinct()
                ->from('Base_PluginRelation pr')
                ->leftJoin('pr.Plugin p')
                ->where('p.namespace IS NULL')
                ->execute();
        if ($rows->count() > 0)
        {
           $namespaces = array();
           foreach($rows as $row)
           {
                $namespaces[] = $row->namespace;
           }
           self::disablePlugin($namespaces);
        }

    }

    private static
    function readPluginLocation($location)
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

        if (!is_dir($location))
        {
            $logger->error(_str('Plugin location does not exist: %s', $location));
            throw new KTapiException(_kt('Plugin location does not exist: %s', $location));
        }

        $plugins = glob($location . '*Plugin.inc.php');
        foreach($plugins as $plugin)
        {
            try
            {
                self::installPlugin($plugin, false);
            }
            catch(Doctrine_Exception $ex)
            {
                $logger->error(_str('readPluginLocation: exception: %s', $ex->getMessage()));
                throw $ex;
            }
            catch(Exception $ex)
            {
                 $logger->warn(_str('readPluginLocation: exception: %s', $ex->getMessage()));
            }
        }

        $subdirs = glob($location . '*', GLOB_ONLYDIR);
        foreach($subdirs as $dir)
        {
            self::readPluginLocation($dir);
        }
    }

    public static
    function installPlugin($path, $validateRelations = true)
    {
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

        $query = Doctrine_Query::create();
        $rows = $query->delete()
                ->from('Base_PluginModuleRelation pmr')
                ->where('pmr.plugin_module_namespace IN (
                    SELECT bpm.namespace
                    FROM Base_PluginModule bpm
                    INNER JOIN Base_Plugin p ON p.id = bpm.plugin_id
                    WHERE p.namespace = :namespace
                    )')
                ->execute(array(':namespace'=>$namespace));


        $query = Doctrine_Query::create();
        $rows = $query->delete()
                ->from('Base_PluginModule bpm')
                ->where('bpm.plugin_id = (SELECT bp.id FROM Base_Plugin bp WHERE bp.namespace = :namespace)')
                ->execute(array(':namespace'=>$namespace));

        $query = Doctrine_Query::create();
        $rows = $query->delete()
                ->from('Base_PluginRelation pr')
                ->where('pr.plugin_namespace = :namespace)')
                ->execute(array(':namespace'=>$namespace));

        $class->register();

        if ($validateRelations)
        {
            self::validateRelations();
        }

        return $class;
    }

    public static
    function uninstallPlugin($namespace, $options = array())
    {
        $condition = ' AND bp.can_delete = :can_delete';
        $conditionParams = array(':namespace'=>$namespace, ':can_delete'=> 1);

        $overwrite = (isset($options['force_overwrite']) && $options['force_overwrite']);

        if ($overwrite)
        {
            $condition = '';
            $conditionParams = array();
        }

        $query = Doctrine_Query::create();
        $rows = $query->delete('Base_Plugin')
                ->from('Base_Plugin bp')
                ->where('bp.namespace = :namespace' . $condition)
                ->execute($conditionParams);

        if ($overwrite && ($rows === 0))
        {
            throw new KTapiException(_kt('No effect by uninstall of plugin with namespace: %s', $namespace));
        }
    }

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


        $condition = ' AND bpm.can_disable = :can_disable';
        $conditionParams = array(':can_disable'=> 1);

        $overwrite = ($status == 'Disabled' && isset($options['force_overwrite']) && $options['force_overwrite']);

        if ($overwrite)
        {
            $condition = '';
            $conditionParams = array();
        }
        $namespace = "'" . implode("','", $namespace) . "'";
        $query = Doctrine_Query::create();
        $rows = $query->update('Base_PluginModule bpm')
                ->set('bpm.status', ':status', array(':status'=>$status))
                ->where("bpm.namespace in ($namespace)" . $condition)
                ->execute($conditionParams);

        if ($overwrite && $rows === 0)
        {
            throw new KTapiException(_kt('No effect by when changing status to %s on module with namespace: %s', $status, $namespace));
        }
    }

    public static
    function enableModule($namespace, $options=array())
    {
        self::setModuleStatus($namespace,'Enabled',$options);
    }

    public static
    function disableModule($namespace, $options=array())
    {
        self::setModuleStatus($namespace,'Disabled',$options);
    }

    public static
    function isModuleEnabled($namespace)
    {
        $query = Doctrine_Query::create();
        $rows = $query->select('status')
                ->from('Base_PluginModule bpm')
                ->where('bpm.namespace = :namespace')
                ->limit(1)
                ->execute(array(':namespace'=>$namespace));
        if ($rows->count() == 0)
        {
            return false;
        }
        return ($rows[0]->status == 'Enabled');
    }

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

        $condition = ' AND bp.can_disable = :can_disable';
        $conditionParams = array(':namespace'=>$namespace, ':can_disable'=> 1);

        $overwrite = ($status == 'Disabled' && isset($options['force_overwrite']) && $options['force_overwrite']);

        if ($overwrite)
        {
            $condition = '';
            $conditionParams = array();
        }

        $namespace = "'" . implode("','", $namespace) . "'";
        $query = Doctrine_Query::create();
        $rows = $query->update('Base_Plugin bp')
                ->set('bp.status', ':status', array(':status'=>$status))
                ->where("bp.namespace in ($namespace)" . $condition)
                ->execute($conditionParams);

        if ($overwrite && $rows === 0)
        {
            throw new KTapiException(_kt('No effect when changing status to %s on plugin with namespace: %s', $status, $namespace));
        }
    }

    public static
    function disablePlugin($namespace, $options = array())
    {
        self::setPluginStatus($namespace, 'Disabled', $options);
    }

    public static
    function enablePlugin($namespace, $options = array())
    {
        self::setPluginStatus($namespace, 'Enabled', $options);
    }

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

    public static
    function isPluginEnabled($namespace)
    {
        $query = Doctrine_Query::create();
        $rows = $query->select('status')
                ->from('Base_Plugin bp')
                ->where('bp.namespace = :namespace')
                ->limit(1)
                ->execute(array(':namespace'=>$namespace));
        if ($rows->count() == 0)
        {
            return false;
        }
        return ($rows[0]->status == 'Enabled');
    }

    public static
    function isPluginCompatible($namespace)
    {

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

    /**
     * Get a filtered list of namespaces
     *
     * @param string $filter
     * @return array
     */
    public static
    function getNamespaces($filter = '')
    {
        $query = Doctrine_Query::create();
        $query->select('pm.namespace')
          ->from('Plugin_Module pm')
          ->innerJoin('pm.Plugin p')
          ->where('pm.namespace LIKE :name');

        $namespaces = $query->execute(array(':name' => $filter.'%'), Doctrine::FETCH_ARRAY);
        return Util_Doctrine::getColumnFromArray('namespace', $namespaces);
    }
}
?>