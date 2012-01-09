<?php

/**
 * View class for index
 *
 * @author Thomas Lahn
 */
class IndexView extends View
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
}

?>