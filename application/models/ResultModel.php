<?php

require_once 'application/models/databases/es-matrix/tables/ResultTable.php';

/**
 * Model class for test results
 *
 * @property int|null $id
 * @property int|null $testcase_id
 * @property int|null $env_id
 * @property bool $value
 */
class ResultModel extends \PointedEars\PHPX\Model
{
  /* ORM */
	/**
	 * (non-PHPdoc)
	 * @see \PointedEars\PHPX\Model::$_persistentTable
	 */
  protected static $_persistentTable = 'ResultTable';

	/**
	 * (non-PHPdoc)
	 * @see \PointedEars\PHPX\Model::$_persistentId
	 */
  protected static $_persistentId = 'id';

  /**
	 * (non-PHPdoc)
	 * @see \PointedEars\PHPX\Model::$_persistentProperties
	 */
  protected static $_persistentProperties = array(
    'version_id', 'testcase_id', 'env_id', 'value'
  );

  /**
   * Result ID
   * @var int|null
   */
  protected $_id;

  /**
   * ID of the testcase that has been run
   * @var int|null
   */
  protected $_testcase_id;

  /**
   * ID of the environment in which has been tested
   * @var int|null
   */
  protected $_env_id;

  /**
   * Testcase result; <code>true</code> for passed, <code>false</code> for fail
   * @var boolean
   */
  protected $_value;

  /**
   * @param int|null $value
   * @return ResultModel
   */
  public function setId ($value)
  {
    $this->_id = ($value === null) ? $value : (int) $value;
    return $this;
  }

  /**
   * @return int|null
   */
  public function getId ()
  {
    return $this->_id;
  }

  /**
   * @param int $value
   * @return ResultModel
   */
  public function setTestcase_id ($value)
  {
    $this->_testcase_id = (int) $id;
    return $this;
  }

  /**
   * @return int
   */
  public function getTestcase_id()
  {
    return $this->_testcase_id;
  }

  /**
   * @param int $value
   * @return ResultModel
   */
  public function setEnv_id ($value)
  {
    $this->_env_id = (int) $id;
    return $this;
  }

  /**
   * @return int
   */
  public function getEnv_id ()
  {
    return $this->_env_id;
  }

  /**
   * @param bool $value
   * @return ResultModel
   */
  public function setValue ($value)
  {
    $this->_value = (bool) $value;
    return $this;
  }

  /**
   * @return bool
   */
  public function getValue ()
  {
    return $this->_value;
  }
}