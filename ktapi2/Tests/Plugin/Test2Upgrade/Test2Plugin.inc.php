<?php

class Test2Plugin extends Plugin
{
    public
    function getConfig()
    {
        return array(
            'namespace' => 'test',
            'display_name' => 'Test Plugin',
            'db_version' => 1
        );
    }

    public
    function register()
    {
        parent::register(__FILE__);

        $this->registerAction('Test2Action', 'Test2Action.inc.php');
    }
}

?>