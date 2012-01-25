<?php
require_once 'lib/Db/Mapper.php';

require_once 'application/models/databases/es-matrix/tables/FeatureTable.php';
require_once 'application/models/FeatureModel.php';
require_once 'application/models/mappers/TestcaseMapper.php';

require_once 'includes/features.class.php';

/**
 * Mapper class for features
 *
 * @author Thomas Lahn
 */
class FeatureMapper extends Mapper
{
  private static $_instance = null;

  protected $_table = 'FeatureTable';
  
  private function __construct()
  {
    /* Singleton */
  }
  
  /**
   * Returns the instance of this mapper
   *
   * @return FeatureMapper
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
   * Saves a feature in the features table
   *
   * @param FeatureModel|array $feature
   */
  public function save($feature)
  {
//       debug($feature);
    if (is_array($feature))
    {
      $featureObj = new FeatureModel($feature);
    }
    
    $id = $featureObj->id;
    $data = array(
      'id'  => $id,
      'code'  => $featureObj->code,
      'title' => $featureObj->title,
//      'created' => date('Y-m-d H:i:s'),
    );

    if (is_null($id) || $id === 0)
    {
      unset($data['id']);
//        debug($data);
      
      $success = $this->getDbTable()->insert($data);
      if ($success)
      {
        $id = $this->getDbTable()->getDatabase()->getLastInsertId();
      }
    }
    else
    {
      $success = $this->getDbTable()->updateOrInsert($data, array('id' => $id));
    }
    
    if ($success)
    {
      /* DEBUG */
//       debug($feature);
      
      $mapper = TestcaseMapper::getInstance();
      $table = $mapper->getDbTable();
      $table->beginTransaction();
      
    	/* Delete saved testcases for that feature */
      $table->delete(null, array('feature_id' => $id));
      
      /* Assign new testcases to feature */
      $codes = $feature['testcases']['codes'];
      
      if ($codes)
      {
        $gluedCodes = implode('', $codes);
        if (!empty($gluedCodes))
        {
          foreach ($feature['testcases']['titles'] as $key => $title)
          {
            $testcase = new TestcaseModel(array(
              'feature_id' => $id,
              'title'      => $title,
              'code'       => $codes[$key]
            ));
  
            /* DEBUG */
//             debug($testcase);
        
            TestcaseMapper::getInstance()->save($testcase);
          }
        }
      }
      
      $success = $table->commit();
      if (!$success)
      {
        $table->rollBack();
      }
    }
    
    return $success;
  }
  
  /**
   * Import features from a <code>FeatureList</code> into the features table
   *
   * @param FeatureList $featureList
   */
  public function importAll(FeatureList $featureList)
  {
    $features = array();
    
    foreach ($featureList->items as $key => $featureData)
    {
      $feature = new FeatureModel(array(
        'id' => $key + 1,
        'code' => $featureData->content,
        'title' => $featureData->title
      ));
      
      $this->save($feature);
      
      $features[] = $feature;
    }
    
//     debug($features);
  }
  
  /**
   * Finds a feature in the features table by ID
   *
   * @param int $id
   * @param FeatureModel[optional] $feature
   *   TODO: Why?
   * @return Feature
   */
  public function find($id, FeatureModel $feature = null)
  {
    $result = $this->getDbTable()->find($id);
    if (0 == count($result))
    {
      return null;
    }
    
    $row = $result[0];
    
    if (is_null($feature))
    {
      $feature = new FeatureModel();
    }
    
    $id = $row['id'];
    $feature->setId($id)
            ->setCode($row['code'])
            ->setTitle($row['title'])
            ->setTestcases(TestcaseMapper::getInstance()->findByFeatureId($id))
//             ->setCreated($row['created'])
    ;
    
    return $feature;
  }
  
  /**
   * Fetches all records from the features table
   *
   * @return array
   */
  public function fetchAll()
  {
    $resultSet = $this->getDbTable()->fetchAll();
    $features = array();
    $testcaseMapper = TestcaseMapper::getInstance();
    foreach ($resultSet as $row)
    {
      $id = $row['id'];
      $feature = new FeatureModel(array(
        'id'        => $id,
        'code'      => $row['code'],
        'title'     => $row['title'],
        'testcases' => $testcaseMapper->findByFeatureId($id)
      ));
//         ->setCreated($row->created)
      ;
      $features[] = $feature;
    }

//     debug($features);
    
    return $features;
  }
  
  /**
   * Deletes a record from the features table
   *
   * @return boolean
   */
  public function delete($id)
  {
    $success = $this->getDbTable()->delete($id);
//     debug($success);
    return $success;
  }
}
