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
        if (!is_object($obj))
        {
            throw new KTapiException(_kt('Object expected, but was passed %s', print_r($obj)));
        }
        $db = KTapi::getDb();

        $record = array();

        $record['display_name'] = $obj->getDisplayName();
        $record['classname'] = get_class($obj);
        $record['namespace'] = $obj->getNamespace();
        $record['module_config'] = $obj->getConfig();
        $record['ordering'] = $obj->getOrder();
        $record['can_disable'] = $obj->canDisable();
        $record['dependencies'] = $obj->getDependencies();

        return self::registerParams($plugin, $moduleType, $path, $record);
    }

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

        $params['module_config'] = (isset($params['module_config'])) ? _serialize($params['module_config']) : '';
        $params['dependencies'] = (isset($params['dependencies'])) ? _serialize($params['dependencies']) : '';

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