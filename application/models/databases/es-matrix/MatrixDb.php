<?php

require_once 'lib/Db/MySQLDB.php';

class MatrixDb extends PointedEars\PHPX\Db\MySQLDB
{
  protected $_dbname = 'es-matrix';
}