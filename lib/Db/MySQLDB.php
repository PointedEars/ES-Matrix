<?php

require_once 'lib/Db/Database.php';

class MySQLDB extends Database
{
  /**
   * Database host
   * @var string
   */
  protected $_host;
  
  /**
  * Database name
  * @var string
  */
  protected $_dbname;
  
  /**
   * Username to access the database
   * @var string
   */
  protected $_username;
  
  /**
   * Password to access the database
   * @var string
   */
  protected $_password;
  
  public function __construct()
  {
    $this->_dsn = "mysql:host={$this->_host};dbname={$this->_dbname}";
    parent::__construct();
  }
  
  /**
  * Escapes an associative array so that its string representation can be used
  * in a query.
  *
  * NOTE: Intentionally does not check whether the array actually is associative!
  *
  * @param array &$array
  *   The array to be escaped
  * @return array
  *   The escaped array
  */
  protected function _escapeArray(array &$array)
  {
    foreach ($array as $column => &$value)
    {
      $value = "`" . $column . "`=:{$column}";
    }
  
    return $array;
  }
}