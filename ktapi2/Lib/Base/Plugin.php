<?php

class Base_Plugin extends KTAPI_Record
{

    public function setDefinition()
    {
        $this->setTableName('plugins');

        $this->addAutoInc('id');
        $this->addString('display_name', Length::NAME);
        $this->addString('path' , Length::FULL_PATH );
        $this->addEnumerationWithDefault('status', PluginStatus::get(), PluginStatus::DISABLED);
        $this->addIntegerWithDefault('version', 1);
        $this->addBooleanWithDefault('can_disable',1);
        $this->addBooleanWithDefault('can_delete', 1);
        $this->addIntegerWithDefault('ordering',0);
        $this->addNamespace('namespace');
        $this->addArray('config');

    }

    public function setUp()
    {
        $this->hasMany('Base_PluginModule','PluginModules', 'id', 'plugin_id');
    }

}