<?php
abstract class Trigger extends Plugin_Module
{
    const BEFORE            = 1; // can easily do bitwise - to resolve when trigger must run
    const AFTER             = 2;

    protected $params;

    public $whenToRun; // readonly property

    public $appliesToNamespaces;

    public $dependsOnNamespaces;

    public abstract
    function execute($context, $action_namespace, $action_params, $runningWhen);

    /**
     * Initialise the trigger
     *
     */
    public
    function __construct()
    {
    }

    /**
     * Sets the namespaces that the trigger is applicable within.
     * The trigger will only be run on these namespaces;
     *
     * @param array $namespaces
     */
    protected
    function setApplicableNamespaces($namespaces)
    {
        $this->appliesToNamespaces = $namespaces;
    }

    /**
     * Set the namespaces that the trigger is dependant on.
     * These must be included for the trigger to function correctly.
     *
     * @param array $namespaces
     * @return void
     */
    protected
    function setDependentNamespaces($namespaces)
    {
        $this->dependsOnNamespaces = $namespaces;
    }

    /**
     * Registers the trigger as a plugin module.
     *
     */
    public
    function register()
    {
        $this->module_config = array(
            'appliesTo' => $this->appliesToNamespaces,
            'dependsOn' => $this->dependsOnNamespaces
            );
        parent::register('trigger');
    }
}
?>