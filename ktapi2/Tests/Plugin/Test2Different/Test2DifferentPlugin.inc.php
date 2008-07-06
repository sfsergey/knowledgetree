<?php

class Test2DifferentPlugin extends Plugin
{
    public
    function getConfig()
    {
        return array(
            'namespace' => 'testdiff',
            'display_name' => 'Test 2 Diff Plugin',
            'description' => 'My Test 2 Diff Plugin.',
            'includes' => array('Base_Tag.inc.php'),
            'dependencies' => array('plugin.test'),
            'can_delete' => false,
            'version' => '1.0a',
            'db_version' => 2
        );
    }

    public
    function register()
    {
        parent::register(__FILE__);

        $this->registerAction('Test2DiffAction', 'Test2Action.inc.php');
    }
}

?>