<?php

require_once 'includes/global.inc';

require_once 'lib/Model.php';

require_once 'application/models/adapters/MatrixAdapter.php';
require_once 'application/models/TestcaseModel.php';

/**
 * Data model for a language feature
 *
 * @author Thomas Lahn
 */
class FeatureModel extends Model
{
  /* ORM */
  const persistentTable = 'feature';
  
  /**
   * ID of the feature
   * @var int
   */
  protected $_id;

  /**
   * Code that identifies the feature in the frontend
   * @var string
   */
  protected $_code;
  
  /**
   * <code>title</code> attribute of the feature, if any
   * @var string
   */
  protected $_title;
  
  /**
   * ECMAScript Edition that describes the feature, if any
   * @var int
   */
  protected $_edition;
  
  /**
   * Section of the ECMAScript Language Specification that describes
   * the feature, if any
   * @var string
   */
  protected $_section;
  
  /**
   * URN to refer to the section of the ECMAScript Language Specification
   * that describes the feature, if any
   * @var string
   */
  protected $_section_urn;
//   protected $_created;

  /**
   * Testcases for the feature
   * @var array[TestcaseModel]
   */
  protected $_testcases;

  /**
   * Database adapter
   * @var MatrixAdapter
   */
  public static $persistentAdapter;
  
  /**
   * Sets the ORM database adapter for this model
   */
  protected function setAdapter()
  {
    self::$persistentAdapter = MatrixAdapter::getInstance();
  }
  
  /**
   * @param int $id
   * @return FeatureModel
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
   * @param string $code
   * @return FeatureModel
   */
  public function setCode($code)
  {
    $this->_code = htmlEntityDecode(trim((string) $code), ENT_QUOTES, 'UTF-8');
    return $this;
  }
    
  /**
   * @return string $code
   */
  public function getCode()
  {
    return $this->_code;
  }
  
  /**
   * @param string $title
   * @return FeatureModel
   */
  public function setTitle($title)
  {
    $this->_title = htmlEntityDecode(trim((string) $title), ENT_QUOTES, 'UTF-8');
    return $this;
  }
  
  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->_title;
  }
  
  /**
   * @param int $edition
   * @return FeatureModel
   */
  public function setEdition($edition)
  {
    $this->_edition = (int) $edition;
    return $this;
  }
  
  /**
   * @return int
   */
  public function getEdition()
  {
    return $this->_edition;
  }
  
  /**
   * @param string $section
   * @return FeatureModel
   */
  public function setSection($section)
  {
    $this->_section = (string) $section;
    return $this;
  }
  
  /**
   * @return string
   */
  public function getSection()
  {
    return $this->_section;
  }

  /**
  * @param string $urn
  * @return FeatureModel
  */
  public function setSection_URN($urn)
  {
    $this->_section_urn = (string) $urn;
    return $this;
  }
  
  /**
   * @return string
   */
  public function getSection_URN()
  {
    return $this->_section_urn;
  }
  
  /**
   * @param array[TestcaseModel] $testcases
   * @return FeatureModel
   */
  public function setTestcases($testcases)
  {
    $this->_testcases = $testcases;
    return $this;
  }
  
  /**
   * @return array[TestcaseModel]
   */
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
  
  /* ORM methods */
  
  /**
   * Finds a feature by ID
   */
  public function find()
  {
    parent::find();
    $this->setTestcases(TestcaseModel::findByFeatureId($this->id));
  }
}

