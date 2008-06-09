<?php

class Base_NodeDynamicPermissions extends Doctrine_Record
{
  public function setTableDefinition()
  {
    $this->setTableName('node_dynamic_permissions');
    $this->hasColumn('node_id', 'integer', 4);
    $this->hasColumn('group_id', 'integer', 4);
    $this->hasColumn('dynamic_condition_id', 'integer', 4);
    $this->hasColumn('permission_id', 'integer', 4);
  }

  public function setUp()
  {
    parent::setUp();
  }
}