<?php

class RolesTestCase extends KTAPI_TestCase
{
    function setUp()
    {
        $db = KTapi::getDb();
        $db->execute('DELETE FROM members');
    }

    function testRoles()
    {
        print "\n\ntestRoles()\n\n";

        $role1 = Security_Role::create('test1');
        $role2 = Security_Role::create('test2');

        list($r1, $r2) = Security_Role::get(array($role1->Id, $role2->Id));
        $this->assertEqual($r1->Id, $role1->Id);
        $this->assertEqual($r2->Id, $role2->Id);
        $this->assertEqual($r1->Name, $role1->Name);
        $this->assertEqual($r2->Name, $role2->Name);

        $r1 = Security_Role::getByRoleName($role1->Name);
        $this->assertEqual($r1->Name, $role1->Name);
    }

}

?>