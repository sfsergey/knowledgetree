<?php

class Base_Field extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('fields');

    $this->addIntegerPrimary('member_id');
    $this->addString('name', Length::NAME );
    $this->addGeneralStatus('status', true);
    $this->addInteger('unit_id');
  }

  public function setUp()
  {
    $this->hasOne('Base_Fieldset','Fieldset','submember_id','member_id','Base_MemberSubMember');
    $this->hasOne('Base_Unit','Unit','unit_id','member_id');
  }
}