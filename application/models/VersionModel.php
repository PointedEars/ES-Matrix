<?php

require_once 'lib/AbstractModel.php';

/**
 * Model class for implementation versions
 */
class VersionModel extends AbstractModel
{
  protected $_id;
  protected $_implementation_id;
  protected $_name;
    
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
    $this->_name = trim((string) $name);
    return $this;
  }
  
  public function getName()
  {
    return $this->_name;
  }
}

