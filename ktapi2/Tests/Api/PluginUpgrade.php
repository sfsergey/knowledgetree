<?php

class PluginUpgradeTestCase extends KTAPI_TestCase
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

    function testPluginUpgrade()
    {
        PluginManager::addPluginLocation('ktapi2/Tests/Plugin/Test');

        PluginManager::readAllPluginLocations();

        PluginManager::clearPluginLocations();

        $db = KTapi::getDb();
        $db->execute('UPDATE plugins SET path = :path WHERE namespace = :namespace',
                    array(':namespace'=>'plugin.test', ':path'=> 'ktapi2/Tests/Plugin/Test2Upgrade/Test2Plugin.inc.php'));

        PluginManager::addPluginLocation('ktapi2/Tests/Plugin/Test2Upgrade');
        PluginManager::addPluginLocation('ktapi2/Tests/Plugin/Test2Different');

        PluginManager::readAllPluginLocations();
    }


}

?>