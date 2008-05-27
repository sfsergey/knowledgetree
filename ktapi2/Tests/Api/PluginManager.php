<?php

class PluginManagerTestCase extends KTAPI_TestCase
{
    function testPluginManager()
    {
        PluginManager::addPluginLocation('ktapi2/Tests/Plugin');

        PluginManager::readAllPluginLocations();

        PluginManager::uninstallPlugin('plugin.test');
    }



}

?>