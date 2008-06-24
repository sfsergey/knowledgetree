<?php

class Base_QueueNotification extends KTAPI_Record
{

    public function setDefinition()
    {
        $this->setTableName('queue_notifications');

        $this->addInteger('email_id');
        $this->addInteger('user_id');
        $this->addInteger('node_id');
        $this->addArray('email_config');

        /*

        Could also add status conditions in case there is failure.... ??

        */
    }

    public function setUp()
    {
        $this->hasOne('Base_EmailTemplate','Email', 'email_id',  'id' );
        $this->hasOne('Base_User','User', 'user_id',  'member_id' );
        $this->hasOne('Base_Node','Node', 'node_id',  'id' );
    }

}