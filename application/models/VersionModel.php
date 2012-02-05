<?php

require_once 'lib/AbstractModel.php';

/**
 * Model class for implementation versions
 */
class VersionModel extends AbstractModel
{
  protected $_id = null;
  protected $_implementation_id = null;
  protected $_name = '';
    
  public function setId($id)
  {
    $this->_id = is_null($id) ? $id : (int) $id;
    return $this;
  }
 
  public function getId()
  {
    return $this->_id;
  }

  public function setImplementation_Id($id)
  {
    $this->_implementation_id = is_null($id) ? $id : (int) $id;
    return $this;
  }
 
  public function getImplementationId()
  {
    return $this->_implementation_id;
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

