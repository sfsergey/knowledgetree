<?php

// DONE

class Base_WorkflowDocumentTypeAssociation extends KTAPI_Record
{
    public
    function setDefinition()
    {
        $this->setTableName('workflow_document_type_associations');

        /*

        When a document with document_type_id is added, the workflow is started automatically.

         */

        $this->addInteger('workflow_id');
        $this->addInteger('document_type_id');
    }

    public function setUp()
    {
        $this->hasOne('Base_Workflow', 'Workflow', 'workflow_id', 'id');
        $this->hasOne('Base_DocumentType', 'DocumentType', 'document_type_id', 'member_id');
    }
}