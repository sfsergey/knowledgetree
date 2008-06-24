<?php

// DONE

class Base_AuthenticationSourceGroup extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('authentication_source_groups');

        $this->addAutoInc('id');
        $this->addInteger('auth_source_id');
        $this->addString('display_name', 100);
        $this->addArray('group_config');
    }

    public
    function setUp()
    {
        $this->hasOne('Base_AuthenticationSource','Source', 'auth_source_id','id');
    }

}