<?php

require_once 'lib/Db/Table.php';

class ImplementationTable extends Table
{
  protected $_name = 'implementation';
  
  /**
   * Retrieves all rows from the table in sort order.
   *
   * @return array
   * @see Database::select()
   * @overrides Table::fetchAll()
   */
  public function fetchAll($fetch_style = null, $column_index = null, array $ctor_args = null)
  {
    return $this->_database->select($this->_name, null, null, 'sortorder');
  }
}
