<?php

class Base_NodeTag extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('node_tags');

    $this->addIntegerPrimary('node_id');
    $this->addIntegerPrimary('tag_id');
  }

  public function setUp()
  {
    $this->hasOne('Base_Node','Node', 'node_id', 'id');
    $this->hasOne('Base_Tag','Tag', 'tag_id', 'id');
  }
}