<?php

require_once 'Application.php';
require_once 'AbstractModel.php';

/**
 * A general view handled by a controller according to the MVC pattern
 *
 * @author tlahn
 */
class View
{
  /**
   * Default template resource path
   *
   * @var string
   */
  protected $_template = '';
  
  /**
   * Content that can be inserted in the template
   *
   * @var string
   */
  protected $_content = '';
  
  /**
   * Template variables.  The variable name serves as item key, the item's value
   * is the variable value.
   *
   * @var array
   */
  protected $_template_vars = array();
    
  /**
   * Creates a new view
   *
   * @param string $template
   *   Template resource path
   */
  public function __construct($template)
  {
    $this->_template = $template;
  }
  
  /**
   * Magic setter method used for defining template variables
   *
   * @param string $name
   *   Variable name
   * @param mixed $value
   *   Variable value
   */
  public function __set($name, $value)
  {
    $this->_template_vars[$name] = $value;
  }

  /**
   * Magic getter method used for retrieving values of template variables
   *
   * @param string $name
   *   Variable name
   */
  public function __get($name)
  {
    return $this->_template_vars[$name];
  }
  
  /**
   * Returns <var>$v</var> with occurences of '&' (ampersand), '"' (double quote),
   * "'" (single quote), '<' (less than), and '>' (greater than) replaced by their
   * HTML character entity references, if any, or their numeric HTML character
   * reference (as required primarily in HTML for attribute values and element
   * content).
   *
   * @param mixed $value
   */
  public function escape($value)
  {
    if (is_array($value))
    {
      return array_map(array('self', 'escape'), $value);
    }
    else if (is_object($value))
    {
      if ($value instanceof AbstractModel)
      {
        foreach ($value->getPropertyVars() as $varName)
        {
          $value->$varName = self::escape($value->$varName);
        }
      }
      
      return $value;
    }
    else
    {
      if (is_string($value))
      {
        $value = strval($value);
        $encoding = mb_detect_encoding($value);
        if ($encoding === 'ASCII')
        {
          $encoding = 'ISO-8859-1';
        }
        return htmlspecialchars($value, ENT_QUOTES, $encoding);
      }
      
      return $value;
    }
  }
  
  /**
   * Assigns a value to a template variable
   *
   * @param string $name
   *   Variable name
   * @param mixed $value
   *   Variable value
   * @param bool $escape
   *   If <code>true</code>, replace all potentially conflicting characters
   *   in <var>$value</var> with their HTML entity references.  The default is
   *   <code>false</code>.
   * @return mixed The assigned value (after possible HTML encoding)
   * @see View::escape()
   */
  public function assign($name, $value, $escape = false)
  {
    if ($escape)
    {
      $value = $this->escape($value);
    }

    $this->$name = $value;
    return $value;
  }
  
  /**
   * Renders the view by including a template
   *
   * @param string $template
   *   Optional alternative template resource path.
   *   If not provided, the default template ($template property) will be used.
   * @throws Exception if no template has been defined before
   */
  public function render($template = null, $content = null)
  {
    if (!is_null($content))
    {
      ob_start();
        require_once $content;
        $this->_content = ob_get_contents();
      ob_end_clean();
    }
    
  	if (!is_null($template))
  	{
  		require $template;
  	}
    elseif ($this->_template)
    {
      require $this->_template;
    }
    else
    {
      throw new Exception('No template defined');
    }
  }
  
  /**
   * Returns the content for insertion into the template
   */
  public function getContent()
  {
    return $this->_content;
  }
  
  public function getURL($controller = null, $action = 'index')
  {
    return Application::getInstance()->getURL($controller, $action);
  }
}

?>