<?php

require_once '../../php/features.class.php';

$features = new FeatureList(array(
  'versions' => array(
    'javascript' => '<a href="#javascript" title="Netscape/Mozilla.org JavaScript">JavaScript</a>',
    'jscript'    => '<a href="#jscript" title="Microsoft JScript">JScript</a>',
    'ecmascript' => '<a href="#ecmascript">ECMAScript</a>',
    ''           => <<<HTML
This <abbr title="implementation">impl.</abbr><sup><a
name="this-ua" href="#fn-this-ua">[1]</a></sup>
HTML
    ,
    'jsc'        => '<a href="#jscore">
      <abbr title="Apple WebKit JavaScriptCore">JSCore</abbr></a>',
    'opera'      => '<a href="#opera" title="Opera ECMAScript">Opera</a>',
    'kjs'        => '<a href="#kjs"><acronym title="Konqueror JavaScript">KJS</acronym></a>',
    //'as'         => '<a href="#actionscript">ActionScript</a>'
  ),

  'safeVersions' => array(
    'javascript' => 1.3,
    'jscript'    => '5.1.5010',
    'opera'      => '6.0'),

  'urns' => array(
    'mdc'     => 'https://developer.mozilla.org/en/',
    'js15ref' => 'mdc:Core_JavaScript_1.5_Reference:',
    'msdn'    => 'http://msdn.microsoft.com/en-us/library/',
    'es3'     => 'http://www.mozilla.org/js/language/E262-3.pdf'),

  'items' => array(
    new Feature(array(
      'anchors'    => array('!', 'opNotEqual'),
      'title'      => 'Strict Not Equal/Nonidentity operator',
      'content'    => '<code>!==</code>',
      'versions'   => array(
        'javascript' => array('1.3',
          'urn'    => 'js15ref:Operators:Comparison_Operators',
          'tested' => TRUE),
        'jscript'    => array('1.0',
          'urn' => 'msdn:ky6fyhws%28VS.85%29.aspx'),
        'ecmascript' => array(3,
          'urn' => 'es3:#page=74'),
        '' => '"1 !== \"1\""',
        'opera'      => array(5.02, 'tested' => TRUE),
        'jsc'        => array(525.19, 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE)
      )
    )),
    
    new Feature(array(
      'title'      => 'Unary plus (converts to Number)',
      'content'    => <<<EOD
              <a href="javascript:window.alert(+'042')"
                 onclick="window.alert(+'042'); return false"
                 ><code>+<var>expression</var></code></a>
EOD
      ,
      'versions' => array(
        '' => '"+\"42\" == 42"',
        'ecmascript' => 1,
        'javascript' => array('1.3',      'tested' => TRUE),
        'jscript'    => array('3.1.3510', 'tested' => TRUE),
        'jsc'        => array(525.19, 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera'      => array(5.02, 'tested' => TRUE),
      )
    )),
    
    new Feature(array(
      'title'      => 'RegExp literal with only optional global and case-insensitive modifier',
      'content'    => '<code>/<var>regularExpression</var>/</code>[<code>g</code>][<code>i</code>]',
      'versions'   => array(
        '' => '"/abc/gi.constructor == RegExp"',
        'javascript' => array('1.2',
          'urn'    => 'js15ref:Global_Objects:RegExp',
          'tested' => TRUE),
        'jscript'    => array('3.1.3510',
          'urn'    => 'msdn:jscript7/html/jsobjregexpression.asp',
          'tested' => TRUE),
        'ecmascript' => '-',
        'jsc'        => array(525.19, 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera' => array(5.02, 'tested' => TRUE),
      )
    )),
    
    new Feature(array(
      'title'      => 'RegExp literal with optional multiline modifier',
      'content'    => '<code>/<var>regularExpression</var>/</code>[<code>g</code>][<code>i</code>][<code>m</code>]',
      'versions'   => array(
        '' => '"/abc/gim.constructor == RegExp"',
        'javascript' => array('1.5', 'tested' => TRUE),
        'jscript'    => array('5.5.6330', 'tested' => TRUE),
        'ecmascript' => 3,
        'jsc'        => array(525.19, 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera' => array(5.02, 'tested' => TRUE),
      )
    )),
    
    new Feature(array(
      'title'      => 'Regular Expression with non-greedy matching',
      'content'    => '<code>/(<var>&hellip;</var>+?|<var>&hellip;</var>*?)/</code>',
      'versions'   => array(
        '' => '"aaa".match(/^aa*?/) == "a" && "aaa".match(/^aa+?/) == "aa"',
        'ecmascript' => 3,
        'javascript' => array(1.5, 'tested' => TRUE,
          'urn' => 'js15ref:Global_Objects:RegExp'),
        'jscript'    => array('5.5.6330', 'tested' => TRUE,
          'urn' => 'msdn:jscript7/html/jsobjregexpression.asp'),
        'jsc'        => array(525.19, 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera' => array(7.02, 'tested' => TRUE),
      )
    )),
    
    new Feature(array(
      'title'      => 'Regular Expression with non-capturing negative lookahead',
      'content'    => '<code>/(?!<var>&hellip;</var>)/</code>',
      'versions'   => array(
        '' => '"abac".match(/a(?!b)./) == "ac"',
        'ecmascript' => 3,
        'javascript' => array(1.5, 'tested' => TRUE,
          'urn'    => 'js15ref:Global_Objects:RegExp'),
        'jscript'    => array('5.5.6330',
          'urn' => 'msdn:jscript7/html/jsobjregexpression.asp',
          'tested' => TRUE),
        'jsc'        => array('525.27.1', 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera'   => array(7.02, 'tested' => TRUE),
      )
    )),
    
    new Feature(array(
      'title' => 'Regular Expression with non-capturing parentheses',
      'content' => '<code>/(?:<var>&hellip;</var>)/</code>',
      'versions' => array(
        '' => '"ab".match(/a(?:b)/) == "ab"',
        'ecmascript' => 3,
        'javascript' => array(1.5, 'tested' => TRUE,
          'urn' => 'js15ref:Global_Objects:RegExp'),
        'jscript' => array('5.5.6330',
          'urn' => 'msdn:jscript7/html/jsobjregexpression.asp',
          'tested' => TRUE),
        'jsc'     => array('525.27.1', 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera'   => array(7.02, 'tested' => TRUE),
      )
    )),
    
    new Feature(array(
      'title' => 'Regular Expression with non-capturing positive lookahead',
      'content' => '<code>/(?=<var>&hellip;</var>)/</code>',
      'versions' => array(
        '' => '"ab".match(/a(?=b)/) == "a"',
        'ecmascript' => 3,
        'javascript' => array(1.5, 'tested' => TRUE,
          'urn' => 'js15ref:Global_Objects:RegExp'),
        'jscript' => array('5.5.6330',
          'urn' => 'msdn:jscript7/html/jsobjregexpression.asp',
          'tested' => TRUE),
        'jsc'     => array('525.27.1', 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera'   => array(7.02, 'tested' => TRUE),
      )
    )),

    new Feature(array(
      'title' => 'Label',
      'content' => '<code><var>label</var>:</code>',
      'versions' => array(
        '' => '"foo: true"',
        'ecmascript' => 3,
        'javascript' => array(1.2,
          'urn' => 'js15ref:Statements:label'),
        'jscript' => array('3.1.3510',
          'urn'    => 'msdn:jscript7/html/jsstmlabeled.asp',
          'tested' => TRUE),
        'jsc'     => array('525.27.1', 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera'   => array(5.02, 'tested' => TRUE),
      )
    )),
    
    new Feature(array(
      'anchors'  => array('equals'),
      'title'    => 'Equals operator',
      'content'  => '<code>==</code>',
      'versions' => array(
        '' => '1 == "1"',
        'ecmascript' => 1,
        'javascript' => array('1.0',
          'urn' => '#equals',
          'tooltip' => '<span>
            (</span>deprecated since 1.4 <em>for comparison of two
            <code>JSObject</code> objects</em>; use the
            <code>JSObject<span class="punct">.</span>equals</code>
            method instead<span>)</span></span>',
          'assumed' => TRUE),
        'jscript'    => array('1.0', 'assumed' => TRUE),
        'jsc'        => array(525.13, 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera'      => array(5.02, 'tested' => TRUE)
      )
    )),
    
    new Feature(array(
      'title'    => 'Strict Equals/Identity operator',
      'content'  => '<code>===</code>',
      'versions' => array(
        '' => '!(1 === "1")',
        'ecmascript' => 3,
        'javascript' => '1.3',
        'jscript'    => '1.0',
        'jsc'        => '530.17',
        'kjs'        => '3.5.10',
        'opera'      => '9.52'
      )
    )),
        
    new Feature(array(
      'title' => 'Type declaration',
      'content' => <<<HTML
        <a href="javascript:tryThis('var foo: Object;', 'window.alert(e);')"
          onclick="return tryThis('var foo: Object; false', 'window.alert(e); false')"
          ><code><var>identifier</var> : <var>type</var></code></a>
HTML
      ,
      'versions' => array(
        'ecmascript' => 4,
        'javascript' => '2.0',
        'jscript' => '7.0',
        'jsc'     => '-',
        'kjs'     => '-',
        'opera'   => '-',
      )
    )),

    new Feature(array(
      'title' => 'Object initializer',
      'content' => '<code>{<var>name</var>:
            <var>value</var>, &hellip;}</code>',
      'versions' => array(
        '' => '{a: "b"}.a == "b"',
        'ecmascript' => 3,
        'javascript' => 1.3,
        'jscript'    => '3.0',
        'jsc'        => array('525.27.1', 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera'      => array(5.02, 'tested' => TRUE)
      )
    )),
            
    new Feature(array(
      'title' => 'Function expression',
      'content' => '<code>= function
            <var>identifier</var>(&hellip;) {&hellip;}</code>',
      'versions' => array(
        '' => '"(function foo() { return 42; })() == 42"',
        'ecmascript' => 1,
        'javascript' => 1.2,
        'jscript'    => '1.0',
        'jsc'        => array(525.13, 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera'      => array(5.02, 'tested' => TRUE)
      )
    )),

    new Feature(array(
      'title' => 'Anonymous function expression',
      'content' => '<code>= function(&hellip;) {&hellip;}</code>',
      'versions' => array(
        '' => '"(function() { return 42; })() == 42"',
        'ecmascript' => 3,
        'javascript' => '1.3*',
        'jscript'    => array('3.1.3510', 'tested' => TRUE),
        'jsc'        => array(525.13, 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera'      => array(5.02, 'tested' => TRUE)
      )
    )),
        
    new Feature(array(
      'title' => 'Function statement',
      'content' => '<code>if (<var>&hellip;</var>) { function f() { <var>&hellip;</var> }; }</code>',
      'versions' => array(
        '' => '"function f() {}; if (true) { function f() { return 42; }; } f() == 42"',
        'ecmascript' => '-',
        'javascript' => array(1.3, 'tested' => TRUE),
        'jscript' => array('3.1.3510', 'tested' => TRUE),
        'jsc' => array('525.27.1', 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera' => array(5.02, 'tested' => TRUE),
      )
    )),
    
    new Feature(array(
      'content' => '<code>Date.prototype.toDateString()</code>',
      'versions' => array(
        '' => 'jsx.object.isMethod(Date, "prototype", "toDateString")
               && "(new Date()).toDateString()"',
        'ecmascript' => 3,
        'javascript' => array(1.5),
        'jscript'    => array('tested' => '5.5.6330'),
        'jsc'        => array('tested' => 530.17),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => 5.02),
      )
    )),
    
    new Feature(array(
      'content' => '<code>Date.prototype.toGMTString()</code>',
      'versions' => array(
        '' => 'jsx.object.isMethod(Date, "prototype", "toGMTString")
               && "(new Date()).toGMTString()"',
        'ecmascript' => 1,
        'javascript' => array('tested' => 1.3),
        'jscript'    => array('tested' => '5.1.5010'),
        'jsc'        => array('tested' => 530.17),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => 5.02),
      )
    )),
        
    new Feature(array(
      'content' => '<code>Date.prototype.toLocaleDateString()</code>',
      'versions' => array(
        '' => 'jsx.object.isMethod(Date, "prototype", "toLocaleDateString")
               && "(new Date()).toLocaleDateString()"',
        'ecmascript' => 3,
        'javascript' => array(1.5),
        'jscript'    => array('tested' => '5.5.6330'),
        'jsc'        => array('tested' => 530.17),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => 5.02),
      )
    )),
    
    new Feature(array(
      'content' => '<code>Date.prototype.toLocaleFormat()</code>',
      'versions' => array(
        '' => 'jsx.object.isMethod(Date, "prototype", "toLocaleFormat")
               && "(new Date()).toLocaleFormat(\'%A, %B %e, %Y\')"',
        'ecmascript' => '-',
        'javascript' => array(1.6, 'tested' => 1.8),
        'jscript'    => '-',
        'jsc'        => '-',
        'kjs'        => '-',
        'opera'      => '-'
      )
    )),
        
    new Feature(array(
      'content' => '<code>Date.prototype.toLocaleString()</code>',
      'versions' => array(
        '' => 'jsx.object.isMethod(Date, "prototype", "toLocaleString")
               && "(new Date()).toLocaleString()"',
        'ecmascript' => 1,
        'javascript' => array('tested' => 1.3),
        'jscript'    => array('5.1.5010', 'tested' => TRUE),
        'jsc'        => array('525.13', 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera'      => array(5.02, 'tested' => TRUE)
      )
    )),
    
    new Feature(array(
      'content' => '<code>Date.prototype.toLocaleTimeString()</code>',
      'versions' => array(
        '' => 'jsx.object.isMethod(Date, "prototype", "toLocaleTimeString")
               && "(new Date()).toLocaleTimeString()"',
        'ecmascript' => 3,
        'javascript' => array(1.5),
        'jscript'    => array('tested' => '5.5.6330'),
        'jsc'        => array('tested' => 530.17),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => 5.02),
      )
    )),
    
    new Feature(array(
      'content' => '<code>Date.prototype.toString()</code>',
      'versions' => array(
        '' => 'jsx.object.isMethod(Date, "prototype", "toString")
               && "(new Date()).toString()"',
        'ecmascript' => 1,
        'javascript' => array('1.0', 'tested' => 1.3),
        'jscript'    => array('tested' => '5.1.5010'),
        'jsc'        => array('tested' => 530.17),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => 5.02),
      )
    )),
    
    new Feature(array(
      'content' => '<code>Date.prototype.toSource()</code>',
      'versions' => array(
        '' => 'jsx.object.isMethod(Date, "prototype", "toSource")
               && "(new Date()).toSource()"',
        'ecmascript' => '-',
        'javascript' => array('1.0', 'tested' => 1.3),
        'jscript'    => '-',
        'jsc'        => '-',
        'kjs'        => '-',
        'opera'      => '-',
      )
    )),
        
    new Feature(array(
      'content' => '<code>Date.prototype.toTimeString()</code>',
      'versions' => array(
        '' => 'jsx.object.isMethod(Date, "prototype", "toTimeString")
               && "(new Date()).toTimeString()"',
        'ecmascript' => 3,
        'javascript' => array(1.5),
        'jscript'    => array('tested' => '5.5.6330'),
        'jsc'        => array('tested' => 530.17),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => 5.02),
      )
    )),
       
    new Feature(array(
      'content' => '<code>Date.prototype.toUTCString()</code>',
      'versions' => array(
        '' => 'jsx.object.isMethod(Date, "prototype", "toUTCString")
               && "(new Date()).toUTCString()"',
        'ecmascript' => 1,
        'javascript' => array('tested' => 1.3),
        'jscript'    => array('tested' => '5.1.5010'),
        'jsc'        => array('tested' => 530.17),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => 5.02),
      )
    )),

    new Feature(array(
      'content' => '<code>JSON.parse()</code>',
      'versions' => array(
        '' => '"typeof JSON != \"undefined\""
               + "&& jsx.object.isMethod(JSON, \"parse\")"
               + "&& JSON.parse(\'{\"answer\": 42}\')[\"answer\"] === 42"',
        'ecmascript' => 5,
        'javascript' => array('tested' => '1.8.1'),
        'jscript'    => '-',
        'jsc'        => '-',
        'kjs'        => '-',
        'opera'      => '-',
      )
    )),
        
    new Feature(array(
      'content' => '<code>JSON.stringify()</code>',
      'versions' => array(
        '' => '"typeof JSON != \"undefined\""
               + " && jsx.object.isMethod(JSON, \"stringify\")"
               + " && JSON.stringify({answer: 42}) === \'{\"answer\":42}\'"',
        'ecmascript' => 5,
        'javascript' => array('tested' => '1.8.1'),
        'jscript'    => '-',
        'jsc'        => '-',
        'kjs'        => '-',
        'opera'      => '-',
      )
    )),
    
    new Feature(array(
      'content' => '<code>Math.max(<var>a</var>, <var>b</var>)</code>',
      'versions' => array(
        '' => 'jsx.object.isMethod(Math, "max")
               && Math.max(1, 2) == 2',
        'ecmascript' => 1,
        'javascript' => array('1.0', 'urn' => 'js15ref:Global_Objects:Math:max'),
        'jscript' => array('3.1.3510', 'tested' => TRUE),
        'jsc' => array('525.27.1', 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera' => array(5.02, 'tested' => TRUE),
      )
    )),

    new Feature(array(
      'content' => '<code>Math.max(<var>a</var>, <var>b</var>, <var>&hellip;</var>)</code>',
      'versions' => array(
        '' => 'jsx.object.isMethod(Math, "max")
               && Math.max(1, 2, 3) == 3',
        'ecmascript' => 3,
        'javascript' => array(1.5, 'tested' => TRUE,
          'urn' => 'js15ref:Global_Objects:Math:max'),
        'jscript' => array('5.5.6330', 'tested' => TRUE),
        'jsc' => array('525.27.1', 'tested' => TRUE),
        'kjs'        => array('3.5.9', 'tested' => TRUE),
        'opera' => array(5.02, 'tested' => TRUE)
      )
    )),
    
    new Feature(array(
      'content' => '<code>Object.prototype.hasOwnProperty(&hellip;)</code>',
      'versions' => array(
        'ecmascript' => 3,
        'javascript' => array(1.5, 'tested' => TRUE),
        'jscript'    => array('5.5.6330', 'tested' => TRUE),
        'jsc'        => array(525.13, 'tested' => TRUE),
        'kjs'        => array('3.2', 'documented' => 3.2, 'tested' => '3.5.9'),
        'opera'      => array(5.02, 'tested' => TRUE)
      )
    )),

    new Feature(array(
      'content' => '<code>String.fromCharCode(<var>integer</var>)</code>',
      'versions' => array(
        'ecmascript' => 1,
        'javascript' => array(1.2, 'tested' => '1.8.1'),
        'jscript'    => array('3.0', 'tested' => TRUE),
         'jsc'       => array('530.17', 'tested' => TRUE),
        'kjs'        => '?',
        'opera'      => '?'
      )
    )),
    
    new Feature(array(
      'content' => '<code>String.prototype.charCodeAt(<var>integer</var>)</code>',
      'versions' => array(
        '' => "'x'.charCodeAt(0) == 120",
        'ecmascript' => 1,
        'javascript' => array(1.2, 'tested' => '1.8.1'),
        'jscript'    => array('3.0', 'tested' => TRUE),
        'jsc'        => array('530.17', 'tested' => TRUE),
        'kjs'        => array('tested' => '4.3.2'),
        'opera'      => array('tested' => '10.00')
      )
    )),
    
    new Feature(array(
      'content' => '<code>String.prototype.localeCompare(<var>string</var>)</code>',
      'versions' => array(
        '' => '"jsx.object.isMethod(\"ä\", \"localeCompare\")"
              + "&& \"ä\".localeCompare(\"ü\") < 0"',
        'ecmascript' => 3,
        'javascript' => array('?'),
        'jscript'    => array('5.5'),
        'jsc'        => array('?'),
        'kjs'        => array('tested' => '4.3.2'),
        'opera'      => array('?')
      )
    )),
        
    new Feature(array(
      'content' => '<code>String.prototype.trim()</code>',
      'versions' => array(
        '' => "jsx.object.isMethod(String.prototype, 'trim')
               && ' x '.trim().length == 1",
        'ecmascript' => '-',
        'javascript' => array('1.8.1', 'tested' => '1.8.1'),
        'jscript'    => '-',
        'jsc'        => '-',
        'kjs'        => '-',
        'opera'      => '-'
      )
    )),
  ),
));

?>