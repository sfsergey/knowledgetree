<?php

// DONE

class Base_ActiveSession extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('active_sessions');

        $this->addAutoInc('id');
        $this->addString('session', 40);
        $this->addInteger('user_member_id');
        $this->addTimestamp('start_date');
        $this->addInteger('user_member_id');
        $this->addUnsignedInteger('ip');
        $this->addEnumeration('client_type', ClientType::get());
        $this->addTimestamp('activity_date', false);
    }

    public function setUp()
    {
        $this->hasOne('Base_User', 'User', 'user_member_id', 'id');
    }
}