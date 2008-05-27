<?php

class FieldModule
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

    public abstract
    function getDisplayName()
    {
        return $this->module->name;
    }

    public
    function register($plugin, $tableName, $fieldName, $className, $property)
    {
        $this->base = Plugin_Module::registerParams($plugin, 'Field', '',
            array(
                'classname'=>$className,
                'display_name'=>$property,
                'module_config'=>array('tablename'=>$tableName, 'fieldname'=>$fieldName),
                'dependencies'=>''));
    }

    public
    function getTableName()
    {
         return $this->module->module_config['tablename'];
    }

    public
    function getFieldName()
    {
         return $this->module->module_config['fieldname'];
    }

    public
    function getClassName()
    {
         return $this->module->classname;
    }

    public
    function getPropertyName()
    {
        return $this->getDisplayName();
    }

    public
    function getOrder()
    {
        return $this->module->order;
    }

    public
    function canDisable()
    {
        return $this->module->can_disable;
    }

    public
    function getDependencies()
    {
        return array();
    }
}
?>