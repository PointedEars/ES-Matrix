<?php

require_once 'application/models/databases/es-matrix/tables/VersionTable.php';
require_once 'application/models/VersionModel.php';

/**
 * Mapper class for tested implementation versions
 *
 * @author Thomas Lahn
 */
class VersionMapper extends \PointedEars\PHPX\Db\Mapper
{
  private static $_instance = null;

  /**
   * (non-PHPDoc)
   * @see Mapper::$_table
   */
  protected $_table = 'VersionTable';

  protected function __construct()
  {
    /* Singleton */
  }

  /**
   * Returns the instance of this mapper
   *
   * @return VersionMapper
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
   * Saves a version of an implementation in the database
   *
   * @param int $implementation_id
   *   Implementation ID
   * @param string $name
   *   Version string
   * @return int|null
   *   ID of the inserted or existing record,
   *   <code>null</code> otherwise.
   */
  public function save ($implementation_id, $name)
  {
    $table = $this->getDbTable();

    $data = array(
      'impl_id' => $implementation_id,
    	'name' => $name
  	);

    if (!$table->insert($data))
    {
      return $this->getIdByName($name);
    }

    return $table->lastInsertId;
  }

	/**
   * Updates the versions of an implementation in the database
   *
   * @param int $implementation_id
   *   Implementation ID
   * @param array $assigned
   *   IDs of versions assigned to the implementation
   * @param array $available
   *   IDs of versions not assigned to the implementation.  Versions that are
   *   neither listed in <var>$assigned</var> nor here, are _removed_ from
   *   the database.
   * @return bool
   *   <code>true</code> if all database operations were successful,
   *   <code>false</code> otherwise.
   */
  public function saveAll ($implementation_id, $assigned, $available)
  {
    /* DEBUG */
//     define('DEBUG', 2);

    $table = $this->getDbTable();
    $table->beginTransaction();

    /* Unassign all versions from the implementation */
    $table->update(
      array('impl_id' => null),
      array('impl_id' => $implementation_id)
    );

//     debug($versions);

    /* Update or insert all assigned versions */
    foreach ($assigned as &$version)
    {
      /*
       * NOTE: New versions must have a minor version part, else they are
       *       IDs of existing versions.
       */
      if (strpos($version, '.') === false && intval($version) == $version)
      {
        $table->update(
          array('impl_id' => $implementation_id),
          array('id'      => (int) $version)
        );
      }
      else
      {
        $result = $this->save($implementation_id, $version);
        if ($result !== null)
        {
          $version = $result;
        }
      }
    }

    /* Delete obsolete versions */
    $table->delete(null, array(
      'id' => array('NOT IN' => array_merge($assigned, $available))
    ));

    return $table->commit();
  }

  /**
   * Finds a version ID by name
   *
   * @param string $name
   *   Version string to search for
   * @return int
   */
  public function getIdByName ($name)
  {
    $result = $this->getDbTable()->select(null, array('name' => $name));
    if (0 === count($result))
    {
      return null;
    }

    $row = $result[0];
    $ver = new VersionModel($row);
    return $ver->id;
  }

  /**
   * Finds all versions of an implementation by its ID
   *
   * @param int $impl_id
   *   Implementation ID
   * @return array[VersionModel]|null
   */
  function getByImplementationId($impl_id)
  {
    /* DEBUG */
//     define('DEBUG', 2);

    $resultSet = $this->getDbTable()->select(null, array('impl_id' => $impl_id),
      "ORDER BY SUBSTRING_INDEX(`name`, '.', 1) + 0,
      	 SUBSTRING_INDEX(SUBSTRING_INDEX(`name`, '.', -3), '.', 1) + 0,
       	 SUBSTRING_INDEX(SUBSTRING_INDEX(`name`, '.', -2), '.', 1) + 0,
         SUBSTRING_INDEX(`name`, '.', -1) + 0");

    if (!$resultSet)
    {
      return null;
    }

    $versions = array();

    foreach ($resultSet as $row)
    {
      $ver = new VersionModel($row);
      $versions[$ver->id] = $ver;
    }

    return $versions;
  }

  /**
   * Fetches all records from the version table
   *
   * @return array
   */
  public function fetchAll()
  {
    $resultSet = $this->getDbTable()->select(null, null,
      "ORDER BY SUBSTRING_INDEX(`name`, '.', 1) + 0,
        	 SUBSTRING_INDEX(SUBSTRING_INDEX(`name`, '.', -3), '.', 1) + 0,
         	 SUBSTRING_INDEX(SUBSTRING_INDEX(`name`, '.', -2), '.', 1) + 0,
           SUBSTRING_INDEX(`name`, '.', -1) + 0");

    $versions = array();

    foreach ($resultSet as $row)
    {
      $ver = new VersionModel($row);
      $versions[$ver->id] = $ver;
    }

    return $versions;
  }

  /**
   * Returns an array of the IDs of the versions that are considered safe
   *
   * @return array[int]
   */
  public function getSafeVersions()
  {
    $resultSet = $this->getDbTable()->select('id', array('safe' => 1));
    return array_map(create_function('$e', 'return $e["id"];'), $resultSet);
  }

  /**
   * Returns an array of the IDs of the versions that are considered safe
   *
   * @return array[int]
   */
  public function getUnsafeVersions()
  {
    $resultSet = $this->getDbTable()->select('id', array('safe' => 0));
    return array_map(create_function('$e', 'return $e["id"];'), $resultSet);
  }
}

