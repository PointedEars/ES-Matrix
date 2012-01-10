<?php

require_once 'lib/Db/Table.php';

require_once 'application/models/databases/es-matrix/MatrixDb.php';

class TestcaseTable extends Table
{
  protected $_name = 'testcase';

  public function __construct()
  {
    $this->_database = Application::getInstance()->getDefaultDatabase();
  }
}

