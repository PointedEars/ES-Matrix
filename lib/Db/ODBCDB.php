<?php

require_once 'lib/Db/Database.php';

class ODBCDB extends Database
{
  /**
   * ODBC alias
   * @var string
   */
  protected $_alias;
  
  public function __construct()
  {
    $this->_connection = @odbc_connect($this->_alias, "" ,"");
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
    return '[' . $name . ']';
  }

  /**
   * (non-PHPdoc)
   * @see Database::_escapeAliasArray()
   */
  protected function _escapeAliasArray(array &$array)
  {
    foreach ($array as $column => &$value)
    {
      $value = $value . ' AS [' . $column . ']';
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