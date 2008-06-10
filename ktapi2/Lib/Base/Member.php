<?php

class Base_Member extends Doctrine_Record
{
  public function setTableDefinition()
  {
    $this->setTableName('members');
    $this->hasColumn('id', 'integer', 4, array('primary' => true,  'notnull' => true, 'autoincrement' => true));
    $this->hasColumn('member_type', 'enum', null, array('values' =>  array(  0 => 'Group', 1 => 'User', 2=>'Role', 3=>'Unit' ), 'notnull' => true));
    $this->hasColumn('status', 'enum', null, array('values' =>  array(  0 => 'Enabled', 1=>'Disabled', 2 => 'Deleted' ),'default'=>'Enabled','notnull' => true));
    $this->hasColumn('node_id', 'integer', 4);
    $this->hasColumn('unit_id', 'integer', 4);

    $this->option('type', 'INNODB');

  }

  public function setUp()
  {
  }
}