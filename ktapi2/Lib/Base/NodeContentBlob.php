<?php

class Base_NodeContentBlob extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('node_content_blobs');

    $this->addIntegerPrimary('node_id', false);
    $this->addBlob('content');
    $this->addTimestamp('locked_date', false);
  }

  public function setUp()
  {
    $this->hasOne('Base_Node','Node', 'node_id', 'id');
  }
}