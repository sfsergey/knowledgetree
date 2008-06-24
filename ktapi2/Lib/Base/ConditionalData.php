<?php

// TODO: check setup

class Base_ConditionalData extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('conditional_data');

        /*

        Known as simple conditional metadata,
        when a field changes to a specific value, another dependant field must change too.

        The simple conditional metadata may be further restricted by document type and/or unit.


        */

        $this->addInteger('field_member_id');
        $this->addInteger('to_data_id');
        $this->addInteger('effect_member_id');
        $this->addInteger('parent_data_id');
        $this->addInteger('documenttype_member_id');
        $this->addInteger('unit_member_id');
    }

    public function setUp()
    {
        $this->hasOne('Base_Field', 'ChangedField', 'field_member_id', 'id');
        $this->hasOne('Base_Data', 'ToValue', 'to_data_id', 'id');
        $this->hasOne('Base_Field', 'EffectsField', 'effect_member_id', 'id');
        $this->hasOne('Base_DataGroup', 'DataGroup', 'parent_data_id', 'id');
        $this->hasOne('Base_DocumentType', 'DocumentType', 'documenttype_member_id', 'id');
        $this->hasOne('Base_Unit', 'Unit', 'unit_member_id', 'id');
    }
}