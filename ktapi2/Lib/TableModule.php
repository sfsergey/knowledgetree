<?php

class TableModule extends PluginModule
{
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
}
?>