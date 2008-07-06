<?php

class KTAPI_Session_NotActiveException extends KTAPI_SessionException
{
    public
    function __construct()
    {
        parent::__construct('Session not active.');
    }
}

?>