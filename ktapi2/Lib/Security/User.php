<?php

class Security_User
{
    /**
     *
     * @var Base_User
     */
    private $base;

    public
    function __construct($base)
    {
        $this->base = $base;
    }

    protected
    function __get($property)
    {
        $method = 'get' . $property;
        if (method_exists($this, $method))
        {
            return call_user_func(array($this, $method));
        }
        else
        {
            throw new KTapiUnknownPropertyException($this, $property);
        }
    }

    protected
    function __set($property, $value)
    {
        $method = 'set' . $property;
        if (method_exists($this, $method))
        {
            return call_user_func(array($this, $method), $value);
        }
        else
        {
            throw new KTapiUnknownPropertyException($this, $property);
        }
    }


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

        if (isset($options['password']))
        {
            $password = $options['password'];
        }
        else
        {
            if (!isset($options['authSource']))
            {
                $password = Util_Security::randomPassword();
                $notifyUser = true;
            }
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
            $user->password = Util_Security::hashPassword($password);
            $user->email = $email;

            if (isset($options['mobile'])) $user->mobile = $options['mobile'];
            if (isset($options['timezone'])) $user->timezone = $options['timezone'];
            if (isset($options['language'])) $user->language = $options['language'];

            $user->save();

            $db->commit();

            $user = new Security_User($user);
            if (isset($options['authSource']))
            {
                $authname = isset($options['authId'])?$options['authId']: $username;

                $user->setAuthenticationSource($options['authSource'], $authname);
            }

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
    function validatePassword($password)
    {
        return Util_Security::hashPassword($password) == $this->base->password;
    }

    public
    function setAuthenticationSource($authSource, $authId)
    {
        throw new Exception('TODO');
    }

    public
    function setPassword($password)
    {
        $this->base->password = Util_Security::hashPassword($password);
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
        $this->base->language = $language;
    }

    public
    function save()
    {
        $this->base->save();
    }
}

?>