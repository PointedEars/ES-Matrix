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
   * Saves a result in the result table, and updates related tables
   *
   * @param array $data
   *   Result data
   * @return bool
   *   <code>true</code> on success, <code>false</code> on failure
   * @see PDO::commit()
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
    
    /* DEBUG */
    if (defined('DEBUG') && DEBUG > 0)
    {
      debug($data);
    }
    
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
      
      return $table->commit();
    }
    
    return false;
  }
}