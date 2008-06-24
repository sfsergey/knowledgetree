<?php

// DONE

class Base_WorkflowStateAction extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('workflow_state_actions');

        $this->addAutoInc();
        $this->addInteger('workflow_state_id');
        $this->addNamespace('action_namespace');
        $this->addArray('action_config');
        $this->addInteger('node_id', false); // this may be null. it is a reference for action_config in case a reference is required.
        $this->addIntegerWithDefault('ordering', 0);
    }

    public function setUp()
    {
        $this->hasOne('Base_Workflow', 'Workflow', 'workflow_id', 'id');
        $this->hasOne('Base_Node', 'Node', 'node_id', 'id');
    }
}