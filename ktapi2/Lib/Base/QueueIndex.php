<?php

class Base_QueueIndex extends KTAPI_Record
{

    public function setDefinition()
    {
        $this->setTableName('queue_indexing');

        $this->addInteger('node_id');
        $this->addEnumeration('stage', IndexStage::get(), IndexStage::REQUEST);
        $this->addTimestamp('request_date');
        $this->addTimestamp('processed_date');
        $this->addString('error');

    }

    public function setUp()
    {
        $this->hasOne('Base_Node','Node', 'node_id',  'id' );
    }

}