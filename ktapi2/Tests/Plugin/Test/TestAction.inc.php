<?php

class TestAction extends Action
{
    public
    function __construct($module = null)
    {
        parent::__construct($module);

//        $this->addParameter(StringParameter::create('Author')
//                            ->setAllowNull(true)
//                            ->setDefaultValue('Conrad'));
//
//        $this->addParameter(IntParameter::create('Pens Available')
//                            ->setAllowNull(true)
//                            ->setMinValue(0)
//                            ->setDefaultValue('3'));
//
//        $this->addParameter(DateParameter::create('date')
//                            ->setAllowNull(true)
//                            ->setDefaultValue(date('Y-m-d')));
    }

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