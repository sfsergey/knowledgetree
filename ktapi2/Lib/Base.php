<?php

class KTAPI_Base
{
    /**
     * Enter description here...
     *
     * @var Doctrine_Record
     */
    protected $base;

    public
    function __construct($base)
    {
        $this->base = $base;
    }

    protected
    function __get($property)
    {
        $method = 'get' . $property;
        if (method_exists($this, $method))
        {
            return call_user_func(array($this, $method));
        }
        else
        {
            throw new KTapiUnknownPropertyException($this, $property);
        }
    }

    protected
    function __set($property, $value)
    {
        $method = 'set' . $property;
        if (method_exists($this, $method))
        {
            return call_user_func(array($this, $method), $value);
        }
        else
        {
            throw new KTapiUnknownPropertyException($this, $property);
        }
    }

    public
    function save()
    {
        $this->base->save();
    }
}

?>