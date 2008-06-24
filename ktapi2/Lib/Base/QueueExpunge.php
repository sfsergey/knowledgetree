<?php

class Base_QueueExpunge extends KTAPI_Record
{

    public function setDefinition()
    {
        $this->setTableName('queue_expunge');

        $this->addInteger('node_id');
    }

    public function setUp()
    {
        $this->hasOne('Base_Node','Node', 'node_id',  'id' );
    }

}