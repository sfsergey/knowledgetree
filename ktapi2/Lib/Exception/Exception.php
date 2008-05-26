<?php

class KTapiException extends Exception
{
    public
    function __construct($format)
    {
        parent::__construct(_kt(func_get_args()));
    }
}


?>