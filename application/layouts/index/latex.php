<?php

function latexSpecialChars( $string )
{
  $map = array(
//       '  ' => "\\~\\~",
      '\"'  => "\\dq{}",
      "#"  =>"\\#",
      "$"  =>"\\$",
      "%"  =>"\\%",
      "&"  =>"\\&",
      "~"  =>"\\~{}",
      "_"  =>"\\_",
      "^"  =>"\\^{}",
      "\\" =>"\\textbackslash{}",
      "{"  =>"\\{",
      "}"  =>"\\}",
  );
  return preg_replace( "/([\"\^\%~\\\\#\$%&_\{\}])/e", "\$map['$1']", $string );
}

function latexCodeEscape($s)
{
  return preg_replace(
      array('/<var[^>]*>/', '|</var>|', '/π/'),
      array('\\var{', '}', '$\\pi$'),
      latexSpecialChars(strip_tags($s, '<var>,</var>')));
}
