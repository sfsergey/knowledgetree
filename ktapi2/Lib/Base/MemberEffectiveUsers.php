<?php

class Base_MemberEffectiveUsers extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('member_effective_users');
    $this->hasColumn('member_id', 'integer', 4);
    $this->hasColumn('user_member_id', 'integer', 4);
  }

  public function setUp()
  {
    parent::setUp();
  }
}