<?php

class PluginManagerTestCase extends KTAPI_TestCase
{
    function setUp()
    {
        try {
            PluginManager::uninstallPlugin('plugin.test');
        }
        catch (Exception $ex){
            // do nothing, we don't care
        }
    }

    function testPluginManager()
    {
        PluginManager::addPluginLocation('ktapi2/Tests/Plugin');

        PluginManager::readAllPluginLocations();

        PluginManager::get();
    }
}

?>