<?php

class TestTrigger extends Trigger
{
    public
    function __construct($module = null)
    {
        parent::__construct($module);
    }

    public
    function getNamespace()
    {
        return 'trigger.test';
    }

    public
    function getDisplayName()
    {
        return _kt('Test Trigger');
    }

    protected
    function getApplicableNamespaces()
    {
        return array('action.document.checkin','action.document.add');
    }

    protected
    function getParameters()
    {
        //$this->addStringParameter('extra')->setAllowNull(true);
        return '';
    }


    protected
    function fullExecute($context, $action_namespace, $action_params, $runningWhen)
    {

    }
}

?>