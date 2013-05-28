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
  protected $_template = 'application/layouts/layout.phtml';

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

  public function isSafe($feature_id)
  {
    return isset($this->results['safeFeatures'][$feature_id]);
  }
}

?>