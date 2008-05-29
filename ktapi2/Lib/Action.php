<?php

abstract class Action extends PluginModule
{
    public abstract
    function getCategoryNamespace();

    protected abstract
    function executeAction($context, $params);

    public
    function getNamespace()
    {
        throw new KTapiException(_kt('Namespace not specified.'));
    }

    public
    function getDisplayName()
    {
        throw new KTapiException(_kt('Display name not specified.'));
    }

    public
    function isActive()
    {
        return true;
    }

    public
    function getParameters()
    {
        return array();
    }

    public
    function getReturn()
    {
        return array();
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

    public
    function register($plugin, $path)
    {
        $this->base = Plugin_Module::registerParams($plugin, 'Action', $path,
            array(
                'namespace'=>$this->getNamespace(),
                'classname'=>get_class($this),
                'display_name'=>$this->getDisplayName(),
                'module_config'=>'',
                'dependencies'=>''));
    }
}
?>