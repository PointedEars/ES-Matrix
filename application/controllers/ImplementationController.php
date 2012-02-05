<?php

require_once 'lib/Controller.php';

require_once 'application/views/IndexView.php';
require_once 'application/models/ImplementationModel.php';
require_once 'application/models/mappers/ImplementationMapper.php';

/**
 * A controller for handling the implementations listed in the
 * ECMAScript Support Matrix
 *
 * @author Thomas Lahn
 */
class ImplementationController extends Controller
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
  
  protected function addAction()
  {
    $impl = new ImplementationModel();
    $this->editAction($impl);
  }
  
  /**
   * Edit the feature specified by one of two parameters
   *
   * @param FeatureModel $feature
   *   {@link FeatureModel} to use. The default is the feature specified
   *   by the <code>id</code> request parameter.
   */
  protected function editAction(ImplementationModel $impl = null)
  {
    if (is_null($impl))
    {
      $id = Application::getParam('id');
      $impl = ImplementationMapper::getInstance()->find($id);
    }
    
    $this->assign('implementation', $impl);
    $this->render(null, 'application/layouts/implementation/edit.phtml');
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

    if (ImplementationMapper::getInstance()->save(array(
         	'id'          => Application::getParam('id', $_POST),
         	'sortorder'   => Application::getParam('sortorder', $_POST),
    			'name'        => Application::getParam('impl_name', $_POST),
    			'acronym'     => Application::getParam('acronym', $_POST),
       )))
    {
       $this->indexAction();
    }
  }
  
  /*
   * Deletes an implementation
   */
  protected function deleteAction()
  {
    if (ImplementationMapper::getInstance()->delete(Application::getParam('id', $_POST)))
    {
      $this->indexAction();
    }
  }
}