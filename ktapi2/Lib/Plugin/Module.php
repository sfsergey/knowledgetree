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
    function registerParams($plugin, $moduleType, $path, $params)
    {
        if (!$plugin instanceof Plugin)
        {
            throw new KTapiException(_kt('Plugin expected, but was passed %s', get_class($plugin)));
        }
        if (!is_array($params))
        {
            throw new KTapiException(_kt('Array expected, but was passed %s', print_r($params, true)));
        }
        $db = KTapi::getDb();

        $record = $db->create('Base_PluginModule');

        $record->plugin_id = $plugin->getId();
        $record->module_type = $moduleType;
        $record->status = 'Enabled';
        $record->path = _relativepath($path);

        $valid_keys = array('classname','display_name','module_config','ordering','can_disable','dependencies', 'namespace');
        $serialize_keys = array('module_config', 'dependencies');

        if (isset($params['namespace']))
        {
            $params['namespace'] .= '.' . $plugin->getNamespace();
        }

        foreach($params as $key=>$value)
        {
            if (!in_array($key, $valid_keys))
            {
                throw new KTapiException(_kt('Invalid key: %s', $key));
            }
            if (in_array($key, $serialize_keys))
            {
                $value = _serialize($value);
            }
            $record->$key = $value;
        }

        $record->save();

        return $record;
    }



}
?>