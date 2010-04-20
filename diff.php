<?php

/* DEBUG */
// phpinfo();

define('TYPE_CHANGELOG', 'changelog');
define('FORMAT_TEXT', 'text');

$cmd = 'svn diff';
$opts = '-r PREV -x --ignore-eol-style --no-diff-deleted';
$target = '.';
$subtitle = 'Differences to previous revision';
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
$format = isset($_REQUEST['format']) ? $_REQUEST['format'] : '';

if ($type === TYPE_CHANGELOG)
{
  $cmd = 'svn log';
  $opts = '-v';
	$subtitle = 'Change log';
}

if ($format === FORMAT_TEXT)
{
  header('Content-Type: text/plain; charset=UTF-8');
  passthru("$cmd $opts $target");
}
else
{
  header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
  <head>
    <!--meta http-equiv="Content-Style-Type" content="text/css"-->
    
    <title>ECMAScript Support Matrix: <?php echo $subtitle; ?></title>

    <meta name="DCTERMS.alternative" content="ES Matrix: diff">
    <meta name="DCTERMS.audience" content="Web developers">
    <meta name="DCTERMS.available" content="<?php
      echo gmdate('Y-m-d\TH:i:s+00:00', @filemtime(__FILE__));
      ?>">
    <meta name="DCTERMS.created" content="<?php
      echo gmdate('Y-m-d\TH:i:s+00:00');
      ?>">
    <meta name="DCTERMS.creator" content="Thomas 'PointedEars' Lahn &lt;<?php
      require_once '../../php/global.inc';
      echo randomEsc('js@PointedEars.de');
      ?>&gt;">
    
    <!--link rel="stylesheet" href="style.css" type="text/css"-->
  </head>
  
  <body>
    <h1><a name="top" id="top">ECMAScript Support Matrix</a></h1>
    <h2><?php echo $subtitle; ?>
    	(<a href="<?php
				echo $_SERVER['SCRIPT_URL'] . '?';
        if ($type === TYPE_CHANGELOG)
				{
          echo "type=$type&amp;";
        }
				?>format=<?php echo FORMAT_TEXT; ?>">plain text</a>)</h2>
    <pre><?php
      exec("$cmd $opts $target | sed 's/&/&amp;/g; s/</\&lt;/g'", $output);
      echo join("\n", $output);
      ?></pre>
  </body>
</html>
<?php
}
?>