<?php

/**
 * View class for index
 *
 * @author Thomas Lahn
 */
class IndexView extends \PointedEars\PHPX\View
{
  /**
   * Default template resource path
   *
   * @var string
   */
  protected $_template = 'layouts/layout.phtml';

  /**
   * Creates a new view
   *
   * @param string $template
   *   Template resource path (ignored)
   */
  public function __construct($template = null)
  {
    parent::__construct($this->_template);

    global $encoding;
    $this->assign('encoding', $encoding);
  }

  /**
   *
   * @param int $feature_id
   */
  public function isSafe($feature_id)
  {
    return isset($this->results['safeFeatures'][$feature_id]);
  }

  /**
   * Maps testcase code to a formatted version
   *
   * @param TestcaseModel $e
   *   Testcase
   * @param int $i
   *   Testcase index
   * @return string
   */
  private function _mapTestcaseCode ($e, $i)
  {
    return '<h3>Test&nbsp;' . ($i + 1) . "</h3><p><code>"
      . str_replace('  ', '&nbsp;', $this->escape($e->code))
      . '</code></p>';
  }

  /**
   * Returns the escaped list of testcase codes
   *
   * @param array[TestcaseModel] $testcases
   * @return string
   */
  public function getEscapedTestcaseCodes ($testcases)
  {
    return implode("\n",
      array_map(
        array($this, '_mapTestcaseCode'),
        $testcases, array_keys($testcases)));
  }
}

?>
