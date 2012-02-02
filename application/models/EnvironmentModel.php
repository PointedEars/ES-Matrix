<?php

require_once 'lib/AbstractModel.php';

/**
 * Model class for test environments
 */
class EnvironmentModel extends AbstractModel
{
  protected $_id;
  protected $_name;
  protected $_user_agent;
    
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
    
  public function setUser_agent($user_agent)
  {
    $this->_user_agent = trim((string) $user_agent);
    return $this;
  }
  
  public function getUser_agent()
  {
    return $this->_user_agent;
  }
}

