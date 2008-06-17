<?php

class UserAndGroupsTestCase extends KTAPI_TestCase
{
    function setUp()
    {
        $db = KTapi::getDb();
        $db->execute('DELETE FROM members');
    }

    function testUsers()
    {
        $this->title();

        $this->title('creating test users (test1, test2)');
        $user1 = Security_User::create('test1', 'Test User 1', 'test1@knowledgetree.com');
        $user2 = Security_User::create('test2', 'Test User 2', 'test2@knowledgetree.com');

        $this->title('testing Security_User::get()');
        list($u1, $u2) = Security_User::get(array($user1->Id, $user2->Id));
        $this->assertEqual($u1->Id, $user1->Id);
        $this->assertEqual($u2->Id, $user2->Id);
        $this->assertEqual($u1->Username, $user1->Username);
        $this->assertEqual($u2->Username, $user2->Username);
        $this->assertEqual($u1->Name, $user1->Name);
        $this->assertEqual($u2->Name, $user2->Name);

        $this->title('testing getByUsername()');
        $u1 = Security_User::getByUsername($user1->Username);
        $this->assertEqual($u1->Username, $user1->Username);
    }

    function testGroups()
    {
        $this->title();

        $this->title('creating test groups  (group 1, group 2)');
        $group1 = Security_Group::create('group 1');
        $group2 = Security_Group::create('group 2');

        $this->title('testing Security_Group::get()');
        list($g1, $g2) = Security_Group::get(array($group1->Id, $group2->Id));

        $this->assertEqual($g1->Id, $group1->Id);
        $this->assertEqual($g2->Id, $group2->Id);
        $this->assertEqual($g1->Name, $group1->Name);
        $this->assertEqual($g2->Name, $group2->Name);


        $this->title('testing $group1->addSubgroup($group2)');
        $group1->addSubgroup($group2);

        $this->assertTrue($group1->hasSubgroup($group2));
        $this->assertFalse($group2->hasSubgroup($group1));

        $this->assertTrue($group2->isMemberOf($group1));
        $this->assertFalse($group1->isMemberOf($group2));

        $this->title('testing $group2->getSubgroups()');
        $g2a = $group2->getSubgroups();

        $this->assertEqual(count($g2a), 0);

        $g1a = $group1->getSubgroups();
        $this->assertEqual(count($g1a), 1);
        $this->assertEqual($group2->Id, $g1a[0]->Id);


        $this->title('testing $group1->getParentGroups()');
        $g1a = $group1->getParentGroups();
        $this->assertEqual(count($g1a), 0);


        $g2a = $group2->getParentGroups();

        $this->assertEqual(count($g2a), 1);
        $this->assertEqual($group1->Id, $g2a[0]->Id);


    }

    function testUserGroups()
    {
        $this->title();

        $this->title('creating test data');
        $user1 = Security_User::create('test1', 'Test User 1', 'test1@knowledgetree.com');
        $group1 = Security_Group::create('group 1');
        $group2 = Security_Group::create('group 2');
        $group1->addSubgroup($group2);

        $this->title('testing $group2->addUser($user1)');
         $group2->addUser($user1);

         $this->assertFalse($group1->hasUser($user1));
         $this->assertTrue($group2->hasUser($user1));

        $this->title('testing $group1->getEffectiveUsers()');
         $users = $group1->getEffectiveUsers();

         $users = array_values($users);
         $this->assertEqual(count($users),1);
         $this->assertTrue($users[0]->Id, $user1->Id);

        $this->title('testing $group2->removeUser($user1)');

         $group2->removeUser($user1);

         $this->assertFalse($group1->hasUser($user1));
         $this->assertFalse($group2->hasUser($user1));

         $this->assertFalse($group1->hasEffectiveUser($user1));
         $this->assertFalse($group2->hasEffectiveUser($user1));

         $this->title('testing $group2->addUser($user1)');
         $group2->addUser($user1);

         $this->assertTrue($group1->hasEffectiveUser($user1));
         $this->assertTrue($group2->hasEffectiveUser($user1));

        $this->title('testing $group2->getUsers()');

         $users = $group2->getUsers();

         $this->assertEqual(count($users),1);
         $this->assertTrue($users[0]->Id, $user1->Id);

         $users = $group1->getUsers();

         $this->assertEqual(count($users),0);

         $users = $group2->getUsers('User');

         $this->assertEqual(count($users),1);
         $this->assertTrue($users[0]->Id, $user1->Id);

         $users = $group2->getUsers('boo');

         $this->assertEqual(count($users),0);


         $groups = $user1->getGroups();

         $this->assertEqual(count($groups),1);
         $this->assertTrue($groups[0]->Id, $group2->Id);

         $groups = $user1->getEffectiveGroups();

         $this->assertEqual(count($groups),2);
         $this->assertTrue($groups[0]->Id, $group1->Id);
         $this->assertTrue($groups[1]->Id, $group2->Id);

        $this->title('testing $group2->delete()');

         $group2->delete();

         $users = $group2->getUsers();

         $this->assertEqual(count($users),0);

         $users = $group1->getUsers();

         $this->assertEqual(count($users),0);

    }

    function testUpdateUsers()
    {
        $this->title();

        $this->title('creating $user1->save()');
        $user1 = Security_User::create('test1', 'Test User 1', 'test1@knowledgetree.com');

        $user1->Name = 'User 1 - Update';
        $user1->save();

        $userId = $user1->Id;

        $user1 = Security_User::get($userId);
        $this->assertEqual($userId, $user1->Id);
    }

    function testUpdateGroups()
    {
        $this->title();


        $this->title('creating $group1->save()');

        $group1 = Security_Group::create('group 1');
        $unit1 = Security_Unit::create('unit 1');
        $group1->Name = 'Group 1 - Update';
        $group1->save();


        $groupId = $group1->Id;

        $group1 = Security_Group::get($groupId);
        $this->assertEqual($groupId, $group1->Id);

        $group1->assignToUnit($unit1);

        $group1 = Security_Group::get($groupId);
        $this->assertEqual($group1->getUnitId(), $unit1->Id);

    }

    function testDuplicateUsernames()
    {
        $this->title();
        $user1 = Security_User::create('test1', 'Test User 1', 'test1@knowledgetree.com');
        $user1->delete();

        $user2 = Security_User::create('test1', 'Test User 1', 'test1@knowledgetree.com');
        $user3 = Security_User::create('test2', 'Test User 2', 'test2@knowledgetree.com');


        $users = Security_User::getUsersByFilter('');


    }

    function testDuplicateGroupNames()
    {
        $this->title();
        $group1 = Security_Group::create('group 1');
        $group1->delete();

        $group2 = Security_Group::create('group 1');

    }

    function testGroupAdmin()
    {
        $this->title();
        $group1 = Security_Group::create('group 1');

        $this->assertFalse($group1->isSystemAdministrator());
        $this->assertFalse($group1->isUnitAdministrator());

        $group1->setSystemAdministrator(true);
        $group1->setUnitAdministrator(false);

        $group1 = Security_Group::get($group1->Id);

        $this->assertTrue($group1->isSystemAdministrator());
        $this->assertFalse($group1->isUnitAdministrator());

        $group1->setUnitAdministrator(true);
        $this->assertTrue($group1->isUnitAdministrator());

    }

}

?>