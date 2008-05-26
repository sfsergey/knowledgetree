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
    function register($plugin, $moduleType, $obj, $path)
    {
        $db = KTapi::getDb();

        $record = $db->create('Base_PluginModule');

        $record->plugin_id = $plugin->getId();
        $record->module_type = $moduleType;
        $record->display_name = $obj->getDisplayName();
        $record->status = 'Disabled';
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
}
?>