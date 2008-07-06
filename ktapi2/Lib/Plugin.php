<?php
abstract class Plugin extends KTAPI_Base
{
    public
    function __construct($base = null)
    {
        parent::__construct($base);
    }

    public
    function getDisplayName()
    {
        $config = $this->getConfig();
        ValidationUtil::arrayKeyExpected('display_name', $config);
        return _kt($config['display_name']);
    }

    public
    function getNamespace()
    {
        $config = $this->getConfig();
        ValidationUtil::arrayKeyExpected('namespace', $config);
        return 'plugin.' . $config['namespace'];
    }

    public abstract
    function getConfig();

    public
    function getId()
    {
        return $this->base->id;
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    public
    function getVersion()
    {
        return $this->base->config['version'];
    }

    /**
     * This is the database version for the plugin. It starts from zero and must be incremented
     * sequentially. Each db version must have a corresponding file in the plugin migrations directory.
     * The naming convention for the db migration files are XXX_name.php. A class
     * must be defined with a name (PluginName)Plugin_(XXX)_Upgrade
     *
     * @return int
     */
    public
    function getDbVersion()
    {
        return $this->base->config['db_version'];
    }

    public
    function getIncludes()
    {
        return $this->base->config['includes'];
    }

    public
    function getCurrentVersion()
    {
        if (is_null($this->base))
        {
            return 0;
        }

        return $this->base->version;
    }

    public
    function loadBase()
    {
        if (is_null($this->base))
        {
            $namespace = $this->getNamespace();
            $base = Doctrine::getTable('Base_Plugin')->findOneByNamespace($namespace);
            $this->base = empty($base)?null:$base;
        }
        return $this->base;
    }

    public
    function upgrade()
    {
        $newVersion = $this->getDbVersion();
        if ($newVersion == 0)
        {
            return;
        }

        $logger = LoggerManager::getLogger('upgrade');

        $migrationPath = _path($this->getBasePath() . 'migration');

        $displayName = $this->getDisplayName();
        $namespace = $this->getNamespace();

        $migration = new KTAPI_Migration($migrationPath);
        $logger->info(_str('Starting migration on plugin %s (%s) from %d to %d', $displayName, $namespace, $currentVersion, $newVersion));

        $migration->setContext($namespace);

        $raiseEx = null;


        try
        {
            $migration->migrate($newVersion);
        }
        catch(Doctrine_Migration_Exception $ex)
        {
            if (strpos($ex->getMessage(), 'Already at version') === false)
            {
                $raiseEx = $ex;
            }
        }
        catch(Exception $ex)
        {
            $raiseEx = $ex;
            PluginManager::disablePlugin($namespace, true); // true = force disable
        }
        $logger->info(_str('End migration on plugin %s (%s)', $displayName, $namespace));

        if (isset($raiseEx))
        {
            throw $raiseEx;
        }

    }

    public
    function canDisable()
    {
        return $this->base->can_disabled;
    }

    public
    function canDelete()
    {
        return $this->base->can_delete;
    }

    public
    function getOrder()
    {
        $this->base->ordering;
    }

    public
    function getDependencies()
    {
        return $this->base->config['dependencies'];
    }

    public
    function getBasePath()
    {
        return _ktpath(dirname($this->base->path));
    }

    public
    function getModules()
    {
        return $this->modules;
    }

    function register($path)
    {
        $db = KTapi::getDb();

        $namespace = $this->getNamespace();
        if (PluginManager::isPluginRegistered($namespace))
        {
            $record = $this->loadBase();
        }
        else
        {
             $record = new Base_Plugin();
        }

        $config = $this->getConfig();

        // TODO: in future, we could validate dependencies.
        // complications come in when reading plugins in random order.
        // better to do dependency checking at a higher level which has more scope.

        ValidationUtil::arrayKeyExpected('display_name', $config);

        if (!isset($config['description']))
        {
            $config['description'] = '';
        }
        if (!isset($config['version']))
        {
            $config['version'] = '0.1';
        }
        if (!isset($config['db_version']))
        {
            $config['db_version'] = 0;
        }
        if (!isset($config['dependencies']))
        {
            $config['dependencies'] = array();
        }
        if (!isset($config['includes']))
        {
            $config['includes'] = array();
        }

        $record->display_name = $config['display_name'];
        $record->path = _relativepath($path);
        $record->status = PluginStatus::ENABLED;
        $record->version = isset($config['version'])?$config['version']:'0.1';
        $record->can_disable = isset($config['can_disable'])?$config['can_disable']:true;
        $record->can_delete = isset($config['can_delete'])?$config['can_delete']:true;
        $record->namespace = $this->getNamespace();
        $record->config = $config;


        $record->save();

        if (!empty($dependencies))
        {
            foreach($dependencies as $dependency)
            {
                $table = new Base_PluginRelation();
                $table->plugin_namespace = $namespace;

                $table->related_plugin_namespace = $dependency;

                $table->save();
            }
        }

        $this->base = $record;

        $this->upgrade();

        return $record;
    }


    protected
    function registerTranslation($locale, $language, $POfilename)
    {
        $POfilename = _require($POfilename, $this->getBasePath());
        $lang = new Translation();
        $lang->register($this, $locale, $language, $POfilename);
    }

    protected
    function registerTable($tableName, $baseClass, $path)
    {
        $path = _require($path, $this->getBasePath());
        $table = new TableModule();
        $table->register($this, $path, $tableName, $baseClass);
    }

    protected
    function registerField($tableName, $fieldName, $className, $property)
    {
        $field = new FieldModule();
        $field->register($this, $tableName, $fieldName, $className, $property);
    }

    protected
    function registerMemberProperty($namespace, $baseClass, $displayName, $getter, $setter, $propertyName, $type, $default=null)
    {
        $property = new MemberPropertyModule();
        $property->register($this, $namespace, $baseClass, $displayName, $getter, $setter, $propertyName, $type, $default);
    }

    protected
    function registerUnitTest($className, $path)
    {
        $path = _require($path, $this->getBasePath());
        $test = new UnitTest();
        $test->register($this, $className, $path);
    }

    protected
    function registerAction($classname, $path)
    {
        $path = _require($path, $this->getBasePath());

        require_once($path);

        ValidationUtil::classExists($classname, $path);

        $action = new $classname;

        ValidationUtil::validateType($action, 'Action');

        $action->register($this, $path);
    }

    protected
    function registerTrigger($classname, $path)
    {
        $path = _require($path, $this->getBasePath());

        require_once($path);

        ValidationUtil::classExists($classname, $path);

        $trigger = new $classname;

        ValidationUtil::validateType($trigger, 'Trigger');

        $trigger->register($this, $path);
    }

    protected
    function registerAuthenticationProvider($classname, $path)
    {
        $path = _require($path, $this->getBasePath());

        require_once($path);

        ValidationUtil::classExists($classname, $path);

        $provider = new $classname;

        ValidationUtil::validateType($provider, 'Security_Authentication_Provider');

        $provider->register($this, $path);

        return $provider;
    }

    protected
    function registerStorageProvider($classname, $path)
    {
        $path = _require($path, $this->getBasePath());

        require_once($path);

        ValidationUtil::classExists($classname, $path);

        $provider = new $classname;

        ValidationUtil::validateType($provider, 'Security_Storage_Provider');

        $provider->register($this, $path);
    }
}
?>