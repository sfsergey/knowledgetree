<?php

// DONE

class Base_Workflow extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('workflows');

        $this->addAutoInc();
        $this->addString('display_name');
        $this->addInteger('start_state_id', false); // initially null, until the first state is created
        $this->addGeneralStatus('status', true);
        $this->addInteger('unit_id');
    }

    public function setUp()
    {
        $this->hasOne('Base_WorkflowState', 'State', 'start_state_id', 'id');
        $this->hasOne('Base_Unit', 'Unit', 'unit_id', 'member_id');
    }
}