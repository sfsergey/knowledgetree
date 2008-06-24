<?php

// TODO: check setup

class Base_ComplexConditionData extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('complex_conditional_data');

        /*

        Based on the complex condition being identifyied, we can derive the fields that must change and the datasets they must make available.

         */

        $this->addInteger('complex_condition_id');
        $this->addInteger('effect_member_id');
        $this->addAutoInc('parent_data_id');
    }

    public function setUp()
    {
        $this->hasOne('Base_ConditionalData', 'ConditionalData', 'complex_condition_id', 'id');
        $this->hasOne('Base_DataGroup', 'DataGroup', 'parent_data_id', 'id');
        $this->hasOne('Base_Field', 'EffectsField', 'effect_member_id', 'id');

    }
}