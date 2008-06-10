<?php

class Base_MemberEffectiveUser extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('member_effective_users');
    $this->hasColumn('member_id', 'integer', 4, array('primary'=>true, 'notnull'=>true));
    $this->hasColumn('user_member_id', 'integer', 4, array('primary'=>true, 'notnull'=>true));
  }

  public function setUp()
  {
    parent::setUp();
  }
}