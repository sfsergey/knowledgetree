<?php

final class StringParameter extends Parameter
{
    private $minLength;
    private $maxLength;
    private $regex;

    protected
    function __construct($name, $default = null, $allowNull = false)
    {
        parent::__construct($name, 'string', $default, $allowNull);
        $this->minLength = 0;
        $this->maxLength = null;
        $this->regex = null;
    }

    public static
    function create($name, $default = null, $allowNull = false)
    {
        return new StringParameter($name, $default, $allowNull);
    }

    protected
    function __get($property)
    {
        switch ($property)
        {
            case 'MinLength':
                return $this->minLength;
            case 'MaxLength':
                return $this->maxLength;
            case 'Regex':
                return $this->regex;
            default:
                return parent::__get($property);
        }
    }

    protected
    function __set($property, $value)
    {
        switch ($property)
        {
            case 'MinLength':
            case 'MaxLength':
            case 'Regex':
                call_user_func_array('set' . $property, array($value));
                break;
            default:
                parent::__set($property, $value);
        }
    }

    public
    function validateValue($value)
    {
    }

    public
    function setMinLength($value)
    {
        $this->minLength = $value;
        return $this;
    }

    public
    function setMaxLength($value)
    {
        $this->maxLength = $value;
        return $this;
    }

    public
    function setRegex($value)
    {
        $this->regex = $value;
        return $this;
    }
}

?>