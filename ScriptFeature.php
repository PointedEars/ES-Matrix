<?php

require_once '../../php/features.class.php';

class ScriptFeature extends Feature
{
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
      // keywords
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
        
      // operators
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
}