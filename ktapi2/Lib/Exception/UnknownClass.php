<?php

class KTAPI_UnknownClassException extends KTAPI_BaseException
{
    public
    function __construct($classname, $filename)
    {
        parent::__construct("Expected class of type '%s' to be defined in '%s'.", $classname, $filename);
    }
}

?>