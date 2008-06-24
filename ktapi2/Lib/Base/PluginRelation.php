<?php

class Base_PluginRelation extends KTAPI_Record
{

    public function setDefinition()
    {
        $this->setTableName('plugin_relations');

        $this->addNamespace('plugin_namespace');
        $this->addNamespace('related_plugin_namespace');

    }

    public function setUp()
    {
        $this->hasOne('Base_Plugin','Plugin', 'plugin_namespace',  'namespace' );
        $this->hasOne('Base_Plugin','RelatedPlugin',   'related_plugin_namespace',   'namespace' );
    }

}