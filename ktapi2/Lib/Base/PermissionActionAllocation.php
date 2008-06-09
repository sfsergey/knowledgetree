<?php

class Base_PermissionActionAllocation extends Doctrine_Record
{
  public function setTableDefinition()
  {
    $this->setTableName('permission_action_allocation');
    $this->hasColumn('permission_id', 'integer', 4);
    $this->hasColumn('action_namespace', 'string', null);
  }

  public function setUp()
  {
    parent::setUp();
  }
}