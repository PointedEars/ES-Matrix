<?php

require_once '../lib/footnotes.class.php';

require_once 'views/IndexView.php';
require_once 'models/mappers/FeatureMapper.php';
// require_once 'models/mappers/TestcaseMapper.php';
require_once 'models/mappers/ImplementationMapper.php';
require_once 'models/mappers/ResultMapper.php';
require_once 'models/mappers/EnvironmentMapper.php';

use \PointedEars\PHPX\Application;

/**
 * A controller for handling the default view of the ECMAScript Support Matrix
 *
 * @author Thomas Lahn
 */
class IndexController extends \PointedEars\PHPX\Controller
{
  /**
   * Creates a new controller for the index view
   */
  public function __construct()
  {
    parent::__construct('IndexView');
  }

  protected function indexAction ($template = null, $content = null)
  {
    $implementations = ImplementationMapper::getInstance()->fetchAll();

    /* DEBUG */
    if (defined('DEBUG') && DEBUG > 0)
    {
      debug($implementations);
    }

    $features = FeatureMapper::getInstance()->fetchAll();

    $results = ResultMapper::getInstance()->getResultArray($features, $implementations);

    $environments = EnvironmentMapper::getInstance()->fetchAllPerImplementation();

    $this->assign('edit', isset($_SESSION['edit']));
    $this->assign('test', (bool) Application::getParam('test'));
    $this->assign('message', Application::getParam('message'), true);

    $this->assign('implementations', $implementations);
    $this->assign('features', $features);
    $this->assign('results', $results);
    $this->assign('environments', $environments);
    $this->assign('footnotes', new FootnoteList('[', ']', true));

    if (is_null($template))
    {
      $this->render(null, 'layouts/index/index.phtml');
    }
    else
    {
      $this->render($template, $content);
    }
  }

  protected function indexLatexAction ()
  {
    $this->indexAction(
      'layouts/text.phtml',
      'layouts/index/index-latex.phtml');
  }

  protected function testcasesLatexAction ()
  {
    $features = FeatureMapper::getInstance()->fetchAll();

    $this->assign('features', $features);

    $this->render(
        'layouts/text.phtml',
        'layouts/index/testcases-latex.phtml');
  }

  protected function resultsLatexAction ()
  {
    $this->indexAction(
        'layouts/text.phtml',
        'layouts/index/results-latex.phtml');
  }

  protected function importAction ()
  {
    require_once 'es-matrix.inc.php';
//     FeatureMapper::getInstance()->importAll($features);
//     TestcaseMapper::getInstance()->importAll($features);
    $this->indexAction();
  }

  protected function editAction ()
  {
    $_SESSION['edit'] = true;
    Application::redirect();
  }

  protected function endEditAction ()
  {
    unset($_SESSION['edit']);
    Application::redirect();
  }

  protected function runTestsAction ()
  {
    Application::redirect('test=1#features-table');
  }

  protected function saveResultsAction ()
  {
    $message = 'success';

    try
    {
      if (!ResultMapper::getInstance()->save(array(
          'implementation' => Application::getParam('implementation', $_POST),
          'version'        => Application::getParam('version', $_POST),
          'user_agent'     => Application::getParam('HTTP_USER_AGENT', $_SERVER),
          'results'        => Application::getParam('results', $_POST)
        )))
      {
        /* Results not saved, other error */
        $message = 'database_error';
      }
    }
    catch (EnvironmentTestedException $e)
    {
      /* Results not saved, environment already tested */
      $message = 'tested';
    }

    Application::redirect($message ? "message=$message" : '');
  }
}
