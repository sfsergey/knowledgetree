<?php

class Base_ActiveSession extends Doctrine_Record
{

    public function setTableDefinition()
    {
        $notnull = KTconstant::get(KTconstant::BASE_DB_NOT_NULL);

        $this->setTableName('active_sessions');
        $this->hasColumn('id', 'integer', 4, KTconstant::get(KTconstant::BASE_DB_AUTOINC));
        $this->hasColumn('session', 'string', 100, $notnull);
        $this->hasColumn('user_member_id', 'integer', $notnull);
        $this->hasColumn('start_date', 'timestamp', $notnull);
        $this->hasColumn('ip', 'int', $notnull);
        $this->hasColumn('is_webservice', 'integer', 1, array('notnull'=>true, 'unsigned'=>true, 'default'=>0));
        $this->hasColumn('activity_date', 'timestamp', $notnull);
    }

    public function setUp()
    {
    }
}