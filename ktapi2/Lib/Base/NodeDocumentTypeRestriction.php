<?php

class Base_NodeDocumentTypeRestriction extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('node_document_type_restrictions');

    $this->addIntegerPrimary('node_id');
    $this->addIntegerPrimary('document_type_id');
  }

  public function setUp()
  {
    $this->hasOne('Base_Node','Node', 'node_id', 'id');
    $this->hasOne('Base_DocumentType','DocumentType', 'document_type_id', 'id');
  }
}