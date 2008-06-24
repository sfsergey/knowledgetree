<?php

class Base_MemberPropertyValue extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('member_property_values');

    $this->addAutoInc('id');
    $this->addInteger('grouping_member_id');
    $this->addNamespace('property_namespace');
    $this->addString('value');
  }

  public function setUp()
  {
    $this->hasOne('Base_Group','Group', 'grouping_member_id', 'member_id');
  }
}