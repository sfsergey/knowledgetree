<?php

class StructureParameter extends Parameter
{
    private $contents;

    protected
    function __construct($name, $type, $default = null, $allowNull = false)
    {
        parent::__construct($name, $type, $default, $allowNull);
        $this->contents = array();
    }

    public
    function add($parameter)
    {
        if (!$parameter instanceof Parameter)
        {
            throw new KTapiException('Parameter object expected.');
        }

        if (in_array($parameter, $this->contents))
        {
            throw new KTapiException('Parameter already in use.');
        }

        $this->contents[] = $parameter;
    }
}

?>