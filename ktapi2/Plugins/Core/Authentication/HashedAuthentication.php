<?php

class HashedAuthenticationProvider extends Security_Authentication_Provider
{
    protected
    function getProviderConfig()
    {
        return array(
            'provider_namespace' => 'hashed.password',
            'display_name' => 'Hashed Password Provider'
        );
    }

    /**
     * The authentication source does not require any configuration.
     *
     * An empty array is returned.
     *
     * @return array
     */
    public
    function getSourceConfigParams()
    {
        return array();
    }

    /**
     * Returns an array of parameters the user must provide in order to authenticate.
     *
     * @return array
     */
    public
    function getInputParams() // TODO: getAuthConfigParams()
    {
        $input = StructureParameter::create()
            ->add(StringParameter::create('password'));

        return $input->getContents();
    }

    /**
     * This does a simple MD5 hash of the password.
     *
     * @param string $password
     * @return string
     */
    private static
    function hash($password)
    {
        return md5($password);
    }

    /**
     * Authenticates the user password by comparing the hash of the input 'password' with the stored hashed password.
     *
     * @param Security_User $user
     * @param array $options
     * @return boolean
     */
    public
    function authenticate($user, $options = array())
    {
        $user = SecurityUtil::validateUser($user);

        ValidationUtil::arrayExpected($options, 'options');
        ValidationUtil::arrayOptionExpected($options, 'password');

        $config = $user->getAuthConfig();

        ValidationUtil::arrayOptionExpected($config, 'password');

        return ($config['password'] == self::hash($options['password']));

    }

    /**
     * Update the auth configuration for the user.
     *
     * It hashes the 'password' value.
     *
     * @param Security_User $user
     * @param array $options
     * @return void
     */
    public
    function changeAuthConfig($user, $options = array())
    {
        $user = SecurityUtil::validateUser($user);

        ValidationUtil::arrayOptionExpected($options, 'password');

        $config = $user->getAuthConfig();

        $config['password'] = self::hash($options['password']);

        $user->setAuthConfig($config);
    }

    /**
     * Indicates if the auth configuration can be changed for the user.
     *
     * @param Security_User $user
     * @return boolean
     */
    public
    function canChangeAuthConfig($user)
    {
        return true;
    }

    /**
     * When creating the user, this function extracts the relevant parameters from the input options array.
     *
     * It returns an array containing the hashed password used for authentication.
     *
     * @param array $options
     * @return array
     */
    public
    function getUserAuthConfig(&$options)
    {
        if (isset($options['password']))
        {
            $password = $options['password'];
        }
        else
        {
            $password = SecurityUtil::randomPassword();

            $options['password'] = $password;
            $options['notifyUser'] = true;
        }

        $config = array();
        $config['password'] = self::hash($password);

        return $config;
    }
}

?>