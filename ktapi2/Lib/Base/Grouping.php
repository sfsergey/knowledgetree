<?php

class Base_Grouping extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('groupings');
    $this->hasColumn('id', 'integer', 4, array( 'primary'=>true,   'notnull' => true, 'autoincrement'=>true ));
    $this->hasColumn('member_id', 'integer', 4, array( 'notnull' => true ));
    $this->hasColumn('name', 'string', null, array(  'notnull' => true ));
    $this->hasColumn('type', 'enum', null, array('values' =>  array(  0 => 'Group', 1 => 'Role', 2=>'Unit', 3=>'Fieldset',4=>'Field',5=>'DocumentType' ),'notnull' => true));

    $this->option('type', 'INNODB');

    $this->index('member_id', array('fields'=>array('member_id'), 'type'=>'UNIQUE'));

  }

  public function setUp()
  {
    $this->hasOne('Base_Member as Member', array('local' => 'member_id', 'foreign' => 'id','onDelete' => 'CASCADE'));
    $this->hasOne('Base_Group as Group', array('local' => 'id', 'foreign' => 'member_id' ));
  }

    public function preDelete($event)
    {
        $event->skipOperation();
    }

    public function postDelete($event)
    {
        $this->name = $this->name . '_delete_' . $this->id;
        $this->status = 'Deleted';
        $this->save();
    }

}