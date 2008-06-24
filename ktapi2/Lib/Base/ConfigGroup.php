<?php

// DONE

class Base_ConfigGroup extends KTAPI_Record
{

    public function setDefinition()
    {
        $this->setTableName('config_groups');

        $this->addAutoInc('id');
        $this->addString('display_name', 100);
        $this->addString('description', 255);
        $this->addString('group_namespace', 100);
    }

    public function setUp()
    {
    }

}