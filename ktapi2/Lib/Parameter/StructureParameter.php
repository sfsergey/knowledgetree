<?php

class StructureParameter extends Parameter
{
    private $contents;

    /**
     * Constructor for a structure
     *
     * @param string $name
     */
    protected
    function __construct($name)
    {
        parent::__construct($name, 'struct');
        $this->contents = array();
    }

    /**
     * Returns a structure
     *
     * @param string $name
     * @return StructureParameter
     */
    public
    function create($name = 'return')
    {
        return new StringParameter($name);
    }

    public
    function add($parameter)
    {
        if (!$parameter instanceof Parameter)
        {
            throw new KTapiException(_kt('Parameter object expected, but was passed: %s', get_class($parameter)));
        }

        if (in_array($parameter, $this->contents))
        {
            throw new KTapiException(_kt('Parameter already in use.'));
        }

        $this->contents[] = $parameter;
    }

    public
    function getContents()
    {
        return $this->contents;
    }

}

?>