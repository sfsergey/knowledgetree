<?php

class Base_Fieldset extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('fieldsets');

    $this->addIntegerPrimary('member_id');
    $this->addString('name', null);
    $this->addGeneralStatus('status');
    $this->addInteger('unit_id');
  }

  public function setUp()
  {
    $this->hasOne('Base_Field','Fields','member_id','submember_id','Base_MemberSubMember');
    $this->hasOne('Base_Unit','Unit','unit_id','member_id');
  }
}