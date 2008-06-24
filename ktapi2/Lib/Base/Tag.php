<?php

class Base_Tag extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('tags');

    $this->addAutoInc('id');
    $this->addString('tag');
    $this->addInteger('unit_id');
  }

  public function setUp()
  {
    $this->hasOne('Base_Unit','Unit', 'unit_id', 'member_id');
  }
}