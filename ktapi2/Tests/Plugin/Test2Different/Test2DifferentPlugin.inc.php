<?php

class Test2DifferentPlugin extends Plugin
{
    public
    function getDisplayName()
    {
        return _kt('Test 2 Diff Plugin');
    }

    public
    function getNamespace()
    {
        return 'plugin.testdiff';
    }

    public
    function getDbVersion()
    {
        return 2;
    }

    public
    function getDependencies()
    {
        return array('plugin.test');
    }


    public
    function canDelete()
    {
        return false;
    }

    public
    function getVersion()
    {
        return '1.0a';
    }


    public
    function register()
    {
        parent::register(__FILE__);

        $this->registerAction('Test2DiffAction', 'Test2Action.inc.php');
    }
}

?>