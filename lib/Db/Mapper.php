<?php

require_once 'lib/Db/Table.php';

abstract class Mapper
{
  protected $_dbTable;
  
  /**
   * Sets the <code>Table</code> for this mapper
   * @param string|Table $dbTable
   * @throws Exception
   */
  public function setDbTable($dbTable)
  {
    if (is_string($dbTable))
    {
      $dbTable = new $dbTable();
    }
  
    if (!($dbTable instanceof Table)) {
      throw new Exception('Invalid table data gateway provided');
    }
  
    $this->_dbTable = $dbTable;
  }

  /**
   * Gets the <code>Table</code> for this mapper
   */
  public function getDbTable($table)
  {
    if (null === $this->_dbTable)
    {
      $this->setDbTable($table);
    }
    
    return $this->_dbTable;
  }
}