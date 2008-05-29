<?php
abstract class Trigger extends Action
{
    const BEFORE            = 1; // can easily do bitwise - to resolve when trigger must run
    const AFTER             = 2;

    public $whenToRun; // readonly property

    /**
     * List of action namespaces that the trigger applies to. When an action in this list is run, this trigger will be executed.
     *
     * @var array
     */
    public $appliesToNamespaces;

    /**
     * List of namespaces which this trigger depends on. This trigger will not be active unless all dependencies are enabled.
     *
     * @var array
     */
    public $dependsOnNamespaces;

    /**
     * Initialise the trigger
     *
     */
    public
    function __construct($module = null)
    {
        $this->module = $module;
        $this->parameters = array();
        $this->return = array();
        $this->whenToRun = Trigger::AFTER;
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

    function getCategoryNamespace()
    {
        return '';
    }

    function getConfig()
    {
        return array(
            'appliesTo' => $this->appliesToNamespaces,
            'dependsOn' => $this->dependsOnNamespaces
            );
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
        return $this;
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
        return $this;
    }

    private
    function appliesTo($namespace)
    {
        return (in_array($namespace, $this->appliesToNamespaces));
    }

    private
    function areParametersValid($context, $action_params, $throwException=true)
    {

    }

    private
    function areDependenciesEnabled()
    {

    }

    private
    function shouldRun($runningWhen)
    {
        return (($this->whenToRun & $runningWhen) == $runningWhen);
    }

    protected
    function execConditions($context, $action_namespace, $action_params, $runningWhen)
    {
        // if it is scheduled to run before or after, and it is not correct, then should just break out. not fatal.
        if (!$this->shouldRun($runningWhen))
        {
            // TODO: log
            return false;
        }

        //  if action namespace does not apply, just break out. it is not fatal, but it should not have happened.

        if (!$this->appliesTo($action_namespace))
        {
            // TODO: log
            return false;
        }

        // if dependencies are not enabled, then we should break out. it is not fatal.
        if (!$this->areDependenciesEnabled())
        {
            // TODO: log
            return false;
        }

        // parameters that are invalid is a fatal condition however!!!
        $this->areParametersValid($context, $action_params, true);

        return true;
    }

    protected abstract
    function fullexecute($context, $action_namespace, $action_params, $runningWhen);

    protected
    function executeAction($context, $params)
    {

    }

    public
    function execute($context, $params)
    {
        parent::execute($context, $params);
    }

}
?>