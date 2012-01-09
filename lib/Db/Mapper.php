<?php

require_once 'lib/Db/Table.php';

abstract class Mapper
{
  protected static $_dbTable;
  
  /**
   * Sets the <code>Table</code> for this mapper
   * @param string|Table $dbTable
   * @throws Exception
   */
  public static function setDbTable($dbTable)
  {
    if (is_string($dbTable))
    {
      $dbTable = new $dbTable();
    }
  
    if (!($dbTable instanceof Table)) {
      throw new Exception('Invalid table data gateway provided');
    }
  
    self::$_dbTable = $dbTable;
  }
}