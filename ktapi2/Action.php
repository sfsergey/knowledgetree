<?php
class Action
{
    private $namespace;

    private $category;

    private $name;

    private $return;

    private $parameters;

    private $module;

    public
    function __constructor($namespace, $name)
    {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->category = $category;
        $this->parameters = array();
        $this->return = array();
    }

    protected
    function __get($property)
    {
        switch ($property)
        {
            case 'Namespace':
                return $this->namespace;
            case 'Name':
                return $this->name;
            case 'CategoryNamespace':
                return $this->category;
            case 'Return':
                return $this->return;
            case 'Parameters':
                return $this->parameters;
            default:
                throw new UnknownPropertyException($this, $property);
        }
    }

    public abstract
    function execute($params);

    public
    function dependsOnNamespaces()
    {
        return array();
    } // empty return if no dependancies

    protected
    function setCategory($category_namespace, $category_name)
    {
    }

    protected
    function setReturn($return)
    {

    }

    protected
    function addParameter($param)
    {
        if (!$param instanceof ActionParameter) throw new Exception('Action parameter expected');
        $this->parameters[] = $param;
    }
}
?>