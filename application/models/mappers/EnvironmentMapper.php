<?php
require_once 'lib/Db/Mapper.php';

require_once 'application/models/databases/es-matrix/tables/EnvironmentTable.php';
require_once 'application/models/EnvironmentModel.php';

/**
 * Mapper class for test environments
 *
 * @author Thomas Lahn
 */
class EnvironmentMapper extends Mapper
{
  private static $_instance = null;
  
  /*
   * (non-PHPDoc) see Mapper::$_table
   */
  protected $_table = 'EnvironmentTable';
  
  private function __construct()
  {
    /* Singleton */
  }
  
  /**
   * Returns the instance of this mapper
   *
   * @return EnvironmentMapper
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
   * Saves an environment in the testcase table
   *
   * @param string $user_agent
   *   User-Agent string
   * @param int $version_id
   *   Version ID, if available.  The default is 0 (no assignment).
   * @return int|null
   *   ID of the inserted or existing record,
   *   <code>null</code> otherwise.
   */
  public function save($user_agent, $version_id = 0)
  {
    $table = $this->getDbTable();
    
    $data = array(
			'user_agent' => $user_agent,
			'version_id' => $version_id
		);
    
    if (!$table->insert($data))
    {
      return $this->getIdByUserAgent($user_agent);
    }
    
    return $table->lastInsertId;
  }
  
  /**
   * Finds an environment in the environment table by ID
   *
   * @param int $id
   * @param EnvironmentModel $env
   * @return EnvironmentModel
   */
  public function find($id, EnvironmentModel $env)
  {
    $result = $this->getDbTable()->find($id);
    if (0 == count($result))
    {
      return null;
    }
    $row = $result[0];
    $env->setId($row['id'])
    ->setName($row['name'])
    ->setUser_agent($row['user_agent']);
    return $env;
  }

  /**
   * Finds an environment in the environment table by User-Agent string
   *
   * @param string $ua
   *   User-Agent string to search for
   * @return int
   */
  public function getIdByUserAgent($ua)
  {
    $result = $this->getDbTable()->select(null, array('user_agent' => $ua));
    if (0 == count($result))
    {
      return null;
    }

    $row = $result[0];
    $env = new EnvironmentModel($row);
    return $env->id;
  }
  
  /**
   * Fetches all records from the environment table
   *
   * @return array
   */
  public function fetchAll()
  {
    $resultSet = $this->getDbTable()->fetchAll();
    $envs = array();
    foreach ($resultSet as $row)
    {
      $env = new EnvironmentModel(array(
        'id'         => $row['id'],
        'name'       => $row['name'],
        'user_agent' => $row['user_agent']
      ));
      ;
      $envs[] = $env;
    }
    
    return $envs;
  }
}

