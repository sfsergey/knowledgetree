<?php

abstract class Security_Authentication_Provider extends PluginModule
{
    /**
     * Registers the authentication provider module.
     *
     * @param Plugin $plugin
     * @param string $path
     * @return void
     */
    public
    function register($plugin, $path)
    {
        $namespace = strtolower('authentication.provider.' . $this->getProviderNamespace());

        $className = get_class($this);
        $displayName = $this->getDisplayName();

        $this->base = Plugin_Module::registerParams($plugin, 'AuthenticationProvider', $path,
            array(
                'namespace'=>$namespace,
                'classname'=>$className,
                'display_name'=>$displayName,
                'module_config'=>'',
                'dependencies'=>''));
    }

    /**
     * Returns the provider namespace.
     *
     * This function must be overridden!
     *
     * @return string
     */
    public
    function getProviderNamespace()
    {
        throw new Exception('Namespace must be set by provider.');
    }

    /**
     * Returns the display name for the plugin handler.
     *
     * Note that this string should return a string without _kt() in it.
     *
     * This function must be overridden!
     * @return string
     */
    public
    function getDisplayName()
    {
        throw new Exception('Display name must be set.');
    }

    /**
     * This function must be overridden to authenticate with the authentication provider.
     *
     * @param Security_User $user
     * @param array $options
     * @return boolean
     */
    public abstract
    function authenticate($user, $options = array());


    /**
     * Override this to change the user's authorisation configuration.
     *
     * e.g. This may be used to change the user password.
     *
     * @param Security_User $user
     * @param array $options
     * @return void
     */
    public
    function changeAuthConfig($user, $options = array())
    {
        throw new KTapiException('Cannot change auth config');
    }

    /**
     * If the authentication provider deals with simple passwords, it needs to indicate if
     * it supports changing of passwords.
     *
     * This may be overridden. It defaults to false.
     *
     * @param Security_User $user
     * @return boolean
     */
    public
    function canChangeAuthConfig($user)
    {
        return false;
    }

    /**
     * Returns the configuration parameters for the authentication source.
     *
     * This method must be overridden.
     *
     * @abstract
     * @return array
     */
    public abstract
    function getSourceConfigParams();

    /**
     * Returns the input parameters that must be provided by the user for authentication.
     *
     * This method must be overridden.
     *
     * @abstract
     * @return array
     */
    public abstract
    function getInputParams();

    /**
     * Returns an array to be stored in the user's auth config. This stores user specific configuration.
     *
     * This method must be overridden.
     *
     * @param array $options
     * @return array
     */
    public abstract
    function getUserAuthConfig(&$options);

    /**
     * Indicates if the provider provides a query interface to import users for a specific source.
     *
     * This method may be overrriden. It defaults to false.
     *
     * @param Authentication_Source $source
     * @return bool
     */
    public
    function canImport($source)
    {
        return false;
    }

    /**
     * Queries users on an authentication source using a filter.
     *
     * It returns an array of Security_Authentication_ImportUser. These items may be passed to the import() function.
     *
     * @param Authentication_Source $source
     * @param string $filter
     * @return array
     */
    public
    function queryUsers($source, $filter)
    {
        return array();
    }

    /**
     * Import a user based on the results of queryUsers().
     *
     * @param Authentication_Source $source
     * @param Security_Authentication_ImportUser $user
     * @return void
     */
    public
    function import($source, $user)
    {
        throw new Exception('Import is not supported.');
    }
}
?>