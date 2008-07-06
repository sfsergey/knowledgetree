<?php

class Base_MimeTypeGroup extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('mime_type_groups');

    $this->addIntegerPrimary('member_id');
    $this->addString('name', Length::NAME);
    $this->addGeneralStatus('status', true);
    $this->addInteger('unit_id');
  }

  public function setUp()
  {
    $this->hasMany('Base_MimeTypes','MimeTypes', 'member_id', 'submember_id', 'Base_MemberSubMember' );
  }

}