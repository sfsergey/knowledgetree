<?php

class DocumentTestCase extends KTAPI_TestCase
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
        PluginManager::addPluginLocation('ktapi2/Tests/Plugin/Test');

        PluginManager::readAllPluginLocations();

    }
    function testGetDocument()
    {
        $rootFolder = Repository_Folder::get(1);

        print "$rootFolder->Id\n";
        print "$rootFolder->Name\n";
        print "$rootFolder->Description\n";
        print "$rootFolder->ParentId\n";
        print "$rootFolder->CreatedById\n";
        print "$rootFolder->FullPath\n";
        print "$rootFolder->OwnerId\n";

        var_dump($rootFolder->getListing(array('contentTypes'=>Repository_Folder::FOLDER_LISTING)));

        $this->assertTrue(true);
    }
}

?>