<?php

class Base_MimeTypeExtension extends KTAPI_Record
{
    public function setDefinition()
    {
        $this->setTableName('mime_types');

        $this->addInteger('mime_type_id');
        $this->addString('extension', 100);
    }

    public function setUp()
    {
        $this->hasOne('Base_MimeType','MimeType', 'mime_type_id', 'id');
    }
}