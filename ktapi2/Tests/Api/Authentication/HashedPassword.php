<?php

class HashedAuthenticationTestCase extends KTAPI_TestCase
{
    function setUp()
    {
        $db = KTapi::getDb();
        $db->execute('DELETE FROM members');
    }

    function testAuthentication()
    {
        $this->title();

        $user = Security_User::create('admin', 'Test User 1', 'test1@knowledgetree.com', array('password'=>'123'));

        $this->title('Security_Session::getSession()');

        // getting a session now should throw exception
        try
        {
            $session = Security_Session::getSession();
            $this->assertTrue(false);
        }
        catch(Exception $ex)
        {
            $this->assertTrue(true);
        }
        $this->title('Security_Session::isAuthenticated() - false');

        $this->assertFalse(Security_Session::isAuthenticated());

        $user = Security_User::getByUsername('admin');

        $this->title('$user->authenticate()');

        $session = $user->authenticate(array('password'=>'123', 'ip'=>'127.0.0.1'));

        $this->title('Security_Session::isAuthenticated() - true');

        $this->assertTrue(Security_Session::isAuthenticated());

        $this->title('Security_Session::isAuthenticated() - false');

        $this->assertFalse(Security_Session::isAnonymous());

        $user = Security_Session::getSessionUser();

        $this->title('Security_Session::endSession()');

        Security_Session::endSession();

        $this->assertFalse(Security_Session::isAuthenticated());

        $this->title('Security_Session::enableAdminMode()');

        try
        {
            Security_Session::enableAdminMode();
            $this->assertTrue(false);
        }
        catch(Exception $ex)
        {
            // we expect an exception as
            $this->assertTrue(true);
        }
        $this->assertFalse(Security_Session::isAdminModeEnabled());

        $this->title('$user->canChangeAuthConfig()');

        $this->assertTrue($user->canChangeAuthConfig());

        $this->title('$user->changeAuthConfig()');
        $user->changeAuthConfig(array('password'=>'new password'));
    }

    function testResume()
    {
        $this->title();

        $user = Security_User::create('admin', 'Test User 1', 'test1@knowledgetree.com', array('password'=>'123'));


        $user1 = Security_User::getByUsername('admin');
        $user1->changeAuthConfig(array('password'=>'123'));

        $this->title('$user1->authenticate()');

        $session1 = $user1->authenticate(array('password'=>'123', 'ip'=>'127.0.0.1'));

        // we expect getting session to work now.
        try
        {
            $session1 = Security_Session::getSession();
            $this->assertTrue(true);
        }
        catch(Exception $ex)
        {
            $this->assertTrue(false);
        }
        $this->assertEqual($session1->PHPsession, session_id());

        $session1 = Security_Session::resumeSession($session1->PHPsession);

        $session1 = Security_Session::getSession();

        $this->assertEqual($session1->PHPsession, session_id());

        $this->assertTrue(Security_Session::isAuthenticated());
    }

    function testSysAdmin()
    {
        $this->title();

        $group = Security_Group::create('sysadmin group');
        $user = Security_User::create('admin', 'Test User 1', 'test1@knowledgetree.com', array('password'=>'123'));


        $user1 = Security_User::getByUsername('admin');

        $this->assertFalse($user1->isSystemAdministrator());

        $group->setSystemAdministrator(true);

        $group->addUser($user1);

        $user1 = Security_User::getByUsername('admin');

        $this->title('$user1->isSystemAdministrator()');
        $this->assertTrue($user1->isSystemAdministrator());

        $this->title('Security_Session::enableAdminMode()');
        $session1 = $user1->authenticate(array('password'=>'123', 'ip'=>'127.0.0.1'));


        Security_Session::enableAdminMode();
        $this->title('Security_Session::isAdminModeEnabled()');
        $this->assertTrue(Security_Session::isAdminModeEnabled());

    }

}

?>