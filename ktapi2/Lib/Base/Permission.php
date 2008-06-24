<?php

class Base_Permission extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('permissions');

    $this->addAutoInc('id');
    $this->addString('display_name');
//    $this->addNamespace('namespace');  - i don't think we need this one.
  }

  public function setUp()
  {
    parent::setUp();
  }
}