<?php

class TestTrigger extends Trigger
{
    public
    function __construct($module = null)
    {
        parent::__construct($module);
    }

    protected
    function getNamespace()
    {
        return 'trigger.test';
    }

    protected
    function getName()
    {
        return 'Test Trigger';
    }

    protected
    function getApplicableNamespaces()
    {
        return array('action.document.checkin','action.document.add');
    }

    protected
    function getParameters()
    {
        $this->addStringParameter('extra')->setAllowNull(true);
    }


    protected
    function executeTrigger($context, $action_namespace, $action_params, $runningWhen)
    {

    }
}

?>