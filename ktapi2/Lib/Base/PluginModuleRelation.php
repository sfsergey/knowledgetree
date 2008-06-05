<?php

class Base_PluginModuleRelation extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('plugin_module_relations');
        $this->hasColumn('plugin_module_namespace', 'string', 255, array('fixed' => false, 'primary' => true,   'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('related_module_namespace', 'string', 255, array('fixed' => false, 'primary' => true,   'notnull' => true, 'autoincrement' => false));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Base_PluginModule as PluginModule', array('local' => 'plugin_module_namespace', 'foreign' => 'namespace', 'onDelete'=>'CASCADE', 'onUpdate'=>'CASCADE'));
        $this->hasOne('Base_PluginModule as RelatedPluginModule', array('local' => 'related_module_namespace', 'foreign' => 'namespace', 'onDelete'=>'CASCADE', 'onUpdate'=>'CASCADE'));
    }

}