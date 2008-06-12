<?php

require_once('../KTapi.inc.php');

KTapi::initTestFramework();

class KTAPI_TestCase extends UnitTestCase
{
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
        $this->addFile('Api/UserAndGroups.php');
        $this->addFile('Api/Roles.php');
        $this->addFile('Api/Units.php');
        $this->addFile('Api/Metadata.php');
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
