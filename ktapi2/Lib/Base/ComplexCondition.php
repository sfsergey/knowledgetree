<?php

// TODO: check setup

class Base_ComplexCondition extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('complex_conditions');

        /*

        This complex  condition is active when the document is of type document type and the condition is true.

         */

        $this->addInteger('documenttype_member_id');
        $this->addString('condition');
        $this->addAutoInc('id');
    }

    public function setUp()
    {
        $this->hasOne('Base_DocumentType', 'DocumentType', 'documenttype_member_id', 'id');
        $this->hasOne('Base_NamedCondition', 'Condition', 'condition_id', 'id');
    }
}