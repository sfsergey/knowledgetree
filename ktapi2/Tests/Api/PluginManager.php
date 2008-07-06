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
            print $ex->getMessage() . "\n";
        }
    }

    function testPluginManager()
    {
        $this->title();

        PluginManager::addPluginLocation('ktapi2/Tests/Plugin/Test');

        $this->title('PluginManager::readAllPluginLocations()');

        PluginManager::readAllPluginLocations();

        $this->title('PluginManager::disableModule');
        PluginManager::disableModule('field.base_document.custom_document_no.plugin.test');
        $this->title('PluginManager::isModuleEnabled');
        $this->assertFalse(PluginManager::isModuleEnabled('field.base_document.custom_document_no.plugin.test'));

        PluginManager::disableModule('table.tag.plugin.test');
        $this->assertFalse(PluginManager::isModuleEnabled('table.tag.plugin.test'));

        $this->title('PluginManager::enableModule');
        PluginManager::enableModule('table.tag.plugin.test');
        $this->title('PluginManager::isModuleEnabled');
        $this->assertTrue(PluginManager::isModuleEnabled('table.tag.plugin.test'));

        $this->title('PluginManager::isPluginRegistered()');
        $this->assertTrue(PluginManager::isPluginRegistered('plugin.test'));
        $this->title('PluginManager::isPluginEnabled()');
        $this->assertTrue(PluginManager::isPluginEnabled('plugin.test'));


    }

    function testGetPluginModules()
    {
        $this->title();

        PluginManager::addPluginLocation('ktapi2/Tests/Plugin');

        PluginManager::readAllPluginLocations();

        $this->title('PluginManager::getPluginModules()');
        $modules = PluginManager::getPluginModules();
        $this->assertTrue(count($modules) > 0);
        //var_dump($modules);
    }

    function testGetNewPlugins()
    {
        $this->title();

        $this->title('PluginManager::getNewPlugins()');
        $plugins = PluginManager::getNewPlugins();
        $this->assertTrue(count($plugins) > 0);
        //var_dump($plugins);
    }

    function testGetPlugins()
    {
        $this->title();

        PluginManager::addPluginLocation('ktapi2/Tests/Plugin');

        PluginManager::readAllPluginLocations();

        $this->title('PluginManager::getPlugins()');
        $plugins = PluginManager::getPlugins();
        $this->assertTrue(count($plugins) > 0);
        //var_dump($plugins);
    }


}

?>