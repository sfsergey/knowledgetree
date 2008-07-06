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

    const CACHE_DIRECTORY           = 'directory.cache';
    const TEMPORARY_DIRECTORY       = 'directory.temp';

    const ROOT_URL                  = 'url.root';

    const BROWSE_PAGINATE_ITEMS     = 'browse.paginate.count';
    const BROWSE_PAGINATE_OPTIONS     = 'browse.paginate.options';


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

        $query = Doctrine_Query::create()
                    ->from('Base_Config c INDEXBY c.config_namespace');

        self::$config = $query->execute();
    }

    public static
    function clearCache()
    {
        self::$config = null;
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
            $config = self::$config[$namespace];
            return TypeUtil::encodeValue($config->value, $config->type);
        }

        if (isset($default))
        {
            return $default;
        }

        throw new KTAPI_Configuration_UnknownNamespaceException($namespace);
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
            $config = self::$config[$namespace];
            $config->value = TypeUtil::decodeValue($value, $config->type);
            $config->save();
            return;
        }

        throw new KTAPI_Configuration_UnknownNamespaceException($namespace);
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
            throw new KTAPI_Configuration_NamespaceExistsException($namespace);
        }
        catch(KTAPI_Configuration_NamespaceExistsException $ex)
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
        return DoctrineUtil::simpleOneQuery('Base_ConfigGroup', array('group_namespace'=>$namespace));
    }

    public static
    function deleteGroup($namespace)
    {
        DoctrineUtil::simpleDelete('Base_ConfigGroup', array('group_namespace'=>$namespace));
    }

    public static
    function delete($namespace)
    {
        DoctrineUtil::simpleDelete('Base_Config', array('config_namespace'=>$namespace));
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