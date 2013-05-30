<?php

class ImplementationTable extends \PointedEars\PHPX\Db\Table
{
  protected static $_name = 'implementation';

  /**
   * Retrieves all rows from the table in sort order.
   *
   * @return array
   * @see Database::select()
   * @overrides Table::fetchAll()
   */
  public function fetchAll($fetch_style = null, $column_index = null, array $ctor_args = null)
  {
    return parent::select(null, null, 'ORDER BY sortorder');
  }
}
