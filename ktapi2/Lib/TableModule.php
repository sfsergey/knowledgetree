<?php

class TableModule extends PluginModule
{
    public
    function register($plugin, $path, $tableName, $baseClass)
    {
        $namespace = strtolower('table.' . $tableName);

        $this->base = Plugin_Module::registerParams($plugin, 'Table', $path,
            array(
                'namespace'=>$namespace,
                'classname'=>$baseClass,
                'display_name'=>$tableName,
                'module_config'=>null,
                'dependencies'=>'')
        );


        require_once($path);

        if (!class_exists($baseClass))
        {
            throw new KTapiException(_kt('Class %s expected in $path but was not found.',$baseClass));
        }

        $tableClass = new $baseClass();
        $table = $tableClass->getTable();
        $table->export();
    }
}
?>