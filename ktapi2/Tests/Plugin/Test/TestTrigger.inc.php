<?php

class TestTrigger extends Trigger
{
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

    function getParameters()
    {
        $params = StructureParameter::create()
                    ->add(StringParameter::create('Approver')
                            ->setAllowNull(true)
                            ->setDefaultValue('Megan'));


        return $params->getContents();
    }


    protected
    function fullExecute($context, $action_namespace, $action_params, $runningWhen)
    {

    }
}

?>