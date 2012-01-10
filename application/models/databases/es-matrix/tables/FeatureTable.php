<?php

require_once 'lib/Db/Table.php';

require_once 'application/models/databases/es-matrix/MatrixDb.php';

class FeatureTable extends Table
{
  protected $_name = 'feature';

  public function __construct()
  {
    $this->_database = Application::getInstance()->getDefaultDatabase();
  }
}
