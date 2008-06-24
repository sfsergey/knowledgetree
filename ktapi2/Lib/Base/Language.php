<?php

class Base_Language extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('languages');

    $this->addString('id', 5);
    $this->addString('name', 100);
  }

  public function setUp()
  {
  }

}