<?php

// DONE

class Base_EmailTemplate extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('email_templates');

        $this->addAutoInc('id');
        $this->addString('namespace', 100);
        $this->addString('language_id', 5);
        $this->addString('subject', 255);
        $this->addString('body', null);
        $this->addString('html_body', null);
    }

    public
    function setUp()
    {
        $this->hasOne('Base_Language','Language', 'language_id','id');
    }

}