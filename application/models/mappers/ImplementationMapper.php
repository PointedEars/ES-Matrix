<?php

require_once 'application/models/ImplementationModel.php';
require_once 'application/models/mappers/VersionMapper.php';

/**
 * Mapper class for tested implementations
 *
 * @author Thomas Lahn
 */
class ImplementationMapper extends \PointedEars\PHPX\Db\Mapper
{
  private static $_instance = null;

  /*
   * (non-PHPDoc) see Mapper::$_table
   */
  protected $_table = 'ImplementationTable';

  protected function __construct()
  {
    /* Singleton */
  }

  /**
   * Returns the instance of this mapper
   *
   * @return ImplementationMapper
   */
  public static function getInstance()
  {
    if (is_null(self::$_instance))
    {
      self::$_instance = new self();
    }

    return self::$_instance;
  }

  /**
   * @param string|Table $table
   * @return ImplementationTable
   * @see Mapper::getDbTable()
   */
  public function getDbTable($table = null)
  {
    return parent::getDbTable();
  }

	/**
   * Saves an implementation in the database
   *
   * @param string $implementation
   *   Implementation string
   * @return int|null
   *   ID of the inserted or existing record,
   *   <code>null</code> otherwise.
   */
  public function save ($implementation)
  {
    if (is_array($implementation))
    {
      $implObj = new ImplementationModel($implementation);

      if (defined('DEBUG') && DEBUG > 0)
      {
        debug($implObj);
      }

      $success = $implObj->save();

      VersionMapper::getInstance()->saveAll($implObj->id,
        $implementation['assigned'], $implementation['available']);

      return $implObj->persistentTable->lastInsertId;
    }

    if (!$this->table->insert(array('name' => $implementation)))
    {
      return $this->getIdByName($implementation);
    }

    return $table->lastInsertId;
  }

  /**
   * Finds an implementation ID by name
   *
   * @param string $name
   *   Implementation name to search for
   * @return int
   */
  public function getIdByName($name)
  {
    $result = $this->getDbTable()->select(null, array('name' => $name));
    if (0 == count($result))
    {
      return null;
    }

    $row = $result[0];
    $impl = new ImplementationModel($row);
    return $impl->id;
  }

  /**
   * Fetches all records from the implementation table
   *
   * @return array
   */
  public function fetchAll()
  {
    $resultSet = $this->getDbTable()->fetchAll();
    $impls = array();
    foreach ($resultSet as $row)
    {
      $impl = new ImplementationModel($row);

      $impls[$impl->id] = $impl;
    }

    return $impls;
  }

  /**
   * Finds an implementation by ID
   *
   * @param int $id
   * @return ImplementationModel
   */
  public function find ($id)
  {
    $impl = new ImplementationModel();
    $impl = $impl->find($id);
    if ($impl !== null)
    {
      $impl->setVersions(
           		 VersionMapper::getInstance()->getByImplementationId($impl->id));
    }

    return $impl;
  }

  /**
   * Resets the <code>tested</code> column of all implementations
   *
   * @param bool $value
   */
  public function setTested ()
  {
    $this->table->update(array('tested' => false));
  }

  /**
   * Resets the <code>tested</code> column of all implementations
   *
   * @param bool $value
   */
  public function resetTested ()
  {
    $this->table->update(array('tested' => false));
  }
}