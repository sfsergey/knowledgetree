<?php

// DONE

class Base_WorkflowTransitions extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('workflow_transitions');

        /*


         */

        $this->addAutoInc();
        $this->addInteger('from_state_id');
        $this->addInteger('to_state_id');
        $this->addString('display_name');
        $this->addGeneralStatus('status', true);
        $this->addInteger('votes_required', false);
        $this->addBooleanWithDefault('has_restrictions', false);
        $this->addEnumeration('period_type', Frequency::get());
        $this->addString('period_value', 20);
    }

    public function setUp()
    {
        $this->hasOne('Base_Workflow', 'Workflow', 'workflow_id', 'id');
    }
}