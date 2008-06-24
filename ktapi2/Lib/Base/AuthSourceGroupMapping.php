<?php

// DONE

class Base_AuthenticationSourceGroupMapping extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('authentication_source_group_mapping');

        $this->addInteger('auth_group_id', 100);
        $this->addInteger('group_member_id', 100);
    }

    public
    function setUp()
    {
        $this->hasOne('Base_AuthenticationSourceGroup','Source', 'auth_source_id','id');
        $this->hasOne('Base_Group','Group', 'group_member_id','member_id');
    }

}