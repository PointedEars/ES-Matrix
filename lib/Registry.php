<?php

/**
 * Basic registry class
 *
 * @author Thomas Lahn
 */
abstract class Registry
{
  /**
   * Data storage
   * @var array
   */
  protected static $_data = array();
  
  /**
   * Puts data in storage
   *
   * @param string $key
   * @param mixed $value
   */
  public static function set($key, $value)
  {
    self::$_data[$key] = $value;
  }

  /**
   * Gets data from storage
   *
   * @param string $key
   * @return mixed
   */
  public static function get($key)
  {
    return self::$_data[$key];
  }
}