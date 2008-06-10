<?php

class DocumentTestCase extends KTAPI_TestCase
{
    function setUp()
    {
        $db = KTapi::getDb();
        $db->execute('DELETE FROM members');
    }

    function testUsers()
    {
        print "\n\ntestUsers()\n\n";

        $user1 = Security_User::create('test1', 'Test User 1', 'test1@knowledgetree.com');
        $user2 = Security_User::create('test2', 'Test User 2', 'test2@knowledgetree.com');

        list($u1, $u2) = Security_User::get(array($user1->Id, $user2->Id));
        $this->assertEqual($u1->Id, $user1->Id);
        $this->assertEqual($u2->Id, $user2->Id);
        $this->assertEqual($u1->Username, $user1->Username);
        $this->assertEqual($u2->Username, $user2->Username);
        $this->assertEqual($u1->Name, $user1->Name);
        $this->assertEqual($u2->Name, $user2->Name);

        $u1 = Security_User::getByUsername($user1->Username);
        $this->assertEqual($u1->Username, $user1->Username);
    }

    function testGroups()
    {
        print "\n\ntestGroups()\n\n";

        $group1 = Security_Group::create('group 1');
        $group2 = Security_Group::create('group 2');

        list($g1, $g2) = Security_Group::get(array($group1->Id, $group2->Id));

        $this->assertEqual($g1->Id, $group1->Id);
        $this->assertEqual($g2->Id, $group2->Id);
        $this->assertEqual($g1->Name, $group1->Name);
        $this->assertEqual($g2->Name, $group2->Name);

        $group1->addSubgroup($group2);

        $this->assertTrue($group1->hasSubgroup($group2));
        $this->assertFalse($group2->hasSubgroup($group1));

        $this->assertTrue($group2->isMemberOf($group1));
        $this->assertFalse($group1->isMemberOf($group2));

        $g2a = $group2->getSubgroups();

        $this->assertEqual(count($g2a), 0);

        $g1a = $group1->getSubgroups();
        $this->assertEqual(count($g1a), 1);
        $this->assertEqual($group2->Id, $g1a[0]->Id);


        $g1a = $group1->getParentGroups();
        $this->assertEqual(count($g1a), 0);


        $g2a = $group2->getParentGroups();

        $this->assertEqual(count($g2a), 1);
        $this->assertEqual($group1->Id, $g2a[0]->Id);


    }

    function testUserGroups()
    {
        print "\n\ntestUserGroups()\n\n";

        $user1 = Security_User::create('test1', 'Test User 1', 'test1@knowledgetree.com');
        $group1 = Security_Group::create('group 1');
        $group2 = Security_Group::create('group 2');
        $group1->addSubgroup($group2);

         $group2->addUser($user1);

         $this->assertFalse($group1->hasUser($user1));
         $this->assertTrue($group2->hasUser($user1));

         $group2->removeUser($user1);

         $this->assertFalse($group1->hasUser($user1));
         $this->assertFalse($group2->hasUser($user1));

         $this->assertFalse($group1->hasEffectiveUser($user1));
         $this->assertFalse($group2->hasEffectiveUser($user1));

         $group2->addUser($user1);

         $this->assertTrue($group1->hasEffectiveUser($user1));
         $this->assertTrue($group2->hasEffectiveUser($user1));

    }

    function testUpdateUsers()
    {
        print "\n\ntestUpdateUsers()\n\n";

        $user1 = Security_User::create('test1', 'Test User 1', 'test1@knowledgetree.com');

        $user1->Name = 'User 1 - Update';
        $user1->save();

        $userId = $user1->Id;

        $user1 = Security_User::get($userId);
        $this->assertEqual($userId, $user1->Id);
    }

    function testUpdateGroups()
    {
        print "\n\ntestUpdateGroups()\n\n";

        $group1 = Security_Group::create('group 1');
        $group1->Name = 'Group 1 - Update';
        $group1->save();

        $groupId = $group1->Id;

        $group1 = Security_Group::get($groupId);
        $this->assertEqual($groupId, $group1->Id);
    }
}

?>