<?php

class Base_NodeMemberPermission extends Doctrine_Record
{
  public function setTableDefinition()
  {
    $this->setTableName('node_member_permissions');
    $this->hasColumn('node_id', 'integer', 4);
    $this->hasColumn('member_id', 'integer', 4);
    $this->hasColumn('permission_id', 'integer', 4);
  }

  public function setUp()
  {
    parent::setUp();
  }
}