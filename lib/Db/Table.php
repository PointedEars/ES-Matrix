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
   *
   * @return array
   * @see Database::fetchAll()
   */
  public function fetchAll($fetch_style = null, $column_index = null, array $ctor_args = null)
  {
    return $this->_database->fetchAll($this->_name, $fetch_style, $column_index, $ctor_args);
  }
  
  /**
   * Selects data from one or more tables
   *
   * @return array
   * @see Database::select()
   */
  public function select($columns = null, $where = null, $order = null, $limit = null)
  {
    return $this->_database->select($this->_name, $columns, $where, $order, $limit);
  }
  
  /**
   * Updates records in one or more tables
   *
   * @return bool
   * @see Database::update()
   */
  public function update($data, $condition)
  {
    return $this->_database->update($this->_name, $data, $condition);
  }
  
  /*
   * Inserts a record into the table
   *
   * @return bool
   * @see Database::insert()
   */
  public function insert($data)
  {
    return $this->_database->insert($this->_name, $data);
  }
  
  /*
   * Delete a record from the table
   *
   * @param int $id  ID of the record to delete
   * @return bool
   * @see Database::delete()
   */
  public function delete($id)
  {
    return $this->_database->delete($this->name, array($this->_id => $id));
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
      return $this->update($data, $condition);
    }
    else
    {
      return $this->insert($data);
    }
  }

  /**
   * Finds a record by ID
   *
   * @param mixed $id
   */
  public function find($id)
  {
    /* DEBUG */
    if (defined('DEBUG') && DEBUG > 0)
    {
      var_dump($id);
    }
    
    return $this->select(null, array($this->_id => $id));
  }
}