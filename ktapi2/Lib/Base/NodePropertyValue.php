<?php

class Base_NodePropertyValue extends KTAPI_Record
{
  public function setDefinition()
  {
    $this->setTableName('node_property_values');

    $this->addAutoInc('id');
    $this->addInteger('node_id');
    $this->addNamespace('property_namespace');
    $this->addString('value');
  }

  public function setUp()
  {
    $this->hasOne('Base_Node','Node', 'node_id', 'id');
  }
}