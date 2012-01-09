<?php

require_once 'lib/Model.php';

class FeatureModel extends Model
{
  protected $_id;
  protected $_name;
  protected $_title;
//   protected $_created;
    
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
  
  public function setId($id)
  {
    $this->_id = (int) $id;
    return $this;
  }
 
  public function getId()
  {
    return $this->_id;
  }
    
  public function setName($name)
  {
    $this->_name = (string) $name;
    return $this;
  }
    
  public function getName()
  {
    return $this->_name;
  }
  
  public function setTitle($title)
  {
    $this->_title = (string) $title;
    return $this;
  }
  
  public function getTitle()
  {
    return $this->_title;
  }

//   public function setCreated($timestamp);
//   public function getCreated();
}

