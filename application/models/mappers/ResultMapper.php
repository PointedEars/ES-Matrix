<?php

use \PointedEars\PHPX\Application;

require_once 'models/ResultModel.php';
require_once 'models/mappers/ImplementationMapper.php';
require_once 'models/mappers/EnvironmentMapper.php';
require_once 'models/mappers/VersionMapper.php';

/**
 * Mapper class for tested implementation versions
 *
 * @author Thomas Lahn
 */
class ResultMapper extends \PointedEars\PHPX\Db\Mapper
{
  private static $_instance = null;

  /**
	 * (non-PHPdoc)
   * @see \PointedEars\PHPX\Db\Mapper::$_table
   */
  protected $_table = 'ResultTable';

  protected function __construct ()
  {
    /* Singleton */
  }

  /**
   * Returns the instance of this mapper
   *
   * @return ResultMapper
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
   * Saves a result in the result table, and updates related tables
   *
   * @param array $data
   *   Result data
   * @return bool
   *   <code>true</code> on success, <code>false</code> on failure
   * @throws EnvironmentAlreadyTestedException if the environment
   *   specified by the User-Agent header field was already tested.
   * @see PDO::commit()
   */
  public function save ($data)
  {
    $ver_id = null;

    if (isset($data['implementation']))
    {
      $impl_id = ImplementationMapper::getInstance()->save($data['implementation']);
      if ($impl_id !== null && $impl_id > 0)
      {
        $ver_id = VersionMapper::getInstance()->save($impl_id, $data['version']);
      }
    }

    /* DEBUG */
    if (defined('DEBUG') && DEBUG > 0)
    {
      if ($ver_id !== null && $ver_id > 0)
      {
        $data['version_id'] = $ver_id;
      }

      debug($data);
    }

    $env_id = EnvironmentMapper::getInstance()->save($data['user_agent'], $ver_id);
    if ($env_id !== null && $env_id > 0)
    {
      $table = $this->getDbTable();
      $table->beginTransaction();

      $results = $data['results'];

      if (is_array($results))
      {
        foreach ($results as $testcase_id => $value)
        {
          /* Find old result for this testcase and environment */
          $previous = $table->select(
              null,
              array(
              	'testcase_id' => $testcase_id,
                'env_id'      => $env_id
              ));

          /*
           * Never overwrite previous results; results are
           * only reset when testcases are updated
           */
          if (!$previous)
          {
            $table->insert(
              array(
              	'testcase_id' => $testcase_id,
              	'env_id'      => $env_id,
            		'value'       => $value
              )
            );
          }
          else
        {
            $previous = $previous[0];
            if ($value !== $previous['value'])
            {
              /* Handle differing results */
            }
          }
        }
      }

      return $table->commit();
    }

    return false;
  }

  /**
   * Returns an array whose keys are the IDs of all features that are
   * considered safe.
   *
   * @param array[FeatureModel] $features
   * @param array[ImplementationModel] $implementations
   * @param array $results
   * @return array
   */
  private function _getSafeFeatures ($features, $implementations, $results)
  {
    $unsafeVersions = VersionMapper::getInstance()->getUnsafeVersions();
    $safeFeatures = array();

    if (is_array($features) && is_array($results))
    {
      foreach ($features as $feature_id => $feature)
      {
        $num_testcases = count($feature->testcases);

        /*
         * Features without testcases are _not_ safe,
         * any assigned results must be bogus
         * (should not happen because of database constraints).
         * Also, features without results are _not_ safe.
         */
        if ($num_testcases < 1
            || !isset($results[$feature_id])
            || !is_array($results[$feature_id]))
        {
          continue;
        }

        $feature_results = $results[$feature_id];

        /* Feature is _not_ safe if results are _incomplete_ */
        foreach ($implementations as $impl_id => $implementation)
        {
          if (!isset($feature_results[$impl_id])
               || !is_array($feature_results[$impl_id]))
          {
            /* check next feature */
            continue 2;
          }
        }

        /* If results are complete, compute flat results */
        $flat_results = array();

        foreach ($feature_results as $impl_id => $impl_results)
        {
          if (is_array($impl_results))
          {
            foreach ($impl_results as $version_id => $version_result)
            {
              $flat_results[$version_id] = $version_result['values'];
            }
          }
        }

        /*
         * Feature is _not_ safe if _complete_ results
         * include _failed_ test for _unsafe_ version
         */
        foreach ($unsafeVersions as $unsafe_version_id)
        {
          if (isset($flat_results[$unsafe_version_id]))
          {
            $unsafe_result = array_sum(str_split($flat_results[$unsafe_version_id]));

            if ($unsafe_result < $num_testcases)
            {
              /* check next feature */
              continue 2;
            }
          }
        }

        $safeFeatures[$feature_id] = true;
      }
    }

    return $safeFeatures;
  }

  /**
   * Returns the tensor array of test results.
   *
   * The first key of the array is the feature ID, the second key
   * is the implementation ID, and the third key is the version name.
   * The stored value is the number of successful testcases for that
   * feature, implementation, and version.  Compared against the non-zero
   * number of testcases <tt>n</tt> for a feature, the value <tt>v</tt>
   * can be used to find out how well supported a feature is in an
   * implementation and version (v === 0: no support; v < n: partial
   * support; v === n: full support).
   *
   * @param array[Feature] $features
   *   The features that should be checked if they are safe according
   *   to the results
   * @param array[Implementation] $implementations
   *   The implementations that should be checked
   * @return array
   */
  public function getResultArray ($features, $implementations)
  {
    /* DEBUG */
//     define('DEBUG', 2);

    $db = $this->getDbTable()->getDatabase();
    $rows = $db->select(
      '`result` r
       LEFT JOIN `testcase` t ON r.testcase_id = t.id
       LEFT JOIN `feature` f ON t.feature_id = f.id
       LEFT JOIN `environment` e ON r.env_id = e.id
       LEFT JOIN `version` v ON e.version_id = v.id
       LEFT JOIN `implementation` i ON v.impl_id = i.id',
      array(
      	'feature_id' => 'f.id',
      	'impl_id'    => 'i.id',
      	'version_id' => 'v.id',
        'value'      => 'r.value'
      ),
      null,
      "ORDER BY feature_id, i.sortorder,
       SUBSTRING_INDEX(v.name, '.', 1) + 0,
       SUBSTRING_INDEX(SUBSTRING_INDEX(v.name, '.', -3), '.', 1) + 0,
       SUBSTRING_INDEX(SUBSTRING_INDEX(v.name, '.', -2), '.', 1) + 0,
       SUBSTRING_INDEX(v.name, '.', -1) + 0,
       t.id"
    );

    $result = array();
    if (is_array($rows))
    {
      /* Get version names here to make query result smaller and query faster */
      $versions = VersionMapper::getInstance()->fetchAll();
      $ver_name_cache = array();

      foreach ($rows as $row)
      {
        $feature_id = (int) $row['feature_id'];
        $impl_id    = (int) $row['impl_id'];
        $version_id = (int) $row['version_id'];

//         if ($feature_id === 0 || $impl_id === 0 || $version_id === 0)
//         {
//           continue;
//         }

        if ($version_id > 0)
        {
          if (!isset($result['forFeatures'][$feature_id][$impl_id][$version_id]))
          {
            if (array_key_exists($version_id, $ver_name_cache))
            {
              $version_name = $ver_name_cache[$version_id];
            }
            else
            {
              $version_name = $versions[$version_id]->name;
              $ver_name_cache[$version_id] = $version_name;
            }

            $result['forFeatures'][$feature_id][$impl_id][$version_id] = array(
              'version' => $version_name,
              'values'  => ''
            );
          }

          $result['forFeatures'][$feature_id][$impl_id][$version_id]['values'] .=
            $row['value'];
        }
      }

      $result['safeFeatures'] = $this->_getSafeFeatures(
        $features, $implementations,
        Application::getParam('forFeatures', $result));
    }

    if (defined('DEBUG') && DEBUG > 0)
    {
      debug($result);
    }

    return $result;
  }
}