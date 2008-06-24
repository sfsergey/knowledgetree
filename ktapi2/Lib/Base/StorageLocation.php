<?php

class Base_StorageLocation extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('storage_locations');

    $this->addAutoInc('id');
    $this->addNamespace('storage_module_namespace');
    $this->addString('display_name');
    $this->addArray('location_config');
    $this->addGeneralStatus('status');
    $this->addIntegerWithDefault('num_files',0);
    $this->addInteger('disk_usage', 0);
  }

  public function setUp()
  {
  }
}