<?php

require_once 'lib/Db/MySQLDB.php';

class MatrixDb extends MySQLDB
{
  protected $_host     = 'localhost';
  protected $_dbname   = 'db_mw3020_1';
  protected $_username = 'usr_mw3020';
  protected $_password = '6fd3f5b4q0';
  
  /* NOTE: Value must be written exactly so, see MySQL manual */
  protected $_charset  = 'utf8';
}