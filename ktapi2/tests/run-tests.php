<?php

require_once('../KTapi.inc.php');

KTapi::initTestFramework();


class UnitTests extends TestSuite
{
    function UnitTests()
    {
        $this->TestSuite('KnowledgeTree KTAPI Unit tests');
        $this->addFile('api/Authentication.php');
        $this->addFile('api/DocumentActions/CheckoutDocument.php');
        $this->addFile('api/Document.php');
        $this->addFile('api/FolderActions/AddDocument.php');
        $this->addFile('api/Folder.php');
    }

    function addFile($file)
    {
        $file = _ktapipath('tests/' . $file, false);
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
