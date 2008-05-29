<?php

class Test2DiffAction extends Action
{
    public
    function getNamespace()
    {
        return 'action.test2diff';
    }

    public
    function getDisplayName()
    {
        return _kt('Test 2 Diff Action');
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