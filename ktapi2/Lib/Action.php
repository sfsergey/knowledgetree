<?php

abstract class Action
{
    const TRIGGER_BEFORE            = 1; // can easily do bitwise - to resolve when trigger must run
    const TRIGGER_AFTER             = 2;

    private $return;

    private $parameters;

    private $module;

    public
    function __construct($module = null)
    {
        $this->module = $module;
        $this->parameters = array();
        $this->return = array();
    }

    protected
    function __get($property)
    {
        switch ($property)
        {
            case 'Namespace':
            case 'Name':
            case 'CategoryNamespace':
                return call_user_func_array('get' . $property);
            case 'Return':
                return $this->return;
            case 'Parameters':
                return $this->parameters;
            default:
                throw new KTapiUnknownPropertyException($this, $property);
        }
    }

    public abstract
    function getNamespace();

    public abstract
    function getDisplayName();

    public abstract
    function getCategoryNamespace();
    /**
     * Adds a parameter to the action/trigger
     *
     * @param Parameter $parameter
     * @return Parameter
     */
    protected
    function addParameter($parameter)
    {
        if (!$parameter instanceof Parameter)
        {
            throw new KTapiException('Parameter object expected.');
        }
        $this->parameters[] = $parameter;
        return $parameter;
    }


    protected abstract
    function executeAction($context, $params);

    public
    function isActive()
    {
        return true;
    }

    public
    function execute($context, $params)
    {
        $connection = KTapi::getDb();
        $connection->beginTransaction();

        try
        {
            $triggers = KTapi::getTriggersByNamespace($this->namespace);

            foreach($triggers as $trigger)
            {
                $trigger->fullExecute($context, $params, $this->namespace, Trigger::BEFORE);
            }

            self::executeAction($params);

            foreach($triggers as $trigger)
            {
                $trigger->fullExecute($context, $params, $this->namespace, Trigger::AFTER);
            }

            $connection->commit();

        }
        catch(Exception $ex)
        {
            $connection->rollback();

            throw $ex;
        }
    }

    protected
    function setReturn($return)
    {

    }

    public
    function register($plugin, $path)
    {
        $this->base = Plugin_Module::registerObject($plugin, 'Action', $this, $path);
    }

    function getOrder()
    {
        return 0;
    }
    function canDisable()
    {
        return false;
    }
    function getDependencies()
    {
        return array();
    }


}
?>