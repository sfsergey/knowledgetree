<?php

class Base_GroupingProperty extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('grouping_properties');
    $this->hasColumn('id', 'integer', 4, array('unsigned'=>true, 'primary'=>true,   'notnull' => true ));
    $this->hasColumn('grouping_member_id', 'integer', 4, array(   'notnull' => true ));
    $this->hasColumn('property_namespace', 'string', null, array(  'notnull' => true ));
    $this->hasColumn('value', 'string', null, array(  'notnull' => true ));

    $this->option('type', 'INNODB');


  }

  public function setUp()
  {
    $this->hasOne('Base_Group as Group', array(
                                     'local' => 'grouping_member_id',
                                     'foreign' => 'member_id'
                                     ));

  }
}