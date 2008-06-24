<?php

class Base_QueueDownload extends KTAPI_Record
{

    public function setDefinition()
    {
        $this->setTableName('queue_downloads');

        $this->addAutoInc('id');
        $this->addInteger('content_node_id');
        $this->addString('hash');
        $this->addTimestamp('expiry_date');

    }

    public function setUp()
    {
        $this->hasOne('Base_Node','Node', 'content_node_id',  'id' );
    }

}