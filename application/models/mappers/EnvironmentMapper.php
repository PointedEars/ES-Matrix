<?php

require_once 'application/models/EnvironmentModel.php';

class EnvironmentTestedException extends Exception
{
  public function __construct ()
  {
    parent::__construct('Environment was already tested, discarding results');
  }
}

/**
 * Mapper class for test environments
 *
 * @author Thomas Lahn
 */
class EnvironmentMapper extends \PointedEars\PHPX\Db\Mapper
{
  private static $_instance = null;

  /*
   * (non-PHPDoc) see Mapper::$_table
   */
  protected $_table = 'EnvironmentTable';

  protected function __construct()
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
   * @throws EnvironmentAlreadyTestedException if the environment
   *   specified by the User-Agent header field was already tested.
   */
  public function save ($user_agent, $version_id)
  {
    $env = new EnvironmentModel(array(
      'user_agent' => $user_agent,
      'version_id' => $version_id,
    ));

    $env->findByUserAgent();
    if ($env->id !== null && $env->tested)
    {
      throw new EnvironmentTestedException();
    }

    $env->tested = true;

    if (!$env->save())
    {
      /*
       * Untested environment could not be saved,
       * makes no sense to add results
       */
      return null;
    }

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
      $envs[] = new EnvironmentModel($row);
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

  /**
   * Resets the <code>tested</code> field for all environments
   * so that they can be tested again
   *
   * @param bool $value
   */
  public function setAllUntested ()
  {
    $this->table->update(array('tested' => false), null);
  }
}