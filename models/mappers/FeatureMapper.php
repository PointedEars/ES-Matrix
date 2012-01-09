<?php
require_once 'lib/Db/Mapper.php';

require_once 'models/databases/es-matrix/tables/FeatureTable.php';
require_once 'models/FeatureModel.php';

require_once 'includes/features.class.php';

class FeatureMapper extends Mapper
{
  /**
   * Gets the <code>Table</code> for this mapper
   */
  public static function getDbTable()
  {
    if (null === self::$_dbTable)
    {
      self::setDbTable('FeatureTable');
    }
    
    return self::$_dbTable;
  }
  
  /**
   * Saves a feature in the features table
   * @param Feature $feature
   */
  public static function save(FeatureModel $feature)
  {
    $id = $feature->id;
    $data = array(
      'id'  => $id,
      'name'  => $feature->name,
      'title' => $feature->title,
//      'created' => date('Y-m-d H:i:s'),
    );
  

    if (is_null($id))
    {
      unset($data['id']);
      self::getDbTable()->insert($data);
    }
    else
    {
      self::getDbTable()->updateOrInsert($data, array('id' => $id));
    }
  }
  
  public static function saveAll(FeatureList $featureList)
  {
    $features = array();
    
    foreach ($featureList->items as $key => $featureData)
    {
      $feature = new FeatureModel(array(
        'id' => $key + 1,
        'name' => $featureData->content,
        'title' => $featureData->title
      ));
      
      self::save($feature);
      
      $features[] = $feature;
    }
    
    var_dump($features);
  }
  
  /**
   * Finds a feature in the features table by ID
   * @param int $id
   * @param FeatureModel $feature
   * @return Feature
   */
  public static function find($id, FeatureModel $feature)
  {
    $result = self::getDbTable()->find($id);
    if (0 == count($result))
    {
      return null;
    }
    $row = $result->current();
    $feature->setId($row->id)
    ->setName($row->name)
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
  public static function fetchAll()
  {
    $resultSet = self::getDbTable()->fetchAll();
    $features = array();
    foreach ($resultSet as $row)
    {
      $feature = new FeatureModel(array(
        'id'    => $row['id'],
        'name'  => $row['name'],
        'title' => $row['title']
      ));
//         ->setCreated($row->created)
      ;
      $features[] = $feature;
    }
    
    return $features;
  }
}

