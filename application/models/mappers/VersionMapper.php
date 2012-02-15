<?php
require_once 'lib/Db/Mapper.php';

require_once 'application/models/databases/es-matrix/tables/VersionTable.php';
require_once 'application/models/VersionModel.php';

/**
 * Mapper class for tested implementation versions
 *
 * @author Thomas Lahn
 */
class VersionMapper extends Mapper
{
  private static $_instance = null;
  
  /*
   * (non-PHPDoc) see Mapper::$_table
   */
  protected $_table = 'VersionTable';
  
  private function __construct()
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
  public function save($implementation_id, $name)
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
   * Finds a version ID by name
   *
   * @param string $name
   *   Version string to search for
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
    $impl = new VersionModel($row,
      array(
    		'impl_id' => 'implementation_id'
      )
    );
    return $impl->id;
  }
  
  /**
   * Fetches all records from the version table
   *
   * @return array
   */
  public function fetchAll()
  {
    $resultSet = $this->getDbTable()->fetchAll();
    $vers = array();
    foreach ($resultSet as $row)
    {
      $ver = new VersionModel(
        array(
          'id'         => $row['id'],
          'name'       => $row['name']
        ),
        array(
      		'impl_id' => 'implementation_id'
        )
      );
      $vers[] = $ver;
    }
    
    return $vers;
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

