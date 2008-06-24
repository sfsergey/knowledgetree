<?php

class Base_NodeMetadataFieldValue extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('node_metadata_field_values');

    $this->addIntegerPrimary('node_metadata_version_id');
    $this->addIntegerPrimary('field_member_id');
    $this->addString('value');
  }

  public function setUp()
  {
    $this->hasOne('Base_NodeMetadataVersion', 'MetadataVersion', 'node_metadata_version_id', 'id');
    $this->hasOne('Base_Field', 'Field', 'field_member_id', 'id');
  }

}