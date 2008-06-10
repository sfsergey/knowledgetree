<?php

class Base_MemberSubMember extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('member_submembers');
    $this->hasColumn('member_id', 'integer', 4, array('primary'=>true, 'notnull'=>true));
    $this->hasColumn('submember_id', 'integer', 4, array('primary'=>true, 'notnull'=>true));
  }

  public function setUp()
  {
  }
}