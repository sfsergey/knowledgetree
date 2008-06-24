<?php

// TODO: check ChildData

class Base_Data extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('data');

        $this->addAutoInc('id');
        $this->addInteger('data_member_id');
        $this->addString('displayValue');
        $this->addString('storedValue', false);
        $this->addInteger('parent_data_id');
    }

    public
    function setUp()
    {
        $this->hasOne('Base_DataGroup','DataGroup', 'data_member_id','member_id');
        $this->hasOne('Base_Data','ParentData', 'parent_data_id','member_id');
        $this->hasMany('Base_Data','ChildData', 'id','parent_data_id');
    }

}