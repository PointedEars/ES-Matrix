<?php
require_once 'lib/Db/Mapper.php';

require_once 'application/models/databases/es-matrix/tables/TestcaseTable.php';
require_once 'application/models/TestcaseModel.php';

require_once 'includes/features.class.php';

/**
 * Mapper class for testcases
 *
 * @author Thomas Lahn
 */
class TestcaseMapper extends Mapper
{
  private static $_instance = null;
  
  /*
   * (non-PHPDoc) see Mapper::$_table
   */
  protected $_table = 'TestcaseTable';
  
  private function __construct()
  {
    /* Singleton */
  }
  
  /**
   * Returns the instance of this mapper
   *
   * @return TestcaseMapper
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
   * Saves a testcase in the testcase table
   *
   * @param TestcaseModel $testcase
   */
  public function save(TestcaseModel $testcase)
  {
    $id = $testcase->id;
    $data = array(
      'id'  => $id,
      'feature_id'  => $testcase->feature_id,
      'title'       => $testcase->title,
      'code'        => $testcase->code,
      'quoted'      => $testcase->quoted
    );

    if (defined('DEBUG') && DEBUG > 0)
    {
      debug($data);
    }
    
    if (is_null($id))
    {
      unset($data['id']);
      $this->getDbTable()->insert($data);
    }
    else
    {
      $this->getDbTable()->updateOrInsert($data, array('id' => $id));
    }
  }
  
  /**
   * Saves the testcases for a feature
   *
   * @param int $featureId
   * @param array $testcases
   */
  public function saveForFeature($featureId, array $testcases)
  {
    $table = $this->getDbTable();
    $table->beginTransaction();
    
    /*
     * NOTE: Must _delete_ saved testcases for that feature to avoid
     * invalid results (ON DELETE CASCADE)
     */
    $table->delete(null, array('feature_id' => $featureId));
    
    /* Assign new testcases to feature */
    $codes = $testcases['codes'];
    
    if ($codes)
    {
      $gluedCodes = implode('', $codes);
      if (!empty($gluedCodes))
      {
        $quoteds = $testcases['quoteds'];
        foreach ($testcases['titles'] as $key => $title)
        {
          $quoted = null;
          if (is_array($quoteds) && array_key_exists($key, $quoteds))
          {
            $quoted = $quoteds[$key];
          }
          
          $testcase = new TestcaseModel(array(
            'feature_id' => $featureId,
            'title'      => $title,
            'code'       => $codes[$key],
            'quoted'     => $quoted
          ));
    
          /* DEBUG */
          if (defined('DEBUG') && DEBUG > 0)
          {
            debug($testcase);
          }
    
          $this->save($testcase);
        }
      }
    }
    
    $success = $table->commit();
    if (!$success)
    {
      $table->rollBack();
    }
    
    return $success;
  }
  
  public function importAll(FeatureList $featureList)
  {
    $testcases = array();
    
    foreach ($featureList->items as $key => $featureData)
    {
      $versions = $featureData->versions;
      $code = isset($versions['']) ? $versions[''] : null;
      if (!is_null($code))
      {
        $testcase = new TestcaseModel(array(
        	'id' => $key + 1,
          'feature_id' => $key + 1,
          'code' => $code
        ));

        $this->save($testcase);
      
        $testcases[] = $testcase;
      }
    }

//     function mapper($el)
//     {
//       return strlen(trim($el->code));
//     }
//     debug(max(array_map('mapper', $testcases)));
    
//     debug($testcases);
  }
  
  /**
   * Returns the testcases for a feature specified by its ID
   *
   * @param int $id
   * @return array
   */
  public function findByFeatureId($id)
  {
    $resultSet = $this->getDbTable()->select(null, array('feature_id' => $id));
    $testcases = array();
    foreach ($resultSet as $row)
    {
      $testcase = new TestcaseModel($row);
//         ->setCreated($row->created)
      ;
      $testcases[] = $testcase;
    }

    if (defined('DEBUG') && DEBUG > 0)
    {
      debug(array('testcases' => $testcases));
    }
    
    return $testcases;
  }
  
  /**
   * Fetches all records from the testcase table
   *
   * @return array
   */
  public function fetchAll()
  {
    $resultSet = $this->getDbTable()->fetchAll();
    $testcases = array();
    foreach ($resultSet as $row)
    {
      $testcase = new TestcaseModel(array(
        'id'         => $row['id'],
        'feature_id' => $row['feature_id'],
        'title'      => $row['title'],
        'code'       => $row['code']
      ));
//         ->setCreated($row->created)
      ;
      $testcases[] = $testcase;
    }
    
    return $testcases;
  }
}

