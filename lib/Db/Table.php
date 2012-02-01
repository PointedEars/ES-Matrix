<?php

require_once 'lib/Model.php';

/**
 * Generic database table model class
 *
 * @author Thomas Lahn
 * @property-read int $lastInsertId
 *   ID of the last inserted row, or the last value from
     a sequence object, depending on the underlying driver.
 */
abstract class Table /* extends Model */
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
  
  public function __construct()
  {
    $this->_database = Application::getInstance()->getDefaultDatabase();
  }
  
  /**
   * Returns the database for the table
   * @return Database
   */
  public function getDatabase()
  {
    return $this->_database;
  }
  
  /**
   * Initiates a transaction
   *
   * @return bool
   * @see Database::beginTransaction()
   */
  public function beginTransaction()
  {
    return $this->_database->beginTransaction();
  }
  
  /**
   * Rolls back a transaction
   *
   * @return bool
   * @see Database::rollBack()
   */
  public function rollBack()
  {
    return $this->_database->rollBack();
  }
  
  /**
   * Commits a transaction
   *
   * @return bool
   * @see Database::commit()
   */
  public function commit()
  {
    return $this->_database->commit();
  }
  
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
  
  /**
   * Inserts a record into the table
   *
   * @return bool
   * @see Database::insert()
   */
  public function insert($data)
  {
    return $this->_database->insert($this->_name, $data);
  }
  
  /**
   * Returns the ID of the last inserted row, or the last value from
   * a sequence object, depending on the underlying driver.
   *
   * @return int
   * @see Database::getLastInsertId()
   */
  public function getLastInsertId()
  {
    return $this->_database->lastInsertId;
  }
  
  /**
   * Delete a record from the table
   *
   * @param int $id
   *   ID of the record to delete.  May be <code>null</code>,
   *   in which case <var>$condition</var> must specify
   *   the records to be deleted.
   * @param array[optional] $condition
   *   Conditions that must be met for a record to be deleted.
   *   Ignored if <var>$id</var> is not <code>null</code>.
   * @return bool
   * @throws InvalidArgumentException if both <var>$id</var> and
   * 	 <var>$condition</var> are <code>null</code>.
   * @see Database::delete()
   */
  public function delete($id, array $condition = null)
  {
    if (!is_null($id))
    {
      $condition = array($this->_id => $id);
    }
    else if (is_null($condition))
    {
      throw new InvalidArgumentException(
        '$id and $condition cannot both be null');
    }
    
    return $this->_database->delete($this->_name, $condition);
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
      debug($id);
    }
    
    return $this->select(null, array($this->_id => $id));
  }
}