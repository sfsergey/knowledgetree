<?php

class Base_Unit extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('units');
    $this->hasColumn('member_id', 'integer', 4, array('primary' => true,  'notnull' => true ));
    $this->hasColumn('name', 'string', null);
    $this->hasColumn('status', 'enum', null, array('values' =>  array(  0 => 'Enabled', 1 => 'Deleted' ),'default'=>'Enabled','notnull' => true));
    $this->hasColumn('unit_id', 'int', 4);
  }

  public function setUp()
  {
  }
}