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
      'title' => $testcase->title,
      'code' => $testcase->code
    );

//     var_dump($data);
    
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
//     var_dump(max(array_map('mapper', $testcases)));
    
//     var_dump($testcases);
  }
  
  /**
   * Finds a testcase in the features table by ID
   *
   * @param int $id
   * @param TestcaseModel $feature
   * @return Testcase
   */
  public function find($id, TestcaseModel $testcase)
  {
    $result = $this->getDbTable()->find($id);
    if (0 == count($result))
    {
      return null;
    }
    $row = $result[0];
    $testcase->setId($row['id'])
    ->setFeature_id($row['feature_id'])
    ->setTitle($row['title'])
    ->setCode($row['code'])
//     ->setCreated($row->created)
    ;
    return $testcase;
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

