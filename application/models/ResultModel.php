<?php

require_once 'lib/Model.php';

/**
 * Model class for test results
 */
class ResultModel extends Model
{
  protected $_id;
  protected $_testcase_id;
  protected $_environment_id;
  protected $_value;
    
  public function setId($id)
  {
    $this->_id = (int) $id;
    return $this;
  }
 
  public function getId()
  {
    return $this->_id;
  }
    
  public function setTestcase_id($id)
  {
    $this->_testcase_id = (int) $id;
    return $this;
  }
 
  public function getTestcase_id()
  {
    return $this->_testcase_id;
  }
    
  public function setEnvironment_id($id)
  {
    $this->_environment_id = (int) $id;
    return $this;
  }
 
  public function getEnvironment_id()
  {
    return $this->_environment_id;
  }
}

