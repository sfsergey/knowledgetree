<?php

// DONE

class Base_AuthenticationSource extends KTAPI_Record
{

    public
    function setDefinition()
    {
        $this->setTableName('authentication_sources');

        $this->addAutoInc('id');
        $this->addString('auth_module_namespace', 100);
        $this->addString('display_name', 100);
        $this->addArray('auth_config');
        $this->addGeneralStatus('status', true);
        $this->addBooleanWithDefault('is_system', 0);
    }

    public
    function setUp()
    {
        $this->hasOne('Base_PluginModule','AuthenticationProvider', 'auth_module_namespace','namespace');
    }

}