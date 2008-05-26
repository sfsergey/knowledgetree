<?php

class PluginManagerTestCase extends KTAPI_TestCase
{
    function testPluginManager()
    {
        PluginManager::addPluginLocation('ktapi2/Tests/Plugin');

        PluginManager::readAllPluginLocations();

        $query = Doctrine_Query::create();
        $query->select('pm.status')
          ->from('Base_Plugin pm')
          ->where('pm.status = :status');

        $namespaces = $query->execute(array(':status' => 'Disabled'), Doctrine::FETCH_ARRAY);
        var_dump($namespaces);


    }
}

?>