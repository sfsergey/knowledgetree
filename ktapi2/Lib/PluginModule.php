<?php

abstract class PluginModule
{
    protected $module;

    public
    function __construct($module = null)
    {
        $this->module = $module;
    }

    protected
    function __get($property)
    {
        $method = 'get' . $property;
        if (method_exists($this, $method))
        {
            return call_user_func(array($this, $method));
        }
        else
        {
            throw new KTapiUnknownPropertyException($this, $property);
        }
    }

    public
    function getNamespace()
    {
        return $this->module->namespace;
    }

    public
    function getDisplayName()
    {
        return $this->module->name;
    }

    public
    function getOrder()
    {
        return $this->module->order;
    }

    public
    function canDisable()
    {
        return $this->module->can_disable;
    }

    public
    function getDependencies()
    {
        return array();
    }
}
?>