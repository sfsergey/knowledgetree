<?php

class IntParameter extends MinMaxParameter
{
    protected
    function __construct($name, $min = null, $max = null, $default = null, $allowNull = false)
    {
        parent::__construct($name, 'int', $min, $max, $default, $allowNull);
    }

    public static
    function create($name, $min = null, $max = null, $default = null, $allowNull = false)
    {
        return new IntParameter($name, $min, $max, $default, $allowNull);
    }

    public
    function validate($value)
    {

    }
}

?>