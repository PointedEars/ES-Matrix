<?php

require_once 'lib/Model.php';

/**
 * Model class for tested implementations
 */
class ImplementationModel extends Model
{
  protected $_id;
  protected $_sortorder;
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

  public function setSortOrder($sortOrder)
  {
    $this->_sortorder = (int) $sortOrder;
    return $this;
  }
  
  public function getSortOrder()
  {
    return $this->_sortorder;
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

