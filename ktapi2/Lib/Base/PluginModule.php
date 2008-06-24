<?php

class Base_PluginModule extends KTAPI_Record
{

    public function setDefinition()
    {
        $this->setTableName('plugin_modules');

        $this->addAutoInc('id');
        $this->addInteger('plugin_id');
        $this->addEnumeration('module_type', PluginModuleType::get());
        $this->addString('display_name', 255);
        $this->addEnumeration('status', PluginStatus::get(), PluginStatus::ENABLED);
        $this->addString('classname', 255);
        $this->addString('path', null);
        $this->addArray('module_config');
        $this->addIntegerWithDefault('ordering', 0);
        $this->addBooleanWithDefault('can_disable', 1);
        $this->addNamespace('namespace');
        $this->addArray('dependencies');

    }

    public function setUp()
    {
        $this->hasOne('Base_Plugin','Plugin',   'plugin_id',  'id' );
    }

}