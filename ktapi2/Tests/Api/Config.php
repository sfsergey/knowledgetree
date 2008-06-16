<?php

class ConfigTestCase extends KTAPI_TestCase
{
    const GROUP_NAMESPACE = 'group.test';
    const CONFIG_NAMESPACE = 'my.test';

    function testConfig()
    {
        $this->title();


        $this->title('KTAPI_Config::createGroup()');

        KTAPI_Config::deleteGroup(self::GROUP_NAMESPACE );
        KTAPI_Config::createGroup(self::GROUP_NAMESPACE ,'stuff','stuff');

        $this->title('KTAPI_Config::getGroup()');

        $group = KTAPI_Config::getGroup(self::GROUP_NAMESPACE );

        $this->assertEqual($group->group_namespace, self::GROUP_NAMESPACE );

        $this->title('KTAPI_Config::create()');

        KTAPI_Config::delete(self::CONFIG_NAMESPACE);

        KTAPI_Config::create(self::CONFIG_NAMESPACE , 'Test', 'Value', self::GROUP_NAMESPACE);


        $this->title('KTAPI_Config::set() & KTAPI_Config::get()');

        KTAPI_Config::set(KTAPI_Config::ALLOW_ANONYMOUS_ACCESS, true);
        $this->assertTrue(KTAPI_Config::get(KTAPI_Config::ALLOW_ANONYMOUS_ACCESS));

        KTAPI_Config::set(KTAPI_Config::ALLOW_ANONYMOUS_ACCESS, false);
        $this->assertFalse(KTAPI_Config::get(KTAPI_Config::ALLOW_ANONYMOUS_ACCESS));

    }
}

?>