<?php

class Base_ConfigGroup extends Doctrine_Record
{

    public function setTableDefinition()
    {
        $notnull = KTconstant::get(KTconstant::BASE_DB_NOT_NULL);

        $this->setTableName('config_groups');
        $this->hasColumn('id', 'integer', 4, KTconstant::get(KTconstant::BASE_DB_AUTOINC));
        $this->hasColumn('display_name', 'string', 100, $notnull);
        $this->hasColumn('description', 'string', 255, $notnull);
        $this->hasColumn('group_namespace', 'string', 255, $notnull);
    }

    public function setUp()
    {
    }

}