<?php

class Security_User extends KTAPI_BaseMember
{
    // TODO: AUTHENTICATION SOURCE


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

        if (isset($options['password']))
        {
            $password = $options['password'];
        }
        else
        {
            $password = Util_Security::randomPassword();
            $options['password'] = $password;
            $notifyUser = true;
        }

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
            $user->auth_config = $authSource->getUserAuthConfig($options);
            $user->timezone = KTAPI_Config::get(KTAPI_Config::DEFAULT_TIMEZONE);
            $user->language_id = KTAPI_Config::get(KTAPI_Config::DEFAULT_LANGUAGE);
            $user->created_date = date('Y-m-d H:i:s');

            if (isset($options['mobile'])) $user->mobile = $options['mobile'];
            if (isset($options['timezone'])) $user->timezone = $options['timezone'];
            if (isset($options['language'])) $user->language_id = $options['language'];

            $user->save();

            $db->commit();

            $user = new Security_User($user);

            if (isset($options['notifyUser'])) $notifyUser = $options['notifyUser'];

            if ($notifyUser)
            {
                // TODO: mail user an email about password creation.
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

    public
    function getEffectiveGroups()
    {
        $rows = $this->base->EffectiveGroups;

        return Util_Doctrine::getObjectArrayFromCollection($rows, 'Security_Group');
    }


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


    public
    function canChangePassword()
    {
        $provider = $this->getAuthProvider();

        return $provider->canChangePassword($this);
    }

    public
    function changePassword($password, $options = array())
    {
        $provider = $this->getAuthProvider();

        if (!$provider->canChangePassword($this))
        {
            throw new Exception('Cannot change password');
        }

        return $provider->changePassword($this, $password, $options);
    }

    public
    function getAuthConfig()
    {
        return $this->base->auth_config;
    }

    public
    function setAuthConfig($config)
    {
        $this->base->auth_config = $config;
        $this->save();
    }

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

            $disabled = false;

            if ($this->base->invalid_login > $threshold)
            {
                if ($threshold_action == 'disable')
                {
                    $this->base->status = 'Disabled';
                    $disabled = true;
                }
            }

            $this->save();

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

        if ($auth == false)
        {
            return false;
        }

        return Security_Session::getSession($options);
    }

    private $isSystemAdmin;

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

    private $unitAdmins;

    public
    function isUnitAdmin()
    {
        if (isset($this->unitAdmins))
        {
            return count($this->unitAdmins) > 0;
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
        $this->unitAdmins = $unitGroups;
        return count($this->unitAdmins) > 0;
    }

}

?>