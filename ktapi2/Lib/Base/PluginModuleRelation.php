<?php

class Base_PluginModuleRelation extends KTAPI_Record
{
    public function setDefinition()
    {
        $this->setTableName('plugin_module_relations');

        $this->addNamespace('plugin_module_namespace');
        $this->addNamespace('related_module_namespace');
    }

    public function setUp()
    {
        $this->hasOne('Base_PluginModule','PluginModule', 'plugin_module_namespace',  'namespace');
        $this->hasOne('Base_PluginModule','RelatedPluginModule',  'related_module_namespace', 'namespace' );
    }

}