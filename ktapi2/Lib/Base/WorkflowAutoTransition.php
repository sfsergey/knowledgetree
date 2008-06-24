<?php

// DONE

class Base_WorkflowAutoTransition extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('workflow_auto_transition');

        /*

        This is part of time based notifications or records management.

        When the action_date is reached, if the node is in the state of the transition, the transition will be taken.

         */

        $this->addInteger('node_id');
        $this->addInteger('transition_id');
        $this->addTimestamp('action_date');
    }

    public function setUp()
    {
        $this->hasOne('Base_Node', 'Node', 'node_id', 'id');
        $this->hasOne('Base_WorkflowTransition', 'Transition', 'transition_id', 'id');
    }
}