<?php

require_once 'lib/Model.php';

abstract class Adapter
{
  /**
   * Database used by the adapter
   * @var Database
   */
  protected $_database = null;

  /**
   * Constructs the adapter, associating a {@link Database} with it
   * @param Database $database
   */
  /* Singleton */
  protected function __construct(Database $database)
  {
    $this->_database = $database;
  }
  
  /**
  * Selects data from one or more tables
  *
  * @return array
  * @see Database::select()
  */
  public function select($table, $columns = null, $where = null, $order = null, $limit = null)
  {
    return $this->_database->select($table, $columns, $where, $order, $limit);
  }
  
  /**
   * Finds all records matching the set properties of a model object
   *
   * @param Model $object
   * @return array[Model]
   */
  public function findAll(Model $object, $order = null, $limit = null)
  {
    $properties = $object->getPropertyVars();
    $where = array();
    
    foreach ($properties as $property)
    {
      if (!is_null($object->$property))
      {
        $where[$property] = $object->$property;
      }
    }
    
    $class = get_class($object);
    $query_result = $this->select($class::persistentTable, null, $where, $order, $limit);
    
    $num_results = count($query_result);
    if ($num_results === 0)
    {
      return null;
    }

    $result = array();
    
    foreach ($query_result as $row)
    {
      $result[] = new $class($row);
    }

    return $result;
  }
  
  /**
   * Finds the record for a model object by its primary key
   *
   * @param Model $object
   * @return Model
   *   The filled object if the primary key value could be found,
   *   <code>null</code> otherwise
   */
  public function find(Model $object)
  {
    $class = get_class($object);
    $primaryKey = $class::persistentPrimaryKey;
    
    if (is_array($primaryKey))
    {
      /* TODO */
    }

    $result = $this->select($class::persistentTable, null, array($primaryKey => $object->$primaryKey));
    if (0 == count($result))
    {
      return null;
    }
    
    $row = $result[0];
    $object->map($row);
    
    return $object;
  }
}