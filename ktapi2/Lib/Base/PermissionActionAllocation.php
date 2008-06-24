<?php

class Base_PermissionActionAllocation extends KTAPI_Record
{
  public function setDefinition()
  {
    $this->setTableName('permission_action_allocation');

    $this->addIntegerPrimary('permission_id');
    $this->addStringPrimary('action_namespace');
  }

  public function setUp()
  {
    $this->hasOne('Base_Permission', 'Permission', 'permission_id', 'id');
  }
}