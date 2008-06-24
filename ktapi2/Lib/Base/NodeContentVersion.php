<?php

class Base_NodeContentVersion extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('node_content_versions');

    $this->addIntegerPrimary('node_id', false);
    $this->addInteger('size');
    $this->addInteger('storage_location_id');
    $this->addArray('storage_config');
    $this->addString('md5hash',32);
    $this->addString('language_id', 5);
    $this->addEnumeration('relation', ContentVersionRelation::get());
  }

  public function setUp()
  {
    $this->hasOne('Base_Node','Node', 'node_id', 'id');
  }
}