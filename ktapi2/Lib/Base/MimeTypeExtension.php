<?php

class Base_MimeTypeExtension extends KTAPI_Record
{
    public function setDefinition()
    {
        $this->setTableName('mime_type_extensions');

        $this->addIntegerPrimary('mime_type_id');
        $this->addStringPrimary('extension', Length::EXTENSION);
    }

    public function setUp()
    {
        $this->hasOne('Base_MimeType','MimeType', 'mime_type_id', 'id');
    }
}