<?php

class KTAPI_BaseException extends Exception
{
    const ORIGINAL      = 0;
    const TRANSLATION   = 1;

    private $params;

    public
    function __construct($format)
    {
        parent::__construct($format);
        $this->params = func_get_args();
    }

    public
    function __get($property)
    {
        switch($property)
        {
            case 'Message':
                return call_user_func('_kt', $this->params);
            case 'OriginalMessage':
                return call_user_func('_str', $this->params);
            default:
                throw new KTAPI_UnknownPropertyException($property);
        }
    }
}


?>