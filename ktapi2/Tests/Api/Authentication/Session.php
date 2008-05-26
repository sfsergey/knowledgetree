<?php

class SesionTestCase extends KTAPI_TestCase
{
    function testStartBasicSession()
    {
        $session = new Session(array('username'=>'admin','password'=>'admin'),'127.0.0.1');
        $session->onFailure = array('KtAPI','failed'); // callback function
        KTapi::authenticate($session);
    }
    function testStartAnonymousSession()
    {
        $session = new AnonymousSession('127.0.0.1');
        $session->onFailure = array('KtAPI','failed'); // callback function
        KTapi::authenticate($session);
    }
    function testResumeActiveSession()
    {
        $session = new ResumeSession();
        $session->onFailure = array('KtAPI','failed'); // callback function
        KTapi::authenticate($session);
    }
    function testStartWebserviceSession()
    {
        $session = new Session(array('username'=>'admin','password'=>'admin', 'webservice'=>true),'127.0.0.1');
        $session->onFailure = array('KtAPI','failed'); // callback function
        KTapi::authenticate($session);
    }
    function testStopSession()
    {
        $session = new Session(array('username'=>'admin','password'=>'admin', 'webservice'=>true),'127.0.0.1');
        $session->onFailure = array('KtAPI','failed'); // callback function
        KTapi::authenticate($session);
        $session->end();   // alias for logout
    }
    function testResumeWebserviceSession()
    {
        $session = new ResumeSession('1231239123','127.0.0.1');
        $session->onFailure = array('KtAPI','failed'); // callback function
        KTapi::authenticate($session);
    }
}

?>