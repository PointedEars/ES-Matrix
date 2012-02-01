<?php

require_once 'includes/global.inc';

require_once 'lib/Model.php';

require_once 'application/models/adapters/MatrixAdapter.php';

class TestcaseModel extends Model
{
  /* ORM */
  const persistentTable = 'testcase';
  
  protected $_id;
  protected $_feature_id;
  protected $_title;
  protected $_code;
    
  /**
  * Sets the database adapter for this model
  */
  protected function setAdapter()
  {
    self::$persistentAdapter = MatrixAdapter::getInstance();
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
    
  public function setFeature_id($id)
  {
    $this->_feature_id = (int) $id;
    return $this;
  }
    
  public function getFeature_id()
  {
    return $this->_feature_id;
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

  /**
   * Returns the testcases for a feature specified by its ID
   *
   * @param int $id
   * @return array
   */
  public static function findByFeatureId($id)
  {
    $testcase = new self(array('feature_id' => $id));
    $result = self::$persistentAdapter->findAll($testcase);
    
    if (defined('DEBUG') && DEBUG > 0)
    {
      debug($result);
    }
    
    return $result;
  }
}

