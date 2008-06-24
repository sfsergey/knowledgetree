<?php

class Base_SavedSearch extends KTAPI_Record
{

  public function setDefinition()
  {
    $this->setTableName('saved_search');

    /*

    if is_subscribed = 1, then we must run the experession periodially, and mail the user the results.

    when member_id = null, then appropriate members may see.

    */

    $this->addAutoInc('id');
    $this->addString('name');
    $this->addString('expression');
    $this->addBooleanWithDefault('is_subscribed', 0);
    $this->addInteger('member_id', false);
  }

  public function setUp()
  {
  }
}