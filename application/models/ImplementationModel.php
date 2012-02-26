<?php

require_once 'lib/AbstractModel.php';

require_once 'application/models/adapters/MatrixAdapter.php';

/**
 * Model class for tested implementations
 *
 * @property int $id
 * @property int $sortorder
 * @property string $name
 * @property string $acronym
 */
class ImplementationModel extends AbstractModel
{
  /* ORM */
  const persistentTable = 'implementation';
  
  /**
   * Implementation ID
   * @var int
   */
  protected $_id;
  
  /**
   * Sort order
   * @var int|null
   */
  protected $_sortorder;
  
  /**
   * Implementation name
   * @var string
   */
  protected $_name;
  
  /**
   * Acronym for implementation name (for display)
   * @var string
   */
  protected $_acronym;
  
  /**
   * Versions of this implementation
   * @var array[VersionModel]
   */
  protected $_versions;
  
  /**
   * @param int $id
   * @return ImplementationModel
   */
  public function setId($id)
  {
    $this->_id = (int) $id;
    return $this;
  }
 
  /**
  * Sets the database adapter for this model
  */
  protected function setAdapter()
  {
    $this->_persistentAdapter = MatrixAdapter::getInstance();
  }
  
  /**
   * @return int
   */
  public function getId()
  {
    return $this->_id;
  }

  /**
   * @param int $sortOrder
   * @return ImplementationModel
   */
  public function setSortOrder($sortOrder)
  {
    $this->_sortorder = (int) $sortOrder;
    return $this;
  }
  
  /**
   * @return int
   */
  public function getSortOrder()
  {
    return $this->_sortorder;
  }
  
  /**
   * @param string $name
   * @return ImplementationModel
   */
  public function setName($name)
  {
    $this->_name = trim((string) $name);
    return $this;
  }
  
  /**
   * @return string
   */
  public function getName()
  {
    return $this->_name;
  }
  
  /**
   * @param string $acronym
   * @return ImplementationModel
   */
  public function setAcronym($acronym)
  {
    $this->_acronym = trim((string) $acronym);
    return $this;
  }
  
  /**
   * @return string
   */
  public function getAcronym()
  {
    return $this->_acronym;
  }

  /**
  * @return string
  */
  public function getAcronymOrName()
  {
    return !empty($this->_acronym) ? $this->_acronym : $this->_name;
  }
  
  /**
  * @param array[VersionModel]|null $versions
  * @return ImplementationModel
  */
  public function setVersions($versions)
  {
    if (is_null($versions) || is_array($versions))
    {
      $this->_versions = $versions;
      return $this;
    }

    throw new Exception('Expected null or array of VersionModel instances');
  }
  
  /**
   * @return array[VersionModel]
   */
  public function getVersions()
  {
    return $this->_versions;
  }
}