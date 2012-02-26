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
   * Saves an environment in the database
   *
   * @param string $user_agent
   *   User-Agent string
   * @param int $version_id
   *   Version ID, if available.  The default is 0 (no assignment).
   * @return int|null
   *   ID of the inserted or existing record,
   *   <code>null</code> otherwise.
   */
  public function save($user_agent, $version_id)
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

  /**
   * Fetches all records from the environment table
   *
   * @return array
   */
  public function fetchAllPerImplementation()
  {
    $resultSet = $this->getDbTable()->getDatabase()->select(
      'environment AS e
			 LEFT JOIN version AS v ON e.version_id = v.id
			 LEFT JOIN implementation AS i ON v.impl_id = i.id',
      array(
        'impl_id'  => 'i.id',
        'version'  => 'v.name',
        'env_name' => 'e.name',
        'user_agent' => 'e.user_agent'
      ),
      'v.id IS NOT NULL AND impl_id IS NOT NULL',
      "ORDER BY i.sortorder,
       SUBSTRING_INDEX(`version`, '.', 1) + 0,
       SUBSTRING_INDEX(SUBSTRING_INDEX(`version`, '.', -3), '.', 1) + 0,
       SUBSTRING_INDEX(SUBSTRING_INDEX(`version`, '.', -2), '.', 1) + 0,
       SUBSTRING_INDEX(`version`, '.', -1) + 0,
       e.sortorder, e.name"
    );
    
    $envs = array();
    foreach ($resultSet as $row)
    {
      $envs[(int) $row['impl_id']][] = array(
        'version'   => $row['version'],
        'name'      => $row['env_name'],
        'userAgent' => $row['user_agent']
      );
    }
    
    if (defined('DEBUG') && DEBUG > 0)
    {
      debug($envs);
    }
    
    return $envs;
  }
}

