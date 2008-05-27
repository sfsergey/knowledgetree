<?php

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
        $this->includeFile('Base_Tag.inc.php');

        parent::register(__FILE__);

        $this->registerAction('TestAction', 'TestAction.inc.php');

        $this->registerTable('tag', 'Base_Tag', 'Base_Tag.inc.php'); // tablename, basename, $path
        $this->registerField('Base_Document', 'custom_document_no', 'Document', 'CustomDocumentNo'); // table, field, class, property


        //$this->registerLanguage('fr_FR', 'Français', 'TestLanguage.po');

        //$this->registerTrigger('TestTrigger', 'TestTrigger.inc.php');

        //$this->registerUnitTest('TestUnitTest'); // registerUnitTest($classname, [$path]) if path is not provided, then $classname.inc.php
    }

    public
    function upgrade()
    {
        // TODO
        throw new Exception('todo');
    }
}

?>