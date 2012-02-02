<?php

/**
* Abstract model class
*
* Provides basic setters and getters for protected/private properties
* and a constructor to initialize properties using setters and getters.
*
* @author Thomas Lahn
*/
abstract class Model extends AbstractModel
{
  /* ORM */
  const persistentPrimaryKey = 'id';
  
  /**
   * @var Adapter
   */
  protected static $persistentAdapter;
  
  /**
   * Creates a new model object
   *
   * @param array $data     Initialization data (optional)
   * @param array $mapping  Mapping for initialization data (optional)
   */
  public function __construct(array $data = null, array $mapping = null)
  {
    $this->setAdapter();
        
    parent::__construct($data, $mapping);
  }
      
  /**
   * Finds the record for the model object in a database, and fills the object
   * with missing data
   * @see Adapter::find(Model)
   */
  public function find()
  {
    $class = get_class($this);
    return $class::$persistentAdapter->find($this);
  }
}
