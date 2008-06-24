<?php

class Base_NodeDynamicPermissions extends KTAPI_Record
{
  public function setDefinition()
  {
    $this->setTableName('node_dynamic_permissions');

    $this->addIntegerPrimary('node_id');
    $this->addIntegerPrimary('group_id');
    $this->addIntegerPrimary('condition');
    $this->addInteger('permission_id');
  }

  public function setUp()
  {
    $this->hasOne('Base_Node', 'Node', 'node_id', 'id');
    $this->hasOne('Base_Group', 'Group', 'group_id', 'id');
    $this->hasOne('Base_Permission', 'Permission', 'permission_id', 'id');
  }
}