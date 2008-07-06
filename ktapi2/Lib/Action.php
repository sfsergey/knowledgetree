<?php

abstract class Action extends PluginModule
{
    protected abstract
    function executeAction($context, $params);

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
    function getDocumentation()
    {
        return $this->module->module_config['documentation'];
    }

    public abstract
    function getConfig();

    public
    function register($plugin, $path)
    {
        $config = $this->getConfig();

        $namespace = ValidationUtil::arrayKeyExpected('module_namespace', $config);
        $documentation = ValidationUtil::arrayKeyExpected('documentation', $config);

        if ($this instanceof Trigger)
        {
            $moduleType = 'Trigger';
            $namespace = 'trigger.' . $namespace;

            ValidationUtil::arrayKeyExpected('applies_to', $config);
            ValidationUtil::arrayKeyExpected('depends_on', $config);
        }
        else
        {
            $moduleType = 'Action';
            $namespace = 'action.' . $namespace;
            $functionName = ValidationUtil::arrayKeyExpected('function', $config);

            ValidationUtil::arrayKeyExpected('category_namespace', $config);
            ValidationUtil::arrayKeyExpected('category_name', $config);
        }

        $this->base = Plugin_Module::registerParams($plugin, $moduleType, $path,
            array(
                'namespace'=>$namespace,
                'classname'=>get_class($this),
                'display_name'=>$functionName,
                'module_config'=>$config,
                'dependencies'=>''));
    }
}
?>