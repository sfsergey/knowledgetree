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

    public static
    function registerAction($action)
    {
    }

    public static
    function registerCategory($category)
    {
    }

    public static
    function registerTrigger($trigger)
    {
    }

    public static
    function getAction($namespace)
    {
    }

    public static
    function getTrigger($namespace)
    {
    }

    public static
    function getActionsByCategory($namespace)
    {
    }

    public static
    function getNamespaces($filter = '')
    {
        $query = Doctrine_Query::create();
        $query->select('pm.*')
          ->from('Plugin_Module pm')
          ->innerJoin('pm.Plugin p');

        $sql = $query->getSql();

        print $sql;
//        die;

        $namespaces = $query->execute();
        return $namespaces;
    }
}
?>