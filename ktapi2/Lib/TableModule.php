<?php

class TableModule
{
    private $module;

    public
    function __construct($module = null)
    {
        $this->module = $module;
    }

    protected
    function __get($property)
    {
        switch ($property)
        {
            case 'Namespace':
            case 'Name':
            case 'CategoryNamespace':
                return call_user_func_array('get' . $property);
            default:
                throw new KTapiUnknownPropertyException($this, $property);
        }
    }

    public
    function getNamespace()
    {
        return $this->module->namespace;
    }

    public
    function getDisplayName()
    {
        return $this->module->name;
    }

    public
    function register($plugin, $path, $tableName, $baseClass)
    {
        $namespace = strtolower($plugin->getNamespace() . '.table.' . $tableName);

        $this->base = Plugin_Module::registerParams($plugin, 'Table', $path,
            array(
                'namespace'=>$namespace,
                'classname'=>$baseClass,
                'display_name'=>$tableName,
                'module_config'=>null,
                'dependencies'=>''));
    }

    function getOrder()
    {
        return $this->module->order;
    }
    function canDisable()
    {
        return $this->module->can_disable;
    }

    function getDependencies()
    {
        return array();
    }
}
?>