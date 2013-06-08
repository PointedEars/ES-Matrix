<?php

require_once 'application/models/databases/es-matrix/tables/FeatureTable.php';
require_once 'application/models/FeatureModel.php';
require_once 'application/models/mappers/TestcaseMapper.php';

require_once 'lib/features.class.php';

/**
 * Mapper class for features
 *
 * @author Thomas Lahn
 */
class FeatureMapper extends \PointedEars\PHPX\Db\Mapper
{
  private static $_instance = null;

  protected $_table = 'FeatureTable';

  protected function __construct()
  {
    /* Singleton */
  }

  /**
   * Returns the instance of this mapper
   *
   * @return FeatureMapper
   */
  public static function getInstance ()
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
   * @param array $feature
   * @return FeatureModel|null
   *   The updated or added feature, or <code>null</code> on error
   */
  public function save (array $feature)
  {
    /*
     * Improved approach:
     * - Client is only provided with essential data
     * - Client only provides essential data
     */

    /*
     * 1. Create FeatureModel with data from database by ID
     *    or default values
     */
    $featureObj = new FeatureModel();

    if (defined('DEBUG') && DEBUG > 0)
    {
    	debug($featureObj);
    }

    $featureObj->find($feature['id']);

    if (defined('DEBUG') && DEBUG > 0)
    {
    	debug($featureObj);
    }

    /* 2. Update FeatureModel with passed data */
    $featureObj->map($feature);

    if (defined('DEBUG') && DEBUG > 0)
    {
    	debug($feature);
    	debug($featureObj);
    }

    /* 3. Save updated feature in database */
    if ($featureObj->id === null)
    {
    	$featureObj->created = gmdate('Y-m-d H:i:s');
    }

    if (defined('DEBUG') && DEBUG > 0)
    {
    	debug($featureObj);
    }

    $success = $featureObj->save();

    if ($success)
    {
      /* DEBUG */
      if (defined('DEBUG') && DEBUG > 0)
      {
        debug($featureObj);
      }

      /*
       * Do not replace testcases (and remove results)
       * if only metadata should be saved
       */
      if (isset($feature['testcases']))
      {
//         /* DEBUG only */
//         var_dump($feature);
//         return null;

      	$success = (null !== TestcaseMapper::getInstance()->saveForFeature($featureObj));

      	/* DEBUG */
      	if (defined('DEBUG') && DEBUG > 0)
      	{
      		debug($featureObj);
      	}
      }
    }

    return ($success ? $featureObj : null);
  }

  /**
   * Import features from a <code>FeatureList</code> into the features table
   *
   * @param FeatureList $featureList
   */
  public function importAll (FeatureList $featureList)
  {
    $features = array();

    foreach ($featureList->items as $key => $featureData)
    {
      $versions = $featureData->versions;
      $app = Application::getInstance();
      $edition = $app->getParam('ecmascript', $versions);
      $section = null;
      if ($edition !== null)
      {
        if (is_array($edition))
        {
          $urn = $app->getParam('urn', $edition);
          $section = $app->getParam('section', $edition);
          $edition = $edition[0];
        }
      }

      $feature = array(
        'id'          => $key + 1,
        'code'        => $featureData->content,
        'title'       => $featureData->title,
        'edition'     => $edition,
        'section'     => $section,
        'section_urn' => $urn
      );

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
  public function fetchAll ()
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

    uasort($features, array('FeatureModel', 'compare'));

    return $features;
  }

  /**
  * Finds a feature in the features table by ID
  *
  * @param int $id
  * @return FeatureModel|null
  *   A <code>FeatureModel</code> if the ID was found in
  *   the database; null otherwise.
  */
  public function find ($id)
  {
    $row = $this->getDbTable()->find($id);
    if (!$row)
    {
      return null;
    }

    $feature = new FeatureModel($row);
    $feature->setTestcases(TestcaseMapper::getInstance()->findByFeatureId($id));

    return $feature;
  }

  /**
   * Deletes a record from the features table
   *
   * @return boolean
   */
  public function delete ($id)
  {
    $success = $this->getDbTable()->delete($id);
//     debug($success);
    return $success;
  }
}
