<?php

class Base_Role extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('roles');

    $this->addIntegerPrimary('member_id');
    $this->addString('name', null);
    $this->addGeneralStatus('status');
    $this->addInteger('unit_id');
  }

  public function setUp()
  {
    $this->hasMany('Base_Group','Groups', 'member_id', 'submember_id', 'Base_MemberSubMember' );
    $this->hasMany('Base_User','Users',  'member_id',  'submember_id', 'Base_MemberSubMember' );
    $this->hasMany('Base_User','EffectiveUsers',  'member_id', 'user_member_id',  'Base_MemberEffectiveUser' );
  }
}