<?php

require_once 'lib/Db/Adapter.php';
require_once 'lib/Db/MySQLDB.php';

class MySQLAdapter extends Adapter
{
  /**
  * Constructs the adapter, associating a {@link MySQLDB} with it
  * @param MySQLDB $database
  */
  /* Singleton */
  protected function __construct(MySQLDB $database)
  {
    parent::__construct($database);
  }
}