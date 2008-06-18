<?php

class KTAPI_Config
{
    const MAX_SESSIONS                      = 'session.max';
    const SESSION_TIMEOUT                   = 'session.timeout';
    const ALLOW_ANONYMOUS_ACCESS            = 'session.allow.anonymous';

    const MAX_WEBSERVICE_SESSIONS           = 'session.webservice.max';
    const WEBSERVICE_SESSION_TIMEOUT        = 'session.webservice.timeout';

    const DEFAULT_LANGUAGE                  = 'language.default';
    const DEFAULT_TIMEZONE                  = 'timezone.default';

    const INVALID_PASSWORD_THRESHOLD        = 'invalid.password.threshold';
    const INVALID_PASSWORD_THRESHOLD_ACTION = 'invalid.password.threshold.action';

    const SMTP_HOST             = 'smtp.host';
    const SMTP_PORT             = 'smtp.port';
    const SMTP_USER             = 'smtp.username';
    const SMTP_PASSWORD         = 'smtp.password';
    const SMTP_SSL              = 'smtp.ssl';


    private static $config = null;

    /**
     * Initialise the config.
     *
     */
    private static
    function init()
    {
        if (isset(self::$config))
        {
            return;
        }

        self::$config = Doctrine_Query::create()
                    ->from('Base_Config c INDEXBY c.config_namespace')
                   // ->useResultCache(true)
                    ->execute();
    }

    /**
     * Get the default namespace
     *
     * @param string $namespace
     * @param mixed $default
     * @return mixed
     */
    public static
    function get($namespace, $default = null)
    {
        self::init();

        if (isset(self::$config[$namespace]))
        {
            // TODO: refactor into util class so we can reuse in other components

            $config = self::$config[$namespace];
            $value = $config->value;
            switch ($config->type)
            {
                case 'bool':
                case 'boolean':
                    return ($value == 'true')?true:false;
                case 'int':
                case 'integer':
                    return (int) $value;
                case 'double':
                case 'float':
                    return (double) $value;
                default:
                    return $value;
            }
        }

        if (isset($default))
        {
            return $default;
        }

        throw new KTapiConfigurationException('Unknown property');
    }

    /**
     * Set a value on the config
     *
     * @param string $namespace
     * @param mixed $value
     */
    public static
    function set($namespace, $value)
    {
        self::init();

        if (isset(self::$config[$namespace]))
        {
            // TODO: refactor into util class so we can reuse in other components
            $config = self::$config[$namespace];
            switch($config->type)
            {
                case 'bool':
                case 'boolean':
                    switch($value)
                    {
                        case 1:
                        case true:
                        case 'true':
                            $value = 'true';
                            break;
                        case 0:
                        case false:
                        case 'false':
                            $value = 'false';
                            break;
                        default:
                            throw new Exception('Invalid value');

                    }
                default:
                    $config->value = $value;
            }

            $config->save();
            return;
        }

        throw new KTapiConfigurationException(_str('Unknown namespace %s', $namespace));
    }

    /**
     * Create a new configuration item
     *
     * @param string $namespace
     * @param string $displayName
     * @param mixed $value
     * @param string $groupNamespace
     * @param array $options
     */
    public static
    function create($namespace, $displayName, $value, $groupNamespace, $options = array())
    {
        try
        {
            $group = self::getGroup($groupNamespace);
        }
        catch(Exception $ex)
        {
            // if group is not found, we should rethrow
            throw $ex;
        }

        try
        {
            $config = self::get($namespace);
            throw new KTapiConfigExistsException($namespace);
        }
        catch(KTapiConfigExistsException $ex)
        {
            throw $ex;
        }
        catch(Exception $ex)
        {
            // don't do anything.
        }

        $config = new Base_Config();
        $config->config_namespace = $namespace;
        $config->display_name = $displayName;
        $config->value = $value;
        $config->config_group_id = $group->id;

        $params = array('default', 'can_edit', 'type','type_config','description');

        foreach($params as $param)
        {
            if (isset($options[$param])) $config->$param = $options[$param];
        }

        $config->save();
    }

    public static
    function getGroup($namespace)
    {
        return Util_Doctrine::simpleOneQuery('Base_ConfigGroup', array('group_namespace'=>$namespace));
    }

    public static
    function deleteGroup($namespace)
    {
        Util_Doctrine::simpleDelete('Base_ConfigGroup', array('group_namespace'=>$namespace));
    }

    public static
    function delete($namespace)
    {
        Util_Doctrine::simpleDelete('Base_Config', array('config_namespace'=>$namespace));
    }


    public static
    function createGroup($namespace, $displayName, $description)
    {
        try
        {
            $group = self::getGroup($namespace);
            throw new Exception('Group exists');
        }
        catch(Exception $ex)
        {
            // don't do anything...
        }
            $group = new Base_ConfigGroup();
            $group->group_namespace = $namespace;
            $group->display_name = $displayName;
            $group->description = $description;
            $group->save();

    }

}

?>