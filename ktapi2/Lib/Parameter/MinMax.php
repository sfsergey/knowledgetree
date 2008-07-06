<?php

abstract class MinMaxParameter extends BaseParameter
{
    private $minValue;
    private $maxValue;

    protected
    function __construct($name, $type, $min = null, $max = null, $default = null, $allowNull = false)
    {
        parent::__construct($name, $type, $default, $allowNull);
        $this->minValue = $min;
        $this->maxValue = $max;
    }

    protected
    function __get($property)
    {
        switch ($property)
        {
            case 'MinValue':
                return $this->minValue;
            case 'MaxValue':
                return $this->maxValue;
            default:
                return parent::__get($property);
        }
    }


}

?>