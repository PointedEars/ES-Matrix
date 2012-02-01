<?php

require_once 'application/models/databases/es-matrix/MatrixDb.php';

require_once 'lib/Db/MySQLAdapter.php';

class MatrixAdapter extends MySQLAdapter
{
  private static $_instance = null;

  protected function __construct()
  {
    parent::__construct(new MatrixDb());
  }
  
  /**
   * Returns the instance of this adapter
   *
   * @return MatrixAdapter
   */
  public static function getInstance()
  {
    if (null === self::$_instance)
    {
      self::$_instance = new self();
    }
    
    return self::$_instance;
  }
}