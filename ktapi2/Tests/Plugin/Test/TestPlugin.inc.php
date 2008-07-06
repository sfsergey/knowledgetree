<?php

class TestPlugin extends Plugin
{
    public
    function getConfig()
    {
        return array(
            'namespace' => 'test',
            'display_name' => 'Test Plugin',
            'description' => 'My test plugin.',
            'version' => '0.1',
            'includes' => array('Base_Tag.inc.php'),
            'dependencies' => array()
        );
    }

    public
    function register()
    {
        parent::register(__FILE__);

        $this->registerAction('TestAction', 'TestAction.inc.php');

        $this->registerTable('tag', 'Base_Tag', 'BaseTag.inc.php'); // tablename, basename, $path
        $this->registerField('Base_Document', 'custom_document_no', 'Document', 'CustomDocumentNo'); // table, field, class, property

        $this->registerTranslation('fr_FR', 'Français', 'TestLanguage.po');

        $this->registerTrigger('TestTrigger', 'TestTrigger.inc.php');

        $this->registerUnitTest('TestUnitTest', 'TestUnitTest.inc.php'); // registerUnitTest($classname, [$path]) if path is not provided, then $classname.inc.php
    }

}

?>