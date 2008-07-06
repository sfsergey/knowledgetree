<?php

class StructureParameter extends BaseParameter
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
     * @static
     * @return StructureParameter
     */
    public static
    function create($name = 'return')
    {
        return new StructureParameter($name);
    }

    public
    function add($parameter)
    {
        ValidationUtil::validateType($parameter, 'BaseParameter');

        if (in_array($parameter, $this->contents))
        {
            throw new KTapiException(_kt('Parameter already in use.'));
        }

        $this->contents[] = $parameter;

        return $this;
    }

    public
    function getContents()
    {
        return $this->contents;
    }

}

?>