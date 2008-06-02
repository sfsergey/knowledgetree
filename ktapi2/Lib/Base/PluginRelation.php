<?php

class Base_PluginRelation extends Doctrine_Record
{

    public function setTableDefinition()
    {
        $this->setTableName('plugin_relations');
        $this->hasColumn('plugin_namespace', 'string', 255, array('fixed' => false, 'primary' => true, 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('related_plugin_namespace', 'string', 255, array('fixed' => false, 'primary' => true,   'notnull' => true, 'autoincrement' => false));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Base_Plugin as Plugin', array('local' => 'plugin_namespace', 'foreign' => 'namespace'));
        $this->hasOne('Base_Plugin as RelatedPlugin', array('local' => 'related_plugin_namespace', 'foreign' => 'namespace'));
    }

}