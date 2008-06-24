<?php

class Base_QueueUpload extends KTAPI_Record
{

    public function setDefinition()
    {
        $this->setTableName('queue_uploads');

        $this->addAutoInc('id');
        $this->addString('temp_filename');
        $this->addString('orig_filename');
        $this->addInteger('filesize');
        $this->addString('hash');
        $this->addTimestamp('created_date');

    }

    public function setUp()
    {
        $this->hasOne('Base_Node','Node', 'content_node_id',  'id' );
    }

}