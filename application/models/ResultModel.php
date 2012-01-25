<?php

require_once 'lib/Model.php';

/**
 * Model class for test results
 *
 * @property int $id
 * @property int $testcase_id
 * @property int $environment_id
 * @property bool $value
 */
class ResultModel extends Model
{
  /**
   * Result ID
   * @var int
   */
  protected $_id;
  
  /**
   * ID of the testcase that has been run
   * @var int
   */
  protected $_testcase_id;
  
  /**
   * ID of the environment in which has been tested
   * @var unknown_type
   */
  protected $_environment_id;
  
  /**
   * Testcase result; <code>true</code> for passed, <code>false</code> for fail
   * @var boolean
   */
  protected $_value;
  
  /**
   * @param int $id
   * @return ResultModel
   */
  public function setId($id)
  {
    $this->_id = (int) $id;
    return $this;
  }
 
  /**
   * @return int
   */
  public function getId()
  {
    return $this->_id;
  }
    
  /**
   * @param int $id
   *   Testcase ID
   * @return ResultModel
   */
  public function setTestcase_id($id)
  {
    $this->_testcase_id = (int) $id;
    return $this;
  }
 
  /**
   * @return int
   *   Testcase ID
   */
  public function getTestcase_id()
  {
    return $this->_testcase_id;
  }
    
  /**
   * @param int $id
   *   Environment ID
   * @return ResultModel
   */
  public function setEnvironment_id($id)
  {
    $this->_environment_id = (int) $id;
    return $this;
  }
 
  /**
   * @return int
   *   Environment ID
   */
  public function getEnvironment_id()
  {
    return $this->_environment_id;
  }

  /**
   * @param bool $value
   *   Testcase result
   * @return ResultModel
   */
  public function setValue($value)
  {
    $this->_value = (bool) $value;
    return $this;
  }
 
  /**
   * @return bool
   *   Testcase result
   */
  public function getValue()
  {
    return $this->_value;
  }
}

