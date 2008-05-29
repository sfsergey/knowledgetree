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

    public
    function getIncludes()
    {
        return array();
    }

    public
    function getVersion()
    {
        return 1;
    }

    public
    function getCurrentVersion()
    {
        return $this->basePlugin->version;
    }

    public

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
        return dirname($this->basePlugin->path) . DIRECTORY_SEPARATOR;
    }

    function register($path)
    {
        $db = KTapi::getDb();

        $record = $db->create('Base_Plugin');

        $record->display_name = $this->getDisplayName();
        $record->path = $path;
        $record->status = 'Enabled';
        $record->version = $this->getVersion();
        $record->can_disable = $this->canDisable();
        $record->can_delete = $this->canDelete();
        $record->namespace = $this->getNamespace();
        $record->dependencies = _serialize(
            array(
                'dependencies'=>$this->getDependencies(),
                'includes'=>$this->getIncludes()));

        $record->save();

        $this->basePlugin = $record;

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
        if (!empty($path) && dirname($path) == '.')
        {
            $path = dirname($this->basePlugin->path) . DIRECTORY_SEPARATOR . $path;
        }

        if (!file_exists($path))
        {
            throw new KTapiException(_kt('File expected: %s', $path));
        }

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