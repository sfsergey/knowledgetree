<?php

class Base_Node extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('nodes');
    $this->hasColumn('id', 'integer', 4, array('unsigned' => 0, 'primary' => true,  'notnull' => true, 'autoincrement' => true));
    $this->hasColumn('depth', 'integer', 4);
    $this->hasColumn('title', 'string', null);
    $this->hasColumn('full_path', 'string', null);
    $this->hasColumn('parent_node_id', 'integer', 4);
    $this->hasColumn('node_type', 'enum', null, array('values' =>  array(  0 => 'Folder', 1 => 'Document', 2 => 'Shortcut' ),'notnull' => true));
    $this->hasColumn('permission_node_id', 'integer', 4);
    $this->hasColumn('unit_id', 'integer', 4);
    $this->hasColumn('owned_by_id', 'integer', 4);
    $this->hasColumn('created_by_id', 'integer', 4);
    $this->hasColumn('created_date', 'integer', 4);
    $this->hasColumn('modified_by_id', 'integer', 4);
    $this->hasColumn('modified_date', 'integer', 4);
    $this->hasColumn('status', 'enum', null, array('values' =>  array(  1 => 'Live', 3 => 'Deleted', 4 => 'Archived' ),'default'=>'Live','notnull' => true));
    $this->hasColumn('metadata_version_id', 'integer', 4);
    $this->hasColumn('description', 'string', null);

  }

  public function setUp()
  {
    parent::setUp();
    $this->hasOne('Base_Node as Parent', array('local' => 'parent_node_id', 'foreign' => 'id'));

    $this->hasOne('Base_DocumentMetadatumVersion as MetadataVersion', array('local' => 'metadata_version_id', 'foreign' => 'id'));

//    $this->hasMany('Base_DocumentContentVersion as ContentVersion', array('local' => 'id', 'foreign' => 'document_id'));

//    $this->hasOne('Base_User as User', array('local' => 'creator_id', 'foreign' => 'id'));
  }

  public function preInsert($event)
  {
      $this->created_by_id = KTapi::getSession()->getUserId();
      $this->created_date = date('Y-m-d H:i:s');
  }

  public function preUpdate($event)
  {
      $this->modified_by_id = KTapi::getSession()->getUserId();
      $this->modified_date = date('Y-m-d H:i:s');
  }



}