<?php

require_once 'lib/Controller.php';

require_once 'application/views/IndexView.php';
require_once 'application/models/FeatureModel.php';
require_once 'application/models/mappers/FeatureMapper.php';

/**
 * A controller for handling the feature view of the ECMAScript Support Matrix
 *
 * @author Thomas Lahn
 */
class FeatureController extends Controller
{
  /**
   * Creates a new controller for the feature view
   */
  public function __construct()
  {
    parent::__construct('IndexView');
  }
  
  protected function indexAction()
  {
    Application::redirect();
  }
  
  protected function newAction()
  {
    $feature = new FeatureModel();
    $this->editAction($feature);
  }
  
  /**
   * Edit the feature specified by one of two parameters
   *
   * @param FeatureModel $feature
   *   {@link FeatureModel} to use. The default is the feature specified
   *   by the <code>id</code> request parameter.
   */
  protected function editAction(FeatureModel $feature = null)
  {
    if (is_null($feature))
    {
      $id = Application::getParam('id');
      $feature = FeatureMapper::getInstance()->find($id);
    }
    
    if (!is_array($feature->testcases) || count($feature->testcases) === 0)
    {
      $feature->testcases = array(new TestcaseModel());
    }
    
    $this->assign('feature', $feature);
    $this->render(null, 'application/layouts/feature/edit.phtml');
  }
  
  /**
   * Saves a feature
   */
  protected function saveAction()
  {
    if (Application::getParam('cancel', $_POST))
    {
      $this->indexAction();
      return;
    }

    if (FeatureMapper::getInstance()->save(array(
         	'id'    => Application::getParam('id', $_POST),
         	'code'  => Application::getParam('code', $_POST),
    			'title' => Application::getParam('title', $_POST),
//            	'testcases' => Application::getParam('testcase[]', $_POST)
       )))
    {
       $this->indexAction();
    }
  }
  
  /*
   * Deletes a feature
   */
  protected function deleteAction()
  {
    if (FeatureMapper::getInstance()->delete(Application::getParam('id', $_POST)))
    {
      $this->indexAction();
    }
  }
}