<?php

require_once 'includes/global.inc';

require_once 'lib/Model.php';

/**
 * Data model for a language feature
 *
 * @author Thomas Lahn
 */
class FeatureModel extends Model
{
  protected $_id;
  protected $_code;
  protected $_title;
//   protected $_created;

  protected $_testcases;
    
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
  
  public function setTestcases($testcases)
  {
    $this->_testcases = $testcases;
  }
  
  public function getTestCases()
  {
    return $this->_testcases;
  }

//   public function setCreated($timestamp);
//   public function getCreated();

  static function compareTo(FeatureModel $a, FeatureModel $b)
  {
    $al = strip_tags($a->code);
    $bl = strip_tags($b->code);
    return strcasecmp($al, $bl);
  }
}

