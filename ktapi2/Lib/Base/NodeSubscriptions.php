<?php

class Base_NodeSubscriptions extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('node_subscriptions');

    $this->addIntegerPrimary('node_id');
    $this->addIntegerPrimary('user_id');
    $this->addNamespace('action_namespace', false);
  }

  public function setUp()
  {
    $this->hasOne('Base_Node','Node', 'node_id', 'id');
    $this->hasOne('Base_User','User', 'user_id', 'member_id');
  }
}