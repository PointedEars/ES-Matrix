<?php

$encoding = mb_detect_encoding(file_get_contents(__FILE__));
header("Content-Type: text/html" . ($encoding ? "; charset=$encoding" : ""));

$modi = max(array(
  @filemtime(__FILE__),
//   @filemtime('es-matrix.inc.php'),
  @filemtime('style.css'),
  @filemtime('table.js')
));

header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $modi) . ' GMT');

/* Cached resource expires in HTTP/1.1 caches 24h after last retrieval */
header('Cache-Control: max-age=86400, s-maxage=86400, must-revalidate, proxy-revalidate');

/* Cached resource expires in HTTP/1.0 caches 24h after last retrieval */
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');

// require_once 'lib/Application.php';
// $application = Application::getInstance();
// $application->setDefaultDatabase('es-matrix')
require_once 'application/controllers/IndexController.php';
new IndexController();