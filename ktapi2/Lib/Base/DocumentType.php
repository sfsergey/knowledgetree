<?php

class Base_DocumentType extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('document_types');

    $this->addIntegerPrimary('member_id');
    $this->addString('name',  Length::NAME );
    $this->addGeneralStatus('status', true);
    $this->addInteger('unit_id');
  }

  public function setUp()
  {
    $this->hasMany('Base_MemberPropertyValue','Properties', 'member_id', 'member_id' );
  }

}