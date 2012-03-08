<?php

require_once 'includes/global.inc';

require_once 'lib/AbstractModel.php';

require_once 'application/models/adapters/MatrixAdapter.php';
require_once 'application/models/TestcaseModel.php';

/**
 * Data model for a language feature
 *
 * @author Thomas Lahn
 * @property array[TestcaseModel] $testcases
 */
class FeatureModel extends AbstractModel
{
  /* ORM */
//   const persistentTable = 'feature';
  
  /**
   * ID of the feature
   * @var int
   */
  protected $_id = null;

  /**
   * Code that identifies the feature in the frontend
   * @var string
   */
  protected $_code;
  
  /**
   * <code>title</code> attribute of the feature, if any
   * @var string
   */
  protected $_title = null;
  
  /**
   * ECMAScript Edition that describes the feature, if any
   * @var string
   */
  protected $_edition = null;
  
  /**
   * Section of the ECMAScript Language Specification that describes
   * the feature, if any
   * @var string
   */
  protected $_section = null;
  
  /**
   * URN to refer to the section of the ECMAScript Language Specification
   * that describes the feature, if any
   * @var string
   */
  protected $_section_urn = null;

  /**
   * <code>true</code> if the feature is intentionally generic,
   * <code>false</code> otherwise.
   * @var bool
   */
  protected $_generic = false;

  /**
   * <code>true</code> if the implementation version needs to
   * be declared in order to use this feature,
   * <code>false</code> otherwise.
   * @var bool
   */
  protected $_versioned = false;
  
  /**
   * UTC date of creation as timestamp
   * @var int
   */
  protected $_created;
  
  /**
   * UTC date of last modification as timestamp
   * @var int
   */
  protected $_modified;

  /**
   * Testcases for the feature
   * @var array[TestcaseModel]
   */
  protected $_testcases = null;

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
    $this->_id = is_null($id) ? $id : (int) $id;
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
    $this->_title = is_null($title)
                  ? $title
                  : htmlEntityDecode(trim((string) $title), ENT_QUOTES, 'UTF-8');
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
   * @param string $edition
   * @return FeatureModel
   */
  public function setEdition($edition)
  {
    $this->_edition = is_null($edition) ? $edition : trim((string) $edition);
    return $this;
  }
  
  /**
   * @return string
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
    $this->_section = is_null($section) ? $section : trim((string) $section);
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
    $this->_section_urn = is_null($urn) ? $urn : trim((string) $urn);
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
   * @param bool $generic
   * @return FeatureModel
   */
  public function setGeneric($generic)
  {
    $this->_generic = (bool) $generic;
    return $this;
  }
  
  /**
   * @return bool
   */
  public function getGeneric()
  {
    return $this->_generic;
  }

  /**
   * @param bool $versioned
   * @return FeatureModel
   */
  public function setVersioned($versioned)
  {
    $this->_versioned = (bool) $versioned;
    return $this;
  }
  
  /**
   * @return bool
   */
  public function getVersioned()
  {
    return $this->_versioned;
  }

  /**
   * @param string $date
   * @return FeatureModel
   */
  public function setCreated($date)
  {
    $this->_created = is_null($date) ? $date : strtotime($date . ' GMT');
    return $this;
  }
  
  /**
   * @return int
   */
  public function getCreated()
  {
    return $this->_created;
  }
  
  /**
   * @param string $date
   * @return FeatureModel
   */
  public function setModified($date)
  {
    $this->_modified = is_null($date) ? $date : strtotime($date . ' GMT');
    return $this;
  }
  
  /**
   * @return int
   */
  public function getModified()
  {
    return $this->_modified;
  }
  
  /**
   * @param array[TestcaseModel] $testcases
   * @return FeatureModel
   */
  public function setTestcases($testcases)
  {
    $this->_testcases = is_array($testcases) ? $testcases : null;
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

  static function compare(FeatureModel $a, FeatureModel $b)
  {
    $al = strip_tags($a->code);
    $bl = strip_tags($b->code);
    return strcasecmp($al, $bl);
  }
  
  /* ORM methods */
  
  /**
   * Finds a feature by ID
   */
//   public function find()
//   {
//     parent::find();
//     $this->setTestcases(TestcaseModel::findByFeatureId($this->id));
//   }
}

