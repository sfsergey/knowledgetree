<?php

// DONE

class Base_WorkflowStateRestrictedAction extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('workflow_state_restrict_actions');

        /*

        When in a given state, only allow the following actions

         */

        $this->addInteger('workflow_state_id');
        $this->addNamespace('action_namespace');
    }

    public
    function setUp()
    {
        $this->hasOne('Base_WorkflowState', 'WorkflowState', 'workflow_state_id', 'id');
    }
}