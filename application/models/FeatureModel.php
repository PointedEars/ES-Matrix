<?php

require_once 'includes/global.inc';

require_once 'lib/Model.php';

class FeatureModel extends Model
{
  protected $_id;
  protected $_code;
  protected $_title;
//   protected $_created;
    
  public function setId($id)
  {
    $this->_id = (int) $id;
    return $this;
  }
 
  public function getId()
  {
    return $this->_id;
  }
    
  public function setCode($code)
  {
    $this->_code = htmlEntityDecode(trim((string) $code), ENT_QUOTES, 'UTF-8');
    return $this;
  }
    
  public function getCode()
  {
    return $this->_code;
  }
  
  public function setTitle($title)
  {
    $this->_title = htmlEntityDecode(trim((string) $title), ENT_QUOTES, 'UTF-8');
    return $this;
  }
  
  public function getTitle()
  {
    return $this->_title;
  }

//   public function setCreated($timestamp);
//   public function getCreated();
}

