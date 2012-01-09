<?php

require_once 'lib/Model.php';

class Database extends Model
{
  /**
   * DSN of the database
   * @var string
   */
  protected $_dsn = '';
  
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
  
  /**
   * Database connection
   * @var PDO
   */
  protected $_connection;
  
  public function __construct()
  {
    $this->_connection = new PDO($this->_dsn, $this->_username, $this->_password);
  }
  
  /**
   * Prepares a statement for execution with the database
   * @param string $query
   */
  public function prepare($query)
  {
    return $this->_connection->prepare($query);
  }
  
  /**
  * Determines if an array is associative (does not have a '0' key)
  *
  * @param array $a
  * @return boolean
  *   <code>true</code> if <var>$a</var> is associative,
  *   <code>false</code> otherwise
  */
  private function _isAssociativeArray(array $a)
  {
    return !array_key_exists(0, $a);
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
      $value = $column . "=:{$column}";
    }
  
    return $array;
  }
    
  /**
  * Constructs the WHERE part of a query
  *
  * @param string|array $where Condition
  * @return string
  */
  private function _where($where)
  {
    if (!is_null($where))
    {
      if (is_array($where))
      {
        if (count($where) < 1)
        {
          return '';
        }
  
        if ($this->_isAssociativeArray($where))
        {
          $this->_escapeArray($where);
        }
  
        $where = '(' . join(') AND (', $where) . ')';
      }
  
      return ' WHERE ' . $where;
    }
  
    return '';
  }

  /**
  * Selects data from one or more tables; the resulting records are stored
  * in the <code>result</code> property.
  *
  * @param string|array[string] $tables Table(s) to select from
  * @param string|array[string] $columns Column(s) to select from (optional)
  * @param string|array $where Condition (optional)
  * @param string $order Sort order (optional)
  * @param string $limit Limit (optional)
  * @return bool
  * @throws <code>Exception</code> if the query fails
  */
  public function select($tables, $columns = null, $where = null, $order = null, $limit = null)
  {
    if (is_null($columns))
    {
      $columns = array('*');
    }
    
    if (!is_array($columns))
    {
      $columns = array($columns);
    }

    $columns = join(',', $columns);
    
    if (!is_array($tables))
    {
      $tables = array($tables);
    }

    $tables = join(',', $tables);

    $query = "SELECT $columns FROM $tables" . $this->_where($where);

    if (!is_null($order))
    {
      $query .= " ORDER BY $order";
    }

    if (!is_null($limit))
    {
      $query .= " LIMIT $limit";
    }
    
    $stmt = $this->prepare($query);

    $params = array();
    
    if ($this->_isAssociativeArray($where))
    {
      foreach ($where as $key => $condition)
      {
        $params[":{$key}"] = $condition;
      }
    }

    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }

  /**
   * Updates one or more records
   *
   * @param string|array $tables
   *   Table name
   * @param array $values
   *   Associative array of column-value pairs
   * @param array|string $where
   *   Only the records matching this condition are updated
   * @return string|bool
   */
  public function update($tables, $updates, $where = null)
  {
    if (!$tables)
    {
      throw new InvalidArgumentException('No table specified');
    }
     
    if (is_array($tables))
    {
      $tables = join(',', $tables);
    }
     
    if (!$updates)
    {
      throw new InvalidArgumentException('No values specified');
    }

    $params = array();
    
    if ($this->_isAssociativeArray($updates))
    {
      foreach ($updates as $key => $condition)
      {
        $params[":{$key}"] = $condition;
      }
    }
    
    $updates = implode(',', $this->_escapeArray($updates));
          
    $query = "UPDATE {$tables} SET {$updates}" . $this->_where($where);
    
    /* DEBUG */
//    echo "Update:<br>";
    
    $stmt = $this->prepare($query);
    
    if ($this->_isAssociativeArray($where))
    {
      foreach ($where as $key => $condition)
      {
        $params[":{$key}"] = $condition;
      }
    }
    
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return ($stmt->errorCode() === 'HY000');
  }
    
  /**
  * Inserts a record into a table.<p>The AUTO_INCREMENT value of the inserted
  * row, if any (> 0), is stored in the {@link $lastId} property of
  * the <code>Database</code> instance.</p>
  *
  * @param string $table
  *   Table name
  * @param array|string $values
  *   Associative array of column-value pairs, indexed array,
  *   or comma-separated list of values.  If <var>$values</var> is not
  *   an associative array, <var>$cols</var> must be passed if the
  *   values are not in column order (see below).
  * @param array|string $cols
  *   Indexed array, or comma-separated list of column names.
  *   Needs only be passed if <var>$values</var> is not an associative array
  *   and the values are not in column order (default: <code>null</code>);
  *   is ignored otherwise.  <strong>You SHOULD NOT rely on column order.</strong>
  * @return bool
  *   <code>true</code> if successful, <code>false</code> otherwise
  */
  public function insert($table, $values, $cols = null)
  {
    if ($cols != null)
    {
      $cols = ' ('
      . (is_array($cols)
      ? join(',', array_map(create_function('$s', 'return "`$s`";'), $cols))
      : $cols) . ')';
    }
    else
    {
      $cols = '';
    }
  
    /* DEBUG */
//     var_dump($values);
  
    $params = array();
    
    if ($this->_isAssociativeArray($values))
    {
      foreach ($values as $key => $condition)
      {
        $params[":{$key}"] = $condition;
      }
      
      $this->_escapeArray($values);
      
      $cols = '';
      $values = 'SET ' . join(', ', $values);
    }
    else
    {
      foreach ($values as &$value)
      {
        if (is_string($value))
        {
          $value = "'" . mysql_real_escape_string($value) . "'";
        }
      }
       
      $values = ' VALUES (' . join(', ', $values) . ')';
    }
  
    $insert = "INSERT INTO `{$table}` {$cols} {$values}";
  
    /* DEBUG */
    //    echo "Insert:<br>";
    var_dump($insert);
    var_dump($params);
    
    $stmt = $this->prepare($insert);
//     $this->_lastId = mysql_insert_id();
  
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    var_dump($result);
    return ($stmt->errorCode() === 'HY000');
//     return false;
  }
    
  /**
  * Retrieves all rows from a table
  *
  * @param int[optional] $fetch_style
  * @param int[optional] $column_index
  * @param array[optional] $ctor_args
  * @return array
  * @see PDOStatement::fetchAll()
  */
  public function fetchAll($table, $fetch_style = null, $column_index = null, array $ctor_args = null)
  {
    /* NOTE: Cannot use table name as statement parameter */
    $stmt = $this->prepare("SELECT * FROM $table");
    $stmt->execute();
  
    if (!is_null($ctor_args))
    {
      $result = $stmt->fetchAll($fetch_style, $column_index, $ctor_args);
    }
    else if (!is_null($column_index))
    {
      $result = $stmt->fetchAll($fetch_style, $column_index);
    }
    else if (!is_null($fetch_style))
    {
      $result = $stmt->fetchAll($fetch_style);
    }
    else
    {
      $result = $stmt->fetchAll();
    }
  
    return $result;
  }
}