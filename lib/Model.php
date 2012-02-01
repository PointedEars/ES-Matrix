<?php

/**
* Interface to be implemented if the model should be localizable
*/
interface ILocalizable
{
  /**
   * Localizes this model.  The actual implementation is left to the model class
   * implementing this interface.
   */
  function localize();
}

/**
 * Abstract model class
 *
 * Provides basic setters and getters for protected/private properties
 * and a constructor to initialize properties using setters and getters.
 *
 * @author Thomas Lahn
 */
abstract class Model
{
  /* ORM */
  const persistentPrimaryKey = 'id';
  
  /**
   * @var Adapter
   */
  protected static $persistentAdapter;
  
  /**
   * Creates a new model object
   *
   * @param array $data     Initialization data (optional)
   * @param array $mapping  Mapping for initialization data (optional)
   */
  public function __construct(array $data = null, array $mapping = null)
  {
    $this->setAdapter();
    
    if (!is_null($data))
    {
      $this->map($data, $mapping);
    }
  }
    
  /**
   * Getter for properties
   *
   * @param string $name
   * @throws ModelPropertyException
   * @return mixed
   */
  public function __get($name)
  {
    /* Support for Object-Relational Mappers */
    if (strpos($name, 'persistent') === 0)
    {
      $class = get_class($this);
      return $class::${$name};
    }
    
    $method = 'get' . ucfirst($name);
    
    if (method_exists($this, $method))
    {
      return $this->$method();
    }
    
    if (property_exists($this, "_$name"))
    {
      return $this->{"_$name"};
    }
    
    return $this->$name;
  }
  
  /**
   * Setter for properties
   *
   * @param string $name
   * @param mixed $value  The new property value before assignment
   * @throws ModelPropertyException
   */
  public function __set($name, $value)
  {
    $method = 'set' . ucfirst($name);
    
    if (method_exists($this, $method))
    {
      return $this->$method($value);
    }
    
    if (property_exists($this, "_$name"))
    {
      $this->{"_$name"} = $value;
      return $this->{"_$name"};
    }

    $this->$name = $value;
  }

  /**
   * Returns <code>true</code> if a variable name is a property variable name
   * (starts with <tt>$_</tt>), <code>false</code> otherwise.
   *
   * @param string $varName
   * @return boolean
   * @see getPropertyVars()
   */
  private static function _isPropertyVar($varName)
  {
    return preg_match('/^_\\w/', $varName) > 0;
  }
  
  /**
   * Returns <code>true</code> if a variable name is a property variable name
   * (starts with <tt>$_</tt>), <code>false</code> otherwise.
   *
   * @param string $varName
   * @return string
   * @see getPropertyVars()
   */
  private static function _toPropertyVar($varName)
  {
    return preg_replace('/^_(\\w)/', '\\1', $varName);
  }
  
  /**
   * Returns the public names of the property variables of a {@link Model}
   * as an array of strings
   *
   * @return array
   */
  public function getPropertyVars()
  {
    return array_map(
      array('self', '_toPropertyVar'),
      array_filter(
        array_keys(get_object_vars($this)),
        array('self', '_isPropertyVar')
      )
    );
  }
  
  /**
   * Maps the values of an associative array to a model object
   *
   * @param array $data
   * @param array $mapping = null
   *   <p>If <var>$mapping</var> is not provided, or <code>null</code> (default),
   *   the values of <var>$data</var> are mapped to properties of
   *   the model object as specified by the keys of <var>$data</var>.</p>
   *   <p>If <var>$mapping</var> is provided and an array, the keys of
   *   <var>$data</var> are mapped to properties as specified by
   *   the corresponding values of <var>$mapping</var>.  If a value of
   *   <var>$mapping</var> is <code>null</code>, the corresponding value
   *   in <var>$data</var> is not mapped; if a key is missing in
   *   <var>$mapping</var>, the value is mapped as if <var>$mapping</var>
   *   was <code>null</code>.</p>
   * @param bool $exclusive
   *   If <code>true</code>, <em>only</em> the keys of $data that are present
   *   in $mapping are mapped.
   * @throws InvalidArgumentException if <var>$mapping</var> is neither
   *   <code>null</code> nor an array.
   */
  public function map($data, $mapping = null, $exclusive = false)
  {
    if (is_null($mapping))
    {
      foreach ($data as $key => $value)
      {
        $this->$key = $value;
      }
    }
    else if (is_array($mapping))
    {
      foreach ($data as $key => $value)
      {
        if (array_key_exists($key, $mapping))
        {
          if ($exclusive || !is_null($mapping[$key]))
          {
            $this->{$mapping[$key]} = $value;
          }
        }
        else
        {
          $this->$key = $value;
        }
      }
    }
    else
    {
      throw new InvalidArgumentException(
        'Expected null or array for $mapping, saw <pre>'
        . print_r($mapping, true) . '</pre>');
    }
  }
  
  /**
   * Finds the record for the model object in a database, and fills the object
   * with missing data
   * @see Adapter::find(Model)
   */
  public function find()
  {
    return $this->persistentAdapter->find($this);
  }
}