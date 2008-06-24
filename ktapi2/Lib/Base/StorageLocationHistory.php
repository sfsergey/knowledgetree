<?php

class Base_StorageLocationHistory extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('storage_location_history');

    $this->addAutoInc('id');
    $this->addInteger('storage_location_id');
    $this->addInteger('user_id');
    $this->addString('history');
    $this->addTimestamp('log_date');
  }

  public function setUp()
  {
  }
}