<?php
require_once 'lib/Application.php';
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
    else
    {
      $featureObj = $feature;
    }
    
    $id = $featureObj->id;
    $data = array(
      'code'        => $featureObj->code,
      'title'       => $featureObj->title,
      'edition'     => $featureObj->edition,
      'section'     => $featureObj->section,
      'section_urn' => $featureObj->section_urn,
    );

    if (is_null($id))
    {
      $data['created'] = gmdate('Y-m-d H:i:s');
    }
    
    $table = $this->getDbTable();
    if (defined('DEBUG') && DEBUG > 0)
    {
      debug($data);
    }
      
    $success = $table->updateOrInsert($data, array('id' => $id));
    
    if ($success)
    {
      if ($table->lastInsertId)
      {
        $id = $table->lastInsertId;
      }
      
      /* DEBUG */
      if (defined('DEBUG') && DEBUG > 0)
      {
        if (is_array($feature))
        {
          debug($feature['testcases']);
        }
        else
        {
          debug($feature->testcases);
        }
      }
      
      if (is_array($feature))
      {
        $success = TestcaseMapper::getInstance()->saveForFeature($id, $feature['testcases']);
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
      $versions = $featureData->versions;
      $app = Application::getInstance();
      $edition = $app->getParam('ecmascript', $versions);
      $section = null;
      if (!is_null($edition))
      {
        if (is_array($edition))
        {
          $urn = $app->getParam('urn', $edition);
          $section = $app->getParam('section', $edition);
          $edition = $edition[0];
        }
      }
      
      $feature = new FeatureModel(array(
        'id'          => $key + 1,
        'code'        => $featureData->content,
        'title'       => $featureData->title,
        'edition'     => $edition,
        'section'     => $section,
        'section_urn' => $urn
      ));
      
      $this->save($feature);
      
      $features[] = $feature;
    }
    
//     debug($features);
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
      $row['testcases'] = $testcaseMapper->findByFeatureId($row['id']);
      $feature = new FeatureModel($row);
      $features[$feature->id] = $feature;
    }

    if (defined('DEBUG') && DEBUG > 1)
    {
      debug($features);
    }
    
    return $features;
  }
  
  /**
  * Finds a feature in the features table by ID
  *
  * @param int $id
  * @param FeatureModel[optional] $feature
  *   TODO: Why?
  * @return FeatureModel
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
            ->setEdition($row['edition'])
            ->setSection($row['section'])
            ->setSection_URN($row['section_urn'])
            ->setTestcases(TestcaseMapper::getInstance()->findByFeatureId($id))
    //             ->setCreated($row['created'])
    ;
  
    return $feature;
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
