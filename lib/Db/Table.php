<?php

require_once 'lib/Model.php';

class Table extends Model
{
  /**
   * Name of the table
   */
  protected $_name = '';
  
  /**
   * Database of the table
   * @var Database
   */
  protected $_database;
  
  protected $_id = 'id';
  
  /**
   * Retrieves all rows from the table
   * @param int[optional] $fetch_style
   * @param int[optional] $column_index
   * @param array[optional] $ctor_args
   * @return array
   * @see PDOStatement::fetchAll()
   */
  public function fetchAll($fetch_style = null, $column_index = null, array $ctor_args = null)
  {
    return $this->_database->fetchAll($this->_name, $fetch_style, $column_index, $ctor_args);
  }
  
  /**
   * Selects data from one or more tables
   */
  public function select($columns = null, $where = null, $order = null, $limit = null)
  {
    return $this->_database->select($this->_name, $columns, $where, $order, $limit);
  }
  
  public function update($data, $condition)
  {
    return $this->_database->update($this->_name, $data, $condition);
  }
  
  public function insert($data)
  {
    return $this->_database->insert($this->_name, $data);
  }
  
 /**
  * Inserts a row into the table or updates an existing one
  *
  * @param array $data
  *   Associative array of column-value pairs to be updated/inserted
  * @param string|array $condition
  *   If there are no records matching this condition, a row will be inserted;
  *   otherwise matching records are updated
  */
  public function updateOrInsert($data, array $condition = null)
  {
    if ($this->select($this->_id, $condition))
    {
      $this->update($data, $condition);
    }
    else
    {
      $this->insert($data);
    }
  }
}

