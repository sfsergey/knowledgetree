<?php

class TestAction extends Action
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
            'category_name' => 'Test Category'
            );
    }

    public
    function getParameters()
    {
        $params = StructureParameter::create()
                    ->add(StringParameter::create('Author')
                            ->setAllowNull(true)
                            ->setDefaultValue('Conrad'));


        return $params->getContents();
    }

    protected
    function executeAction($context, $params)
    {

    }
}

?>