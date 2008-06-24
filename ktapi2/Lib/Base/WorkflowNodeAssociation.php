<?php

// DONE

class Base_WorkflowNodeAssociation extends KTAPI_Record
{
    public
    function setDefinition()
    {
        /*

            if action_date is null, then it is used for workflow node association. when a node is added to a folder, it is associated with
            the workflow automatically.

            if the action_date is not null, it the node is assigned to the workflow in a specific date.
        */
        $this->setTableName('workflow_auto_start');

        $this->addInteger('node_id');
        $this->addInteger('workflow_id');
        $this->addTimestamp('action_date', false); // may be null
    }

    public function setUp()
    {
        $this->hasOne('Base_Node', 'Node', 'node_id', 'id');
        $this->hasOne('Base_Workflow', 'Workflow', 'workflow_id', 'id');
    }
}