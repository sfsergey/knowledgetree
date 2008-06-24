<?php

// DONE

class Base_Config extends KTAPI_Record
{

    public function setDefinition()
    {
        $this->setTableName('config');

        $this->addAutoInc('id');
        $this->addString('config_namespace', 100);
        $this->addString('display_name', 100);
        $this->addString('value', 255);
        $this->addString('default', 255);
        $this->addBooleanWithDefault('can_edit', 1);
        $this->addEnumeration('type', DataType::get());
        $this->addArray('type_config');
        $this->addInteger('config_group_id');
        $this->addString('description', 255);
    }

    public function setUp()
    {
        $this->hasOne('Base_ConfigGroup', 'ConfigGroup', 'config_group_id', 'id');
    }
}