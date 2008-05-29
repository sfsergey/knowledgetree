<?php

class FieldModule extends PluginModule
{
    public
    function register($plugin, $tableName, $fieldName, $className, $property)
    {
        $namespace = strtolower('field.' . $tableName . '.' . $fieldName);

        $this->base = Plugin_Module::registerParams($plugin, 'Field', '',
            array(
                'namespace'=>$namespace,
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
}
?>