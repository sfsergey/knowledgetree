<?php

class Base_NodeContentMetadataVersion extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('node_content_metadata_versions');

    $this->addIntegerPrimary('node_metadata_version_id');
    $this->addInteger('document_type_id');
    $this->addInteger('real_metadata_version_id');
    $this->addInteger('content_node_id');
    $this->addInteger('workflow_state_id');
    $this->addString('custom_doc_no',1024);
    $this->addString('filename');
  }

  public function setUp()
  {
    $this->hasOne('Base_NodeMetadataVersion','NodeMetadataVersion', 'node_metadata_version_id', 'id');
    $this->hasOne('Base_DocumentType','DocumentType', 'document_type_id', 'id');
    $this->hasOne('Base_RealMetadataVersion','RealMetadataVersion', 'real_metadata_version_id', 'id');
    $this->hasOne('Base_Node','ContentNode', 'content_node_id', 'id');
    $this->hasOne('Base_WorkflowState','WorkflowState', 'workflow_state_id', 'id');
  }
}