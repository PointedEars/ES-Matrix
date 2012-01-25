<?php

require_once 'lib/Application.php';
require_once 'lib/View.php';

/* lcfirst() is unavailable before PHP 5.3 */
if (false === function_exists('lcfirst'))
{
  /**
   * Make a string's first character lowercase
   *
   * @param string $str The input string.
   * @return string The resulting string.
   * @link http://www.php.net/manual/en/function.lcfirst.php
   */
  function lcfirst($str)
  {
    return strtolower(substr($str, 0, 1)) . substr($str, 1);
  }
}

/**
 * A general controller that can handle views according to the MVC pattern
 *
 * @author tlahn
 */
abstract class Controller
{
  /**
   * The {@link View} used by this controller
   *
   * @var View
   */
  protected $_view = null;
  
  /**
   * Constructs a controller, initializes the related view, and calls
   * the controller's URI-indicated action method.
   *
   * @param string $viewClass
   *   View class.  The default is <code>'View'</code>.
   * @param string $template
   *   Resource path of the template for the view.  The default is the empty string.
   */
  protected function __construct($viewClass = 'View', $template = null) {
    $this->_view = new $viewClass($template);

    Application::getInstance()->setCurrentController($this);
    $action = Application::getParam('action');
    if ($action)
    {
      $this->{lcfirst($action) . 'Action'}();
    }
    else
    {
      $this->indexAction();
    }
  }
    
  /**
   * Assigns a value to a template variable (after this, <var>$value</var> is
   * available through <code>$this-><var>$name</var></code> in the view's template).
   * <code>Controller</code>s should call this method instead of
   * {@link View::assign()}.
   *
   * @param string $name
   *   Variable name
   * @param mixed $value
   *   Variable value
   * @param bool $encodeHTML
   *   If <code>true</code>, replace all potentially conflicting characters
   *   in <var>$value</var> with their HTML entity references.  The default is
   *   <code>false</code>.
   * @return mixed The assigned value (after possible HTML encoding)
   * @see View::encodeHTML()
   */
  protected function assign($name, $value, $encodeHTML = false)
  {
    return $this->_view->assign($name, $value, $encodeHTML);
  }
  
  /**
   * Renders the {@link View} associated with this controller by including
   * the <code>View</code>'s template.  <code>Controller</code>s
   * should call this method instead of <code>View::render()</code>.
   *
   * @param string $template
   *   Optional alternative template resource path.
   *   If not provided, the default template (the <code>View</code>'s
   *   <code>$template</code> property) will be used.
   */
  public function render($template = null, $content = null)
  {
    $this->_view->render($template, $content);
  }
}

?>