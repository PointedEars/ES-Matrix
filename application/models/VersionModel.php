<?php

/**
 * Model class for implementation versions
 */
class VersionModel extends \PointedEars\PHPX\AbstractModel
{
  protected $_id = null;
  protected $_implementation_id = null;
  protected $_name = '';
  protected $_safe = false;

  public function setId($id)
  {
    $this->_id = is_null($id) ? $id : (int) $id;
    return $this;
  }

  public function getId()
  {
    return $this->_id;
  }

  public function setImplementation_Id($id)
  {
    $this->_implementation_id = is_null($id) ? $id : (int) $id;
    return $this;
  }

  public function getImplementationId()
  {
    return $this->_implementation_id;
  }

  public function setName($name)
  {
    $this->_name = trim((string) $name);
    return $this;
  }

  public function getName()
  {
    return $this->_name;
  }

  public function setSafe($safe)
  {
    $this->_safe = (bool) $safe;
    return $this;
  }

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

