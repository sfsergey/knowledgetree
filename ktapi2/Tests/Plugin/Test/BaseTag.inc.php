<?php

class Base_Tag extends KTAPI_Record
{
    public function setDefinition()
    {
        $this->setTableName('tag');
        $this->addAutoInc('id');
    }
}