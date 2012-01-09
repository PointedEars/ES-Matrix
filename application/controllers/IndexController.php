<?php

require_once 'lib/Controller.php';

require_once 'application/views/IndexView.php';
require_once 'application/models/mappers/FeatureMapper.php';

/**
 * A controller for handling the default view of the ECMAScript Support Matrix
 *
 * @author Thomas Lahn
 */
class IndexController extends Controller
{
  /**
   * Creates a new controller for the index view
   */
  public function __construct()
  {
    parent::__construct('IndexView');
  }
  
  protected function indexAction()
  {
    $features = FeatureMapper::fetchAll();
    $this->assign('features', $features);
    $this->render(null, 'application/layouts/index/index.phtml');
  }
  
  protected function importAction()
  {
    require_once 'es-matrix.inc.php';
//     function mapper($a)
//     {
//       return strlen(trim($a->content));
//     }
//     var_dump(max(array_map('mapper', $features->items)));
    $features = FeatureMapper::saveAll($features);
    $this->indexAction();
  }
}
