<?php

class TestTrigger extends Trigger
{
    public
    function getConfig()
    {
        return array(
            'module_namespace'=>'test',
            'function' => 'test',
            'display_name' => 'Test Action',
            'documentation'=> 'general description of test().',
            'category_namespace'=> 'test',
            'category_name' => 'Test Category',
            'applies_to' => array('action.document.checkin','action.document.add'),
            'depends_on' => array()
            );
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