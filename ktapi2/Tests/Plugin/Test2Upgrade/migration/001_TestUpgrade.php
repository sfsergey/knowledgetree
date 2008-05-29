<?php

class TestUpgrade extends KTAPI_Migration
{
    public
    function up()
    {
        $this->addColumn('tag', 'name', 'string',array('length'=>100));
    }

    public
    function down()
    {
        $this->removeColumn('tag', 'name');
    }
}

?>