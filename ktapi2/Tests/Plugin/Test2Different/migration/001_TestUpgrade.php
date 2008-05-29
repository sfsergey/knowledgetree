<?php

if (!class_exists('Test2DiffUpgrade'))
{

class Test2DiffUpgrade extends KTAPI_Migration
{
    public
    function up()
    {
        $this->addColumn('tag', 'name2', 'string',array('length'=>100));
    }

    public
    function down()
    {
        $this->removeColumn('tag', 'name2');
    }
}

}

?>