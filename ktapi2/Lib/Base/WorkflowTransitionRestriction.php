<?php

// TODO: checked  guard_id

class Base_WorkflowTransitionRestriction extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('workflow_transition_restrictions');

        /*

         if the given transition is available, block it if the guard condition fails

         */

        $this->addInteger('workflow_transition_id');
        $this->addString('condition');
    }

    public
    function setUp()
    {
        $this->hasOne('Base_WorkflowTransition', 'Transition', 'workflow_transition_id', 'id');
    }
}