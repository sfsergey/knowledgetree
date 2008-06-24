<?php

class Translation extends PluginModule
{
    public
    function register($plugin, $locale, $language, $POfilename)
    {
        if (!file_exists($POfilename))
        {
            throw new KTapiException(_kt('PO file does not exist: %s', $POfilename));
        }
        $namespace = strtolower('translation.' . $locale);

        $this->base = Plugin_Module::registerParams($plugin, 'Translation', $POfilename,
            array(
                'namespace'=>$namespace,
                'classname'=>$locale,
                'display_name'=>$language,
                'module_config'=>'',
                'dependencies'=>''));
    }

    public
    function getLocale()
    {
         return $this->module->classname;
    }

    public
    function getLanguage()
    {
         return $this->module->name;
    }

    public
    function getPOfile()
    {
         return $this->module->path;
    }
}
?>