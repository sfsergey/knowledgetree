<?php

class KTAPI_ValueExpectedException extends KTAPI_BaseException
{
    public static
    function __construct($what)
    {
        parent::__construct('No value provided for %s.', $what);
    }
}

?>