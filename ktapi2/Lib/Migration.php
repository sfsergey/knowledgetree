<?php

class KTAPI_Migration extends Doctrine_Migration
{
    protected $context;

    public
    function setContext($context)
    {
        $this->context = $context;
    }

    // TODO: add index on context
    protected function createMigrationTable()
    {
        $conn = Doctrine_Manager::connection();

        try {
            $conn->export->createTable($this->_migrationTableName, array(
                'version' => array('type' => 'integer', 'size' => 11),
                'context' => array('type' => 'string', 'length' => 100)
                ));

            $definition = array( 'fields'=>array('context' => array() ) );

            $conn->export->createIndex($this->_migrationTableName, 'context' , $definition);

            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    protected function setCurrentVersion($number)
    {
        if (empty($this->context))
        {
            throw new KTapiException('Context must be set!');
        }

        $conn = Doctrine_Manager::connection();

        if ($this->hasMigrated()) {
            $conn->exec('UPDATE ' . $this->_migrationTableName . " SET version = :number WHERE context = :context",array(':number'=>$number,':context'=>$this->context));
        } else {
            $conn->exec('INSERT INTO ' . $this->_migrationTableName . " (context, version) VALUES (:context, :number)",array(':number'=>$number,':context'=>$this->context));
        }
    }


    public function getCurrentVersion()
    {
        if (empty($this->context))
        {
            throw new KTapiException('Context must be set!');
        }
        $conn = Doctrine_Manager::connection();

        $result = $conn->fetchColumn('SELECT version FROM ' . $this->_migrationTableName . ' WHERE context = :context',array(':context'=>$this->context));

        return isset($result[0]) ? $result[0]:0;
    }


    public function hasMigrated()
    {
        if (empty($this->context))
        {
            throw new KTapiException('Context must be set!');
        }

        $conn = Doctrine_Manager::connection();

        $result = $conn->fetchColumn('SELECT version FROM ' . $this->_migrationTableName . ' WHERE context = :context',array(':context'=>$this->context));

        return isset($result[0]) ? true:false;
    }
}

?>