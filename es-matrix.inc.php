<?php

require_once 'ScriptFeature.php';

$features = new FeatureList(array(
  'versions' => array(
    'ecmascript' => '<a href="#ecmascript">ECMAScript</a>',
    ''           => <<<HTML
This <abbr title="implementation">impl.</abbr><sup><a
name="this-ua" href="#fn-this-ua">1</a></sup>
HTML
    ,
    'javascript' => '<a href="#javascript" title="Netscape/Mozilla.org JavaScript">JavaScript</a>',
    'jscript'    => '<a href="#jscript" title="Microsoft JScript">JScript</a>',
    'v8'         => '<a href="#v8"><abbr title="Google V8">V8</abbr></a>',
    'jsc'        => '<a href="#jsc"><abbr title="Apple WebKit JavaScriptCore">JSC</abbr></a>',
    'opera'      => '<a href="#opera" title="Opera ECMAScript">Opera</a>',
    'kjs'        => '<a href="#kjs"><acronym title="Konqueror JavaScript">KJS</acronym></a>',
    //'as'         => '<a href="#actionscript">ActionScript</a>'
  ),

  'safeVersions' => array(
    'javascript' => 1.3,
    'jscript'    => '5.1.5010',
    'jsc'        => '525.13',
    'opera'      => '6.06'),

  'urns' => array(
    'mdc'     => 'https://developer.mozilla.org/en/',
    'js15ref' => 'mdc:Core_JavaScript_1.5_Reference/',
    'msdn'    => 'http://msdn.microsoft.com/en-us/library/',
    'es3'     => 'http://www.mozilla.org/js/language/E262-3.pdf'),

  'items' => array(
    new ScriptFeature(array(
      'anchors'    => array('!', 'opNotEqual'),
      'title'      => 'Strict Not Equal/Nonidentity operator',
      'content'    => '<code>!==</code>',
      'versions'   => array(
        'ecmascript' => array(3,
          'urn' => 'es3:#page=74'),
        ''           => '"1 !== \"1\""',
        'javascript' => array('1.3',
          'urn'    => 'js15ref:Operators:Comparison_Operators',
          'tested' => true),
        'jscript'    => array('1.0',
          'tested' => '5.1.5010',
          'urn' => 'msdn:ky6fyhws%28VS.85%29.aspx'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('412.6.2?', 'tested' => '525.13'),
        'opera'      => array(5.02, 'tested' => true),
        'kjs'        => array('3.5.9', 'tested' => true)
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>&quot;\u<var>hhhh</var>&quot; : string</code>',
      'title' => 'Unicode escape sequence in String literal',
      'versions' => array(
        'ecmascript' => 1,
        ''           => '"\'\\u20AC\' == \'€\'"',
        'javascript' => 1.3,
        'jscript'    => array('3.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('6.0', 'tested' => '6.06'),
        'kjs'        => array('tested' => '4.3.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a href="javascript:alert(\'The following should be in one line:\\n\\nfoo\\%0Abar\')"
        onclick="return !!alert(\'The following should be in one line:\\n\\nfoo\\&#10;bar\');"
      ><code>&quot;<var>foo</var>\<br>
        <var>bar</var>&quot; : string</code></a>',
      'title' => 'Escaped newline in String literal',
      'versions' => array(
        'ecmascript' => 5,
        'javascript' => array('', 'tested' => '1.8.1'),
        'jscript'    => array('', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('', 'tested' => '525.13'),
        'opera'      => array('tested' => '10.10'),
        'kjs'        => array('', 'tested' => '4.3.2'),
      )
    )),
    
    new ScriptFeature(array(
      'title'      => 'Unary plus (converts to Number)',
      'content'    => <<<EOD
              <a href="javascript:window.alert(+'042')"
                 onclick="window.alert(+'042'); return false"
                 ><code>+<var>expression</var> : number</code></a>
EOD
      ,
      'versions' => array(
        'ecmascript' => 1,
        '' => '"+\"42\" == 42"',
        'javascript' => array('1.3',      'tested' => true),
        'jscript'    => array('3.1.3510', 'tested' => true),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array(5.02, 'tested' => true),
        'kjs'        => array('3.5.9', 'tested' => true),
      )
    )),
    
    new ScriptFeature(array(
      'title'      => 'RegExp literal with only optional global and case-insensitive modifier',
      'content'    => '<code>/<var>&hellip;</var>/</code>[<code>g</code>][<code>i</code>]
        <code>: RegExp</code>',
      'versions'   => array(
        'ecmascript' => '-',
        ''           => '"/abc/gi.constructor == RegExp"',
        'javascript' => array('1.2',
          'urn'    => 'js15ref:Global_Objects:RegExp',
          'tested' => true),
        'jscript'    => array('3.1.3510',
          'urn'    => 'msdn:jscript7/html/jsobjregexpression.asp',
          'tested' => true),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array(5.02, 'tested' => true),
        'kjs'        => array('3.5.9', 'tested' => true),
      )
    )),
    
    new ScriptFeature(array(
      'title'      => 'RegExp literal with optional multiline modifier',
      'content'    => '<code>/<var>&hellip;</var>/</code>[<code>g</code>][<code>i</code>][<code>m</code>]
        <code>: RegExp</code>',
      'versions'   => array(
        'ecmascript' => 3,
        ''           => '"/abc/gim.constructor == RegExp"',
        'javascript' => array('1.5', 'tested' => true),
        'jscript'    => array('5.5.6330', 'tested' => true),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array(5.02, 'tested' => true),
        'kjs'        => array('3.5.9', 'tested' => true),
      )
    )),
    
    new ScriptFeature(array(
      'title'      => 'RegExp literal with optional sticky modifier',
      'content'    => '<code>/<var>&hellip;</var>/</code>[<code>g</code>][<code>i</code>][<code>m</code>][<code>y</code>]
        <code>: RegExp</code>',
      'versions'   => array(
        'ecmascript' => '-',
        'javascript' => array('1.8', 'tested' => '1.8.1'),
        'jscript'    => '-',
        'v8'         => array('tested' => '-'),
        'jsc'        => array('tested' => '531.9'),
        'kjs'        => '-',
        'opera'      => array('', 'tested' => '10.01'),
      )
    )),
    
    new ScriptFeature(array(
      'title'      => 'Regular Expression with non-capturing negative lookahead',
      'content'    => '<code>/(?!<var>&hellip;</var>)/ : RegExp</code>',
      'versions'   => array(
        'ecmascript' => 3,
        ''           => '"abac".match(/a(?!b)./) == "ac"',
        'javascript' => array(1.5, 'tested' => true,
          'urn'    => 'js15ref:Global_Objects:RegExp'),
        'jscript'    => array('5.5.6330',
          'urn' => 'msdn:jscript7/html/jsobjregexpression.asp',
          'tested' => true),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array(7.02, 'tested' => true),
        'kjs'        => array('3.5.9', 'tested' => true),
      )
    )),
    
    new ScriptFeature(array(
      'title' => 'Regular Expression with non-capturing parentheses',
      'content' => '<code>/(?:<var>&hellip;</var>)/ : RegExp</code>',
      'versions' => array(
        'ecmascript' => 3,
        ''           => '"ab".match(/a(?:b)/) == "ab"',
        'javascript' => array(1.5, 'tested' => true,
          'urn' => 'js15ref:Global_Objects:RegExp'),
        'jscript'    => array('5.5.6330',
          'urn' => 'msdn:jscript7/html/jsobjregexpression.asp',
          'tested' => true),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array(7.02, 'tested' => true),
        'kjs'        => array('3.5.9', 'tested' => true),
      )
    )),
    
    new ScriptFeature(array(
      'title' => 'Regular Expression with non-capturing positive lookahead',
      'content' => '<code>/(?=<var>&hellip;</var>)/ : RegExp</code>',
      'versions' => array(
        'ecmascript' => 3,
        ''           => '"ab".match(/a(?=b)/) == "a"',
        'javascript' => array(1.5, 'tested' => true,
          'urn' => 'js15ref:Global_Objects:RegExp'),
        'jscript'    => array('5.5.6330',
          'urn' => 'msdn:jscript7/html/jsobjregexpression.asp',
          'tested' => true),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array(7.02, 'tested' => true),
        'kjs'        => array('3.5.9', 'tested' => true),
      )
    )),

    new ScriptFeature(array(
      'title'      => 'Regular Expression with non-greedy matching',
      'content'    => '<code>/(<var>&hellip;</var>+?|<var>&hellip;</var>*?)/
        : RegExp</code>',
      'versions'   => array(
        'ecmascript' => 3,
        ''           => '"aaa".match(/^aa*?/) == "a" && "aaa".match(/^aa+?/) == "aa"',
        'javascript' => array(1.5, 'tested' => true,
          'urn' => 'js15ref:Global_Objects:RegExp'),
        'jscript'    => array('5.5.6330', 'tested' => true,
          'urn' => 'msdn:jscript7/html/jsobjregexpression.asp'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array(7.02, 'tested' => true),
        'kjs'        => array('3.5.9', 'tested' => true),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>/\u<var>hhhh</var>/ : RegExp</code>',
      'title' => 'Unicode escape sequence in RegExp literal',
      'versions' => array(
        'ecmascript' => 3,
        ''           => '"/\\u20AC/.test(\'€\')"',
        'javascript' => 1.3,
        'jscript'    => array('3.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '4.3.4'),
      )
    )),
        
    new ScriptFeature(array(
      'title' => 'Label',
      'content' => '<code><var>label</var>:</code>',
      'versions' => array(
        'ecmascript' => 3,
        '' => '"foo: true"',
        'javascript' => array(1.2, 'tested' => '1.5',
          'urn' => 'js15ref:Statements:label'),
        'jscript'    => array('3.1.3510',
          'urn'    => 'msdn:jscript7/html/jsstmlabeled.asp',
          'tested' => true),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array(5.02, 'tested' => true),
        'kjs'        => array('3.5.9', 'tested' => true),
      )
    )),

    new ScriptFeature(array(
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
        'jscript'    => '7.0',
        'v8'         => array('tested' => '-'),
        'jsc'        => '-',
        'opera'      => '-',
        'kjs'        => '-',
      )
    )),

    
    new ScriptFeature(array(
      'anchors'  => array('equals'),
      'title'    => 'Equals operator',
      'content'  => '<code>==</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => '1 == "1"',
        'javascript' => array(
            '<a class="tooltip" href="#equals" name="equals">1.0<span><span>
      (</span>deprecated since 1.4 <em>for comparison of two <code>JSObject</code>
      objects</em>; use the <code>JSObject.equals</code> method instead<span>)</span></span></a>',
          'tested'  => '1.3',
          'urn'     => '#equals',
          'tooltip' => '<span>
            (</span>deprecated since 1.4 <em>for comparison of two
            <code>JSObject</code> objects</em>; use the
            <code>JSObject<span class="punct">.</span>equals</code>
            method instead<span>)</span></span>'),
        'jscript'    => array('1.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => '5.02')
      )
    )),

    new ScriptFeature(array(
      'title'    => 'Strict Equals/Identity operator',
      'content'  => '<code>===</code>',
      'versions' => array(
        'ecmascript' => 3,
        ''           => '!(1 === "1")',
        'javascript' => array('1.3', 'tested' => '1.3'),
        'jscript'    => array('1.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '4.3.2'),
        'opera'      => array('tested' => '5.02')
      )
    )),
    
    new ScriptFeature(array(
      'title' => 'Array initializer',
      'content' => '<code>[<var>value</var>, <var>&hellip;</var>] : Array</code>',
      'versions' => array(
        'ecmascript' => 3,
        ''           => '"[42, 23]"',
        'javascript' => 1.3,
        'jscript'    => array('2.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '4.3.4'),
      )
    )),
    
    new ScriptFeature(array(
      'title' => 'Array initializer with trailing comma',
      'content' => '<code>[<var>value</var>,&nbsp;] : Array</code>',
      'versions' => array(
        'ecmascript' => 3,
        ''           => '"[42,]"',
        'javascript' => 1.3,
        'jscript'    => array('', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '4.3.4'),
      )
    )),
        
    new ScriptFeature(array(
      'title' => 'Array comprehension',
      'content' => <<<HTML
        <code>[<var>expression</var> for (<var>propertyName</var>
        in&nbsp;<var>Object</var>)</code>
        [<code>if (<var>condition</var>)</code>]<code>] : Array</code><br>
        <code>[<var>expression</var> for each (<var>propertyValue</var>
        in&nbsp;<var>Object</var>)</code>
        [<code>if (<var>condition</var>)</code>]<code>] : Array</code>
HTML
      , 'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'mdc:docs/New_in_JavaScript_1.7#Array_comprehensions'),
        'jscript'    => '-',
        'jsc'        => '-',
        'kjs'        => '-',
      )
    )),
    
    new ScriptFeature(array(
      'title' => 'Destructuring assignment',
      'content' => <<<HTML
        [<code>var</code>] <code>[<var>var1</var>,</code>
        [<code><var>var2</var></code>]<code>,
        <var>var3</var>, <var>&hellip;</var>]&nbsp;= <var>Array</var></code>
HTML
      , 'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'mdc:docs/New_in_JavaScript_1.7#Destructuring_assignment'),
        'jscript'    => '-',
        'jsc'        => '-',
        'kjs'        => '-',
      )
    )),
        
    new ScriptFeature(array(
      'content' => '<code>var \u<var>hhhh</var></code>',
      'title' => 'Unicode escape sequence in Identifier',
      'versions' => array(
        'ecmascript' => 3,
        ''           => '"var \\\\u0041 = 1; 1"',
        'javascript' => array('tested' => 1.5),
        'jscript'    => array('tested' => '5.5.6330'),
        'v8'         => array('tested' => '2.0'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '6.06'),
        'kjs'        => array('tested' => '4.3.4'),
      )
    )),
        
    new ScriptFeature(array(
      'title' => 'Object initializer',
      'content' => '<code>{<var>propertyName</var>:
            <var>propertyValue</var>, <var>&hellip;</var>} : Object</code>',
      'versions' => array(
        '' => '{a: "b"}.a == "b"',
        'ecmascript' => 3,
        'javascript' => array(1.3, 'tested' => 1.3),
        'jscript'    => array('3.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array(5.02, 'tested' => true),
        'kjs'        => array('3.5.9', 'tested' => true),
      )
    )),
    
    new ScriptFeature(array(
      'title' => 'Object initializer with trailing comma',
      'content' => '<code><a href="javascript:window.alert%28eval%28\'%28{foo:%2042,}%29\'%29.foo%29;"
        onclick="window.alert(eval(\'({foo: 42,})\').foo); return false"
        >{<var>propertyName</var>: <var>propertyValue</var>,&nbsp;} : Object</a></code>',
      'versions' => array(
        'ecmascript' => 5,
        'javascript' => '1.3',
        'jscript'    => '-',
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '4.3.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>abstract</code>',
      'anchors' => array('a'),
      'versions' => array(
        'javascript' => '2.0',
        'jscript' => '7.0',
        'ecmascript' => 4
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>new ActiveXObject("<var>serverName</var>.<var>typeName</var>"</code>[<code>,
        <var>location</var> : String</code>]<code>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '3.0'
      )
    )),

    new ScriptFeature(array(
      'content' => '<code>arguments</code>',
      'anchor' => 'arguments',
      'versions' => array(
        'ecmascript' => 1,
        ''           => '"function f() { return typeof arguments != \'undefined\' && arguments; };"
                         + " var a = f(); a && typeof a != \'undefined\'"',
        'javascript' => array(1.1,
          'urn' => 'js15ref:Functions:arguments'),
        'jscript'    => '1.0',
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '4.3.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="arguments.callee" id="arguments.callee"
        href="javascript:void((function(){alert(arguments.callee);})())"
        onclick="return !!(function(){alert(arguments.callee);})();"
      ><code>arguments.callee : Function</code></a>',
      'versions' => array(
        'ecmascript' => '1',
        ''           => '"function f() { return typeof arguments != \'undefined\' && arguments; };"
                         + " var a = f(); a && typeof a != \'undefined\' && typeof a.callee != \'undefined\'"',
        'javascript' => array(1.2,
          'urn' => 'js15ref:Functions:arguments:callee'),
        'jscript' => '3.0*',
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '4.3.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="arguments.caller" id="arguments.caller"><code>arguments.caller
        : Function|null</code></a>',
      'versions' => array(
        'ecmascript' => '-',
        ''           => '"function f() { return typeof arguments != \'undefined\' && arguments; };"
                         + " var a = f(); a && typeof a != \'undefined\' && typeof a.caller != \'undefined\'"',
        'javascript' => '<a href="#arguments.caller" class="tooltip">1.1<span><span>; </span>deprecated
      since 1.3</span></a>',
        'jscript' => '<span class="tooltip">-<span> (see&nbsp;<code><a
        href="#Function.prototype.caller"
      >Function.prototype.caller</a></code><span>)</span></span></span>',
        'v8'         => array('tested' => '-'),
        'jsc'        => array('tested' => '-'),
        'kjs'        => array('tested' => '-'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="arguments.length" id="arguments.length"><code>arguments.length : int</code></a>',
      'versions' => array(
        'ecmascript' => '1',
        ''           => '"function f() { return typeof arguments != \'undefined\' && arguments; };"
                         + " var a = f(); a && typeof a != \'undefined\' && typeof a.length == \'number\'"',
        'javascript' => '1.1',
        'jscript'    => '5.5',
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '4.3.4'),
      )
    )),

    new ScriptFeature(array(
      'title' => 'Array constructor/factory',
      'content' => '<code title="Array constructor/factory">Array(<var>&hellip;</var>)</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.1',
        'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.every(<var>iterable</var>,
        <var>callback</var> : Function) : boolean</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.6,
          'urn' => 'js15ref:Global_Objects/Array/every'),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.some(<var>iterable</var>,
        <var>callback</var> : Function) : boolean</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '1.6',
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype : Array</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => '!!getFeature(_global, "Array", "prototype")',
        'javascript' => array('assumed' => '1.1'),
        'jscript'    => array('2.0'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.concat(</code>[<code><var>item1</var></code>[<code>,
        <var>item2</var></code>[<code>, <var>&hellip;</var></code>]]]<code>)
        : Array</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.2',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.every(<var>callback</var>
        : Function</code>[<code>, <var>thisValue</var></code>]<code>)
        : boolean</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '1.6',
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.indexOf(<var>searchElement</var></code>[<code>,
        <var>fromIndex</var> : int</code>]<code>) : int</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '1.6',
        'jscript' => '-'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.join(<var>separator</var> : String)
        : string</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.1',
        'jscript' => '2.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.length : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.1',
        'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.pop()</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.2',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.push(</code>[<code><var>item1</var></code>[<code>,
        <var>item2</var></code>[<code>,
        <var>&hellip;</var></code>]]]<code>) : int</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.2',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.reverse() : Array</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.1',
        'jscript' => '2.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.shift()</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.2',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.slice(<var>start</var> : int</code>[<code>,
        <var>end</var> : int</code>]<code>) : Array</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.2',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.some(<var>callback</var> : Function</code>[<code>,
        <var>thisValue</var></code>]<code>) : boolean</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '1.6',
        'jscript' => '-'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.sort(</code>[<code><var>comparator</var>
        : Function</code>]<code>) : Array</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.1',
        'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a
        href="javascript:a=new(Array(1,2,3));alert(a.splice(1,1,4));alert(a);"
        onclick="var a = new Array(1,2,3); alert(a.splice(1,1,4)); return !!alert(a);"
      ><code>Array.prototype.splice(<var>start</var> : int,
        <var>deleteCount</var> : int</code>[<code>,
        <var>item1</var></code>[<code>, <var>item2</var></code>[<code>,
        <var>&hellip;</var></code>]]]<code>) :&nbsp;Array</code></a>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '<a href="#Array.prototype.splice"
        name="Array.prototype.splice" class="tooltip"
      >1.2<span><span>; </span>no return value before 1.3</span></a>',
        'jscript' => array('5.5*', 'tested' => '5.5.6330'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a href="javascript:a=new(Array(\'1\'));a.unshift(0);alert(a);"
        onclick="var a = new Array(\'1\'); a.unshift(0); return !!alert(a);"
      ><code>Array.prototype.unshift() : int</code></a>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.2?',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="b" id="b"></a><code>boolean</code>',
      'versions' => array(
        'ecmascript' => '4',
        'javascript' => '2.0',
        'jscript' => array('7.0',
          'urn' => 'msdn:jscript7/html/jsdatBoolean.asp')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Boolean(<var>&hellip;</var>)</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => array(1.1,
          'urn' => 'js15ref:Global_Objects:Boolean'),
        'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Boolean.prototype : Boolean</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => '!!getFeature(_global, "Boolean", "prototype")',
        'javascript' => array('assumed' => '1.1'),
        'jscript'    => array('2.0'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>byte</code>',
      'versions' => array(
        'ecmascript' => '4',
        'javascript' => '2.0',
        'jscript' => array('7.0',
          'urn' => 'msdn:jscript7/html/jsdatbyte.asp')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="c" id="c"></a><code>@cc_on</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>char</code>',
      'versions' => array(
        'ecmascript' => '4',
        'javascript' => '2.0',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>class</code>',
      'versions' => array(
        'ecmascript' => '4',
        'javascript' => '2.0',
        'jscript' => array('7.0',
          'urn' => 'msdn:jscript7/html/jsdatchar.asp')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>const</code>',
      'versions' => array(
        'ecmascript' => '4',
        'javascript' => '1.5',
        'jscript' => '7.0'
      )
    )),
          
    new ScriptFeature(array(
      'content' => '<code>Date.prototype : Date</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => '!!getFeature(_global, "Date", "prototype")',
        'javascript' => array('assumed' => '1.1'),
        'jscript'    => array('2.0'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="d" id="d"></a><code>Date.prototype.getFullYear() : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getMilliseconds() : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCDate() : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCDay() : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCFullYear() : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCHours() : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCMilliseconds() : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCMinutes() : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCMonth() : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCSeconds() : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getVarDate()</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setFullYear(<var>year</var> : int</code>[<code>,
        <var>month</var> : int</code>[<code>,
        <var>date</var> : int</code>]]<code>) :&nbsp;int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setMilliseconds(<var>int</var>) : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCDate(<var>int</var>) : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCDay(<var>int</var>) : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCFullYear(<var>year</var> :&nbsp;int</code>[<code>,
        <var>month</var> :&nbsp;int</code>[<code>,
        <var>date</var> :&nbsp;int</code>]]<code>) :&nbsp;int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCHours(<var>hours</var> :&nbsp;int</code>[<code>,
        <var>minutes</var> :&nbsp;int</code>[<code>,
        <var>seconds</var> :&nbsp;int</code>]]<code>) :&nbsp;int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCMilliseconds(<var>int</var>) : int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCMinutes(<var>minutes</var> :&nbsp;int</code>[<code>,
        <var>seconds</var> :&nbsp;int</code>[<code>,
        <var>ms</var> :&nbsp;int</code>]]<code>) :&nbsp;int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCMonth(<var>month</var> : int</code>[<code>,
        <var>date</var> : int</code>]<code>) :&nbsp;int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCSeconds(<var>seconds</var> :&nbsp;int</code>[<code>,
      <var>ms</var> : int</code>]<code>) :&nbsp;int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toDateString() :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toDateString")
               && "(new Date()).toDateString()"',
        'ecmascript' => 3,
        'javascript' => array(1.5, 'tested' => 1.5),
        'jscript'    => array('tested' => '5.5.6330'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => 5.02),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toGMTString() :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toGMTString")
               && "(new Date()).toGMTString()"',
        'ecmascript' => 1,
        'javascript' => array('tested' => 1.3),
        'jscript'    => array('tested' => '5.1.5010'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => 5.02),
      )
    )),
        
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toISOString() :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toISOString")
               && "(new Date()).toISOString()"',
        'ecmascript' => 5,
        'javascript' => array('tested' => '1.8.1'),
    )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toJSON(</code>[<code><var>key</var></code>]<code>) :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toJSON")
               && "(new Date()).toJSON()"',
        'ecmascript' => 5,
        'javascript' => array('tested' => '1.8.1'),
        )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toLocaleDateString() :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toLocaleDateString")
               && "(new Date()).toLocaleDateString()"',
        'ecmascript' => 3,
        'javascript' => array(1.5, 'tested' => 1.5),
        'jscript'    => array('tested' => '5.5.6330'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => 5.02),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toLocaleFormat(<var>format</var> : String) :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toLocaleFormat")
               && "(new Date()).toLocaleFormat(\'%A, %B %e, %Y\')"',
        'ecmascript' => '-',
        'javascript' => array(1.6, 'tested' => 1.6),
        'jscript'    => '-',
        'jsc'        => '-',
        'kjs'        => '-',
        'opera'      => '-'
      )
    )),
        
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toLocaleString() :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toLocaleString")
               && "(new Date()).toLocaleString()"',
        'ecmascript' => 1,
        'javascript' => array('tested' => 1.3),
        'jscript'    => array('5.1.5010', 'tested' => true),
        'jsc'        => array('525.13', 'tested' => true),
        'kjs'        => array('3.5.9', 'tested' => true),
        'opera'      => array(5.02, 'tested' => true)
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toLocaleTimeString() :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toLocaleTimeString")
               && "(new Date()).toLocaleTimeString()"',
        'ecmascript' => 3,
        'javascript' => array(1.5, 'tested' => 1.5),
        'jscript'    => array('tested' => '5.5.6330'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => 5.02),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toSource() :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toSource")
               && "(new Date()).toSource()"',
        'ecmascript' => '-',
        'javascript' => array('1.0', 'tested' => 1.3),
        'jscript'    => '-',
        'jsc'        => '-',
        'kjs'        => '-',
        'opera'      => '-',
      )
    )),
        
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toString() :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toString")
               && "(new Date()).toString()"',
        'ecmascript' => 1,
        'javascript' => array('1.0', 'tested' => 1.3),
        'jscript'    => array('tested' => '5.1.5010'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => 5.02),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toTimeString() :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toTimeString")
               && "(new Date()).toTimeString()"',
        'ecmascript' => 3,
        'javascript' => array(1.5, 'tested' => 1.5),
        'jscript'    => array('tested' => '5.5.6330'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => 5.02),
      )
    )),
       
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toUTCString() :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toUTCString")
               && "(new Date()).toUTCString()"',
        'ecmascript' => 1,
        'javascript' => array('tested' => 1.3),
        'jscript'    => array('tested' => '5.1.5010'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '3.5.9'),
        'opera'      => array('tested' => 5.02),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>@debug</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>debugger</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '3.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>decimal</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => array('7.0',
          'urn' => 'msdn:jscript7/html/jsdatDecimal.asp')
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>decodeURI(<var>String</var>) :&nbsp;string</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.5',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>decodeURIComponent(<var>String</var>) :&nbsp;string</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '1.5',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>delete</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>do&hellip;while</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>double</code>',
      'versions' => array(
        'ecmascript' => '4',
        'javascript' => '2.0',
        'jscript' => array('7.0',
          'urn' => 'msdn:jscript7/html/jsdatdouble.asp')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="e" id="e"></a><code>encodeURI(<var>String</var>)</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '1.5',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>encodeURIComponent(<var>String</var>) :&nbsp;string</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '1.5',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>enum</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '2.0',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Enumerator(<var>&hellip;</var>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Error(</code>[<code><var>message</var> : String</code>]<code>)</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '5.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Error.prototype.description :&nbsp;string</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '5.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Error.prototype.message :&nbsp;string</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '5.5'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Error.prototype.name :&nbsp;string</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '5.5'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Error.prototype.number :&nbsp;int</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '5.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Error.prototype.stack :&nbsp;string</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array('tested' => 1.5),
        'jscript'    => '-',
        'jsc'        => array('tested' => '-'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>expando</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="f" id="f"></a><code>final</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>float</code>',
      'versions' => array(
        'ecmascript' => '4',
        'javascript' => '2.0',
        'jscript' => array('7.0',
          'urn' => 'msdn:jscript7/html/jsdatfloat.asp')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>for each ([var] <var>identifier</var> in <var>Object</var>)</code>',
      'versions' => array(
        'ecmascript' => 'E4X',
        'javascript' => '1.6',
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Function(</code>[<code><var>p1</var> : String</code>[<code>,
        <var>p2</var> : String</code>[<code>, <var>&hellip;</var></code>]<code>,
        <var>pn</var> : String</code>]<code>,</code>]
        <code><var>body</var> : String) :&nbsp;Function</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.1',
        'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>function get <var>identifier</var>(<var>&hellip;</var>) :&nbsp;Function</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>function set <var>identifier</var>(<var>&hellip;</var>) :&nbsp;Function</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '7.0'
      )
    )),
      
    new ScriptFeature(array(
      'title' => 'Function expression',
      'content' => '<code>= function
            <var>identifier</var>(<var>&hellip;</var>) {<var>&hellip;</var>} :&nbsp;Function</code>',
      'versions' => array(
        '' => '"(function foo() { return 42; })() == 42"',
        'ecmascript' => 1,
        'javascript' => array(1.2, 'tested' => 1.3),
        'jscript'    => array('1.0', 'tested' => '5.1.5010'),
        'jsc'        => array(525.13, 'tested' => true),
        'kjs'        => array('3.5.9', 'tested' => true),
        'opera'      => array(5.02, 'tested' => true)
      )
    )),

    new ScriptFeature(array(
      'title' => 'Anonymous function expression',
      'content' => '<code>= function(<var>&hellip;</var>) {<var>&hellip;</var>} :&nbsp;Function</code>',
      'versions' => array(
        '' => '"(function() { return 42; })() == 42"',
        'ecmascript' => 3,
        'javascript' => array('1.3*', 'tested' => '1.3'),
        'jscript'    => array('3.1.3510', 'tested' => true),
        'jsc'        => array(525.13, 'tested' => true),
        'kjs'        => array('3.5.9', 'tested' => true),
        'opera'      => array(5.02, 'tested' => true)
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code title="Expression closure">= <a
        href="javascript:window.alert((function(x)%20x%20*%20x)(2))"
        onclick="eval(\'window.alert((function(x) x * x)(2)); return false\')"
      >function(<var>&hellip;</var>) <var>expression</var> : Function</a></code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array('tested' => 1.8),
        'jscript' => '-',
      )
    )),
            
    new ScriptFeature(array(
      'title' => 'Function statement',
      'content' => '<code>if (<var>&hellip;</var>) { function f() { <var>&hellip;</var> }; }</code>',
      'versions' => array(
        '' => '"function f() {}; if (true) { function f() { return 42; }; } f() == 42"',
        'ecmascript' => '-',
        'javascript' => array(1.3, 'tested' => 1.3),
        'jscript'    => array('3.1.3510', 'tested' => true),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('3.5.9', 'tested' => true),
        'opera'      => array(5.02, 'tested' => true),
      )
    )),

    new ScriptFeature(array(
      'content' => '<code>Function.prototype :&nbsp;Function</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => '!!getFeature(_global, "Function", "prototype")',
        'javascript' => array('assumed' => '1.1'),
        'jscript'    => array('2.0'),
      )
    )),
    
    
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.arity :&nbsp;int</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '<a href="#Function.prototype.arity"
        name="Function.prototype.arity" class="tooltip"
      >1.2<span><span>; </span>deprecated since 1.4</span></a>',
        'jscript' => ''
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.apply(</code>[<code><var>thisArg</var> : Object|undefined</code>[<code>, <var>argArray</var>&nbsp;:&nbsp;Array|arguments</code>]]<code>)</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.3',
        'jscript' => array('5.5', 'tested' => '5.5.6330')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.arguments :&nbsp;arguments</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => <<<HTML
          <span class="tooltip">1.0<span><span>; </span>deprecated since 1.4;
          use <a href="#arguments"><code>arguments</code></a> instead</span></span>
HTML
        , 'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.arguments.callee :&nbsp;Function</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => <<<HTML
          <span class="tooltip">1.2<span><span>; </span>deprecated since 1.4;
          use <code><a href="#arguments.callee">arguments.callee</a></code>
          instead</span></span>
HTML
        , 'jscript' => '5.6'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.arguments.length :&nbsp;int</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => <<<HTML
          <span class="tooltip">1.0<span><span>; </span>deprecated since 1.4;
          use <a href="#arguments.length"><code>arguments.length</code></a>
          instead</span></span>
HTML
        , 'jscript' => ''
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.call(</code>[<code><var>thisArg</var> : Object|undefined</code>[<code>, <var>arg1</var></code>[,<code> <var>arg2</var>, <var>&hellip;</var></code>]]<code>)</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => array(1.3,
          'urn' => 'js15ref:Global_Objects:Function:call'),
        'jscript' => array('5.5', 'tested' => '5.5.6330')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="Function.prototype.caller"
        id="Function.prototype.caller"
      ><code>Function.prototype.caller :&nbsp;Function|null</code></a>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '<span class="tooltip">-<span><span> (</span>see&nbsp;<code><a
        href="#arguments.caller"
      >arguments.caller</a></code><span>)</span></span></span>',
        'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.length :&nbsp;int</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.prototype : Object</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '2.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.toSource() : string</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '1.3',
        'jscript' => ''
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="g" id="g"></a><code><var>Generator</var>.close()</code><sup><a href="#fn-decl-ver" name="decl-ver">V</a></sup>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'mdc:New_in_JavaScript_1.7#Closing_a_generator'),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code><var>Generator</var>.next()</code><sup><a href="#fn-decl-ver">V</a></sup>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Generators'),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code><var>Generator</var>.send(<var>expression</var>)</code><sup><a href="#fn-decl-ver">V</a></sup>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Resuming_a_generator_at_a_specific_point'),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code><var>Generator</var>.throw(<var>expression</var>)</code><sup><a href="#fn-decl-ver">V</a></sup>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Exceptions_in_generators'),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>GetObject(<var>&hellip;</var>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => 'Global object',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.0',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="h" id="h"></a><code>hide</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="i" id="i"></a><code>@if</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>import</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '7.0'
      )
    )),

    new ScriptFeature(array(
      'content' => '(<code><var>String</var> in <var>Object</var></code>) <code>: boolean</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.4',
        'jscript' => '5.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Infinity : number</code>',
      'versions' => array(
        '' => '"Infinity > 0"',
        'ecmascript' => 1,
        'javascript' => 1.3,
        'jscript'    => '3.0',
        'jsc'        => array('tested' => '525.13'),
        'opera'      => '7.0'
      )
    )),

    new ScriptFeature(array(
      'content' => '<code>instanceof</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.4',
        'jscript' => '5.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>int</code>',
      'versions' => array(
        'ecmascript' => '4',
        'javascript' => '2.0',
        'jscript' => array('7.0',
          'urn' => 'http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatint.asp')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>interface</code>',
      'versions' => array(
        'ecmascript' => '4',
        'javascript' => '2.0',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>internal</code>',
      'versions' => array(
        'ecmascript' => '4',
        'javascript' => '2.0',
        'jscript' => '7.0'
      )
    )),

    new ScriptFeature(array(
      'content' => '<code>isFinite(<var>&hellip;</var>) : boolean</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Iterator(<var>Object</var>) : Iterator</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Iterators'),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>JSON.parse(<var>text</var> :&nbsp;String</code>[<code>,<var>reviver</var> : Function</code>]<code>) : Object</code>',
      'versions' => array(
        '' => '"typeof JSON != \"undefined\""
               + "&& isMethod(JSON, \"parse\")"
               + "&& JSON.parse(\'{\"answer\": 42}\')[\"answer\"] === 42"',
        'ecmascript' => 5,
        'javascript' => array('tested' => '1.8.1'),
        'jscript'    => '-',
        'jsc'        => array('tested' => '-'),
        'kjs'        => '-',
        'opera'      => '-',
      )
    )),
        
    new ScriptFeature(array(
      'content' => '<code>JSON.stringify(<var>value</var></code>[<code>, <var>replacer</var></code>[<code>, <var>space</var></code>]]<code>) : string</code>',
      'versions' => array(
        '' => '"typeof JSON != \"undefined\""
               + " && isMethod(JSON, \"stringify\")"
               + " && JSON.stringify({answer: 42}) === \'{\"answer\":42}\'"',
        'ecmascript' => 5,
        'javascript' => array('tested' => '1.8.1'),
        'jscript'    => '-',
        'jsc'        => array('tested' => '-'),
        'kjs'        => '-',
        'opera'      => '-',
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="l" id="l"></a><a name="let" id="let"><code
        title="Block scoping: let statement"
      >let&nbsp;(<var>assignment</var></code>[<code>, <var>&#8230;</var></code>]<code>)
      {&nbsp;</code>[<code><var>statements</var></code>]<code>&nbsp;}</code></a><sup><a href="#fn-decl-ver">V</a></sup>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Block_scope_with_let'),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'title' => 'Block scoping: let expression',
      'content' => <<<HTML
        <code title="Block scoping: let expression">let&nbsp;(<var>assignment</var></code>[<code>,
        <var>&#8230;</var></code>]<code>)&nbsp;<var>expression</var></code><sup><a href="#fn-decl-ver">V</a></sup>
HTML
      , 'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Block_scope_with_let'),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'title' => 'Block scoping: let definition',
      'content' => <<<HTML
        <code title="Block scoping: let definition">let&nbsp;<var>assignment</var></code>[<code>,
        <var>&#8230;</var></code>]<sup><a href="#fn-decl-ver">V</a></sup>
HTML
      , 'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(
          'urn' => 'http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Block_scope_with_let'),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>long</code>',
      'versions' => array(
        'ecmascript' => '4',
        'javascript' => '2.0',
        'jscript' => array('7.0',
          'urn' => 'msdn:jscript7/html/jsdatlong.asp'),
      )
    )),
       
    new ScriptFeature(array(
      'content' => '<code>Math.max(<var>a</var> :&nbsp;Number,
        <var>b</var> :&nbsp;Number) :&nbsp;number</code>',
      'anchors' => array('m'),
      'versions' => array(
        '' => 'isMethod(Math, "max")
               && Math.max(1, 2) == 2',
        'ecmascript' => 1,
        'javascript' => array('1.0',
          'tested' => '1.3',
          'urn'    => 'js15ref:Global_Objects:Math:max'),
        'jscript'    => array('3.0', 'tested' => '3.1.3510'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('3.5.9', 'tested' => true),
        'opera'      => array(5.02, 'tested' => true),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Math.max(<var>a</var> :&nbsp;Number,
        <var>b</var> :&nbsp;Number, <var>&hellip;</var>) :&nbsp;number</code>',
      'versions' => array(
        '' => 'isMethod(Math, "max")
               && Math.max(1, 2, 3) == 3',
        'ecmascript' => 3,
        'javascript' => array('tested' => '1.5',
          'urn' => 'js15ref:Global_Objects:Math:max'),
        'jscript'    => array(5.5, 'tested' => '5.5.6330'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('3.5.9', 'tested' => true),
        'opera'      => array(5.02, 'tested' => true)
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Math.min(<var>a</var> :&nbsp;Number,
        <var>b</var> :&nbsp;Number) :&nbsp;number</code>',
      'versions' => array(
        'javascript' => array('tested' => 1.3),
        'jscript' => array('3.0', 'tested' => '3.1.3510'),
        'ecmascript' => 1
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Math.min(<var>a</var> :&nbsp;Number,
        <var>b</var> :&nbsp;Number, <var>&hellip;</var>) :&nbsp;number</code>',
      'versions' => array(
        'javascript' => array('tested' => 1.5),
        'jscript' => array('5.5', 'tested' => '5.5.6330'),
        'ecmascript' => 3
      )
    )),
        
    new ScriptFeature(array(
      'anchors' => array('n'),
      'content' => '<code>NaN :&nbsp;number</code>',
      'title'   => 'Not-a-number value',
      'versions' => array(
        '' => '"isNaN(NaN)"',
        'ecmascript' => 1,
        'javascript' => 1.3,
        'jscript'    => '3.0',
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => '',
        'opera'      => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'anchors' => array('Number'),
      'content' => '<code>Number(</code>[<code><var>expression</var></code>]<code>)
        :&nbsp;number</code>',
      'versions' => array(
        'javascript' => '',
        'jscript' => array('1.0',
          'urn' => 'msdn:jscript7/html/jsobjnumber.asp'),
        'ecmascript' => ''
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Number.MAX_VALUE :&nbsp;number</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => array('2.0',
          'urn' => 'msdn:jscript7/html/jspromaxvalue.asp'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Number.MIN_VALUE :&nbsp;number</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => array('2.0',
          'urn' => 'msdn:jscript7/html/jsprominvalue.asp'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Number.NaN :&nbsp;number</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => array('2.0',
          'urn' => 'msdn:jscript7/html/jspronannumber.asp')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Number.NEGATIVE_INFINITY :&nbsp;number</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => array('2.0',
          'urn' => 'msdn:jscript7/html/jspronegativeinf.asp')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Number.POSITIVE_INFINITY :&nbsp;number</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => array('2.0',
          'urn' => 'msdn:jscript7/html/jspropositiveinf.asp')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Number.prototype :&nbsp;Number</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => '!!getFeature(_global, "Number", "prototype")',
        'javascript' => array('tested' => '1.1'),
        'jscript'    => array('2.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '2.0'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Number.prototype.toString() :&nbsp;string</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => 'isMethod(42, "toString")',
        'javascript' => array('tested' => '2.0'),
        'jscript'    => array('assumed' => '1.0'),
        'jsc'        => array('tested' => '525.13'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="o" id="o"></a><code>Object(</code>[<code><var>expression</var></code>]<code>) :&nbsp;Object</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.getPrototypeOf(<var>o</var> :&nbsp;Object) :&nbsp;Object</code>',
      'versions' => array(
        '' => 'isMethod(Object, "getPrototypeOf")',
        'ecmascript' => '5',
        'javascript' => array('1.8.1', 'tested' => '1.8.1'),
        'jscript' => '-',
        'jsc'        => array('tested' => '-'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.prototype :&nbsp;Object</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => '!!getFeature(_global, "Object", "prototype")',
        'javascript' => array('assumed' => '1.1'),
        'jscript'    => array('2.0'),
      )
    )),
    
    
    new ScriptFeature(array(
      'content' => '<code>Object.prototype.__defineGetter__(<var>propertyName</var>:&nbsp;string,
      <var>getter</var>:&nbsp;Function)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '1.5',
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.prototype.__defineSetter__(<var>propertyName</var>:&nbsp;string,
      <var>setter</var>:&nbsp;Function)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '1.5',
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.prototype.__iterator__</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Iterators'),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.prototype.__proto__</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '1.3',
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.prototype.constructor :&nbsp;Function</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.1',
        'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.prototype.hasOwnProperty(<var>propertyName</var> :&nbsp;String)
         :&nbsp;boolean</code>',
      'versions' => array(
        'ecmascript' => 3,
        'javascript' => array(1.5, 'tested' => true),
        'jscript'    => array('5.5.6330', 'tested' => true),
        'jsc'        => array(416.11, 'tested' => 525.13),
        'kjs'        => array('3.2', 'documented' => 3.2, 'tested' => '3.5.9'),
        'opera'      => array(5.02, 'tested' => true)
      )
    )),

    new ScriptFeature(array(
      'content' => '<code>Object.prototype.isPrototypeOf(<var>Object</var>)
         :&nbsp;boolean</code>',
      'versions' => array(
        ''           => 'isMethod(Object.prototype, "isPrototypeOf")',
        'ecmascript' => array(3, 'section' => '15.2.4.6'),
        'javascript' => array('tested' => 1.5),
        'jscript'    => array('tested' => '5.5'),
        'jsc'        => array('tested' => 525.13),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.3.4')
    )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.prototype.propertyIsEnumerable(<var>propertyName</var>
         :&nbsp;String) :&nbsp;boolean</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.prototype.toSource() :&nbsp;string</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '1.0',
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>override</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '7.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<a name="p" id="p"></a><code>package</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>@position</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>print(<var>string</var>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>private</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>protected</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>public</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '7.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<a name="q" id="q"></a><a name="r" id="r"></a><code>RegExp(<var>&hellip;</var></code>[<code>,
      <span class="str">&quot;</span></code>[<code class="str">g</code>][<code>i</code>]<code
        class="str"
      >&quot;</code>]<code>) :&nbsp;RegExp</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '1.2',
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>RegExp(<var>&hellip;</var></code>[<code>, <span
        class="str"
      >&quot;</span></code>[<code class="str">g</code>][<code>i</code>][<code>m</code>]<code
        class="str"
      >&quot;</code>]<code>) :&nbsp;RegExp</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.5',
        'jscript' => '3.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>RegExp.$<var>integer</var></code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '3.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>RegExp.</code>{<code>$&amp;</code> | <code>lastMatch</code>}',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '1.2',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>RegExp.</code>{<code>$\'</code> | <code>rightContext</code>}',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>RegExp.</code>{<code>$+</code> | <code>lastParen</code>}',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '{<code>RegExp</code> | <code><var>reArray</var></code>}<code>.</code>{<code>$_</code>
      | <code>input</code>}',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '1.2',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>RegExp.</code>{<code>$`</code> | <code>leftContext</code>}',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '{<code>RegExp</code> | <code><var>reArray</var></code>}<code>.index</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>RegExp.prototype.compile(<var>&hellip;</var>)</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>RegExp.prototype.exec(<var>&hellip;</var>)</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>RegExp.prototype.global</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.2',
        'jscript' => '5.5'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>RegExp.prototype.ignoreCase</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.2',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>RegExp.prototype.multiline</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.2',
        'jscript' => '5.5'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>RegExp.prototype.source</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="s" id="s"></a><code>sbyte</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code><a href="javascript:void(alert(ScriptEngine()))">ScriptEngine</a>()</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code><a
        href="javascript:void(alert(ScriptEngineBuildVersion()))"
      >ScriptEngineBuildVersion</a>()</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code><a
        href="javascript:void(alert(ScriptEngineMajorVersion()))"
      >ScriptEngineMajorVersion</a>()</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code><a
        href="javascript:void(alert(ScriptEngineMinorVersion()))"
      >ScriptEngineMinorVersion</a>()</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>@set</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>short</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '7.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a href="#opNotEqual" title="!==">Strict Not Equal/Nonidentity
      operator</a>'
    )),
      
    new ScriptFeature(array(
      'content' => '<code>String.prototype</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => '!!getFeature(_global, "String", "prototype")',
        'javascript' => array('assumed' => '1.1'),
        'jscript'    => array('2.0'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>String.fromCharCode(<var title="unsigned integer">uint</var>)</code>',
      'versions' => array(
        '' => "String.fromCharCode(0x20AC) == '€'",
        'ecmascript' => 1,
        'javascript' => array(1.2, 'tested' => 1.3),
        'jscript'    => array('3.0', 'tested' => '5.1.5010'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '4.3.2'),
        'opera'      => array('tested' => '5.02',
          'comment' => '5.02 does not support Unicode')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>String.prototype.charCodeAt(<var title="unsigned integer">uint</var>)</code>',
      'versions' => array(
        '' => "'x'.charCodeAt(0) == 120",
        'ecmascript' => array(1, 'generic' => true),
        'javascript' => array(1.2, 'tested' => 1.3),
        'jscript'    => array('3.0', 'tested' => '5.1.5010'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '4.3.2'),
        'opera'      => array('tested' => '5.02')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>String.prototype.concat(<var>&hellip;</var>)</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>String.prototype.localeCompare(<var>string</var>)</code>',
      'versions' => array(
        '' => '"isMethod(String, \"prototype\", \"localeCompare\")"
              + "&& \"a\".localeCompare(\"ä\") <= 0"',
        'ecmascript' => array(3, 'generic' => true),
        'javascript' => array('tested' => '1.8.1'),
        'jscript'    => array('5.5', 'tested' => '5.5.6330'),
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '4.3.2'),
        'opera'      => array('tested' => '10.01')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>String.prototype.match(<var>RegExp</var>)</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => array(1.2, 'tested' => 1.3),
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>String.prototype.replace(<var>string|RegExp</var>, <var>string</var>)</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.2',
        'jscript' => '1.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>String.prototype.replace(<var>string|RegExp</var>, <var>Function</var>)</code>',
      'versions' => array(
        'ecmascript' => 3,
        'javascript' => array('tested' => 1.3),
        'jscript' => array('tested' => '5.5.6330'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>String.prototype.search(<var>RegExp</var>)</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>String.prototype.slice(<var>&hellip;</var>)</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '1.0',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>String.prototype.split(<var>&hellip;</var>)</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.1',
        'jscript' => '3.0'
      )
    )),

    new ScriptFeature(array(
      'content' => '<code>String.prototype.substr(<var>start</var></code>[<code>, <var>length</var></code>]<code>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array('1.0', 'tested' => '1.8.1'),
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>String.prototype.trim()</code>',
      'versions' => array(
        '' => "isMethod(String.prototype, 'trim')
               && ' x '.trim().length == 1",
        'ecmascript' => '-',
        'javascript' => array('1.8.1', 'tested' => '1.8.1'),
        'jscript'    => '-',
        'jsc'        => array('tested' => '-'),
        'kjs'        => '-',
        'opera'      => '-'
      ),
    )),
    
    new ScriptFeature(array(
      'content' => '<code><var>string</var>[<var title="unsigned integer">uint</var>]</code>',
      'title' => 'String subscripting',
      'versions' => array(
        '' => "'x'[0] == 'x'",
        'ecmascript' => '-',
        'javascript' => array('1.0', 'tested' => '1.3'),
        'jscript'    => '-',
        'jsc'        => array('tested' => '525.13'),
        'kjs'        => array('tested' => '4.3.2'),
        'opera'      => array('tested' => '10.01')
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="switch" id="switch"><code>switch&nbsp;(<var>expression</var>)&nbsp;{
      case&nbsp;<var>value</var>:&nbsp;<var>statements</var>;&nbsp;</code>[<code>break;</code>]
      <var>&hellip;</var> <code>default:&nbsp;<var>statements</var>;&nbsp;</code>[<code>break;</code>]<code>&nbsp;}</code></a>',
      'versions' => array(
        'javascript' => array(1.2,
          'urn' => 'js15ref:Statements:switch'),
        'jscript' => array('3.0',
          'urn' => 'msdn:jscript7/html/jsstmswitch.asp'),
        'ecmascript' => 3
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="t" id="t"></a><a name="throw" id="throw"><code>throw&nbsp;<var>expression</var></code></a>',
     'versions' => array(
        'javascript' => array(1.4,
          'urn' => 'js15ref:Statements:throw'),
        'jscript' => array('tested' => '5.1.5010'),
        'ecmascript' => 3
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="try" id="try"><code>try&nbsp;{&nbsp;</code>[<code><var>statements</var></code>]&nbsp;<code>}<br>
        catch&nbsp;(<var>identifier</var>)&nbsp;{&nbsp;</code>[<code><var>statements</var></code>]&nbsp;<code>}</code></a>',
      'versions' => array(
        'javascript' => array(1.4,
          'urn' => 'js15ref:Statements:try...catch'),
        'jscript' => array('tested' => '5.1.5010',
          'urn' => 'msdn:jscript7/html/jsstmtrycatch.asp'),
        'ecmascript' => 3
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>try&nbsp;{&nbsp;</code>[<code><var>statements</var></code>]<code>&nbsp;}<br>
      finally&nbsp;{&nbsp;</code>[<code><var>statements</var></code>]<code>&nbsp;}</code>',
      'versions' => array(
        'ecmascript' => 3,
        'javascript' => 1.4,
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>try&nbsp;{&nbsp;</code>[<code><var>statements</var></code>]<code>&nbsp;}<br>
      catch&nbsp;(<var>identifier</var>)&nbsp;{&nbsp;</code>[<code><var>statements</var></code>]<code>&nbsp;}<br>
      finally&nbsp;{&nbsp;</code>[<code><var>statements</var></code>]<code>&nbsp;}</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.4',
        'jscript' => '5.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>try&nbsp;{</code>&nbsp;[<code><var>statements</var></code>]<code>&nbsp;}<br>
      catch&nbsp;(<var>identifier</var>&nbsp;if&nbsp;<var>expression</var>)&nbsp;{&nbsp;</code>[<code><var>statements</var></code>]&nbsp;<code>}</code><br>
      [<code>catch&nbsp;(<var>identifier</var>)&nbsp;{&nbsp;</code>[<code><var>statements</var></code>]<code>&nbsp;}</code>]<br>
      [<code>finally&nbsp;{&nbsp;</code>[<code><var>statements</var></code>]<code>&nbsp;}</code>]',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '1.5',
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>typeof <var>expression</var></code>',
      'anchor' => 'typeof',
      'versions' => array(
        'ecmascript' => 1,
        'javascript' => 1.1,
        'jscript' => '1.0',
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>undefined</code>',
      'anchors' => array('u', 'undefined'),
      'versions' => array(
        'ecmascript' => 1,
        'javascript' => 1.3,
        'jscript' => 5.5,
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>VBArray.prototype.dimensions()</code>',
      'anchor' => 'v',
      'versions' => array(
        'javascript' => '-',
        'jscript' => '3.0',
        'ecmascript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>VBArray.prototype.getItem(<var>&hellip;</var>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>VBArray.prototype.lbound(<var>&hellip;</var>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '-',
        'jscript' => '3.0'
      )
    )),
    
    
    
    new ScriptFeature(array(
      'content' => '<a name="w" id="w"></a><code>window</code>',
      'versions' => array(
        'javascript' => '<a
        href="http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html"
      >1.0</a><span class="tooltip">**<span><span>; </span>removed in <a
        href="#javascript"
      >1.4</a>; <a
        href="http://developer.mozilla.org/en/docs/DOM:window"
      >Gecko&nbsp;DOM feature</a> since <a href="#javascript">1.5</a></span></span>',
        'jscript' => '-',
        'ecmascript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>window.setInterval(<var>string</var>, <var>msec</var>)</code>',
      'versions' => array(
          'ecmascript' => '-',
          'javascript' => '<a
        href="http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html#1203669"
      >1.2</a><span class="tooltip">**<span><span>; </span>removed in <a
        href="#javascript"
      >1.4</a>; <a
        href="http://developer.mozilla.org/en/docs/DOM:window.setInterval"
      >Gecko&nbsp;DOM feature</a> since <a href="#javascript">1.5</a></span></span>',
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>window.setInterval(<var>functionReference</var>, <var>msec</var></code>[<code>,
      <var>arg1</var></code>[<code>, <var>&hellip;</var>, <var>argN</var></code>]]<code>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '1.2<span class="tooltip">**<span><span>; </span>removed in
      1.4; <a
        href="http://developer.mozilla.org/en/docs/DOM:window.setInterval"
      >Gecko&nbsp;DOM feature</a> since <a href="#javascript">1.5</a></span></span>',
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>window.setTimeout(<var>string</var>, <var>msec</var>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '<a
        href="http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html#1203758"
      >1.0</a><span class="tooltip">**<span><span>; </span>removed in <a
        href="#javascript"
      >1.4</a>; <a
        href="http://developer.mozilla.org/en/docs/DOM:window.setTimeout"
      >Gecko&nbsp;DOM feature</a> since <a href="#javascript">1.5</a></span></span>',
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>window.setTimeout(<var>functionReference</var>, <var>msec</var></code>[<code>,
      <var>arg1</var></code>[<code>, <var>&hellip;</var>, <var>argN</var></code>]]<code>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.2,
          'urn' => 'http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html#1203758',
          'tooltip' => '<span class="tooltip">**<span><span>; </span>removed in
      1.4; <a
        href="http://developer.mozilla.org/en/docs/DOM:window.setTimeout"
      >Gecko&nbsp;DOM feature</a> since <a href="#javascript">1.5</a></span></span>'),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'title' => 'Generator expression',
      'content' => '<code title="Generator expression">yield <var>expression</var></code><sup><a href="#fn-decl-ver">V</a></sup>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Generators'),
        'jscript' => '-' ) )),
  ),
));

?>