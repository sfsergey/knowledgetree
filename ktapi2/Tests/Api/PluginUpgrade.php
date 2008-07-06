<?php

class PluginUpgradeTestCase extends KTAPI_TestCase
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

    function testPluginUpgrade()
    {
        $this->title();
        PluginManager::addPluginLocation('ktapi2/Tests/Plugin/Test');

        PluginManager::readAllPluginLocations();

        $this->title('PluginManager::clearPluginLocations()');
        PluginManager::clearPluginLocations();

        $db = KTapi::getDb();
        $db->execute('UPDATE plugins SET path = :path WHERE namespace = :namespace',
                    array(':namespace'=>'plugin.test', ':path'=> 'ktapi2/Tests/Plugin/Test2Upgrade/Test2Plugin.inc.php'));

        $this->title('PluginManager::addPluginLocation()');

        PluginManager::addPluginLocation('ktapi2/Tests/Plugin/Test2Upgrade');
        PluginManager::addPluginLocation('ktapi2/Tests/Plugin/Test2Different');

        PluginManager::readAllPluginLocations();

        $this->title('PluginManager::uninstallPlugin()');
        PluginManager::uninstallPlugin('plugin.testdiff');

        $this->title('PluginManager::isPluginRegistered()');
        $this->assertTrue(PluginManager::isPluginRegistered('plugin.testdiff'));

    }


}

?>