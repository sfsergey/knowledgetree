<?php

class Base_Member extends KTAPI_Record
{
  public function setDefinition()
  {
    $this->setTableName('members');

    $this->addAutoInc('id');
    $this->addEnumeration('member_type', MemberType::get());
    $this->addGeneralStatus('status');
    $this->addInteger('node_id');
    $this->addInteger('unit_id');

  }

  public function setUp()
  {
      $this->hasOne('Base_Node', 'Node', 'node_id', 'id');
      $this->hasOne('Base_Unit', 'Unit', 'unit_id', 'member_id');
  }
}