<?php

class Security_Session extends KTAPI_Base
{
    const SESSION       = 'kt_session';
    const USER          = 'kt_user';
    const AUTHENTICATED = 'kt_auth';
    const ANONYMOUS     = 'kt_anon';
    const SYSTEM_ADMIN  = 'kt_admin';
    const ADMIN_MODE    = 'kt_admin_mode';
    const UNIT_ADMIN    = 'kt_unit_admin';
    const ADMIN_UNITS   = 'kt_admin_units';
    const UNITS         = 'kt_units';

    public
    function __construct($base)
    {
        parent::__construct($base);
    }

    /**
     * Has a session started where a user authenticated with authentication credientials.
     *
     * @return boolean
     */
    public static
    function isAuthenticated()
    {
        return isset($_SESSION[self::AUTHENTICATED ]) && ($_SESSION[self::AUTHENTICATED ]?true:false);
    }

    /**
     * Has an anonymous session started.
     *
     * @return boolean
     */
    public static
    function isAnonymous()
    {
        return isset($_SESSION[self::ANONYMOUS]) && ($_SESSION[self::ANONYMOUS]?true:false);
    }

    /**
     * Is the current user a system admin.
     *
     * @return boolean
     */
    public static
    function isSystemAdminUser()
    {
        return isset($_SESSION[self::SYSTEM_ADMIN]) && ($_SESSION[self::SYSTEM_ADMIN]?true:false);
    }

    /**
     * Is the current user a unit administrator.
     *
     * @return boolean
     */
    public static
    function isUnitAdminUser()
    {
        return isset($_SESSION[self::UNIT_ADMIN ]) && ($_SESSION[self::UNIT_ADMIN]?true:false);
    }

    /**
     * Does the current user have system admin or unit admin rights.
     *
     * @return boolean
     */
    public static
    function isAdminUser()
    {
        return self::isSystemAdminUser() || self::isUnitAdminUser();
    }

    /**
     * Is the current administrator in admin mode.
     *
     * @return boolean
     */
    public static
    function isAdminModeEnabled()
    {
        return isset($_SESSION[self::ADMIN_MODE ]) && ($_SESSION[self::ADMIN_MODE ]?true:false);
    }

    /**
     * Destroy the current session.
     *
     */
    public static
    function endSession($options = array())
    {
        if (self::isSessionActive($options))
        {
            Util_Doctrine::simpleDelete('Base_ActiveSession', array('session'=>session_id()));
        }

        session_unset();
    }

    /**
     * Enable admin mode if the current user is an admin
     *
     */
    public static
    function enableAdminMode()
    {
        if (!self::isAdminUser())
        {
            throw new Exception('Cannot assign admin mode');
        }
        $_SESSION[self::ADMIN_MODE] = true;
    }

    /**
     * Disable admin mode
     *
     */
    public static
    function disableAdminMode()
    {
        if (self::isAdminModeEnabled())
        {
            unset($_SESSION[self::ADMIN_MODE]);
        }
    }

    /**
     * Start an anonymous session.
     *
     * @param array $options
     */
    public static
    function startAnonymousSession($options = array())
    {
        if (KTAPI_Config::get(KTAPI_Config::ALLOW_ANONYMOUS_ACCESS))
        {
            $user = Security_User::getAnonymousUser();
            $options['anonymous'] = true;

            self::startUserSession($user, $options);
        }
        else
        {
            throw new KTapiException('Cannot start anonymous session.');
        }
    }

    /**
     * Return an array with user information associated with the current session.
     *
     * @param array $options
     * @return Security_User
     */
    public static
    function getSessionUser($options = array())
    {
        if (!isset($_SESSION[self::USER]))
        {
            self::startAnonymousSession($options);
        }
        else
        {
            self::resumeSession(session_id(), $options);
        }

        return $_SESSION[self::USER];
    }

    /**
     * Indicates if an authenticated or anonymous session is active.
     *
     * @return boolean
     */
    public static
    function isSessionActive($options = array())
    {
        try
        {
            self::getSessionUser($options);
        }
        catch(Exception $ex)
        {
            return false;
        }

        return self::isAnonymous() || self::isAuthenticated();
    }

    /**
     * Returns session information.
     *
     * @param array $options
     * @return Security_Session
     */
    public static
    function getSession($options = array())
    {
        if (self::isSessionActive())
        {
            return $_SESSION[self::SESSION ];
        }

        throw new KTapiException('No session is active');

    }

    private static
    function clearOldSessions()
    {
        $now = getdate();

        $normalTimeout = KTAPI_Config::get(KTAPI_Config::SESSION_TIMEOUT);
        $webserviceTimeout = KTAPI_Config::get(KTAPI_Config::WEBSERVICE_SESSION_TIMEOUT);

        $expiry = date("Y-m-d H:i:s", mktime($now['hours'],$now['minutes']-$normalTimeout,$now['seconds'],$now['day'], $now['mon'], $now['year']));
        $webserviceExpiry = date("Y-m-d H:i:s", mktime($now['hours'],$now['minutes']-$webserviceTimeout,$now['seconds'],$now['day'], $now['mon'], $now['year']));


        Doctrine_Query::create()
            ->delete()
            ->from('Base_ActiveSession s')
            ->where('(s.activity_date <= :normal_expiry AND s.is_webservice != :webservice) OR (s.activity_date <= :webservice_expiry AND s.is_webservice = :webservice)',
                    array(':normal_expiry'=>$expiry, ':webservice_expiry'=>$webserviceExpiry, ':webservice'=>true))
            ->execute();

    }

    public static
    function resumeSession($session, $options = array())
    {
        self::clearOldSessions();

        if (isset($_SESSION[self::SESSION ]))
        {
            $sesion = $_SESSION[self::SESSION ]->getPHPsession();

            if ($session == $sesion)
            {
                return $_SESSION[self::SESSION ];
            }
        }

        try
        {
            $sesion = Util_Doctrine::simpleOneQuery('Base_ActiveSession', array('session'=>$session));
            $sesion->activity_date = date('Y-m-d H:i:s');
            $sesion->save();

            session_id($session);
        }
        catch(Exception $ex)
        {
            throw new KTapiException('Session expired!');
        }

        return $_SESSION[self::SESSION ];
    }

    private static
    function resolveIp($options)
    {
        if (isset($options['ip']))
        {
            $ip = $options['ip'];
        }
        else
        {
            if (getenv("REMOTE_ADDR"))
            {
                $ip = getenv("REMOTE_ADDR");
            }
            elseif (getenv("HTTP_X_FORWARDED_FOR"))
            {
                $forwardedip = getenv("HTTP_X_FORWARDED_FOR");
                list($ip,$ip2,$ip3,$ip4)= split (",", $forwardedip);
            }
            elseif (getenv("HTTP_CLIENT_IP"))
            {
                $ip = getenv("HTTP_CLIENT_IP");
            }

            if ($ip == '')
            {
                $ip = '127.0.0.1';
            }
        }

        if (!is_numeric($ip))
        {
            $ip = sprintf('%u',ip2long($ip));
        }

        return $ip;
    }

    public static
    function startUserSession($user, $options = array())
    {
        self::clearOldSessions();
        $_SESSION = array();

        $userId = $user->getId();

        $session = new Base_ActiveSession();
        $session->session = session_id();
        $session->user_member_id = $userId;
        $session->ip = self::resolveIp($options);
        $session->is_webservice = isset($options['is_webservice']) && $options['is_webservice'];
        $session->activity_date = date('Y-m-d H:i:s');
        if (isset($options['is_webservice']) && $options['is_webservice']) $session->is_webservice = true;

        $session->save();

        $_SESSION[self::USER] = $user;

        if (isset($options['anonymous']) && $options['anonymous'])
        {
            $_SESSION[self::ANONYMOUS] = true;

            if (isset($_SESSION[self::AUTHENTICATED ]))
            {
                unset($_SESSION[self::AUTHENTICATED ]);
            }
        }
        else
        {
            $_SESSION[self::AUTHENTICATED ] = true;
            if (isset($_SESSION[self::ANONYMOUS ]))
            {
                unset($_SESSION[self::ANONYMOUS ]);
            }

            if ($user->isSystemAdministrator())
            {
                $_SESSION[self::SYSTEM_ADMIN] = true;
            }

            if ($user->isUnitAdministrator())
            {
                $_SESSION[self::ADMIN_UNITS ] = $user->getAdminUnits();
            }

            $_SESSION[self::UNITS ] = $user->getUnits();

            // delete sessions
            $maxSessions = $session->is_webservice?KTAPI_Config::get(KTAPI_Config::MAX_WEBSERVICE_SESSIONS ):KTAPI_Config::get(KTAPI_Config::MAX_SESSIONS);

            $rows = Doctrine_Query::create()
                    ->select('s.id')
                    ->from('Base_ActiveSession s')
                    ->where('user_member_id = :member_id', array(':member_id'=>$userId))
                    ->orderBy('s.id')
                    ->limit($maxSessions)
                    ->offset($maxSessions)
                    ->execute();

            $rows->delete();
        }

        $_SESSION[self::SESSION ] = new Security_Session($session);
    }

    /**
     * Starts a php session
     *
     */
    public static
    function startPHPsession()
    {
        $session = session_id();
        if (empty($session))
        {
            session_start();
        }
    }

    public
    function getId()
    {
        return $this->base->id;
    }

    public
    function getPHPsession()
    {
        return $this->base->session;
    }

    public
    function getStartDate()
    {
        return $this->base->start_date;
    }

    public
    function getIP()
    {
        return long2ip($this->base->ip);
    }

    public
    function isWebservice()
    {
        return $this->base->is_webservice;
    }

    public
    function getActivityDate()
    {
        return $this->base->activity_date;
    }

}



?>