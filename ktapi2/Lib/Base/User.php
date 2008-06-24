<?php

class Base_User extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('active_users');


//    $this->hasColumn('id', 'integer', 4, KTconstant::get(KTconstant::BASE_DB_AUTOINC));

    $this->addIntegerPrimary('member_id');;
    $this->addString('username', Length::NAME);
    $this->addString('name', Length::NAME);
    $this->addString('email', Length::NAME);
    $this->addString('mobile', Length::NAME);
    $this->addString('language_id', Length::LANGUAGE_ID);
    $this->addTimestamp('last_login_date', false);
    $this->addIntegerWithDefault('invalid_login', 0);
    $this->addStringWithDefault('timezone', 2);
    $this->addGeneralStatus('status', true);
    $this->addInteger('auth_source_id');
    $this->addArray('auth_config');
    $this->addTimestamp('created_date');
  }

  public function setUp()
  {
    $this->hasMany('Base_Group','Groups',  'submember_id', 'member_id', 'Base_MemberSubMember' );

    $this->hasMany('Base_Group','EffectiveGroups',  'user_member_id', 'member_id', 'Base_MemberEffectiveUser' );

        $this->hasOne('Base_AuthenticationSource','AuthenticationSource','auth_source_id',  'id');



  }
}