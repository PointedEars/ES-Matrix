<?php
require_once 'lib/Db/Mapper.php';

require_once 'application/models/databases/es-matrix/tables/ImplementationTable.php';
require_once 'application/models/ImplementationModel.php';

require_once 'application/models/mappers/VersionMapper.php';

/**
 * Mapper class for tested implementations
 *
 * @author Thomas Lahn
 */
class ImplementationMapper extends Mapper
{
  private static $_instance = null;
  
  /*
   * (non-PHPDoc) see Mapper::$_table
   */
  protected $_table = 'ImplementationTable';
  
  private function __construct()
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
  public function save($implementation)
  {
    $table = $this->getDbTable();
    if (is_array($implementation))
    {
      $implObj = new ImplementationModel($implementation);
      
      $id = $implObj->id;
      $data = array(
        'sortorder' => $implObj->sortorder,
        'name'      => $implObj->name,
        'acronym'   => $implObj->acronym,
//        'created' => date('Y-m-d H:i:s'),
      );
      
      if (defined('DEBUG') && DEBUG > 0)
      {
        debug($data);
      }

      $success = $table->updateOrInsert($data, array('id' => $id));
      
      VersionMapper::getInstance()->saveAll($id,
        $implementation['assigned'], $implementation['available']);
      
      return $success;
    }
    else
    {
      if (!$table->insert(array('name' => $implementation)))
      {
        return $this->getIdByName($implementation);
      }
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
   * Finds a feature in the features table by ID
   *
   * @param int $id
   * @param ImplementationModel[optional] $feature
   *   TODO: Why?
   * @return ImplementationModel
   */
  public function find($id, ImplementationModel $impl = null)
  {
    $result = $this->getDbTable()->find($id);
    if (0 == count($result))
    {
      return null;
    }
    
    $row = $result[0];
    
    if (is_null($impl))
    {
      $impl = new ImplementationModel();
    }
    
    $id = $row['id'];
    $impl->setId($id)
         ->setSortOrder($row['sortorder'])
         ->setName($row['name'])
         ->setAcronym($row['acronym'])
         ->setVersions(VersionMapper::getInstance()->getByImplementationId($id))
    //             ->setCreated($row['created'])
    ;
    
    return $impl;
  }
}