<?php

class Base_Document extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('documents');
    $this->hasColumn('node_id', 'integer', 4, array('unsigned' => true, 'primary' => true,  'notnull' => true ));
    $this->hasColumn('checked_out_id', 'integer', 4, array('unsigned' => true));
    $this->hasColumn('checked_out_date', 'timestamp', null, array());
    $this->hasColumn('owner_id', 'integer', 4, array('unsigned' => true));
    $this->hasColumn('is_immutable', 'integer', 1, array('unsigned' => true));
    $this->hasColumn('oem_no', 'string', 255);
  }

  public function setUp()
  {
    parent::setUp();
    $this->hasOne('Base_Node as Node', array('local' => 'node_id', 'foreign' => 'id'));
  }

}