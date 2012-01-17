<?php
require_once 'lib/Db/Mapper.php';

require_once 'application/models/databases/es-matrix/tables/FeatureTable.php';
require_once 'application/models/FeatureModel.php';
require_once 'application/models/mappers/TestcaseMapper.php';

require_once 'includes/features.class.php';

class FeatureMapper extends Mapper
{
  private static $_instance = null;
  
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
   * Gets the {@link Table} for this mapper
   */
  public function getDbTable($table = 'FeatureTable')
  {
    return parent::getDbTable($table);
  }
  
  /**
   * Saves a feature in the features table
   *
   * @param FeatureModel|array $feature
   */
  public function save($feature)
  {
//       var_dump($feature);
    if (is_array($feature))
    {
      // FIXME
      unset($feature['testcases']);
      
      $feature = new FeatureModel($feature);
    }
    
    $id = $feature->id;
    $data = array(
      'id'  => $id,
      'code'  => $feature->code,
      'title' => $feature->title,
//      'created' => date('Y-m-d H:i:s'),
    );

    if (is_null($id) || $id === 0)
    {
      unset($data['id']);
//        var_dump($data);
      return $this->getDbTable()->insert($data);

      /* TODO: Assign testcases to feature here */
    }
    else
    {
      return $this->getDbTable()->updateOrInsert($data, array('id' => $id));
    }
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
    
//     var_dump($features);
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

//     var_dump($features);
    
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
//     var_dump($success);
    return $success;
  }
}
