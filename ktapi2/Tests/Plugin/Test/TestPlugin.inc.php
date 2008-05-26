<?php

//require_once('TestAction.inc.php');
//require_once('TestTrigger.inc.php');
//require_once('TestLanguage.inc.php');

class TestPlugin extends Plugin
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
    function register()
    {
//        $this->includeFile('PEAR.php');

        parent::register(__FILE__);

        $this->registerAction('TestAction', 'TestAction.inc.php');
        //$this->registerTrigger('TestTrigger', 'TestTrigger.inc.php');
        //$this->registerLangauge(new TestLanguage());

        //$this->registerUnitTest('TestUnitTest'); // registerUnitTest($classname, [$path]) if path is not provided, then $classname.inc.php
    }
}

?>