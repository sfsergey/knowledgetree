<?php

class Base_Plugin extends Doctrine_Record
{

    public function setTableDefinition()
    {
        $this->setTableName('plugins');
        $this->hasColumn('id', 'integer', 4, array('unsigned' => 1, 'primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->hasColumn('display_name', 'string', 255, array('fixed' => false, 'primary' => false, 'default' => '', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('path', 'string', null, array('fixed' => false, 'primary' => false, 'default' => '', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('status', 'enum', 11, array('fixed' => false, 'values' =>  array( 0 => 'Enabled',  1 => 'Disabled',  2 => 'Unavailable', ), 'primary' => false, 'default' => 'Disabled', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('version', 'integer', 4, array('unsigned' => 0, 'primary' => false, 'default' => '1', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('can_disable', 'integer', 1, array('unsigned' => 1, 'primary' => false, 'default' => '1', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('can_delete', 'integer', 1, array('unsigned' => 1, 'primary' => false, 'default' => '1', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('ordering', 'integer', 4, array('unsigned' => 0, 'primary' => false, 'default' => '0', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('namespace', 'string', 255, array('fixed' => false, 'primary' => false, 'default' => '', 'notnull' => true, 'autoincrement' => false));
        $this->hasColumn('dependencies', 'string', null, array('fixed' => false, 'primary' => false, 'default' => '', 'notnull' => true, 'autoincrement' => false));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Base_PluginModule as PluginModules', array('local' => 'id', 'foreign' => 'plugin_id'));
    }

}