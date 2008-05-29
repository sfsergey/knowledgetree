<?php


class Base_Tag extends Doctrine_Record
{

    public function setTableDefinition()
    {
        $this->setTableName('tag');
        $this->hasColumn('id', 'integer', 4, array('unsigned' => 1, 'primary' => true, 'notnull' => true, 'autoincrement' => true));
    }

    public function setUp()
    {
        parent::setUp();
    }
}