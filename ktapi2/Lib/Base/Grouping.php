<?php

class Base_Grouping extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('groupings');

    $this->addAutoInc('id');
    $this->addInteger('member_id');
    $this->addString('name', null);
    $this->addEnumeration('type', GroupType::get());
    $this->addInteger('unit_id');

  }

  public function setUp()
  {
    $this->hasOne('Base_Member','Member',  'member_id', 'id' );
    $this->hasOne('Base_Group as Group', 'id', 'member_id');
  }

}