<?php

class Base_NodeSubscriptions extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('node_subscriptions');
    $this->hasColumn('node_id', 'integer', 4);
    $this->hasColumn('user_id', 'integer', 4);
    $this->hasColumn('action_namespace', 'string', null);
  }

  public function setUp()
  {
    parent::setUp();
  }
}