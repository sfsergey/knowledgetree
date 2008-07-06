<?php

class Base_MemberPropertyValue extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('member_property_values');

    $this->addAutoInc('id');
    $this->addInteger('member_id');
    $this->addNamespace('property_namespace');
    $this->addString('value', Length::VALUE);
  }

  public function setUp()
  {
    $this->hasOne('Base_Group','Group', 'member_id', 'member_id');
  }
}