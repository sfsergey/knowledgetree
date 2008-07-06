<?php

class KTAPI_UnexpectedTypeException extends KTAPI_BaseException
{
    private $object;

    public
    function __construct($object, $expectedClassname)
    {
        $this->object = $object;
        parent::__construct('Expected class of type %s, but was passed class of type %s', $expectedClassname, get_class($object));
    }

}

?>