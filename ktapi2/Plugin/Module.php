<?php
class Plugin_Module extends BasePluginModule
{
    public
    function register($moduleType)
    {
        $db = KTapi::getDb();

        $record = $db->create('Plugin_Module');

        //$record = new Plugin_Module();
        $record->plugin_id = $this->plugin_id;
        $record->namespace = $this->namespace;
        $record->module_type = $moduleType;
        $record->display_name = $this->displayName;
        $record->status = $this->status;
        $record->classname = get_class($this);
        $record->path = $this->path;
        $record->module_config = $this->module_config;
        $record->ordering = $this->order;
        $record->can_disable = $this->canDisable;
        $record->dependencies = $this->dependencies;

        $record->save();
    }
}
?>