<?php

class Base_DocumentContentVersion extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('document_content_versions');
    $this->hasColumn('id', 'integer', 4, array('unsigned' => true, 'primary' => true, 'notnull' => true, 'autoincrement' => true));
    $this->hasColumn('node_id', 'integer', 4, array('unsigned' => true, 'notnull' => true));
    $this->hasColumn('filename', 'string', null, array('notnull' => true ));
    $this->hasColumn('size', 'integer', 8, array('unsigned'=>true,'notnull' => true));
    $this->hasColumn('mime_id', 'integer', 4, array('unsigned'=>true, 'notnull' => true));
    $this->hasColumn('version', 'float', 2, array('unsigned'=>true,'notnull' => true));
    $this->hasColumn('storage_location_id', 'int', 4, array('notnull' => true));
    $this->hasColumn('storage_config', 'string', null, array('notnull' => true));
    $this->hasColumn('md5hash', 'string', 32, array('fixed' => true, 'notnull' => true ));
  }

  public function setUp()
  {
    parent::setUp();
    $this->hasOne('Base_Document as Document', array('local' => 'node_id', 'foreign' => 'node_id'));


  }

}