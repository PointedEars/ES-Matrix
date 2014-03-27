<?php

require_once 'views/IndexView.php';
require_once 'models/ImplementationModel.php';
require_once 'models/mappers/ImplementationMapper.php';
require_once 'models/mappers/VersionMapper.php';

use \PointedEars\PHPX\Application;

/**
 * A controller for handling the implementations listed in the
 * ECMAScript Support Matrix
 *
 * @author Thomas Lahn
 */
class ImplementationController extends \PointedEars\PHPX\Controller
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
    $mapper = ImplementationMapper::getInstance();

    if (is_null($impl))
    {
      $id = Application::getParam('id');
      $impl = $mapper->find($id);
    }

    $all_impls = $mapper->fetchAll();
    $all_versions = VersionMapper::getInstance()->fetchAll();

    $this->assign('implementation', $impl);
    $this->assign('implementations', $all_impls);
    $this->assign('all_versions', $all_versions);
    $this->render(null, 'layouts/implementation/edit.phtml');
  }

  /**
   * Saves a feature
   */
  protected function saveAction()
  {
    /* DEBUG */
//     var_dump($_POST);

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
    			'assigned'    => Application::getParam('assigned', $_POST),
    			'available'   => Application::getParam('available', $_POST),
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