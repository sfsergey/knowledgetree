<?php

// DONE

class Base_WorkflowStateVote extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('workflow_state_voters');

        /*

        When in a given state, only allow the member voters.

         */

        $this->addInteger('workflow_state_id');
        $this->addInteger('member_id');
    }

    public
    function setUp()
    {
        $this->hasOne('Base_WorkflowState', 'WorkflowState', 'workflow_state_id', 'id');
        $this->hasOne('Base_Member', 'Member', 'member_id', 'id');
    }
}