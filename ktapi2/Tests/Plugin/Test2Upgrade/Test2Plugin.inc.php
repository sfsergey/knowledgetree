<?php

class Test2Plugin extends Plugin
{
    public
    function getDisplayName()
    {
        return _kt('Test Plugin');
    }

    public
    function getNamespace()
    {
        return 'plugin.test';
    }

    public
    function getDbVersion()
    {
        return 1;
    }

    public
    function register()
    {
        parent::register(__FILE__);

        $this->registerAction('Test2Action', 'Test2Action.inc.php');
    }
}

?>