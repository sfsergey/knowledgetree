<?php

// DONE

class Base_WorkflowNodeTransitionVote extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('workflow_node_transition_votes');

        /*

        when a state has 'has_voting' enabled, all votes are registered in this table.

        (node, state, user) is the primary key

        the result is the transition selected and the date.

        */


        $this->addInteger('node_id');
        $this->addInteger('workflow_state_id');
        $this->addInteger('user_member_id');
        $this->addInteger('transition_id');
        $this->addTimestamp('transition_date');
    }

    public function setUp()
    {
        $this->hasOne('Base_Node', 'Node', 'node_id', 'id');
        $this->hasOne('Base_WorkflowState', 'State', 'workflow_state_id', 'id');
        $this->hasOne('Base_User', 'User', 'user_member_id', 'member_id');
        $this->hasOne('Base_WorkflowTransition', 'Transition', 'transition_id', 'id');
    }
}