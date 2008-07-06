<?php

class Base_Group extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('groups');

    $this->addIntegerPrimary('member_id');
    $this->addString('name',  Length::NAME );
    $this->addGeneralStatus('status', true);
    $this->addInteger('unit_id');
  }

  public function setUp()
  {
    $this->hasMany('Base_MemberPropertyValue','Properties', 'member_id', 'member_id' );
    $this->hasMany('Base_Group','Children', 'member_id', 'submember_id', 'Base_MemberSubMember' );
    $this->hasMany('Base_Group','Parents',  'submember_id', 'member_id', 'Base_MemberSubMember' );
    $this->hasMany('Base_User','Users', 'member_id', 'submember_id', 'Base_MemberSubMember' );
    $this->hasMany('Base_User','EffectiveUsers',  'member_id', 'user_member_id', 'Base_MemberEffectiveUser' );
  }

}