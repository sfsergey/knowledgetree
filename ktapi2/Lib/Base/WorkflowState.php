<?php

// DONE

class Base_WorkflowState extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('workflow_states');

        $this->addAutoInc();
        $this->addInteger('workflow_id');
        $this->addString('display_name');
        $this->addGeneralStatus('status', true);
        $this->addBooleanWithDefault('has_voting', 0);
        $this->addBooleanWithDefault('restrict_actions', 0);
    }

    public function setUp()
    {
        $this->hasOne('Base_Workflow', 'Workflow', 'workflow_id', 'id');
    }
}