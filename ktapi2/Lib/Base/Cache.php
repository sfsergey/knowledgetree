<?php

// DONE

class Base_Cache extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('cache');

        $this->addStringPrimary('cache_namespace', 100);
        $this->addString('cache', null);
        $this->addTimestamp('cache_date');
        $this->addIntegerPrimary('user_member_id');
    }

    public function setUp()
    {
        $this->hasOne('Base_User', 'User', 'user_member_id', 'id');
    }
}