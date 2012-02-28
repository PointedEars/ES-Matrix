<?php

require_once 'includes/global.inc';

require_once 'lib/AbstractModel.php';

/**
 * Generic database model class using PDO (PHP Data Objects)
 *
 * @author Thomas Lahn
 */
class Database extends AbstractModel
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
   * PDO driver-specific options
   * @var array
   */
  protected $_options = array();
  
  /**
   * Database connection
   * @var PDO
   */
  protected $_connection;
  
  /**
   * Last success value of the database operation
   * @var boolean
   */
  protected $_lastSuccess;

  /**
   * Last result of the database operation
   * @var array
   */
  protected $_lastResult;

  /**
  * ID of the last inserted row, or the last value from a sequence object,
  * depending on the underlying driver. May not be supported by all databases.
  * @var string
  */
  protected $_lastInsertId = '';
  
  public function __construct()
  {
    $this->_connection =
      new PDO($this->_dsn, $this->_username, $this->_password, $this->_options);
  }
  
  /**
   * Initiates a transaction
   *
   * @return bool
   * @see PDO::beginTransaction()
   */
  public function beginTransaction()
  {
    return $this->_connection->beginTransaction();
  }
  
  /**
   * Rolls back a transaction
   *
   * @return bool
   * @see PDO::rollBack()
   */
  public function rollBack()
  {
    return $this->_connection->rollBack();
  }
  
  /**
   * Commits a transaction
   *
   * @return bool
   * @see PDO::commit()
   */
  public function commit()
  {
    return $this->_connection->commit();
  }
  
  /**
   * Prepares a statement for execution with the database
   * @param string $query
   */
  public function prepare($query, array $driver_options = array())
  {
    return $this->_connection->prepare($query, $driver_options);
  }
  
  /**
   * Returns the ID of the last inserted row, or the last value from
   * a sequence object, depending on the underlying driver.
   *
   * @return int
   */
  public function getLastInsertId()
  {
    return $this->_lastInsertId;
  }
  
  /**
   * Escapes a database name so that it can be used in a query.
   *
   * @param string $name
   *   The name to be escaped
   * @return string
   *   The escaped name
   */
  public static function escapeName($name)
  {
    return $name;
  }
  
  /**
   * Determines if an array is associative (has not all integer keys).
   *
   * @author
   *   Algorithm courtesy of squirrel, <http://stackoverflow.com/a/5969617/855543>.
   * @param array $a
   * @return boolean
   *   <code>true</code> if <var>$a</var> is associative,
   *   <code>false</code> otherwise
   */
  protected function _isAssociativeArray(array $a)
  {
    for (reset($a); is_int(key($a)); next($a));
    return !is_null(key($a));
  }
  
  /**
   * Escapes an associative array so that its string representation can be used
   * as list with table or column aliases in a query.
   *
   * This method does not actually escape anything; it only inserts the
   * 'AS' keyword.  It should be overridden by inheriting methods.
   *
   * NOTE: This method intentionally does not check whether the array actually
   * is associative.
   *
   * @param array &$array
   *   The array to be escaped
   * @return array
   *   The escaped array
   */
  protected function _escapeAliasArray(array &$array)
  {
    foreach ($array as $column => &$value)
    {
      $value = $value . ' AS ' . $column;
    }
  
    return $array;
  }

  /**
   * @param array $a
   * @param string $prefix
   */
  private static function _expand(array $a, $prefix)
  {
    $a2 = array();
    
    foreach ($a as $key => $value)
    {
      $a2[] = ':' . $prefix . ($key + 1);
    }
    
    return $a2;
  }
  
  /**
   * Escapes an associative array so that its string representation can be used
   * as value list in a query.
   *
   * This method should be overridden by inheriting classes to escape
   * column names as fitting for the database schema they support.  It is
   * strongly recommended that the overriding methods call this method with
   * an appropriate <var>$escape</var> parameter, pass all other parameters
   * on unchanged, and return its return value.
   *
   * NOTE: Intentionally does not check whether the array actually is associative!
   *
   * @param array &$array
   *   The array to be escaped
   * @param string $suffix
   *   The string to be appended to the column name for the value placeholder.
   *   The default is the empty string.
   * @param array $escape
   *   The strings to use left-hand side (index 0) and right-hand side (index 1)
   *   of the column name.  The default is the empty string, respectively.
   * @return array
   *   The escaped array
   */
  protected function _escapeValueArray(array &$array, $suffix = '', array &$escape = array('', ''))
  {
    $result = array();
        
    foreach ($array as $column => $value)
    {
      $op = '=';
      $placeholder = ":{$column}";
      
      if (is_array($value) && $this->_isAssociativeArray($value))
      {
        reset($value);
        $op = ' ' . key($value) . ' ';
        
        $value = $value[key($value)];
      }
      
      if (is_array($value))
      {
        $placeholder = '(' . implode(',', self::_expand($value, $column)) . ')';
      }
      
      $result[] = $escape[0] . $column . $escape[1] . "{$op}{$placeholder}{$suffix}";
    }
  
    return $result;
  }
    
  /**
   * Constructs the WHERE part of a query
   *
   * @param string|array $where
   *   Condition
   * @param string $suffix
   *   The string to be appended to the column name for the value placeholder,
   *   passed on to {@link Database::_escapeValueArray()}.  The default is
   *   the empty string.
   * @return string
   * @see Database::_escapeValueArray()
   */
  protected function _where($where, $suffix = '')
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
          $where = $this->_escapeValueArray($where, $suffix);
        }
  
        $where = '(' . implode(') AND (', $where) . ')';
      }
  
      return ' WHERE ' . $where;
    }
  
    return '';
  }

  /**
   * Selects data from one or more tables; the resulting records are stored
   * in the <code>result</code> property and returned as an associative array,
   * where the keys are the column (alias) names.
   *
   * @param string|array[string] $tables Table(s) to select from
   * @param string|array[string] $columns Column(s) to select from (optional)
   * @param string|array $where Condition (optional)
   * @param string $order Sort order (optional)
   *   If provided, MUST start with ORDER BY or GROUP BY
   * @param string $limit Limit (optional)
   * @param int $fetch_style
   *   The mode that shoould be used for {@link PDOStatement::fetchAll()}.
   *   The default is {@link PDO::FETCH_ASSOC}.
   * @return array
   * @see Database::prepare()
   * @see PDOStatement::fetchAll()
   */
  public function select($tables, $columns = null, $where = null,
    $order = null, $limit = null, $fetch_style = PDO::FETCH_ASSOC)
  {
    if (is_null($columns))
    {
      $columns = array('*');
    }
    
    if (is_array($columns))
    {
      if ($this->_isAssociativeArray($columns))
      {
        $columns = $this->_escapeAliasArray($columns);
      }

      $columns = implode(',', $columns);
    }

    if (is_array($tables))
    {
      if ($this->_isAssociativeArray($columns))
      {
        $columns = $this->_escapeAliasArray($columns);
      }

      $tables = implode(',', $tables);
    }

    $query = "SELECT {$columns} FROM {$tables}" . $this->_where($where);

    if (!is_null($order))
    {
      if (is_array($order))
      {
        $order = 'ORDER BY ' . implode(',', $order);
      }
      
      $query .= " $order";
    }

    if (!is_null($limit))
    {
      $query .= " LIMIT $limit";
    }
    
    $stmt = $this->prepare($query);

    $params = array();
    
    if (is_array($where) && $this->_isAssociativeArray($where))
    {
      foreach ($where as $column => $condition)
      {
        if (is_array($condition) && $this->_isAssociativeArray($condition))
        {
          reset($condition);
          $condition = $condition[key($condition)];
          
          if (is_array($condition))
          {
            foreach (self::_expand($condition, $column) as $param_index => $param_name)
            {
              $params[$param_name] = $condition[$param_index];
            }
          }
        }
        else
        {
          $params[":{$column}"] = $condition;
        }
      }
    }

    /* DEBUG */
    if (defined('DEBUG') && DEBUG > 1)
    {
      debug(array(
      	'query'  => $query,
      	'params' => $params
      ));
    }
    
    $success =& $this->_lastSuccess;
    $success =  $stmt->execute($params);
    
    $result =& $this->_lastResult;
    $result =  $stmt->fetchAll($fetch_style);
    
    if (defined('DEBUG') && DEBUG > 1)
    {
      debug(array(
        '_lastSuccess' => $success,
        'errorInfo'    => $stmt->errorInfo(),
        '_lastResult'  => $result
      ));
    }
    
    return $result;
  }

  /**
   * Sets and returns the ID of the last inserted row, or the last value from
   * a sequence object, depending on the underlying driver.
   *
   * @param string $name
   *   Name of the sequence object from which the ID should be returned.
   * @return string
   */
  protected function _setLastInsertId($name = null)
  {
    return ($this->_lastInsertId = $this->_connection->lastInsertId($name));
  }

  /**
   * Resets the the ID of the last inserted row, or the last value from
   * a sequence object, depending on the underlying driver.
   *
   * @return string
   *   The default value
   */
  protected function _resetLastInsertId()
  {
    return ($this->_lastInsertId = '');
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
   * @return bool
   */
  public function update($tables, $updates, $where = null)
  {
    if (!$tables)
    {
      throw new InvalidArgumentException('No table specified');
    }
     
    if (is_array($tables))
    {
      $tables = implode(',', $tables);
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
    
    $updates = implode(',', $this->_escapeValueArray($updates));
          
    /* TODO: Should escape table names with escapeName(), but what about aliases? */
    $query = "UPDATE {$tables} SET {$updates}" . $this->_where($where, '2');
    
    $stmt = $this->prepare($query);
    
    if (is_array($where) && $this->_isAssociativeArray($where))
    {
      foreach ($where as $column => $condition)
      {
        if (is_array($condition) && $this->_isAssociativeArray($condition))
        {
          reset($condition);
          $condition = $condition[key($condition)];
          
          if (is_array($condition))
          {
            foreach (self::_expand($condition, $column) as $param_index => $param_name)
            {
              $params[$param_name] = $condition[$param_index];
            }
          }
        }
        else
        {
          $params[":{$column}2"] = $condition;
        }
      }
    }

    /* DEBUG */
    if (defined('DEBUG') && DEBUG > 1)
    {
      debug(array(
        'query'  => $query,
        'params' => $params
      ));
    }
    
    $success =& $this->_lastSuccess;
    $success =  $stmt->execute($params);
    
    $this->_resetLastInsertId();
    
    $result =& $this->_lastResult;
    $result =  $stmt->fetchAll();
    
    if (defined('DEBUG') && DEBUG > 1)
    {
      debug(array(
        '_lastSuccess' => $success,
        'errorInfo'    => $stmt->errorInfo(),
        '_lastResult'  => $result
      ));
    }
    
    return $success;
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
   * @see PDOStatement::execute()
   */
  public function insert($table, $values, $cols = null)
  {
    if ($cols != null)
    {
      $cols = ' ('
            . (is_array($cols)
                ? implode(',', array_map(create_function('$s', 'return "`$s`";'), $cols))
                : $cols) . ')';
    }
    else
    {
      $cols = '';
    }
  
    /* DEBUG */
    if (defined('DEBUG') && DEBUG > 2)
    {
      debug(array('values' => $values));
    }
  
    $params = array();
    
    if (is_array($values))
    {
      if ($this->_isAssociativeArray($values))
      {
        foreach ($values as $key => $condition)
        {
          $params[":{$key}"] = $condition;
        }
        
        $values = $this->_escapeValueArray($values);
        
        $cols = '';
        $values = 'SET ' . implode(', ', $values);
      }
      else
      {
        foreach ($values as &$value)
        {
          if (is_string($value))
          {
            $value = "'" . $value . "'";
          }
        }
         
        $values = ' VALUES (' . implode(', ', $values) . ')';
      }
    }
  
    /* TODO: Should escape table names with escapeName(), but what about aliases? */
    $query = "INSERT INTO {$table} {$cols} {$values}";
  
    $stmt = $this->prepare($query);
  
      /* DEBUG */
    if (defined('DEBUG') && DEBUG > 1)
    {
       debug(array(
         'query'  => $query,
         'params' => $params
       ));
    }
    
    $success =& $this->_lastSuccess;
    $success = $stmt->execute($params);
    
    $this->_setLastInsertId();
    
    $result =& $this->_lastResult;
    $result =  $stmt->fetchAll();

    if (defined('DEBUG') && DEBUG > 1)
    {
      debug(array(
        '_lastSuccess'  => $success,
        'errorInfo'     => $stmt->errorInfo(),
        '_lastInsertId' => $this->_lastInsertId,
        '_lastResult'   => $result
      ));
    }
    
    return $success;
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
    $this->_lastSuccess = $stmt->execute();
  
    $result =& $this->_lastResult;
    
    if (is_null($fetch_style))
    {
      $fetch_style = PDO::FETCH_ASSOC;
    }
    
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

  /**
   * Deletes one or more records
   *
   * @param string|array $tables
   *   Table name(s)
   * @param array|string $where
   *   Only the records matching this condition are deleted
   * @return bool
   * @see PDOStatement::execute()
   */
  public function delete($tables, $where = null)
  {
    if (!$tables)
    {
      throw new InvalidArgumentException('No table specified');
    }
         
    if (is_array($tables))
    {
      $tables = implode(',', $tables);
    }
     
    $params = array();
    
    $query = "DELETE FROM {$tables}" . $this->_where($where);
    
    $stmt = $this->prepare($query);
    
    if ($this->_isAssociativeArray($where))
    {
      foreach ($where as $column => $condition)
      {
        if (is_array($condition) && $this->_isAssociativeArray($condition))
        {
          reset($condition);
          $condition = $condition[key($condition)];
          
          if (is_array($condition))
          {
            foreach (self::_expand($condition, $column) as $param_index => $param_name)
            {
              $params[$param_name] = $condition[$param_index];
            }
          }
        }
        else
        {
          $params[":{$column}"] = $condition;
        }
      }
    }

    /* DEBUG */
    if (defined('DEBUG') && DEBUG > 1)
    {
      debug(array(
        'query'  => $query,
        'params' => $params
      ));
    }
    
    $success =& $this->_lastSuccess;
    $success =  $stmt->execute($params);
    
    $result =& $this->_lastResult;
    $result =  $stmt->fetchAll();
    
    if (defined('DEBUG') && DEBUG > 1)
    {
      debug(array(
        '_lastSuccess' => $success,
        'errorInfo'    => $stmt->errorInfo(),
        '_lastResult'  => $result
      ));
    }
    
    return $success;
  }
}