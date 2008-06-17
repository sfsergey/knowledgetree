<?php

class HashedAuthenticationTestCase extends KTAPI_TestCase
{

    function testAuthentication()
    {
        $this->title();

        // don't allow anonymous access for now
        KTAPI_Config::set(KTAPI_Config::ALLOW_ANONYMOUS_ACCESS, false);

        PluginManager::addPluginLocation('ktapi2/Plugins');
        PluginManager::readAllPluginLocations();

        try
        {
            $user = Security_User::getByUsername('admin');
            $user->delete();
        }
        catch(Exception $ex)
        {
        }

        try
        {
            $user = Security_User::create('admin', 'Test User 1', 'test1@knowledgetree.com', array('password'=>'123'));
        }
        catch(Exception $ex)
        {
        }

        $this->title('Security_Session::getSession()');

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

        $this->assertFalse(Security_Session::isAdminModeEnabled());

        $this->title('$user->canChangePassword()');

        $this->assertTrue($user->canChangePassword());

        $user->changePassword(array('password'=>'new password'));
    }

    function testResume()
    {
        $this->title();

        $user1 = Security_User::getByUsername('admin');
        $user1->changePassword(array('password'=>'123'));

        $this->title('$user1->authenticate()');

        $session1 = $user1->authenticate(array('password'=>'123', 'ip'=>'127.0.0.1'));

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

        try
        {
            $group = Security_Group::getByGroupName('sysadmin group');
            $group->delete();
        }
        catch(Exception $ex)
        {
        }

        $group = Security_Group::create('sysadmin group');


        $user1 = Security_User::getByUsername('admin');

        $this->assertFalse($user1->isSystemAdministrator());

        $group->setSystemAdministrator(true);

        try {
        $group->addUser($user1);
        }
        catch(Exception $ex)
        {
            // might not be a problem. fix add user to check before adding constraint
        }
        $user1 = Security_User::getByUsername('admin');

        $this->title('$user1->isSystemAdministrator()');
        $this->assertTrue($user1->isSystemAdministrator());

        $this->title('Security_Session::enableAdminMode()');
        $session1 = $user1->authenticate(array('password'=>'123', 'ip'=>'127.0.0.1'));


        Security_Session::enableAdminMode();
        $this->title('Security_Session::isAdminModeEnabled()');
        $this->assertTrue(Security_Session::isAdminModeEnabled());

        $group->delete();
    }

}

?>