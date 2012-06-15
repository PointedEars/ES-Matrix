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
  
  /*
   * Optional charset parameter value
   */
  protected $_charset = null;
  
  public function __construct()
  {
    $this->_dsn = "mysql:host={$this->_host}"
      . (!is_null($this->_dbname) ? ";dbname={$this->_dbname}" : '')
      . (!is_null($this->_charset) ? ";charset={$this->_charset}" : '');
    
    if (!is_null($this->_charset))
    {
      $this->_options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES " . $this->_charset;
    }
    
    parent::__construct();
  }
  
  /**
   * Escapes a database name so that it can be used in a query.
   *
   * @param string $name
   *   The name to be escaped
   * @return string
   *   The escaped name
   */
  public function escapeName($name)
  {
    return '`' . $name . '`';
  }

  /**
   * (non-PHPdoc)
   * @see Database::_escapeAliasArray()
   */
  protected function _escapeAliasArray(array &$array)
  {
    foreach ($array as $column => &$value)
    {
      $value = $value . ' AS `' . $column . '`';
    }
  
    return $array;
  }

  /**
   * (non-PHPdoc)
   * @see Database::_escapeValueArray()
   */
  protected function _escapeValueArray(array &$array, $suffix = '', array &$escape = array('`', '`'))
  {
    return parent::_escapeValueArray($array, $suffix, $escape);
  }
}