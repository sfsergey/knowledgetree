<?php

class Base_NodeShortcut extends KTAPI_Record
{
  public function setDefinition()
  {
    $this->setTableName('node_shortcuts');

    $this->addIntegerPrimary('node_id');
    $this->addInteger('shortcut_node_id');
  }

  public function setUp()
  {
    $this->hasOne('Base_Node','Node', 'node_id', 'id');
    $this->hasOne('Base_Node','ShortcutNode', 'shortcut_node_id', 'id');
  }

}