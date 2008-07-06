<?php

require_once('../KTapi.inc.php');

KTapi::initTestFramework();

class KTAPI_TestCase extends UnitTestCase
{
    protected
    function title($title  = null)
    {
        if (is_null($title))
        {
            $call = get_call_stack();

            $title = $call[1]['called_function'];
            $title = "\n$title";
        }
        else $title = "\t$title";
        print "$title\n";
    }

    protected
    function dropTable($tablename)
    {
        $db = KTapi::getDb();
        try
        {
           $db->execute("DROP TABLE " . $tablename);
        }
        catch(Exception $ex)
        {

        }
    }

}

class UnitTests extends TestSuite
{
    function UnitTests()
    {
        $this->TestSuite('KnowledgeTree KTAPI Unit tests');
        $this->addFile('Api/PluginManager.php');
        $this->addFile('Api/PluginUpgrade.php');

        PluginManager::addPluginLocation('ktapi2/Commercial');
        PluginManager::addPluginLocation('ktapi2/Plugins');

        PluginManager::uninstallPlugin('plugin.core', array('force_overwrite'=>true,'silent'=>true));
        PluginManager::readAllPluginLocations();

        $this->addFile('Api/Config.php');
        $this->addFile('Api/UserAndGroups.php');


        $this->addFile('Api/Roles.php');
        $this->addFile('Api/Units.php');

        $this->addFile('Api/Metadata.php');
        $this->addFile('Api/Authentication/HashedPassword.php');
    }

    function addFile($file)
    {
        $file = _ktapipath('Tests/' . $file, false);
        parent::addFile($file);
    }
}

$test = new UnitTests();

if (array_key_exists('argv',$_SERVER))
{
    $reporter = new TextReporter();
}
else
{
    $reporter = new HtmlReporter();
}

$test->run($reporter);

?>
