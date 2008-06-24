<?php

// DONE

class Base_WorkflowStatePermission extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('workflow_state_permissions');

        /*

        The effective permissions on nodes in a given state and owned by a specific member.

         */

        $this->addInteger('workflow_state_id');
        $this->addInteger('member_id');
        $this->addInteger('permission_id');
    }

    public
    function setUp()
    {
        $this->hasOne('Base_WorkflowState', 'WorkflowState', 'workflow_state_id', 'id');
        $this->hasOne('Base_Permission', 'Permission', 'permission_id', 'id');
        $this->hasOne('Base_Member', 'Member', 'member_id', 'id');
    }
}