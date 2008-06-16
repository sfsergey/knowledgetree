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

        return Util_Doctrine::getObjectArrayFromCollection($rows, 'Base_AuthenticationSource');
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
        $source = Util_Doctrine::simpleOneQuery('Base_AuthenticationSource', array('auth_module_namespace'=>Security_Authentication_Source::HASHED_PASSWORD_NAMESPACE));
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

    private
    function getOptions($options)
    {
        $config  = $this->base->module_config;

        $config = unserialize($config);

        return $config;
    }

    public
    function getId()
    {
        return $this->base->id;
    }

    public
    function getProviderNamespace()
    {
        return $this->base->auth_module_namespace;
    }

    public
    function getProvider()
    {
        return PluginManager::getModule($this->getProviderNamespace());
    }

    public
    function getDisplayName()
    {
        return $this->base->display_name;
    }

    public
    function getConfig()
    {
        return $this->base->auth_config;
    }

    public
    function isEnabled()
    {
        return $this->base->status == 'Enabled';
    }

    public
    function isDeleted()
    {
        return $this->base->status == 'Deleted';
    }

    public
    function isSystemSource()
    {
        return $this->base->is_system;
    }

    public
    function getUserAuthConfig($options)
    {
        $provider = $this->getProvider();

        return $provider->getUserAuthConfig($options);
    }

    public
    function canImport()
    {
        $provider = $this->getProvider();

        return $provider->canImport($this);
    }

    public
    function filterUsers($filter)
    {
        $provider = $this->getProvider();

        return $provider->filterUsers($this, $filter);
    }

    public
    function import($user)
    {
        $provider = $this->getProvider();

        return $provider->import($this, $user);
    }

}

?>