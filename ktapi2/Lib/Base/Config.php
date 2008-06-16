<?php

class Base_Config extends Doctrine_Record
{

    public function setTableDefinition()
    {
        $notnull = KTconstant::get(KTconstant::BASE_DB_NOT_NULL);

        $this->setTableName('config');
        $this->hasColumn('id', 'integer', 4, KTconstant::get(KTconstant::BASE_DB_AUTOINC));
        $this->hasColumn('config_namespace', 'string', 100, $notnull);
        $this->hasColumn('display_name', 'string', 100, $notnull);
        $this->hasColumn('value', 'string', 255, $notnull);
        $this->hasColumn('default', 'string', 255, $notnull);
        $this->hasColumn('can_edit', 'tinyint', 1, $notnull);
        $this->hasColumn('type', 'enum', null, $notnull);
        $this->hasColumn('type_config', 'string', null, $notnull);
        $this->hasColumn('config_group_id', 'int', null, $notnull);
        $this->hasColumn('description', 'string', 255, $notnull);
    }

    public function setUp()
    {
    }

}