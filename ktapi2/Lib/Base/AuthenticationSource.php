<?php

class Base_AuthenticationSource extends Doctrine_Record
{

    public function setTableDefinition()
    {
        $notnull = KTconstant::get(KTconstant::BASE_DB_NOT_NULL);

        $this->setTableName('authentication_sources');
        $this->hasColumn('id', 'integer', 4, KTconstant::get(KTconstant::BASE_DB_AUTOINC));
        $this->hasColumn('auth_module_namespace', 'string', 100, $notnull);
        $this->hasColumn('display_name', 'string', 100, $notnull);
        $this->hasColumn('auth_config', 'array', null, $notnull);
        $this->hasColumn('status', 'enum', null, KTconstant::get(KTconstant::BASE_DB_GENERAL_STATUS));
        $this->hasColumn('is_system', 'int', 1, $notnull);
    }

    public function setUp()
    {
        $this->hasOne('Base_PluginModule as AuthenticationProvider', array('local' => 'auth_module_namespace', 'foreign' => 'namespace'));
    }

}