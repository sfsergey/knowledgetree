<?php

class Base_MemberSubMembers extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('member_submembers');
    $this->hasColumn('member_id', 'integer', 4, array('primary'=>true, 'notnull'=>true));
    $this->hasColumn('submember_id', 'integer', 4, array('primary'=>true, 'notnull'=>true));
  }

  public function setUp()
  {
      $this->hasOne('Base_Member as Member', array('local'=>'member_id', 'foreign'=>'id','onDelete' => 'CASCADE'));
      $this->hasOne('Base_Member as SubMember', array('local'=>'submember_id', 'foreign'=>'id','onDelete' => 'CASCADE'));

  }
}