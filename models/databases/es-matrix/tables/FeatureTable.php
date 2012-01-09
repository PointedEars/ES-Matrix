<?php

require_once 'lib/Db/Table.php';

require_once 'models/databases/es-matrix/MatrixDb.php';

class FeatureTable extends Table
{
  protected $_name = 'feature';

  public function __construct()
  {
    /* TODO: Re-use Database instance */
    $this->_database = new MatrixDb();
  }
}

