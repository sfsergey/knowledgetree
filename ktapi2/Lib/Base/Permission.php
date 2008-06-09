<?php

class Base_Permission extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('permissions');
    $this->hasColumn('id', 'integer', 4, array('unsigned' => 0, 'primary' => true,  'notnull' => true, 'autoincrement' => true));
    $this->hasColumn('display_name', 'string', null);
    $this->hasColumn('namespace', 'string', null);
  }

  public function setUp()
  {
    parent::setUp();
  }
}