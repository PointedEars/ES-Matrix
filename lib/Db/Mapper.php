<?php

require_once 'lib/Db/Table.php';

/**
 * Generic abstract database mapper class
 *
 * @author Thomas Lahn
 */
abstract class Mapper
{
  /**
   * Class name of the associated table model
   *
   * @var string
   */
  protected $_table = 'Table';
  
  protected $_dbTable;
  
  /**
   * Sets the {@link Table} for this mapper
   * @param string|Table $dbTable
   *   Class name of the new instance, or an existing instance
   * @throws Exception if <var>$dbTable</var> is not a <code>Table</code>
   */
  public function setDbTable($table)
  {
    if (is_string($table))
    {
      $table = new $table();
    }
  
    if (!($table instanceof Table)) {
      throw new Exception('Invalid table data gateway provided');
    }
  
    $this->_dbTable = $table;
  }

  /**
   * Gets the {@link Table} for this mapper
   *
   * @param string|Table $table
   *   Class name of the new instance or an existing instance.
   *   The default is the value of the <code>$_table</code> property.
   * @return Table
   * @throws Exception if <var>$dbTable</var> is not a <code>Table</code>
   * @see Mapper::setDbTable()
   */
  public function getDbTable($table = null)
  {
    if (is_null($this->_dbTable))
    {
      if (is_null($table))
      {
        $table = $this->_table;
      }
      
      $this->setDbTable($table);
    }
    
    return $this->_dbTable;
  }
  
  /**
   * Sorts an array of objects by the property of the nested object.
   * To be used with the u*sort() functions.
   *
   * @param object $a First operand of the comparison
   * @param object $b Second operand of the comparison
   * @param string $property
   *   Name of the property of the nested object by which to sort the outer array
   * @return int
   *   0 if <var>$a</var> and <var>$b</var> are "equal",
   *   <code>-1</code> if <var>$a</var> is "less" than <var>$b</var>,
   *   <code>1</code> otherwise.
   */
  protected static function sortByProperty($a, $b, $property)
  {
    if ($a->$property === $b->$property)
    {
      return 0;
    }
  
    return ($a->$property < $b->$property) ? -1 : 1;
  }
}