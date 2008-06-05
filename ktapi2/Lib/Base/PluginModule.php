<?php

class Base_PluginModule extends Doctrine_Record
{

    public function setTableDefinition()
    {
        $this->setTableName('plugin_modules');
        $this->hasColumn('id', 'integer', 4, array('unsigned' => 1, 'primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->hasColumn('plugin_id', 'integer', 4, array('unsigned' => 1, 'primary' => false, 'default' => '', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('module_type', 'enum', null, array('fixed' => false, 'values' =>  array(  0 => 'Action', 1 => 'Trigger', 2 => 'Table', 3 => 'Field', 4 => 'Language', 5 => 'UnitTest'  ), 'primary' => false, 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('display_name', 'string', 255, array('fixed' => false, 'primary' => false, 'default' => '', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('status', 'enum', null, array(  'values' =>  array(  'Enabled',    'Disabled'  ), 'primary' => false, 'default' => 'Enabled', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('classname', 'string', 255, array('fixed' => false, 'primary' => false, 'default' => '', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('path', 'string', null, array('fixed' => false, 'primary' => false, 'default' => '', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('module_config', 'string', null, array('fixed' => false, 'primary' => false, 'notnull' => false, 'autoincrement' => false));
        $this->hasColumn('ordering', 'integer', 4, array('unsigned' => 0, 'primary' => false, 'default' => '0', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('can_disable', 'integer', 1, array('unsigned' => 1, 'primary' => false, 'default' => '0', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('namespace', 'string', 255, array('fixed' => false, 'primary' => false, 'default' => '', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('dependencies', 'string', null, array('fixed' => false, 'primary' => false, 'default' => '', 'notnull' => true, 'autoincrement' => false));

        $this->index('namespace', array('fields'=>array('namespace'=>array()),  'type'=>'unique' ));

    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Base_Plugin as Plugin', array('local' => 'plugin_id', 'foreign' => 'id', 'onDelete'=>'CASCADE', 'onUpdate'=>'CASCADE'));
    }

}