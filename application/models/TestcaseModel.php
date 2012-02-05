<?php

require_once 'includes/global.inc';

require_once 'lib/AbstractModel.php';

require_once 'application/models/adapters/MatrixAdapter.php';

class TestcaseModel extends AbstractModel
{
  /* ORM */
//   const persistentTable = 'testcase';
  
  /**
   * ID of the testcase
   * @var int
   */
  protected $_id = null;
  
  /**
   * ID of the feature of the testcase
   * @var int
   */
  protected $_feature_id;
  
  /**
   * Title of the testcase
   * @var string
   */
  protected $_title = null;
  
  /**
   * Test code
   * @var string
   */
  protected $_code;
  
  /**
   * Should the code be escaped and quoted on output?
   * @var boolean
   */
  protected $_quoted = null;
    
  /**
   * Sets the database adapter for this model
   */
  protected function setAdapter()
  {
    self::$persistentAdapter = MatrixAdapter::getInstance();
  }
  
  /**
   * @param null|int $id
   * @return TestcaseModel
   */
  public function setId($id)
  {
    $this->_id = is_null($id) ? $id : (int) $id;
    return $this;
  }
 
  /**
   * @return null|int $id
   */
  public function getId()
  {
    return $this->_id;
  }
    
  /**
   * @param null|int $id
   * @return TestcaseModel
   */
  public function setFeature_id($id)
  {
    $this->_feature_id = (int) $id;
    return $this;
  }
    
  /**
   * @return null|int
   */
  public function getFeature_id()
  {
    return $this->_feature_id;
  }
  
  /**
   * @param null|string $title
   * @return TestcaseModel
   */
  public function setTitle($title)
  {
    $this->_title = is_null($title)
                  ? $title
                  : htmlEntityDecode(trim((string) $title), ENT_QUOTES, 'UTF-8');
    return $this;
  }
  
  /**
   * @return null|string
   */
  public function getTitle()
  {
    return $this->_title;
  }
    
  /**
   * @param null|string $code
   * @return TestcaseModel
   */
  public function setCode($code)
  {
    $this->_code = trim(
      preg_replace('/"\\s*\\+\\s*"/', '',
        preg_replace('/\\s+/', ' ', (string) $code)));
    return $this;
  }
  
  /**
   * @return null|string
   */
  public function getCode()
  {
    return $this->_code;
  }

  /**
   * @param null|bool $quoted
   * @return TestcaseModel
   */
  public function setQuoted($quoted)
  {
    $this->_quoted = is_null($quoted) ? $quoted : (boolean) $quoted;
    return $this;
  }
  
  /**
   * @return null|bool
   */
  public function getQuoted()
  {
    return $this->_quoted;
  }
  
  /**
   * Returns the testcases for a feature specified by its ID
   *
   * @param int $id
   * @return array
   */
//   public static function findByFeatureId($id)
//   {
//     $testcase = new self(array('feature_id' => $id));
//     $result = self::$persistentAdapter->findAll($testcase);
    
//     if (defined('DEBUG') && DEBUG > 0)
//     {
//       debug($result);
//     }
    
//     return $result;
//   }
}

