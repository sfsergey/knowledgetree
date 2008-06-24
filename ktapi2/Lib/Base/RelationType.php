<?php

class Base_RelationType extends KTAPI_Record
{
  public function setDefinition()
  {
    $this->setTableName('relation_types');

    $this->addAutoInc('id');
    $this->addString('relation_from');
    $this->addString('relation_to');
  }

  public function setUp()
  {
  }
}