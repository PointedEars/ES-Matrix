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
  
  protected function addAction()
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
    $mapper = FeatureMapper::getInstance();
    $features = $mapper->fetchAll();
    
    if (is_null($feature))
    {
      $id = Application::getParam('id');
//       $feature = $mapper->find($id);
      $feature = $features[$id];
      /* ORM */
//       $feature = new FeatureModel(array('id' => Application::getParam('id')));
//       $feature->find();
    }
    
    $this->assign('feature', $feature);
    $this->assign('features', $features);
    $this->render(null, 'application/layouts/feature/edit.phtml');
  }
  
  /**
   * Saves a feature (metadata and/or testcases)
   */
  protected function saveAction()
  {
    /* DEBUG */
//     define('DEBUG', 2);
//     debug($_POST);
    
    if (Application::getParam('cancel', $_POST))
    {
      $this->indexAction();
      return;
    }
    
    $data = array(
      'id'          => Application::getParam('id', $_POST),
      'code'        => Application::getParam('code', $_POST),
      'title'       => Application::getParam('title', $_POST),
      'edition'     => Application::getParam('edition', $_POST),
      'section'     => Application::getParam('section', $_POST),
      'section_urn' => Application::getParam('section_urn', $_POST),
      'generic'     => Application::getParam('generic', $_POST),
      'versioned'   => Application::getParam('versioned', $_POST),
    );
    
    if (!Application::getParam('metadataOnly', $_POST))
    {
      $data['testcases'] = array(
        'titles'      => Application::getParam('testcase_title', $_POST),
        'codes'       => Application::getParam('testcase_code', $_POST),
        'quoteds'     => Application::getParam('testcase_quoted', $_POST),
        'alt_types'   => Application::getParam('testcase_alt_type', $_POST),
      );
    }
    
    if (null !== ($feature = FeatureMapper::getInstance()->save($data)))
    {
      $source_id = Application::getParam('source_id', $_POST);
      if (Application::getParam('copy', $_POST) && !empty($source_id))
      {
        /* TODO: Redirect to edit form after copy */
        TestcaseMapper::getInstance()->copy($source_id, $feature);
//         debug($feature);
        $this->editAction($feature);
      }
      else
      {
        Application::redirect('#feature' . $feature->id);
      }
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