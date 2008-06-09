<?php

class Base_MetadataVersion extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('metadata_versions');
    $this->hasColumn('id', 'integer', 4, array('unsigned' => true, 'primary' => true, 'notnull' => true, 'autoincrement' => true));
    $this->hasColumn('node_id', 'integer', 4, array('unsigned' => true,  'notnull' => true));
    $this->hasColumn('document_type_id', 'integer', 4, array('unsigned' => 0, 'primary' => false, 'default' => '0', 'notnull' => true, 'autoincrement' => false));
    $this->hasColumn('name', 'string', null, array('fixed' => false, 'primary' => false, 'default' => '', 'notnull' => true, 'autoincrement' => false));
    $this->hasColumn('description', 'string', 200, array('fixed' => false, 'primary' => false, 'default' => '', 'notnull' => true, 'autoincrement' => false));
    $this->hasColumn('status_id', 'integer', 4, array('unsigned' => 0, 'primary' => false, 'notnull' => false, 'autoincrement' => false));
    $this->hasColumn('metadata_version', 'integer', 4, array('unsigned' => 0, 'primary' => false, 'default' => '0', 'notnull' => true, 'autoincrement' => false));
    $this->hasColumn('version_created', 'timestamp', null, array('primary' => false, 'default' => '0000-00-00 00:00:00', 'notnull' => true, 'autoincrement' => false));
    $this->hasColumn('version_creator_id', 'integer', 4, array('unsigned' => 0, 'primary' => false, 'default' => '0', 'notnull' => true, 'autoincrement' => false));
    $this->hasColumn('workflow_id', 'integer', 4, array('unsigned' => 0, 'primary' => false, 'notnull' => false, 'autoincrement' => false));
    $this->hasColumn('workflow_state_id', 'integer', 4, array('unsigned' => 0, 'primary' => false, 'notnull' => false, 'autoincrement' => false));
    $this->hasColumn('custom_doc_no', 'string', 255, array('fixed' => false, 'primary' => false, 'notnull' => false, 'autoincrement' => false));
  }

  public function setUp()
  {
    parent::setUp();
    $this->hasOne('Base_Document as Document', array('local' => 'document_id', 'foreign' => 'id'));
    $this->hasOne('Base_DocumentContentVersion as ContentVersion', array('local' => 'content_version_id', 'foreign' => 'id'));
  }

}