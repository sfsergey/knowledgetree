<?php

class UnitsTestCase extends KTAPI_TestCase
{
    function setUp()
    {
        $db = KTapi::getDb();
        $db->execute('DELETE FROM members');
    }

    function testUnits()
    {
        $this->title();

        $this->title('creating units (test1, test2)');
        $unit1 = Security_Unit::create('test1');
        $unit2 = Security_Unit::create('test2');

        $this->title('testing Security_Unit::get()');
        list($u1, $u2) = Security_Unit::get(array($unit1->Id, $unit2->Id));
        $this->assertEqual($u1->Id, $unit1->Id);
        $this->assertEqual($u2->Id, $unit2->Id);
        $this->assertEqual($u1->Name, $unit1->Name);
        $this->assertEqual($u2->Name, $unit2->Name);

        $this->title('testing Security_Unit:getByUnitName()');
        $u1 = Security_Unit::getByUnitName($unit1->Name);
        $this->assertEqual($u1->Name, $unit1->Name);
    }

    function testUserUnits()
    {
        // TODO: complete

        // add group1, group2, group3
        // assign group1 and group3 to unit 1 and unit 2
        // group2 must be subgroup to group3
        // add user1 to group1 and group 2
        // add user2 to group1 and group3

    }

}

?>