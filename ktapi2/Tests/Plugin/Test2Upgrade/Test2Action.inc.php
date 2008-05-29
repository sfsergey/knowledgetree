<?php

class Test2Action extends Action
{
    public
    function getNamespace()
    {
        return 'action.test';
    }

    public
    function getDisplayName()
    {
        return _kt('Test Action');
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

    public
    function getCategoryNamespace()
    {
        return '';
    }


    protected
    function executeAction($context, $params)
    {

    }

    function getConfig()
    {
        return ;
    }


}

?>