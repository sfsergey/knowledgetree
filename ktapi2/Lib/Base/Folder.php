<?php

class Base_Folder extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('folders');
    $this->hasColumn('node_id', 'integer', 4, array('unsigned' => true, 'primary' => true, 'notnull' => true));

    $this->hasColumn('restrict_document_types', 'integer', 1, array('unsigned' => 0, 'primary' => false, 'default' => '0', 'notnull' => true, 'autoincrement' => false));
    $this->hasColumn('owner_id', 'integer', 4, array('unsigned' => 0, 'primary' => false, 'notnull' => false, 'autoincrement' => false));
    $this->hasColumn('workflow_id', 'integer', 4, array('unsigned' => 0, 'primary' => false, 'notnull' => false, 'autoincrement' => false));
  }

  public function setUp()
  {
    parent::setUp();
    $this->hasOne('Base_Folder as Folder', array('local' => 'parent_id', 'foreign' => 'id'));

    $this->hasMany('Base_Document as Document', array('local' => 'id', 'foreign' => 'folder_id'));
  }

}