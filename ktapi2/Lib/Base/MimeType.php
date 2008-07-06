<?php

class Base_MimeType extends KTAPI_Record
{
    public function setDefinition()
    {
        $this->setTableName('mime_types');

        $this->addAutoInc('id');
        $this->addString('mime_type', 100);
        $this->addString('name', 100);
        $this->addString('icon', 20);
        $this->addNamespace('extractor_namespace');
        $this->addInteger('group_member_id');
        $this->addString('extensions', 100);
    }

    public function setUp()
    {
        $this->hasOne('Base_MimeTypeGroup','MimeTypeGroup', 'group_member_id', 'member_id');
        $this->hasMany('Base_MimeTypeExtension','Extensions', 'id', 'mime_type_id');
    }
}