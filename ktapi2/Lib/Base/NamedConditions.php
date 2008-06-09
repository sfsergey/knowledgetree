<?php

class Base_NamedCondition extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('named_conditions');
    $this->hasColumn('id', 'integer', 4, array('unsigned' => 0, 'primary' => true,  'notnull' => true, 'autoincrement' => true));
    $this->hasColumn('name', 'string', null);
    $this->hasColumn('expression', 'string', null);
    $this->hasColumn('status', 'enum', null, array('values' =>  array(  0 => 'DynamicCondition', 1 => 'SavedSearch' ), 'notnull' => true));
  }

  public function setUp()
  {
    parent::setUp();
  }
}