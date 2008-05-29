<?php

class UnitTest extends PluginModule
{
    public
    function getDisplayName()
    {
        return _kt('Unit Test: %s', parent::getDisplayName());
    }

    public
    function register($plugin, $className, $path)
    {
        if (!file_exists($path))
        {
            throw new KTapiException(_kt('Unit test does not exist: %s', $path));
        }
        $namespace = strtolower($plugin->getNamespace() . '.unittest.' . $className);

        $this->base = Plugin_Module::registerParams($plugin, 'UnitTest', $path,
            array(
                'namespace'=>$namespace,
                'classname'=>$className,
                'display_name'=> $className,
                'module_config'=>'',
                'dependencies'=>''));
    }
}
?>