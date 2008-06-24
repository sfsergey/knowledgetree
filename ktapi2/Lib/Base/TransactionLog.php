<?php

class Base_TransactionLog extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('transaction_log');

    $this->addAutoInc('id');
    $this->addTimestamp('log_date');
    $this->addInteger('user_id');
    $this->addInteger('ip');
    $this->addNamespace('action_namespace');
    $this->addArray('action_config');
    $this->addInteger('node_id');
    $this->addString('transaction', null);
  }

  public function setUp()
  {
      $this->hasOne('Base_User', 'User', 'user_id', 'member_id')
      $this->hasOne('Base_Node', 'Node', 'node_id', 'id')
  }
}