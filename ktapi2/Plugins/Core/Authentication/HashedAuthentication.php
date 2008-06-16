<?php

class HashedAuthenticationProvider extends Security_Authentication_Provider
{
    public
    function register($plugin, $path)
    {
        try
        {
            $module = PluginManager::getModule(Security_Authentication_Source::HASHED_PASSWORD_NAMESPACE);
            return $module;
        }
        catch(Exception $ex)
        {
            // TODO: improve exception handling
            // getModule() throws an exception when not found.
        }

        parent::register($plugin, $path);
    }

    public
    function getSourceConfigParams()
    {
        return array();
    }

    public
    function getInputParams()
    {
        $input = StructureParameter::create()
            ->add(StringParameter::create('password'));

        return $input->getContents();
    }

    private static
    function hash($password)
    {
        return md5($password);
    }

    public
    function authenticate($user, $options = array())
    {
        $user = Util_Security::validateUser($user);

        if (!isset($options['password']))
        {
            throw new Exception('Expected password');
        }

        $config = $user->getAuthConfig();
        if (!isset($config['password']))
        {
            return false;
        }

        return ($config['password'] == self::hash($options['password']));

    }

    public
    function changePassword($user, $options = array())
    {
        $user = Util_Security::validateUser($user);
        if (!is_array($options))
        {
            throw new Exception('Options array expected');
        }

        if (!isset($options['password']))
        {
            throw new Exception('Expected password');
        }

        $config = $user->getAuthConfig();

        $config['password'] = self::hash($options['password']);

        $user->setAuthConfig($config);
    }

    public
    function canChangePassword($user)
    {
        return true;
    }

    public
    function getProviderNamespace()
    {
        return 'hashed.password';
    }

    public
    function getDisplayName()
    {
        return 'Hashed Password Provider';
    }

    public
    function getUserAuthConfig($options)
    {
        $config = array();
        if (isset($options['password']))
        {
            $config['password'] = self::hash($options['password']);
        }
        return $config;
    }
}

?>