<?php

class PluginManagerTestCase extends KTAPI_TestCase
{
    function setUp()
    {
        try {
            PluginManager::uninstallPlugin('plugin.test');
            PluginManager::uninstallPlugin('plugin.testdiff');
        }
        catch (Exception $ex){
            // do nothing, we don't care
        }
    }

    function testPluginManager()
    {
        PluginManager::addPluginLocation('ktapi2/Tests/Plugin/Test');

        PluginManager::readAllPluginLocations();

        PluginManager::disableModule('field.base_document.custom_document_no.plugin.test');
        PluginManager::disableModule('table.tag.plugin.test');
        PluginManager::enableModule('table.tag.plugin.test');

        $this->assertFalse(PluginManager::isModuleEnabled('field.base_document.custom_document_no.plugin.test'));
        $this->assertTrue(PluginManager::isModuleEnabled('table.tag.plugin.test'));

        $this->assertTrue(PluginManager::isPluginRegistered('plugin.test'));
        $this->assertTrue(PluginManager::isPluginEnabled('plugin.test'));
    }


}

?>