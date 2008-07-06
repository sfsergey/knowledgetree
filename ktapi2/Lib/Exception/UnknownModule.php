<?php

class KTAPI_UnknownModuleException extends KTAPI_BaseException
{
    public
    function __construct($namespace)
    {
        parent::__construct("Module could not be resolved for namespace '%s'.", $namespace);
    }
}

?>