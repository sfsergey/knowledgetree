<?php

class Base_NodeMetadataVersion extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('metadata_versions');

    $this->addAutoInc('id');
    $this->addInteger('node_id');
    $this->addString('name');
    $this->addString('description');
    $this->addEnumeration('status', NodeStatus::get());
    $this->addIntegerWithDefault('metadata_version', 0);
    $this->addInteger('created_by_id');
    $this->addTimestamp('created_date');
  }

  public function setUp()
  {
    $this->hasOne('Base_Node', 'Node', 'node_id', 'id');
    $this->hasOne('Base_User', 'User', 'created_by_id', 'id');
  }

}