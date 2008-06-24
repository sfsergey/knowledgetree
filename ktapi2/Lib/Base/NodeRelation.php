<?php

class Base_NodeRelation extends KTAPI_Record
{
  public function setDefinition()
  {
    $this->setTableName('node_relations');

    $this->addInteger('node_id');
    $this->addInteger('related_node_id');
    $this->addInteger('relation_type_id');
  }

  public function setUp()
  {
    $this->hasOne('Base_Node','Node', 'node_id', 'id');
    $this->hasOne('Base_Node','RelatedNode', 'related_node_id', 'id');
    $this->hasOne('Base_RelationType','RelationType', 'relation_type_id', 'id');
  }
}