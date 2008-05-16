<?php
class PluginManager
{
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

    /**
     * Adds an action to the plugin registry
     *
     * @param Action $action
     */
    public static
    function registerAction($action)
    {
        if(!$action instanceof Action) {
            throw new KTapiException('Action object expected.');
        }
        $action->register();
    }

    public static
    function registerActionCategory($category)
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