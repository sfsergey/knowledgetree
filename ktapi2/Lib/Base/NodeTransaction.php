<?php

class Base_NodeTransaction extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('node_transactions');
    $this->hasColumn('id', 'integer', 4); // autoinc
    $this->hasColumn('node_id', 'integer', 4);
    $this->hasColumn('tran_date', 'timestamp', null);
    $this->hasColumn('user_id', 'string', null);
    $this->hasColumn('action_namespace', 'string', null);
    $this->hasColumn('action_params', 'string', null);
    $this->hasColumn('action_log', 'string', null);
  }

  public function setUp()
  {
    parent::setUp();
  }
}