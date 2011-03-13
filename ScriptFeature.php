<?php

require_once 'includes/features.class.php';
require_once 'includes/footnotes.class.php';

$footnotes = new FootnoteList('[', ']', true);

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
    global $footnotes;
    
    if (is_array($ver))
    {
      return isset($ver['generic']) && $ver['generic']
        ? $footnotes->add('generic', '<abbr title="Generic feature">G</abbr>',
            'This method is intentionally specified or implemented as <em>generic</em>;
            it does not require that its <code class="rswd">this</code>
            value be an object of the same type. Therefore, it can be
            transferred to other kinds of objects for use as a method.')
        : '';
    }
    else
    {
      return '';
    }
  }

  protected function getVer($vInfo)
  {
    return parent::getVer($vInfo) . $this->getGeneric($vInfo);
  }
}

?>