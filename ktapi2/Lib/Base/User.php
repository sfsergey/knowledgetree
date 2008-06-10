<?php

class Base_User extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('users');
//    $this->hasColumn('id', 'integer', 4, array('primary' => true,  'notnull' => true, 'autoincrement'=>true ));
    $this->hasColumn('member_id', 'integer', 4, array('primary' => true,   'notnull' => true ));
    $this->hasColumn('username', 'string', 100);
    $this->hasColumn('name', 'string', 100);
    $this->hasColumn('password', 'string', 32);
    $this->hasColumn('quota_max', 'string', 4);
    $this->hasColumn('quota_current', 'integer', 4);
    $this->hasColumn('email', 'string', 100);
    $this->hasColumn('mobile', 'string', 20);
    $this->hasColumn('language_id', 'string', 2);
    $this->hasColumn('last_login', 'timestamp', null);
    $this->hasColumn('invalid_login', 'integer', 1, array('default'=>  0));

    $this->option('type', 'INNODB');

    $this->index('member_id', array('fields'=>array('member_id'), 'type'=>'UNIQUE'));


  }

  public function setUp()
  {
      parent::setUp();

    $this->hasMany('Base_Group as Groups', array(
                                     'local' => 'submember_id',
                                     'foreign' => 'member_id',
                                     'refClass' => 'Base_MemberSubMember'
                                     ));

  }
}