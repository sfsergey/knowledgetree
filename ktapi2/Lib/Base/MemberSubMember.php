<?php

class Base_MemberSubMember extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('member_submembers');

    $this->addIntegerPrimary('member_id');
    $this->addIntegerPrimary('submember_id');
  }

  public function setUp()
  {
      $this->hasOne('Base_Member', 'Member', 'member_id', 'id');
      $this->hasOne('Base_Member', 'SubMember', 'submember_id', 'id');
  }
}