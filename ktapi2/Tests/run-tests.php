<?php

require_once('../KTapi.inc.php');

KTapi::initTestFramework();


class UnitTests extends TestSuite
{
    function UnitTests()
    {
        $this->TestSuite('KnowledgeTree KTAPI Unit tests');
        $this->addFile('Api/PluginManager.php');
//        $this->addFile('api/Authentication/Builtin.php');
//        $this->addFile('api/Authentication/ActiveDirectory.php');
//        $this->addFile('api/Authentication/Ldap.php');
//        $this->addFile('api/DocumentActions/Checkout.php');
//        $this->addFile('api/DocumentActions/Checkin.php');
//        $this->addFile('api/DocumentActions/RenameFilename.php');
//        $this->addFile('api/FolderActions/AddDocument.php');
//        $this->addFile('api/FolderActions/AddFolder.php');
//        $this->addFile('api/ItemActions/CopyItem.php');
//        $this->addFile('api/ItemActions/DeleteItem.php');
//        $this->addFile('api/ItemActions/MoveItem.php');
//        $this->addFile('api/ItemActions/RenameItem.php');
//        $this->addFile('api/Document.php');
//        $this->addFile('api/Folder.php');
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
