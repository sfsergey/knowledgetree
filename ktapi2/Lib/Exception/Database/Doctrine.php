<?php

class KTAPI_Database_DoctrineException extends KTAPI_DatabaseException
{
    private $doctrineException;

    public
    function __construct($doctrineException)
    {
        ValidationUtil::validateType($doctrineException, 'Doctrine_Exception');

        $this->doctrineException = $doctrineException;
        parent::__construct($doctrineException->getMessage());
    }


}

?>