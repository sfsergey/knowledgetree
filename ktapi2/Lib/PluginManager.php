<?php
class PluginManager
{
    private static $pluginLocations = array(); // 'plugins'

    private
    function __construct()
    {
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
    function readAllPluginLocations()
    {
        foreach(self::$pluginLocations as $location)
        {

            self::readPluginLocation($location);
        }
    }

    public static
    function readPluginLocation($location)
    {
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
            throw new KTapiException(_kt('Plugin location does not exist: %s', $location));
        }

        $plugins = glob($location . '*Plugin.inc.php');
        foreach($plugins as $plugin)
        {
            require_once($plugin);

            $pluginClass = basename(substr($plugin, 0, -8)); // stripping .inc.php
            if (!class_exists($pluginClass))
            {
                // todo: log something
                continue;
            }
            $class = new $pluginClass;

            $class->register();
        }

        $subdirs = glob($location . '*', GLOB_ONLYDIR);
        foreach($subdirs as $dir)
        {
            self::readPluginLocation($dir);
        }
    }

    /**
     * Adds an action to the plugin registry
     *
     * @param Action $action
     */
    public static
    function registerAction($plugin, $action, $path)
    {
        if(!$action instanceof Action) {
            throw new KTapiException('Action object expected.');
        }
        $action->register($plugin, $path);
    }

    public static
    function registerActionCategory($namespace, $name)
    {
    }

    /**
     * Adds a trigger to the plugin registry
     *
     * @param Trigger $trigger
     */
    public static
    function registerTrigger($trigger)
    {
        if(!$trigger instanceof Trigger) {
            throw new KTapiException('Trigger object expected.');
        }
        $trigger->register();
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