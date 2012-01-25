<?php

require_once 'lib/Model.php';
require_once 'lib/Registry.php';

/**
 * Basic application class
 *
 * @author Thomas Lahn
 */
class Application
{
  /**
   * Relative path to the controllers directory
   * @var string
   */
  protected $_controllerPath = 'application/controllers';
  
  /**
   * Default controller of the application
   * @var string
   */
  protected $_defaultController = 'Index';
  
  /**
   * Registry key for the default database of the application
   * @var string
   */
  protected $_defaultDatabase;
  
  /**
   * Currently active controller of this application
   * @var Controller
   */
  protected $_currentController;
  
  /**
   * Singleton
   *
   * @var Application
   */
  private static $_instance;
  
  private function __construct()
  {
    /* Singleton pattern */
  }
  
  /**
   * Gets a reference to the <code>Application</code> instance
   * @return Application
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
   * Runs the application, setting up session management and constructing
   * the controller indicated by the URI
   */
  public function run()
  {
    session_start();
    
    $controller = self::getParam('controller');
    if (!$controller)
    {
      $controller = $this->_defaultController;
    }

    $controller = ucfirst($controller);
    
    $controller = $controller . 'Controller';
    require_once "{$this->_controllerPath}/{$controller}.php";
    $this->_currentController = new $controller();
    
    return $this;
  }

  /**
   * Gets a request parameter
   *
   * @param string $key
   *   Key to look up in the array
   * @param array $array
   *   Array where to look up <var>$key</var>.
   *   The default is <code>$_GET</code>.
   * @return mixed
   *   <code>null</code> if there is no such <var>$key</var>
   *   in <var>$array</var>
   */
  public static function getParam($key, array $array = null)
  {
    if (is_null($array))
    {
      $array = $_GET;
    }
    
    return isset($array[$key]) ? $array[$key] : null;
  }
  
  /**
   * Registers a database
   *
   * @param string $key
   * @param Database $database
   */
  public function registerDatabase($key, Database $database)
  {
    Registry::set($key, $database);
  }

  /**
   * Sets the default database
   * @param key Registry key to refer to the {@link Database}
   */
  public function setDefaultDatabase($key)
  {
    $this->_defaultDatabase = $key;
  }

  /**
  * Sets the current controller for this application
  *
  * @param Controller $controller
  * @return Application
  */
  public function setCurrentController(Controller $controller)
  {
    $this->_currentController = $controller;
    return $this;
  }
  
  /**
   * Returns the current controller for this application
   *
   * @return Controller
   */
  public function getCurrentController()
  {
    return $this->_currentController;
  }

  /**
   * Returns the default database for this application
   *
   * @return Database
   */
  public function getDefaultDatabase()
  {
    return Registry::get($this->_defaultDatabase);
  }

  /**
   * Returns a relative URI reference for an action of the application
   */
  public function getURL($controller = null, $action = 'index')
  {
    return $_SERVER['SCRIPT_URL']
      . '?' . (!is_null($controller) ? 'controller=' . $controller : '')
      . ($action !== 'index' ? '&action=' . $action : '');
  }
    
  /**
   * Performs a server-side redirect within the application
   */
  public static function redirect($query = '')
  {
    header('Location: ' . $_SERVER['SCRIPT_URI'] . $query);
  }
}