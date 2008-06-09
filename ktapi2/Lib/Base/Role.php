<?php

class Base_Role extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('roles');
    $this->hasColumn('id', 'integer', 4, array('unsigned' => 0, 'primary' => true,  'notnull' => true, 'autoincrement' => true));
    $this->hasColumn('name', 'string', null);
    $this->hasColumn('status', 'enum', null, array('values' =>  array(  0 => 'Enabled', 1 => 'Deleted' ),'default'=>'Enabled','notnull' => true));

  }

  public function setUp()
  {
    parent::setUp();
  }
}