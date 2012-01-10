<?php

require_once 'lib/Model.php';
require_once 'lib/Registry.php';

class Application
{
  protected $_controllerPath = 'application/controllers';
  protected $_defaultController = 'IndexController';
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
  
  public static function getInstance()
  {
    if (is_null(self::$_instance))
    {
      self::$_instance = new self();
    }
    
    return self::$_instance;
  }
  
  public function run()
  {
    $controller = self::getParam('controller');
    if (!$controller)
    {
      $controller = $this->_defaultController;
    }

    $controller = ucfirst($controller);
    
    require_once "{$this->_controllerPath}/{$controller}.php";
    $this->_currentController = new $controller();
    
    return $this;
  }

  /**
   * Gets a GET request parameter
   *
   * @param string $param
   */
  public static function getParam($param)
  {
    return isset($_GET[$param]) ? $_GET[$param] : null;
  }
  
  public function registerDatabase($key, Database $database)
  {
    Registry::set($key, $database);
  }

  public function setDefaultDatabase($key)
  {
    $this->_defaultDatabase = $key;
  }

  public function getDefaultDatabase()
  {
    return Registry::get($this->_defaultDatabase);
  }
}