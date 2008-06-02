<?php

class PluginManagerTestCase extends KTAPI_TestCase
{
    function setUp()
    {
        try {
            $migration = new KTAPI_Migration();
            $migration->dropTable('tag');
            $migration->dropTable('migration_version');

            PluginManager::uninstallPlugin('plugin.test', array('force_overwrite'=>true));
            PluginManager::uninstallPlugin('plugin.testdiff', array('force_overwrite'=>true));
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

        $this->assertTrue(PluginManager::isModuleEnabled('field.base_document.custom_document_no.plugin.test'));
        $this->assertTrue(PluginManager::isModuleEnabled('table.tag.plugin.test'));

        $this->assertTrue(PluginManager::isPluginRegistered('plugin.test'));
        $this->assertTrue(PluginManager::isPluginEnabled('plugin.test'));
    }


}

?>