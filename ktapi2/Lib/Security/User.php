<?php

class Security_User extends KTAPI_BaseMember
{

    public static
    function get($id)
    {
        return Util_Doctrine::getEntityByIds('Base_User', 'Security_User', 'member_id', $id);
    }

    public static
    function getByUsername($username)
    {
        return Util_Doctrine::getEntityByField('Base_User', 'Security_User', array('username' => $username ));
    }

    public static
    function getAnonymousUser()
    {
        // TODO: define anonymous user in config
        return self::getByUsername('anonymous');
    }

    /**
     * Get a list of groups based on a filter and optional  unit id.
     *
     * @param string $filter
     * @param int $unitId
     * @return array of Security_Group
     */
    public static
    function getUsersByFilter($filter = '', $unitId = null)
    {
        return parent::getMembersByFilter('Base_User','Security_User',$filter);
    }



    public static
    function create($username, $name, $email, $options = array())
    {
        try
        {
            $user = self::getByUsername($username);
        }
        catch(Exception $ex)
        {
            // catch exception where user does not exist
        }
        if (isset($user))
        {
            throw new KTapiException(_kt('User with username %s already exists.', $username));
        }

        $notifyUser = false;

        if (isset($options['authSource']))
        {
            $authSource = $options['authSource'];
        }
        else
        {
            $authSource = Security_Authentication_Source::getDefault();
        }

        if (!$authSource instanceof Security_Authentication_Source)
        {
            throw new Exception('Unknown Authentication Source');
        }

        $provider = $authSource->getProvider();

        $db = KTapi::getDb();

        try
        {
            $db->beginTransaction();

            $member = new Base_Member();
            $member->member_type = 'User';
            $member->save();

            $user = new Base_User();
            $user->member_id = $member->id;
            $user->username = $username;
            $user->name = $name;
            $user->email = $email;
            $user->auth_source_id = $authSource->getId();
            $user->auth_config = $provider->getUserAuthConfig($options);
            $user->timezone = KTAPI_Config::get(KTAPI_Config::DEFAULT_TIMEZONE);
            $user->language_id = KTAPI_Config::get(KTAPI_Config::DEFAULT_LANGUAGE);
            $user->created_date = date('Y-m-d H:i:s');

            if (isset($options['mobile'])) $user->mobile = $options['mobile'];
            if (isset($options['timezone'])) $user->timezone = $options['timezone'];
            if (isset($options['language'])) $user->language_id = $options['language'];

            $user->save();

            $db->commit();

            $user = new Security_User($user);

            // TODO: send general creation email
            if (isset($options['notifyUser']) && $options['notifyUser'])
            {
                // $provider->getEmailContent($user, $options);
            }

        }
        catch(Exception $ex)
        {
            $db->rollback();
            throw $ex;
        }

        return $user;
    }

    public
    function getId()
    {
        return $this->base->member_id;
    }

    public
    function getUsername()
    {
        return $this->base->username;
    }

    public
    function getName()
    {
        return $this->base->name;
    }

    public
    function getEmail()
    {
        return $this->base->email;
    }

    public function getMobile()
    {
        return $this->base->mobile;
    }

    public function getTimezone()
    {
        return $this->base->timezone;
    }

    public function getLanguage()
    {
        return $this->base->language;
    }

    public
    function setAuthSource($authSource, $options = array())
    {
        if (!$authSource instanceof Security_Authentication_Source)
        {
            throw new Exception('Unknown Authentication Source');
        }

        $this->base->auth_source_id = $authSource->getId();
        $this->base->auth_config = $authSource->getUserAuthConfig($options);
    }


    public
    function setName($name)
    {
        $this->base->name = $name;
    }

    public
    function setEmail($email)
    {
        $this->base->email = $email;
    }

    public
    function setTimezone($timezone)
    {
        $this->base->timezone = $timezone;
    }

    public
    function setLanguage($language)
    {
        $this->base->language_id = $language;
    }

    public
    function getLastLoginDate()
    {
        return $this->base->last_login_date;
    }

    public
    function getCreatedDate()
    {
        return $this->base->created_date;
    }

    public
    function getGroups()
    {
        $rows = $this->base->Groups;

        $class = get_class($this);

        return Util_Doctrine::getObjectArrayFromCollection($rows, 'Security_Group');
    }


    //TODO: clearRelated() should possibly be a seperate function. call it when really required.


    public
    function getEffectiveGroups()
    {
        // Note. if one removes this, the dynamic getter functions fail to refresh correctly.
        $this->base->clearRelated();
        $rows = $this->base->EffectiveGroups;

        return Util_Doctrine::getObjectArrayFromCollection($rows, 'Security_Group');
    }

    /**
     * Deletes the user by setting the status to 'deleted'.
     *
     * It sets the username to 'kt_deleted_(username)_(userid)'.
     *
     * @return void
     *
     */
    function delete()
    {
        $username = $this->base->username;

        $authSourceId = $this->base->auth_source_id;
        $authSourceConfig = $this->base->auth_config;

        $this->base->username = 'kt_deleted_' . $username . '_' . $this->getId();

        $defaultSource = Security_Authentication_Source::getDefault();
        $this->base->auth_source_id = $defaultSource->getId();
        $this->base->auth_config = array();

        try
        {
            parent::delete();
        }
        catch(Exception $ex)
        {
            $this->base->username = $username;

            $this->base->auth_source_id = $authSourceId;
            $this->base->auth_config = $authSourceConfig;

            throw $ex;
        }
    }

    /**
     * Returns a reference to the authentication provider based on the assigned authentication source.
     *
     * @return Security_Authentication_provider
     */
    private
    function getAuthProvider()
    {
        $source = $this->base->AuthenticationSource;

        $provider = PluginManager::getModule($source->auth_module_namespace);

        if (!$provider instanceof Security_Authentication_Provider )
        {
            throw new Exception('Security_Authentication_Provider expected');
        }

        return $provider;
    }


    /**
     * Indicates if the auth config can be changed for the current user.
     *
     * @return boolean
     */
    public
    function canChangeAuthConfig()
    {
        $provider = $this->getAuthProvider();

        return $provider->canChangeAuthConfig($this);
    }

    /**
     * Change the authentication configuration for the current user.
     *
     * @param array $options
     * @return void
     */
    public
    function changeAuthConfig($options = array())
    {
        $provider = $this->getAuthProvider();

        if (!$provider->canChangeAuthConfig($this))
        {
            throw new Exception('Cannot change authentication configuration');
        }

        return $provider->changeAuthConfig($this, $options);
    }

    /**
     * Return the auth configuration for the current user.
     *
     * @return array
     */
    public
    function getAuthConfig()
    {
        return $this->base->auth_config;
    }

    /**
     * Save the auth config for the current user.
     *
     * @param array $config
     */
    public
    function setAuthConfig($config)
    {
        $this->base->auth_config = $config;
        $this->save();
    }

    /**
     * Authenticates the user on the system. This is the primary function that should be used.
     *
     * @param array $options
     * @return Security_Session
     */
    public
    function authenticate($options)
    {
        if (!$this->isEnabled())
        {
            return false;
        }

        $provider = $this->getAuthProvider();

        $auth = $provider->authenticate($this, $options);

        if ($auth)
        {
            $this->base->invalid_login = 0;
            $this->base->last_login_date = date('Y-m-d H:i:s');
            $this->base->save();
            Security_Session::startUserSession($this, $options);
        }
        else
        {
            $this->base->invalid_login++;

            $threshold = KTAPI_Config::get(KTAPI_Config::INVALID_PASSWORD_THRESHOLD);
            $threshold_action = KTAPI_Config::get(KTAPI_Config::INVALID_PASSWORD_THRESHOLD_ACTION );

            $thresholdExceeded = $this->base->invalid_login > $threshold;
            if ($thresholdExceeded)
            {
                if ($threshold_action == 'disable')
                {
                    $this->base->status = 'Disabled';
                }
            }

            $this->save();

            // now do communication bit.
            if ($thresholdExceeded)
            {
                switch($threshold_action)
                {
                    case 'allow':
                        break;
                    case 'disable':
                        // TODO: send an email to the user and sysadmin/unitadmin that the account has been disabled
                        break;
                    case 'alert':
                        // TODO: send an email to the sysadmin/unitadmin that there is strange activity
                        break;
                }
            }
        }

        if ($auth == false)
        {
            return false;
        }

        return Security_Session::getSession($options);
    }

    /**
     * A local attribute caching if the the current user is a system administrator.
     *
     * @var boolean
     */
    private $isSystemAdmin;

    /**
     * Identifies if the current user is a system administrator.
     *
     * @return boolean
     */
    public
    function isSystemAdministrator()
    {
        if (isset($this->isSystemAdmin)) return $this->isSystemAdmin;

        $groups = $this->getEffectiveGroups();
        foreach($groups as $group)
        {
            if ($group->isSystemAdministrator())
            {
                $this->isSystemAdmin = true;
                return true;
            }
        }
        $this->isSystemAdmin = false;
        return false;
    }

    /**
     * A local attribute caching units the user has unit adminsitration rights on.
     *
     * @var array
     */
    private $adminUnits;

    /**
     * Identifies if the current user is a unit administrator.
     *
     * @return boolean
     */
    public
    function isUnitAdministrator()
    {
        if (isset($this->adminUnits))
        {
            return count($this->adminUnits) > 0;
        }

        $groups = $this->getEffectiveGroups();
        $unitGroups = array();
        foreach($groups as $group)
        {
            if ($group->isUnitAdministrator())
            {
                $unitGroups[] = $group;
            }
        }
        $this->adminUnits = $unitGroups;
        return count($this->adminUnits) > 0;
    }

    /**
     * Returns the units that the current user may administrator.
     *
     * @return array
     */
    public
    function getAdminUnits()
    {
        if (!$this->isUnitAdministrator())
        {
            return array();
        }
        return $this->adminUnits;
    }

    /**
     * A local attribute caching the units.
     *
     * @var array
     */
    private $units;

    /**
     * Returns all the units the current user is a member of.
     *
     * @return array
     */
    public
    function getUnits()
    {
        if (isset($this->units)) return $this->units;

        $units = array();
        $groups = $this->getEffectiveGroups();
        foreach($groups as $group)
        {
            $unit = $group->getUnit();

            if (is_null($unit))
            {
                continue;
            }
            $units[] = $unit;
        }

        $this->units = $units;
        return $this->units;
    }
}

?>