<?php

class Base_Shortcut extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('shortcuts');
    $this->hasColumn('node_id', 'integer', 4, array('unsigned' => true, 'primary' => true, 'notnull' => true));
    $this->hasColumn('shortcut_node_id', 'integer', 4, array('unsigned' => true, 'notnull' => true));
  }

  public function setUp()
  {
    parent::setUp();
  }

}