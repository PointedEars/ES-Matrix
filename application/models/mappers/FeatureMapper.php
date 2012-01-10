<?php
require_once 'lib/Db/Mapper.php';

require_once 'application/models/databases/es-matrix/tables/FeatureTable.php';
require_once 'application/models/FeatureModel.php';

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
   * Gets the <code>Table</code> for this mapper
   */
  public function getDbTable($table = 'FeatureTable')
  {
    return parent::getDbTable($table);
  }
  
  /**
   * Saves a feature in the features table
   *
   * @param FeatureModel $feature
   */
  public function save(FeatureModel $feature)
  {
    $id = $feature->id;
    $data = array(
      'id'  => $id,
      'code'  => $feature->code,
      'title' => $feature->title,
//      'created' => date('Y-m-d H:i:s'),
    );
  

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
   * @param int $id
   * @param FeatureModel $feature
   * @return Feature
   */
  public function find($id, FeatureModel $feature)
  {
    $result = $this->getDbTable()->find($id);
    if (0 == count($result))
    {
      return null;
    }
    $row = $result->current();
    $feature->setId($row->id)
    ->setCode($row->code)
    ->setTitle($row->title)
//     ->setCreated($row->created)
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
    foreach ($resultSet as $row)
    {
      $feature = new FeatureModel(array(
        'id'    => $row['id'],
        'code'  => $row['code'],
        'title' => $row['title']
      ));
//         ->setCreated($row->created)
      ;
      $features[] = $feature;
    }
    
    return $features;
  }
}

