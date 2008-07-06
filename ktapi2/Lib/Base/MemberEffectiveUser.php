<?php

class Base_MemberEffectiveUser extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('member_effective_users');

    $this->addIntegerPrimary('member_id');
    $this->addIntegerPrimary('user_member_id');
  }

  public function setUp()
  {
      //$this->hasOne('Base_Group', 'Group', 'member_id', 'member_id');
      $this->hasOne('Base_Member', 'Member', 'member_id', 'id');
      $this->hasOne('Base_User', 'User', 'user_member_id', 'member_id');
  }
}