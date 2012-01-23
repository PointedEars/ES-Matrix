<?php

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
  public function __construct(array $options = null)
  {
    if (is_array($options))
    {
      $this->setOptions($options);
    }
  }
  
  public function setOptions(array $options)
  {
    $methods = get_class_methods($this);
    foreach ($options as $key => $value)
    {
      $method = 'set' . ucfirst($key);
      if (in_array($method, $methods))
      {
        $this->$method($value);
      }
    }
  
    return $this;
  }
  
  public function __get($name)
  {
    if (strpos($name, 'persistent') === 0)
    {
      $class = get_class($this);
      throw new Exception("Required $class::\$$name missing!");
    }
    
    $method = "get" . ucfirst($name);
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
  
  public function __set($name, $value)
  {
    $method = "set" . ucfirst($name);
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
}