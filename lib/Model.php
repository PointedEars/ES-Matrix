<?php

abstract class Model
{
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