<?php

class Base_NodeMemberPermission extends KTAPI_Record
{
  public function setDefinition()
  {
    $this->setTableName('node_member_permissions');

    $this->addIntegerPrimary('node_id');
    $this->addIntegerPrimary('member_id');
    $this->addInteger('permission_id');
  }

  public function setUp()
  {
    $this->hasOne('Base_Node', 'Node', 'node_id', 'id');
    $this->hasOne('Base_Member', 'Member', 'member_id', 'id');
    $this->hasOne('Base_Permission', 'Permission', 'permission_id', 'id');
  }
}