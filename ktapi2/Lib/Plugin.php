<?php
abstract class Plugin
{
    protected $basePlugin;

    public
    function __construct($basePlugin = null)
    {
        $this->basePlugin = $basePlugin;
    }

    public abstract
    function getDisplayName();

    public abstract
    function getNamespace();

    public
    function getId()
    {
        return $this->basePlugin->id;
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    public
    function getVersion()
    {
        return '0.1';
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
        return 0;
    }

    public
    function getIncludes()
    {
        return array();
    }

    public
    function getCurrentVersion()
    {
        if (is_null($this->basePlugin))
        {
            return 0;
        }

        return $this->basePlugin->version;
    }

    public
    function loadBase()
    {
        if (is_null($this->basePlugin))
        {
            $namespace = $this->getNamespace();
            $basePlugin = Doctrine::getTable('Base_Plugin')->findOneByNamespace($namespace);
            $this->basePlugin = empty($basePlugin)?null:$basePlugin;
        }
        return $this->basePlugin;
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
        return true;
    }

    public
    function canDelete()
    {
        return true;
    }

    public
    function getOrder()
    {
        return 0;
    }

    public
    function getDependencies()
    {
        return array();
    }

    public
    function getBasePath()
    {
        return _ktpath(dirname($this->basePlugin->path));
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
             $record = $db->create('Base_Plugin');
        }

        $dependencies = $this->getDependencies();

        // TODO: in future, we could validate dependencies.
        // complications come in when reading plugins in random order.
        // better to do dependency checking at a higher level which has more scope.

        $record->display_name = $this->getDisplayName();
        $record->path = _relativepath($path);
        $record->status = 'Enabled';
        $record->version = $this->getVersion();
        $record->can_disable = $this->canDisable();
        $record->can_delete = $this->canDelete();
        $record->namespace = $namespace;
        $record->dependencies = _serialize(
            array(
                'dependencies'=>$dependencies,
                'includes'=>$this->getIncludes()));

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

        $this->basePlugin = $record;

        $this->upgrade();

        return $record;
    }


    protected
    function registerLanguage($locale, $language, $POfilename)
    {
        $POfilename = _require($POfilename, $this->getBasePath());
        $lang = new Language();
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
    function registerUnitTest($className, $path)
    {
        $path = _require($path, $this->getBasePath());
        $test = new UnitTest();
        $test->register($this, $className, $path);
    }

    protected
    function registerAction($class, $path)
    {
        $path = _require($path, $this->getBasePath());

        require_once($path);
        if (!class_exists($class))
        {
           throw new KTapiException(_kt('Class %s was expected in: %s', $class, $path));
        }

        $action = new $class;
        $action->register($this, $path);
    }

    protected
    function registerTrigger($class, $path)
    {
        $path = _require($path, $this->getBasePath());

        require_once($path);
        if (!class_exists($class))
        {
           throw new KTapiException(_kt('Class %s was expected in: %s', $class, $path));
        }

        $trigger = new $class;
        $trigger->register($this, $path);
    }
}
?>