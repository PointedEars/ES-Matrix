<?php
require_once 'lib/Db/Mapper.php';

require_once 'application/models/databases/es-matrix/tables/ResultTable.php';
require_once 'application/models/ResultModel.php';

require_once 'application/models/mappers/ImplementationMapper.php';
require_once 'application/models/mappers/EnvironmentMapper.php';
require_once 'application/models/mappers/VersionMapper.php';

/**
 * Mapper class for tested implementation versions
 *
 * @author Thomas Lahn
 */
class ResultMapper extends Mapper
{
  private static $_instance = null;
  
  /*
   * (non-PHPDoc) see Mapper::$_table
   */
  protected $_table = 'ResultTable';
  
  private function __construct()
  {
    /* Singleton */
  }
  
  /**
   * Returns the instance of this mapper
   *
   * @return ResultMapper
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
   * Saves an result in the result table, and updates related tables
   *
   * @param array $data
   *   Result data
   */
  public function save($data)
  {
    $ver_id = null;
    
    if (isset($data['implementation']))
    {
      $impl_id = ImplementationMapper::getInstance()->save($data['implementation']);
      if (!is_null($impl_id) && $impl_id > 0)
      {
        $ver_id = VersionMapper::getInstance()->save($impl_id, $data['version']);
      }
    }
    
    if (!is_null($ver_id) && $ver_id > 0)
    {
      $data['version_id'] = $ver_id;
    }
    else
    {
      $ver_id = 0;
    }
    
    var_dump($data);
    
    $env_id = EnvironmentMapper::getInstance()->save($data['user_agent'], $ver_id);
    if (!is_null($env_id) && $env_id > 0)
    {
      $table = $this->getDbTable();
      $table->beginTransaction();
      
      $results = $data['results'];
      if (is_array($results))
      {
        foreach ($results as $testcase_id => $value)
        {
          $table->updateOrInsert(
            array(
            	'testcase_id'    => $testcase_id,
            	'environment_id' => $env_id,
          		'value'          => $value
            ),
            array(
             'testcase_id'    => $testcase_id,
             'environment_id' => $env_id,
            )
          );
        }
      }
      
      $table->commit();
    }
  }
    
  /**
   * Finds a version in the version table by ID
   *
   * @param int $id
   * @param VersionModel $env
   * @return VersionModel
   */
  public function find($id, VersionModel $ver)
  {
    $result = $this->getDbTable()->find($id);
    if (0 == count($result))
    {
      return null;
    }
    $row = $result[0];
    $ver->setId($row['id'])
    ->setName($row['name'])
    ->setUser_agent($row['user_agent']);
    return $ver;
  }
  
  /**
   * Fetches all records from the implementation table
   *
   * @return array
   */
  public function fetchAll()
  {
    $resultSet = $this->getDbTable()->fetchAll();
    $vers = array();
    foreach ($resultSet as $row)
    {
      $ver = new VersionModel(array(
        'id'         => $row['id'],
        'name'       => $row['name']
      ));
      ;
      $vers[] = $ver;
    }
    
    return $vers;
  }
}

