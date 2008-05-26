<?php

class CopyItemTestCase extends KTAPI_TestCase
{
    function testCopyItem()
    {
        $logger = LoggerManager::getLogger('sql');
        $logger->debug('hello world');
        $logger = LoggerManager::getLogger('page');
        $logger->debug('boo');
        $logger = LoggerManager::getLogger('page.def');
        $logger->debug('boo');
        $this->assertTrue(false);
    }
}

?>