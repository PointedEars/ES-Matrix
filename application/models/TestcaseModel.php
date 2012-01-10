<?php

require_once 'includes/global.inc';

require_once 'lib/Model.php';

class TestcaseModel extends Model
{
  protected $_id;
  protected $_feature_id;
  protected $_code;
    
  public function setId($id)
  {
    $this->_id = (int) $id;
    return $this;
  }
 
  public function getId()
  {
    return $this->_id;
  }
    
  public function setFeature_id($id)
  {
    $this->_feature_id = (int) $id;
    return $this;
  }
    
  public function getFeature_id()
  {
    return $this->_feature_id;
  }
  
  public function setCode($code)
  {
    $this->_code = trim(
      preg_replace('/"\\s*\\+\\s*"/', '',
        preg_replace('/\\s+/', ' ', (string) $code)));
    return $this;
  }
  
  public function getCode()
  {
    return $this->_code;
  }
}

