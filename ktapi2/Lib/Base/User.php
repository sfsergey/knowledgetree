<?php

class Base_User extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $notnull = KTconstant::get(KTconstant::BASE_DB_NOT_NULL);


    $this->setTableName('active_users');
//    $this->hasColumn('id', 'integer', 4, KTconstant::get(KTconstant::BASE_DB_AUTOINC));
    $this->hasColumn('member_id', 'integer', 4, array('primary' => true,   'notnull' => true ));
    $this->hasColumn('username', 'string', 100, $notnull);
    $this->hasColumn('name', 'string', 100, $notnull);
    $this->hasColumn('email', 'string', 100, $notnull);
    $this->hasColumn('mobile', 'string', 20, $notnull);
    $this->hasColumn('language_id', 'string', 2, $notnull);
    $this->hasColumn('last_login_date', 'timestamp', null);
    $this->hasColumn('invalid_login', 'integer', 1, array('default'=>  0));
    $this->hasColumn('timezone', 'float', 2);
    $this->hasColumn('status', 'enum', null, array('values' =>  array(  0 => 'Enabled', 1 => 'Disabled', 2=>'Deleted' ) ,'notnull' => true));
    $this->hasColumn('auth_source_id', 'integer', 4, $notnull);
    $this->hasColumn('auth_config', 'array', $notnull);
    $this->hasColumn('created_date', 'timestamp', $notnull);


    $this->option('type', 'INNODB');

    $this->index('member_id', array('fields'=>array('member_id'), 'type'=>'UNIQUE'));
  }

  public function setUp()
  {
      parent::setUp();

    $this->hasMany('Base_Group as Groups', array(
                                     'local' => 'submember_id',
                                     'foreign' => 'member_id',
                                     'refClass' => 'Base_MemberSubMember',
                                     ));

    $this->hasMany('Base_Group as EffectiveGroups', array(
                                     'local' => 'user_member_id',
                                     'foreign' => 'member_id',
                                     'refClass' => 'Base_MemberEffectiveUser',
                                     ));

        $this->hasOne('Base_AuthenticationSource as AuthenticationSource', array('local' => 'auth_source_id', 'foreign' => 'id'));



  }
}