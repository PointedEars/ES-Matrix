<?php

/* @section Helper functions */

/**
 * Retrieves the value of an element of an associative array.
 *
 * This is designed for $_GET and other HTTP variables but
 * also works for common associative arrays.
 *
 * @param $key: string
 *   Key identifier.  The default is the empty string.
 * @param $array: string
 *   Array identifier.  The default is '_GET'.  If there is
 *   no such array, the identifier is prefixed with 'HTTP'
 *   and suffixed with '_VARS' (to support the deprecated
 *   HTTP_GET_VARS etc. arrays as of PHP &lt; 4.1).  If
 *   there is still no array with that identifier, return
 *   the empty string.
 * @param $default: string
 *   Default return value if the element specified with
 *   $key is not available in the array.  The default
 *   is the empty string.
 * @return
 *   The value of the element of that array with that key or
 *   the empty string if there is no such element or array.
 * @author
 *  Copyright (C) 2004, 2005  Thomas Lahn &lt;php@PointedEars.de&gt;
 */
function getVars($key = '', $array = '_GET', $default = '', $noEntities = false)
{
  global ${$array};
  if (!isset(${'HTTP'.$array.'_VARS'})) global ${'HTTP'.$array.'_VARS'};
/*
  echo "<pre>getVars: \$$array"."['$key']: return '"
    .(isset(${$array}) && isset(${$array}[$key])
    ? ${$array}[$key]
    : (isset(${'HTTP'.$array.'_VARS'}) && isset(${'HTTP'.$array.'_VARS'}[$key])
       ? ${'HTTP'.$array.'_VARS'}[$key]
       : $default)) . "'</pre><br>\n";
*/
  $result = (isset(${$array}) && isset(${$array}[$key])
    ? ${$array}[$key]
    : (isset(${'HTTP'.$array.'_VARS'}) && isset(${'HTTP'.$array.'_VARS'}[$key])
       ? ${'HTTP'.$array.'_VARS'}[$key]
       : $default));

// TODO: Escape HTML entities
/*
  if (!$noEntities)
  {
    $result = htmlentities($result);
  }
*/
  return $result;
}

/**
 * Converts the argument to a visible (X)HTML hyperlink
 * where its URI target is created from the argument.
 * Supported are e-mail addresses, domain names with
 * optional paths, and valid URIs.
 *
 * @param $text
 *   Argument to be converted.
 * @return
 *   The converted argument if it applies to a supported
 *   scheme, the unconverted argument otherwise.
 *
 * @author (C) 2001-04-04T02:03
 *   mark.young@vdhinc.com at http://php.net/manual/en/ref.strings.php
 *
 * Minor correction to my HTMLEncode function.
 *
 * @author 2002-08-29T09:00
 *   Thomas Lahn &lt;PointedEars@selfhtml.de&gt; at localhost
 *
 * - Added target="_blank"
 * - Added support for ftp(s)-URIs: (ht|f)
 * - Added support for search strings (?...=...&...=...), either
 *   with or without HTML entities: \?=(&\w;|&)
 * - Removed enclosing nl2br call because of preformatted display
 *
 * @author 2003-12-30T14:18
 *   Thomas Lahn &lt;PointedEars@selfhtml.de&gt; at localhost
 *
 * - Removed target="_blank".
 * - Added PHPdoc.
 *
 * @author 2004-01-12T12:45
 *   Thomas Lahn &lt;PointedEars@selfhtml.de&gt; at localhost
 *
 * - Added support for #fragment_identifiers in URIs.
 * - Added support for bugs and comments.
 *
 * @author 2004-01-13T01:29
 *   Thomas Lahn &lt;PointedEars@selfhtml.de&gt; at localhost
 *
 * - Added support for bug aliases.
 *
 * @author 2004-01-26T20:43
 *   Thomas Lahn &lt;PointedEars@selfhtml.de&gt; at localhost
 *
 * - Do not convert URIs in A elements.
 * - Do not allow URIs with "&" before search-string.
 * - camelCased function identifier.  Only classes
 *   and constructors should start with uppercase.
 *
 * @author 2004-01-27T14:07
 *   Thomas Lahn &lt;PointedEars@selfhtml.de&gt; at localhost
 *
 * - Allow to convert URIs preceded by "&gt;" but not followed by "&lt;/a&gt;".
 * - Allow ";" to be part of the search string
 *
 * @author 2004-01-29T14:10
 *   Thomas Lahn &lt;PointedEars@selfhtml.de&gt; at localhost
 *
 * - Require valid domain name for "bar" on conversion of "foo@bar" and
 *   "www.bar".
 * - Be case-insensitive except of bug aliases
 * - Escaped "-" in character classes if not meant as range metacharacter.
 * - Corrected year.
 *
 * @author 2004-02-14T17:37
 *   Thomas Lahn &lt;PointedEars@selfhtml.de&gt; at localhost
 *
 * - Accept only valid Internet domain names
 * - Accept "%" within path and query part (to escape ASCII characters)
 *
 * @author 2004-02-27T19:21
 *   Thomas Lahn &lt;PointedEars@selfhtml.de&gt; at localhost
 *
 * - Allow unescaped ":" in URI components, since it apparently does not
 *   "conflict with the reserved purpose" (RFC 2396, section 2.2.; here:
 *   scheme component)
 * - Allow slashes, dots and dashes in URI components
 * - Removed invalid [...(...|...)...]
 *
 * @author 2004-03-01T21:48
 *   Thomas Lahn &lt;PointedEars@selfhtml.de&gt; at localhost
 *
 * - Allow IPv4 addresses
 *
 * @author 2004-03-08T02:20
 *   Thomas Lahn &lt;PointedEars@selfhtml.de&gt; at localhost
 *
 * - Allow "+" and "," in query part
 * - Optimized character classes
 *
 * @author (C) 2004-04-23T10:03
 *   Thomas Lahn &lt;PointedEars@selfhtml.de&gt; at localhost
 *
 * - Rewrite to use RFC 2822 and 2369 syntax
 */
function htmlEncode($text)
{
  // see RFC 2822 "Internet Message Format"
  $local_part    = '[^()<>@,;:\\"\-\[\] \x00-\x1A\x7F]+';
    
  // see RFC 2396 "Uniform Resource Identifiers (URI): Generic Syntax"
  // $digit      = '\d';          // 0-9; def. not required
  // $hex        = '\da-f';     // "hex" for case-insensitive match; def. N/R
  $alpha         = 'a-z';         // "alpha" for case-insensitive match
  $alphanum      = $alpha.'\d';   // "alphanum" for case-insensitive match
  $mark          = "\-_.!~*\'()";
  $reserved      = ';/?:@&=+$,';
  $unreserved    = $alphanum.$mark;
  $escaped       = '%[\da-f]';    // contains $hex
    
  // added (?!gt;) to allow "&lt;URI&gt;"
  $uric          = '(['.$reserved.$alphanum.$mark.'](?!gt;)|'.$escaped.')';
  $uric_no_slash = '(['.$unreserved.';\?:@&=+$,](?!gt;)|'.$escaped.')';
  $pchar         = '(['.$unreserved.':@&=+$,](?!gt;)|'.$escaped.')';
  $param         = $pchar;
  $segment       = $pchar.'*(;'.$param.')*';
  $abs_path      = '/' . $segment . '(/'.$segment.')*';
  $userinfo      = '(['.$unreserved.';:&=+$,](?!gt;)|'.$escaped.')*';
  $domainlabel   = '(['.$alphanum.']'
                   . '|['.$alphanum.'](['.$alphanum.']|-)*['.$alphanum.']'
                   . ')';
  $toplabel      = '(['.$alpha.']'
                   . '|['.$alpha.'](['.$alphanum.']|-)*['.$alphanum. '])';
  $hostname      = '('.$domainlabel. '\.)*' . $toplabel . '\.?';
  $ipv4_address  = '\d+\.\d+\.\d+\.\d+';
  $host          = '(' . $hostname . '|' . $ipv4_address . ')';
  $port          = '\d*';
  $hostport      = $host . '(:' . $port . ')?';
  $server_req    = '(' . $userinfo . ')?' . $hostport; // server is required
  $reg_name      = '([' . $unreserved . '$,;:@&=+](?!gt;)|' . $escaped . ')+';
  $authority     = '(' . $server_req . '|' . $reg_name . ')';
  $net_path      = '//' . $authority . '('.$abs_path.')?';
  $query         = $uric.'*';
  $scheme        = '(ht|f)tps?';
  $hier_part     = '(' . $net_path  .'|' . $abs_path . ')(\?' . $query . ')?';
  $opaque_part   = $uric_no_slash . $uric.'*';
  $absolute_uri  = $scheme . ':(' . $hier_part . '|' . $opaque_part . ')';
  $fragment      = $uric.'*';
  
  // absolute URIs only
  $uri_reference = $absolute_uri . '(#' . $fragment . ')?';
  // echo '<br>'.htmlentities($local_part . '@' . $host).'<br>';

  $searcharray = array(
    "'(?i)(" . $local_part . '@' . $host . ")'i",
    "'(?i)((?:(?!://).{3}|^.{0,2}))(www\." . $hostname
      . '|' . $ipv4_address . ")'i",
    "'(?i)(?<!href=\")(" . $uri_reference . ")(?!</a>)'i",
    "'(((?i)bug)\s+#?([\dA-Z_]+)\s+((?i)comment|Kommentar)\s+#?(\d+))'",
    "'(((?i)bug)\s+#?([\dA-Z_]+))'",
    "'(((?i)comment|Kommentar)\s+#?(\d+))'"
  );

  $replacearray = array(
    "<a href=\"mailto:\\1\">\\1</a>",
    "\\1http://\\2",
    "<a href=\"\\1\">\\1</a>",
    "<a href=\"./?bug=\\3#c\\5\">\\1</a>",
    "<a href=\"./?bug=\\3#details\">\\1</a>",
    "<a href=\"#c\\3\">\\1</a>"
  );
  
  return preg_replace($searcharray, $replacearray, $text);
}

/**
 * Converts HTML entities to real characters using the detected
 * or specified character encoding.
 *
 * @param string $s
 * @param int[optional] $quote_style
 * @return string
 */
function htmlEntityDecode($s, $quote_style=ENT_COMPAT, $encoding=null)
{
  $s = (string) $s;
  
  if (is_null($encoding))
  {
    $encoding = mb_detect_encoding($s);
    if ($encoding === 'ASCII')
    {
      $encoding = 'ISO-8859-1';
    }
  }
  
  return html_entity_decode($s, $quote_style, $encoding);
}


/**
 * Converts the argument into a visible (X)HTML hyperlink if a condition
 * applies.
 *
 * @author
 *   (C) 2003, 2004  Thomas Lahn &lt;selfhtml.de@PointedEars.de&gt;
 * @param $s
 *   Content to be converted.  Required.
 * @param $sCond
 *   Condition to be true for the content to be converted.
 *   The default is <code>true</code>.
 * @param $sURI
 *   Target URI of the hyperlink.  The default is the
 *   value of $s.
 * @param $sName
 *   Value of the <code>name</code> attribute of the
 *   <code>a</code> element.  Unused if not provided
 *   or empty.
 * @param $sTitle
 *   Value of the <code>title</code> attribute of the
 *   <code>a</code> element.  Unused if not provided
 *   or empty.
 * @param $sClass
 *   Value of the <code>class</code> attribute of the
 *   <code>a</code> element.  Unused if not provided
 *   or empty.
 * @return
 *   The converted argument if the condition applies,
 *   the unconverted argument otherwise.
 */
function makeLinkIf(
  $s,
  $sCond = true,
  $sURI = NULL,
  $sTarget = '',
  $sName = '',
  $sTitle = '',
  $sClass = '')
{
  return ($sCond || $sName
          ? '<a' . ($sCond
                    ? " href=\"" . (is_null($sURI) ? $s : $sURI)
                      . "\"".($sTarget ? " target=\"$sTarget\"" : '')
                    : ''
                   )
            . ($sName  ? " name=\"$sName\""   : '')
            . ($sTitle ? " title=\"$sTitle\"" : '')
            . ($sClass ? " class=\"$sClass\"" : '')
            . '>'
          : ''
         )
         . $s
         . ($sCond || $sName ? '</a>' : '');
}

/**
 * Returns a visible (X)HTML hyperlink that uses the mailto: URI scheme.
 *
 * @author (C) 2003  Thomas Lahn &lt;selfhtml.de@PointedEars.de&gt;
 *
 * @author (C) 2003-12-30  Thomas Lahn &lt;selfhtml.de@PointedEars.de&gt;
 * - Corrected `$email ($name)'.
 * - Now uses rawurlencode(...).
 * - Added PHPdoc.
 *
 * @author (C) 2004-11-30  Thomas Lahn &lt;selfhtml.de@PointedEars.de&gt;
 * - Don't rawurlencode(...) parens for comments.
 *
 * @param $sAddress
 *   E-mail address.  The default is <selfhtml.de@PointedEars.de>.
 * @param $sTitle
 *   Value of the <code>title</code> attribute of the
 *   <code>a</code> element.  Unused if not provided
 *   or empty.  The default is 'PointedEars'.
 * @param $sToName
 *   Name to be used in the To header of the e-mail.
 *   Note that @link{rawurlencode()} is used to escape
 *   special characters automatically.
 *   The default is "Thomas 'PointedEars' Lahn".
 *
 * @return
 *   The converted argument if the condition applies,
 *   the unconverted argument otherwise.
 */
function mailto_link(
  $sAddress = 'selfhtml.de@PointedEars.de',
  $sTitle = 'PointedEars',
  $sToName = "Thomas 'PointedEars' Lahn",
  $sSubject = 'SELFbug',
  $sImgPath = '../../media/mail.gif'
)
{
//width="14" height="15" // image size detection not yet implemented
  return ($sImgPath != ''
          ? '<img src="' . $sImgPath . '" border="0" alt="@">&nbsp;'
          : '')
    . '<a href="mailto:'
    . ($sAddress != ''
       ? $sAddress
       : 'selfhtml.de@PointedEars.de')
    . ($sToName != ''
       ? ' (' . rawurlencode($sToName) . ')'
       : '')
    . ($sSubject != ''
       ? '?subject=' . rawurlencode($sSubject)
       : '')
    . '">' . (($sTitle != '') ? $sTitle : $sAddress) . '</a>';
}

// map bug states to numbers so that they become comparable
function array_values_to_keys($a)
{
  $aNew = array();
  foreach ($a as $key => $value)
  {
    $aNew[$value] = count($aNew);
  }
  return $aNew;
}

/**
 * Maps an array to another array using a callback function.
 *
 * Unlike array_map(), the callback is called with three parameters: the value
 * to be processed, the key of that value, and the array processed.  The return
 * value of the callback defines the value for the same key of the returned
 * array.
 *
 * Because of the way the callback is called, this method supports processing
 * only one array at a time, unlike array_map().  Unlike array_walk(), this
 * function does not modify the original array.
 *
 * @param string|array $callback
 *   The callback to be used for mapping array values.  If an array, the first
 *   element of the array is supposed to be the class name, and the second
 *   element the method name of a static method to be used.
 * @param array $array
 *   The array to process
 * @return array
 * @see array_map()
 * @see array_walk()
 */
function array_map2($callback, $array)
{
  $a = array();
  
  if (is_array($callback))
  {
    list($class, $method) = $callback;
  }
  
  foreach ($array as $key => &$value)
  {
    if (is_array($callback))
    {
      $a[$key] = $class::$method($value, $key, $array);
    }
    else
    {
      $a[$key] = $callback($value, $key, $array);
    }
  }
  
  return $a;
}

/**
 * Converts a string or an array of strings to an associative
 * bitmask array with the string(s) as key(s).
 *
 * Converts the argument to a bitmask array where each member's
 * value is a power of 2, so that arbitrary member values can be
 * added to an integer on which bitwise operations with the member
 * value or a combination of member values are possible.
 *
 * @author (c) 2003 Thomas Lahn &lt;SELFbug@PointedEars.de&gt;
 * @param $aArray
 *   String or array of strings to be converted.
 */
function getBitmaskArray($aArray)
{
  $a = array();
  
  if (is_array($aArray))
  {
    for ($i = 0; $i < count($aArray); $i++)
    {
      $a[$aArray[$i]] = pow(2, $i);
    }
  }
  else
    $a[$aArray] = 1;
  
  return $a;
}

/**
 * Returns the contents of a file as if include() was used.
 *
 * @param string $filename Path of the file to retrieve
 * @return string File contents
 */
function get_include_content($filename)
{
  if (is_file($filename))
  {
    ob_start();
    include $filename;
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
  }
          
  return '';
}
        
/**
 * Replaces each group of expressions in a string with the same
 * corresponding string.
 *
 * @param Array[Array[string] | string, string] $map
 * @param string                                $subject
 * @return string
 *   A copy of $subject with the provided mapping applied.
 */
function preg_replace_group($map = array(), $subject = '')
{
  if ($subject)
  {
    for ($i = 0, $len = count($map); $i < $len; $i++)
    {
      $subject = preg_replace($map[$i][0], $map[$i][1], $subject);
    }
  }

  return $subject;
}

/**
 * Randomly encodes a string of characters.
 *
 * @param string $s
 *   String to be encoded
 * @param string $format = 'sgml'
 *   Encoding format.  Currently only SGML-based encoding of
 *   ASCII characters with character references is supported.
 * @return string
 */
function randomEsc($s = '', $format = 'sgml')
{
  $f = function_exists('mt_rand') ? 'mt_rand' : 'rand';
  
  return preg_replace_callback('/[\\x00-\\x7F]/',
    create_function('$m', "return $f(0, 1)" . '? $m[0] : "&#" . ord($m[0]) . ";";'),
    $s);
}

/**
 * Reduces sequences of two or more consecutive white-space characters
 * in an input to a single space.
 *
 * @param string $s
 * @return string
 */
function reduceWhitespace($s)
{
  return preg_replace('/\s{2,}/', ' ', $s);
}

function debug($x)
{
  echo '<pre>';
  
//   if (is_array($x))
//   {
//     print_r($x);
//   }
//   else
//   {
    var_dump($x);
//   }
  
  echo '</pre>';
}