<?php
abstract class Plugin
{
    protected $basePlugin;

    public
    function getId()
    {
        return $this->basePlugin->id;
    }

    public abstract
    function getDisplayName();


    public abstract
    function getNamespace();

    protected
    function includeFile($fileName)
    {

    }

    public
    function getVersion()
    {
        return 1;
    }

    public
    function getBaseVersion()
    {
        return $this->basePlugin->version;
    }


    public
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
        $record->dependencies = _serialize($this->getDependencies());

        $record->save();

        $this->basePlugin = $record;

        return $record;
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
    function registerAction($class, $path)
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

        $action = new $class;
        $action->register($this, $path);
    }
}
?>