<?php


class Workflow_Engine
{
    public static
    function scheduledWorkflowActions($now = null)
    {
        self::autoWorkflow($now);
        self::autoTransition($now);
    }

    private static
    function autoWorkflow($now = null)
    {
        /*

        this is to be called by schedulled task.

        when now = workflow_node_associations.action_date, set node.workflow = workflow_node_associations.workflow


        things to consider - what if node is already in a workflow.

        */
    }

    private static
    function autoTransition($now = null)
    {
        /*

        this is to be called by schedulled task.

            select nodes where node.state = workflow_auto_transitions.transition.state and action_date = now

            foreach($nodes)
            {
                $node->transition(workflow_auto_transitions.transition)
                remove entry from workflow_auto_transitions
            }

            consider - ensure transition is not a voting related


        */
    }

    public static
    function addedNode($node)
    {
        /*

            consider - node association overrides document type association (opposite of illustration below)

            check if node.DocumentType is in workflow_document_type_associations. if so, then node.Workflow = workflow_document_type_associations.Workflow

            if (node.workflow != null)
            {
                based on workflow_node_associations.action_date = null
                {
                    if node added to workflow_node_associations.node_id
                    {
                        node.Workflow = workflow_node_associations.Workflow
                    }
                }
            }



         */
    }

    public static
    function isTransitionPossible($node, $transition)
    {
        /*

        allowed_tran = node.state.transitions

        return false if transition not in allowed_tran


        if (state.hasvoting and vote count < min required)
            {
                  return false;
            }

        if node.status.transition has restriction
        {
            return false if condition fails
        }


        return true


        */
    }

    public static
    function getNodeActions($node)
    {
        /*

        if node.state.restrict actions, then avail_actions = node.state.restricted_actions, else avail_actions = all_actions

        then filter actions based on user permissions

         */
    }

    public static
    function isDeadlocked($node)
    {
        /*

        $transitions = 0;
         $deadlocked = 0;
         foreach($node.state.transitions)
         {
            $transitions++;
            $deadlocked = isTransitionPossible($node, $transition)
         }

         return ($transitions > 0 && $transitions == $deadlocked)


        */
    }

    public static
    function getNodeTransitions($node)
    {
        /*

             allowed_tran = node.state.transitions

             foreac(allowed_tran)
             {
                if  isTransitionPossible(node, tran) trans += tran;
             }
             return trans;

        */
    }


    public static
    function performTransition($node, $transition, $options = array('validate'=>true))
    {
        /*

        throw exception if !isTransitionPossible(node, tran), otherwise:

        foreach(transition.nextstate.actions)
        {
            perform action
        }

        node.state = transtion.nextstate

        */

    }


}


?>