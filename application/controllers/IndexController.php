<?php

require_once 'lib/Controller.php';

require_once 'application/views/IndexView.php';
require_once 'application/models/mappers/FeatureMapper.php';
require_once 'application/models/mappers/TestcaseMapper.php';
require_once 'application/models/mappers/ImplementationMapper.php';
require_once 'application/models/mappers/ResultMapper.php';

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
    $implementations = ImplementationMapper::getInstance()->fetchAll();

    /* DEBUG */
//     debug($implementations);
        
    $features = FeatureMapper::getInstance()->fetchAll();
    usort($features, array('FeatureModel', 'compareTo'));

    $this->assign('edit', isset($_SESSION['edit']));
    $this->assign('implementations', $implementations);
    $this->assign('features', $features);
    $this->render(null, 'application/layouts/index/index.phtml');
  }
  
  protected function importAction()
  {
    require_once 'es-matrix.inc.php';
    FeatureMapper::getInstance()->importAll($features);
//     TestcaseMapper::getInstance()->importAll($features);
    $this->indexAction();
  }
  
  protected function editAction()
  {
    $_SESSION['edit'] = true;
    Application::redirect();
  }

  protected function endEditAction()
  {
    unset($_SESSION['edit']);
    Application::redirect();
  }
  
  protected function saveResultAction()
  {
    if (ResultMapper::getInstance()->save(array(
          'implementation' => Application::getParam('implementation', $_POST),
          'version'        => Application::getParam('version', $_POST),
          'user_agent'     => Application::getParam('HTTP_USER_AGENT', $_SERVER),
          'results'        => Application::getParam('results', $_POST)
        )))
    {
      Application::redirect();
    }
  }
}
