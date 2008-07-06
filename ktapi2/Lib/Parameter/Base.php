<?php

abstract class BaseParameter
{
    /**
     * The name of the parameter.
     *
     * @var string
     */
    private $name;
    /**
     * The type of the parameter.
     * Possible values include: int, integer, float, date, string, struct
     *
     * @var string
     */
    private $type;
    /**
     * The default value of the parameter.
     *
     * @var mixed
     */
    private $defaultValue;
    /**
     * Is the value allowed to be null.
     *
     * @var boolean
     */
    private $allowNull;
    /**
     * Structure used to maintain order of parameters in scope of input.
     *
     * @var array
     */
    private $insert;

    private $array;

    protected
    function __construct($name, $type, $default = null, $allowNull = false)
    {
        $this->name = $name;
        $this->type = $type;
        $this->defaultValue = $default;
        $this->allowNull = $allowNull;
        $this->array = false;
        $this->insert = array('before'=>array(),'after'=>array());
    }

    protected
    function __get($property)
    {
        switch ($property)
        {
            case 'Name':
                return $this->name;
            case 'Type':
                return $this->type;
            case 'DefaultValue':
                return $this->defaultValue;
            case 'AllowNull':
                return $this->allowNull;
            case 'InsertBefore':
                return $this->insert['before'];
            case 'InsertAfter':
                return $this->insert['after'];
            case 'IsArray':
                return $this->array;
        }
    }

    protected
    function __set($property, $value)
    {
        switch ($property)
        {
            case 'IsArray':
            case 'InsertBefore':
            case 'InsertAfter':
            case 'AllowNull':
                call_user_func_array('set' . $property, array($value));
                break;
            default:
                throw new KTapiUnknownPropertyException($property);
        }
    }


    /**
     * Indicates if the parameter is an array.
     *
     * @param boolean $isArray
     * @return Parameter
     */
    public
    function setAsArray($value)
    {
        $this->isArray = TypeUtil::decodeValue($value, 'boolean');
        return $this;
    }


    /**
     * Set to true if the parameter may be null or not.
     *
     * @param boolean $value
     * @return Parameter
     */
    public
    function setAllowNull($value)
    {
        $this->allowNull = TypeUtil::decodeValue($value, 'boolean');
        return $this;
    }

    /**
     * Set the default value for the parameter.
     *
     * @param mixed $value
     * @return Parameter
     */
    public
    function setDefaultValue($value)
    {
        $this->defaultValue = $value;
        return $this;
    }


    public
    function setInsertBefore($value)
    {
        $this->insert['before'] = $value;
        return $this;
    }
    public
    function setInsertAfter($value)
    {
        $this->insert['after'] = $value;
        return $this;
    }
}

?>