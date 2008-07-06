<?php

class Security_Authentication_Source extends KTAPI_Base
{
    const HASHED_PASSWORD_NAMESPACE = 'authentication.provider.hashed.password.plugin.core';

    public static
    function getAll()
    {
        $sources = array();

        $rows = Doctrine_Query::create()
            ->select()
            ->from('Base_AuthenticationSource b')
            ->where('b.status != :deleted', array(':deleted'=>'Deleted'))
            ->execute();

        return DoctrineUtil::getObjectArrayFromCollection($rows, 'Base_AuthenticationSource');
    }

    private
    function setStatus($status)
    {
        $this->base->status = $status;
        $this->base->save();
    }

    public static
    function getDefault()
    {
       try
       {
        $source = DoctrineUtil::simpleOneQuery('Base_AuthenticationSource', array('auth_module_namespace'=>Security_Authentication_Source::HASHED_PASSWORD_NAMESPACE));
       }
       catch(Exception $ex)
       {
           // TODO: improve exception...

            // we create the default authentication source
            $source = Security_Authentication_Source::create(Security_Authentication_Source::HASHED_PASSWORD_NAMESPACE,
                    'Hashed Authentication Source',
                    array('is_system'=>true));
       }
        return new Security_Authentication_Source($source);
    }


    public
    function disableSource()
    {
        if ($this->base->is_system)
        {
            throw new Exception('Cannot disable source');
        }
        $this->setStatus('Disabled');
    }

    public
    function enableSource()
    {
        $this->setStatus('Enabled');
    }

    public static
    function deleteSource()
    {
        if ($this->base->is_system)
        {
            throw new Exception('Cannot delete source');
        }
        $this->setStatus('Deleted');
    }



    public static
    function create($providerNamespace, $displayName, $config = array(), $options = array())
    {
        $source = new Base_AuthenticationSource();
        $source->auth_module_namespace = $providerNamespace;
        $source->display_name = $displayName;
        $source->auth_config = $config;
        $source->status = 'Enabled';
        if (isset($options['is_system']) && $options['is_system']) $source->is_system = true;

        $source->save();

        return $source;
    }

    /**
     * Returns the authentication source id.
     *
     * @return int
     */
    public
    function getId()
    {
        return $this->base->id;
    }

    /**
     * Returns the authentication provider namespace associated with the source.
     *
     * @return string
     */
    public
    function getProviderNamespace()
    {
        return $this->base->auth_module_namespace;
    }

    /**
     * Returns a reference to the authentication provider.
     *
     * @return Authentication_Source_Provider
     */
    public
    function getProvider()
    {
        return PluginManager::getModule($this->getProviderNamespace());
    }

    /**
     * Returns the source display name.
     *
     * @return string
     */
    public
    function getDisplayName()
    {
        return $this->base->display_name;
    }

    /**
     * Returns the auth source configuration.
     *
     * @return array
     */
    public
    function getConfig()
    {
        return $this->base->auth_config;
    }

    /**
     * Indicates if the source is enabled.
     *
     * @return boolean
     */
    public
    function isEnabled()
    {
        $provider = $this->getProvider();
        return ($this->base->status == 'Enabled') && (!is_null($provider) && $provider->isEnabled());
    }

    /**
     * Indicates if the souce is deleted.
     *
     * @return boolean
     */
    public
    function isDeleted()
    {
        return $this->base->status == 'Deleted';
    }

    /**
     * Indicates if the source is a system source.
     *
     * @return unknown
     */
    public
    function isSystemSource()
    {
        return $this->base->is_system;
    }

    /**
     * Indicates if the provider has import capabilities to import users from the authentication source.
     *
     * @return boolean
     */
    public
    function canImport()
    {
        $provider = $this->getProvider();

        return $provider->canImport($this);
    }

    /**
     * Queries the provider to find users that may be imported from the authentication source.
     *
     * @param string $filter
     * @return array
     */
    public
    function queryUsers($filter)
    {
        $provider = $this->getProvider();

        return $provider->filterUsers($this, $filter);
    }

    /**
     * Creates a user based on the query result.
     *
     * @param Security_Authentication_ImportUser $user
     * @return Security_Authentication_User
     */
    public
    function import($user)
    {
        $provider = $this->getProvider();

        return $provider->import($this, $user);
    }

}

?>