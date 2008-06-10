<?php

class Base_Group extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('groups');
    $this->hasColumn('member_id', 'integer', 4, array('primary' => true,  'notnull' => true ));
    $this->hasColumn('name', 'string', null);
    $this->hasColumn('status', 'enum', null, array('values' =>  array(  0 => 'Enabled', 1 => 'Deleted' ),'default'=>'Enabled','notnull' => true));
    $this->hasColumn('unit_id', 'int', 4);

  }

  public function setUp()
  {
    $this->hasMany('Base_Group as Children', array(
                                     'local' => 'member_id',
                                     'foreign' => 'submember_id',
                                     'owningSide'=> false,
                                     'refClass' => 'Base_MemberSubMember',
                                     ));

    $this->hasMany('Base_Group as Parents', array(
                                     'local' => 'submember_id',
                                     'foreign' => 'member_id',
                                     'refClass' => 'Base_MemberSubMember'
                                     ));

  }

}