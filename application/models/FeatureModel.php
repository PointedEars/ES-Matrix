<?php

require_once 'lib/global.inc';

require_once 'application/models/databases/es-matrix/tables/FeatureTable.php';
require_once 'application/models/TestcaseModel.php';
require_once 'application/models/mappers/TestcaseMapper.php';

/**
 * Data model for a language feature
 *
 * @author Thomas Lahn
 * @property array[TestcaseModel] $testcases
 * @property string $code
 * @property string $title
 * @property string $edition
 * @property string $section
 * @property string $section_urn
 * @property bool $generic
 * @property bool $versioned
 * @property int $created
 * @property int $modified
 */
class FeatureModel extends \PointedEars\PHPX\Model
{
  /* ORM */
	/**
	 * @see \PointedEars\PHPX\Model::$_persistentTable
	 */
	protected static $_persistentTable = 'FeatureTable';

	/**
	 * @see \PointedEars\PHPX\Model::$_persistentId
	 */
	protected static $_persistentId = 'id';

	/**
	 * @see \PointedEars\PHPX\Model::$_persistentProperties
	 */
	protected static $_persistentProperties = array(
	  'code', 'title', 'edition', 'section', 'section_urn',
		'generic', 'versioned', 'created', 'modified'
	);

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
   * @param int $id
   * @return FeatureModel
   */
  public function setId ($id)
  {
    if ($id !== null)
    {
      $this->_id = (int) $id;

      $testcases = $this->testcases;
      if ($testcases)
      {
      	foreach ($testcases as $testcase)
      	{
      		$testcase->feature_id = $this->_id;
      	}
      }
    }

    return $this;
  }

  /**
   * @return int
   */
  public function getId ()
  {
    return $this->_id;
  }

  /**
   * @param string $code
   * @return FeatureModel
   */
  public function setCode ($code)
  {
    $this->_code = htmlEntityDecode(trim((string) $code), ENT_QUOTES, 'UTF-8');
    return $this;
  }

  /**
   * @return string $code
   */
  public function getCode ()
  {
    return $this->_code;
  }

  /**
   * @param string $title
   * @return FeatureModel
   */
  public function setTitle ($title)
  {
    if ($title !== null)
    {
      $this->_title = htmlEntityDecode(trim((string) $title), ENT_QUOTES, 'UTF-8');
    }

    return $this;
  }

  /**
   * @return string
   */
  public function getTitle ()
  {
    return $this->_title;
  }

  /**
   * @param string $edition
   * @return FeatureModel
   */
  public function setEdition ($edition)
  {
    if ($edition !== null)
    {
      $this->_edition = trim((string) $edition);
    }

    return $this;
  }

  /**
   * @return string
   */
  public function getEdition ()
  {
    return $this->_edition;
  }

  /**
   * @param string $section
   * @return FeatureModel
   */
  public function setSection ($section)
  {
    if ($section !== null)
    {
      $this->_section = trim((string) $section);
    }

    return $this;
  }

  /**
   * @return string
   */
  public function getSection ()
  {
    return $this->_section;
  }

  /**
   * @param string $urn
   * @return FeatureModel
   */
  public function setSection_URN ($urn)
  {
    if ($urn !== null)
    {
      $this->_section_urn = trim((string) $urn);
    }

    return $this;
  }

  /**
   * @return string
   */
  public function getSection_URN ()
  {
    return $this->_section_urn;
  }

  /**
   * @param bool $generic
   * @return FeatureModel
   */
  public function setGeneric ($generic)
  {
    $this->_generic = (bool) $generic;
    return $this;
  }

  /**
   * @return bool
   */
  public function getGeneric ()
  {
    return $this->_generic;
  }

  /**
   * @param bool $versioned
   * @return FeatureModel
   */
  public function setVersioned ($versioned)
  {
    $this->_versioned = (bool) $versioned;
    return $this;
  }

  /**
   * @return bool
   */
  public function getVersioned ()
  {
    return $this->_versioned;
  }

  /**
   * @param string $date
   * @return FeatureModel
   */
  public function setCreated ($date)
  {
    $this->_created = ($date === null
    	? $date
    	: (($time = strtotime($date . ' GMT')) !== false
    			? $time
    			: null));
    return $this;
  }

  /**
   * @return int
   */
  public function getCreated ()
  {
    return $this->_created;
  }

  /**
   * @param string $date
   * @return FeatureModel
   */
  public function setModified ($date)
  {
    $this->_modified = ($date === null
    	? $date
      : (($time = strtotime($date . ' GMT')) !== false
      		? $time
      		: null));
    return $this;
  }

  /**
   * @return int
   */
  public function getModified ()
  {
    return $this->_modified;
  }

  /**
   * @param array|array[TestcaseModel]|null $testcases
   * @return FeatureModel
   */
  public function setTestcases ($testcases)
  {
    if ($testcases && is_array($testcases))
  	{
  		$feature_id = $this->id;

  		if (isset($testcases[0]) && $testcases[0] instanceof TestcaseModel)
  		{
  			foreach ($testcases as $testcase)
  			{
  				$testcase->feature_id = $feature_id;
  			}

  			$this->_testcases = $testcases;
  		}
  		else
  		{
  			/* Clear previous testcases */
  			$this->_testcases = array();

  			$codes = $testcases['codes'];
  			if ($codes && trim(implode('', $codes)) !== '')
  			{
  				foreach ($codes as $key => $code)
	  			{
	  				$this->_testcases[$key] = new TestcaseModel(array(
	  					'feature_id' => $feature_id,
	  				  'title'      => $testcases['titles'][$key],
	  					'code'       => $code,
	  					'quoted'     => $testcases['quoteds'][$key],
	  					'alt_type'   => $testcases['alt_types'][$key],
	  				));
	  			}
  			}
  		}
  	}
  	else if ($testcases === null)
  	{
  		$this->_testcases = null;
  	}

    return $this;
  }

  /**
   * @return array[TestcaseModel]
   */
  public function getTestCases ()
  {
    return $this->_testcases;
  }

  static function compare (FeatureModel $a, FeatureModel $b)
  {
    $al = strip_tags($a->code);
    $bl = strip_tags($b->code);
    return strcasecmp($al, $bl);
  }

  /* ORM methods */

  /**
   * Finds a feature by ID
   */
  public function find ()
  {
    parent::find();
    $this->setTestcases(TestcaseMapper::getInstance()->findByFeatureId($this->id));
  }
}