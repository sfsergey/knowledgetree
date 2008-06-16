<?php

abstract class Security_Authentication_Provider extends PluginModule
{
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

        return $this;
    }

    public
    function getProviderNamespace()
    {
        throw new Exception('Namespace must be set by provider.');
    }

    public
    function getDisplayName()
    {
        throw new Exception('Display name must be set.');
    }

    /**
     * Used to authenticate with the authentication provider.
     *
     * @param Security_User $user
     * @param array $options
     * @return boolean
     */
    public abstract
    function authenticate($user, $options = array());

    public
    function changePassword($user, $options = array())
    {
        throw new KTapiException('Cannot change password');
    }

    /**
     * If the authentication provider deals with simple passwords, it needs to indicate if
     * it supports changing of passwords.
     *
     * @param Security_User $user
     * @return boolean
     */
    public
    function canChangePassword($user)
    {
        return false;
    }

    public abstract
    function getSourceConfigParams();

    public abstract
    function getInputParams();

    public abstract
    function getUserAuthConfig($options);

    public
    function canImport($source)
    {
        return false;
    }

    public
    function filterUsers($source, $filter)
    {
        return array();
    }

    public
    function import($source, $user)
    {
        throw new Exception('Import is not supported.');
    }
}
?>