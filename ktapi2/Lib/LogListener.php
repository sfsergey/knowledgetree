<?php

class KTAPI_LogListener extends Doctrine_EventListener
{
    public function preStmtExecute(Doctrine_Event $event)
    {
        $logger = LoggerManager::getLogger('sql');

        $logger->debug($event->getQuery());
        $logger->debug($event->getParams());
    }
}

?>