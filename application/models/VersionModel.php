<?php

/**
 * Model class for implementation versions
 */
class VersionModel extends \PointedEars\PHPX\AbstractModel
{
  /**
   * @var int|null
   */
  protected $_id;

  /**
   * @var int|null
   */
  protected $_implementation_id;

  /**
   * @var string
   */
  protected $_name = '';

  /**
   * @var bool
   */
  protected $_safe = false;

  /**
   * @param int|null $id
   * @return VersionModel
   */
  public function setId ($value)
  {
    $this->_id = ($value === null) ? $value : (int) $value;
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
   * @param int|null $value
   * @return VersionModel
   */
  public function setImplementation_Id ($value)
  {
    $this->_implementation_id = is_null($value) ? $value : (int) $value;
    return $this;
  }

  public function getImplementationId ()
  {
    return $this->_implementation_id;
  }

  /**
   * @param string $value
   * @return VersionModel
   */
  public function setName ($value)
  {
    $this->_name = trim((string) $value);
    return $this;
  }

  /**
   * @return string
   */
  public function getName ()
  {
    return $this->_name;
  }

  /**
   * @param bool $value
   * @return VersionModel
   */
  public function setSafe ($value)
  {
    $this->_safe = (bool) $value;
    return $this;
  }

  /**
   * @return bool
   */
  public function getSafe()
  {
    return $this->_safe;
  }

  /**
   * Maps data used to initialize this <code>ResultModel</code> instance
   * to its data properties.
   *
   * @see AbstractModel::map()
   */
  public function map(array $data, array $mapping = null, $exclusive = false)
  {
    $mapping = array('impl_id' => 'implementation_id');
    parent::map($data, $mapping, $exclusive);
  }
}

