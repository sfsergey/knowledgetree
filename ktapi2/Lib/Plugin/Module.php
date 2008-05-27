<?php

interface ModuleInterface
{
    function getNamespace();
    function getDisplayName();
    function getConfig();
    function getOrder();
    function canDisable();
    function getDependencies();

}

class Plugin_Module extends Base_PluginModule
{
    public static
    function registerObject($plugin, $moduleType, $obj, $path)
    {
        if (!$plugin instanceof Plugin)
        {
            throw new KTapiException('Plugin expected, but was passed %s', get_class($plugin));
        }
        if (!is_object($plugin instanceof Plugin))
        {
            throw new KTapiException('Plugin expected, but was passed %s', get_class($plugin));
        }
        $db = KTapi::getDb();

        $record = $db->create('Base_PluginModule');

        $record->plugin_id = $plugin->getId();
        $record->module_type = $moduleType;
        $record->display_name = $obj->getDisplayName();
        $record->status = 'Enabled';
        $record->classname = get_class($obj);
        $record->namespace = $obj->getNamespace();
        $record->path = _relativepath($path);
        $record->module_config = $obj->getConfig();
        $record->ordering = $obj->getOrder();
        $record->can_disable = $obj->canDisable();
        $record->dependencies = $obj->getDependencies();

        $record->save();

        return $record;
    }

    public static
    function registerParams($plugin, $moduleType, $path, $params)
    {
        if (!$plugin instanceof Plugin)
        {
            throw new KTapiException('Plugin expected, but was passed %s', get_class($plugin));
        }
        if (!is_array($params))
        {
            throw new KTapiException('Array expected, but was passed %s', get_class($plugin));
        }
        $db = KTapi::getDb();

        $record = $db->create('Base_PluginModule');

        $record->plugin_id = $plugin->getId();
        $record->module_type = $moduleType;
        $record->status = 'Enabled';
        $record->namespace = $obj->getNamespace();
        $record->path = _relativepath($path);

        $valid_keys = array('classname','display_name','module_config','ordering','can_disable','dependencies');

        foreach($params as $key=>$value)
        {
            if (!in_array($key, $valid_keys))
            {
                throw new KTapiException(_kt('Invalid key: %s', $key));
            }
            $record->$key = $value;
        }

        $record->save();

        return $record;
    }



}
?>