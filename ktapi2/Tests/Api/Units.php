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
        print "\n\ntestUnits()\n\n";

        $unit1 = Security_Unit::create('test1');
        $unit2 = Security_Unit::create('test2');

        list($u1, $u2) = Security_Unit::get(array($unit1->Id, $unit2->Id));
        $this->assertEqual($u1->Id, $unit1->Id);
        $this->assertEqual($u2->Id, $unit2->Id);
        $this->assertEqual($u1->Name, $unit1->Name);
        $this->assertEqual($u2->Name, $unit2->Name);

        $u1 = Security_Unit::getByUnitName($unit1->Name);
        $this->assertEqual($u1->Name, $unit1->Name);
    }

}

?>