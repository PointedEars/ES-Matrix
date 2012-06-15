<?php

require_once 'lib/AbstractModel.php';
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
  
  protected function __construct()
  {
    /* Singleton pattern */
  }
  
  /**
   * Gets a reference to the <code>Application</code> instance
   *
   * @param Application $instance
   *   The instance to be used as application.  The default is a new
   *   application.  This parameter is ignored if the application was
   *   already initialized.
   * @return Application
   */
  public static function getInstance(Application $instance = null)
  {
    if (is_null(self::$_instance))
    {
      self::$_instance = ($instance === null) ? new self() : $instance;
    }
    
    return self::$_instance;
  }
  
  /**
   * Getter for properties
   *
   * @param string $name
   * @throws ModelPropertyException
   * @return mixed
   */
  public function __get($name)
  {
    /* Support for Object-Relational Mappers */
    if (strpos($name, 'persistent') === 0)
    {
      $class = get_class($this);
      return $class::${
        $name};
    }
  
    $method = 'get' . ucfirst($name);
  
    if (method_exists($this, $method))
    {
      return $this->$method();
    }
  
    if (property_exists($this, "_$name"))
    {
      return $this->{"_$name"};
    }
  
    return $this->$name;
  }
  
  /**
   * Setter for properties
   *
   * @param string $name
   * @param mixed $value  The new property value before assignment
   * @throws ModelPropertyException
   */
  public function __set($name, $value)
  {
    $method = 'set' . ucfirst($name);
  
    if (method_exists($this, $method))
    {
      return $this->$method($value);
    }
  
    if (property_exists($this, "_$name"))
    {
      $this->{"_$name"} = $value;
      return $this->{"_$name"};
    }
  
    /* NOTE: Attempts to set other properties are _silently_ _ignored_ */
  }
  
  /**
   * Runs the application, setting up session management and
   * constructing the controller indicated by the URI
   */
  public function run()
  {
    $this->startSession();
    
    $controller = self::getParam('controller', $_REQUEST);
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

  protected function startSession()
  {
    session_start();
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
   * Returns a relative URI reference for an action of the
   * application
   *
   * @param string[optional] $controller
   * @param string[optional] $action
   * @param int[optional] $id
   */
  public function getURL($controller = null, $action = null, $id = null)
  {
    /* Apache module */
    $url = self::getParam('SCRIPT_URL', $_SERVER);
    if ($url === null)
    {
      /* FastCGI */
      $url = self::getParam('URL', $_SERVER);
      if ($url === null)
      {
        throw new Exception(
          'Neither $_SERVER["SCRIPT_URL"] nor $_SERVER["URL"] is available, cannot continue.');
      }
    }
    
    $query = (!is_null($controller) ? 'controller=' . $controller : '')
           . (!is_null($action) ? '&action=' . $action : '')
           . (!is_null($id) ? '&id=' . $id : '');
    
    return $url . ($query ? '?' . $query : '');
  }
    
  /**
   * Performs a server-side redirect within the application
   */
  public static function redirect($query = '')
  {
    $script_uri = self::getParam('SCRIPT_URI', $_SERVER);
    if (is_null($script_uri))
    {
      /* Server/PHP too old, compute URI */
      if (preg_match('/^[^?]+/',
          self::getParam('REQUEST_URI', $_SERVER), $matches) > 0)
      {
        $query_prefix = $matches[0];
      }
      else
      {
        /* Has .php in it, but at least it works */
        $query_prefix = self::getParam('SCRIPT_NAME', $_SERVER);
      }

      /* TODO: Let user decide which ports map to which URI scheme */
      $script_uri = (self::getParam('SERVER_PORT', $_SERVER) == 443
                      ? 'https://'
                      : 'http://')
                  . self::getParam('HTTP_HOST', $_SERVER)
                  . $query_prefix;
    }

    header('Location: ' . $script_uri
      . ($query ? (substr($query, 0, 1) === '?' ? '' : '?') . $query : ''));
  }
}
