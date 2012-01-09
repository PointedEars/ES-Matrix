<?php

require_once 'lib/Controller.php';

require_once 'views/IndexView.php';
require_once 'models/mappers/FeatureMapper.php';

require_once 'es-matrix.inc.php';

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
    $this->render(null, 'layouts/index/index.phtml');
  }
  
  protected function importAction()
  {
    global $features;
    $features = FeatureMapper::saveAll($features);
    $this->indexAction();
  }
}
