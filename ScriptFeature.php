<?php

require_once 'includes/features.class.php';

/**
 * Returns an (X)HTML test link
 *
 * @param string $sCode
 * @param string $sContent
 * @return string
 */
function getTestLink($sCode = '', $sContent = '')
{
  return '<a href="javascript:' . rawurlencode($sCode . ' void 0') . '"
              onclick="' . htmlentities($sCode . '; return false') . '"
              ><code>' . $sContent . '</code></a>';
}

/**
 * A script language feature
 */
class ScriptFeature extends Feature
{
  /**
   * The implementation versions by which a featureis supported
   *
   * @var Array
   */
  protected $versions = array(
    'javascript'   => '-',
    'jscript'      => '-',
    'ecmascript'   => '-',
    'opera'        => '-'
  );

  /**
   * Returns a syntax-highlighted version of the passed string.
   * (Currently unused in the Matrixes in favor of client-side
   * highlighting which allows a smaller document size.)
   *
   * @param string $s
   * @return string
   */
  protected static function shl($s)
  {
    static $replaced = false;
    static $map = array(
      /* keywords */
      array(
        array(
          'abstract', 'boolean', 'byte', 'char', 'class', 'const', 'decimal',
          'delete', 'do', 'while', 'double', 'enum', 'expando', 'final',
          'float', 'for', 'each', '(?<!<)var(?!>)', 'in', 'function', 'get',
          'set', 'hide', 'import', 'instanceof', 'int', 'interface', 'internal',
          'long', 'override', 'package', 'private', 'protected', 'public',
          'sbyte', 'short', 'switch', 'case', 'break', 'default', 'throw',
          'try', 'catch', 'finally', 'if'),
        '<span class="rswd">\\1</span>'),
        
      /* operators */
      array(
        '/(!?==?)/',
        '<span class="punct">\\1</span>'));
        
    if (!$replaced)
    {
      foreach ($map[0][0] as $key => $value)
      {
        $map[0][0][$key] = '/\b(' . $value . ')\b/';
      }
        
      $replaced = true;
    }
        
    array_shift($s);
    
    $s[1] = preg_replace_group($map, $s[1]);
    
    // print_r($s);
    
    return implode('', $s);
  }
  
  protected function getGeneric($ver)
  {
    if (is_array($ver))
    {
      return isset($ver['generic']) && $ver['generic']
              ? '<sup><abbr title="Generic feature"><a href="#fn-generic" class="footnote-ref">G</a></abbr></sup>'
              : '';
    }
    else
    {
      return '';
    }
  }
  
  public function printMe()
  {
    ?>
<tr<?php echo $this->getSafeStr(); ?>>
          <th<?php echo $this->getTitleStr(); ?>><?php
            echo $this->getAnchors();
            echo /*preg_replace_callback(
              '#(<code>)(.+?)(</code>)#',
              array('self', 'shl'),*/
              preg_replace('/&hellip;/', '&#8230;', $this->content)/*)*/;
            ?></th>
<?php
    $versions = $this->versions;
    if (!is_null($this->list))
    {
      $versions =& $this->list->versions;
    }

    static $row = 0;
    $row++;
    
    $column = 0;
    $thisVersions =& $this->versions;
    
    foreach ($versions as $key => $value)
    {
      $column++;
      $id = "td$row-$column";
      $ver = isset($thisVersions[$key]) ? $thisVersions[$key] : '';
?>
          <td id="<?php echo $id; ?>"<?php
            echo $this->getAssumed($ver) . $this->getTested($ver);
            if (!$key)
            {
              if (!empty($ver))
              {
                echo ' title="Test code: '
                  . htmlspecialchars(
                      preg_replace('/\\\(["\'])/', '\1',
                        preg_replace('/\s{2,}/', ' ', $ver)
                      )
                    )
                  . '"';
              }
              else
            {
                echo ' title="Not applicable: No automated test case'
                  . ' is available for this feature.  If possible, please'
                  . ' click the feature code in the first column to run'
                  . ' a manual test."';
              }
            }
            ?>><?php
            if ($key)
            {
              echo $this->getVer($ver) . $this->getGeneric($ver);
            }
            else
          {
              if (!empty($ver))
              {
                ?><script type="text/javascript">
  // <![CDATA[
  var s = test(<?php echo $ver; ?>, '<span title="Supported">+<\/span>',
    '<span title="Not supported">&#8722;<\/span>');
  tryThis("document.write(s);",
          "document.getElementById('<?php echo $id; ?>').appendChild("
          + "document.createTextNode(s));");
  // ]]>
</script><?php
              }
              else
              {
                echo '<abbr>N/A</abbr>';
              }
            }
            ?></td>
<?php
    }
?>
        </tr>
<?php
  }
}