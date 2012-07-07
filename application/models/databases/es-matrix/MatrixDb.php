<?php

require_once 'lib/Db/MySQLDB.php';

class MatrixDb extends MySQLDB
{
  protected $_host = 'localhost';
  protected $_dbname = 'es-matrix';
  protected $_username = 'root';
  protected $_password = 'r2d2c3rt';
  
  /* NOTE: Value must be written exactly so, see MySQL manual */
  protected $_charset = 'utf8';
}