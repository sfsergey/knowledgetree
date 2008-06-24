<?php

class Base_Node extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('nodes');

    $this->addAutoInc('id');
    $this->addInteger('parent_node_id', false);
    $this->addString('full_path', null);
    $this->addEnumeration('node_type', NodeType::get());
    $this->addInteger('permission_node_id');
    $this->addInteger('unit_id');
    $this->addInteger('depth');
    $this->addString('title', 255);
    $this->addInteger('owned_by_id');
    $this->addInteger('created_by_id');
    $this->addTimestamp('created_date');
    $this->addInteger('modified_by_id', false);
    $this->addTimestamp('modified_date', false);
    $this->addEnumeration('status', NodeStatus::get());
    $this->addInteger('node_metadata_version_id', false);
    $this->addInteger('locked_by_id', false);
    $this->addTimestamp('locked_date', false);
    $this->addBooleanWithDefault('has_document_type_restriction', 0);
  }

  public function setUp()
  {
    $this->hasOne('Base_Node','Parent', 'parent_node_id', 'id');
    $this->hasOne('Base_Node','PermissionNode', 'permission_node_id', 'id');
    $this->hasOne('Base_Unit','Unit', 'unit_id', 'member_id');
    $this->hasOne('Base_User','OwnedBy', 'owned_by_id', 'member_id');
    $this->hasOne('Base_User','CreatedBy', 'created_by_id', 'member_id');
    $this->hasOne('Base_User','ModifiedBy', 'modified_by_id', 'member_id');
    $this->hasOne('Base_Unit','Unit', 'node_metadata_version_id', 'int');
    $this->hasOne('Base_User','LockedBy', 'locked_by_id', 'member_id');
  }
}