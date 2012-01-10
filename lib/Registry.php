<?php

abstract class Registry
{
  protected static $_data = array();
  
  public static function set($key, $value)
  {
    self::$_data[$key] = $value;
  }

  public static function get($key)
  {
    return self::$_data[$key];
  }
}