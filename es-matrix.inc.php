<?php

require_once 'ScriptFeature.php';

$scriptEngineTest = <<<HTML
                  <ul>
                    <li>This user agent:
                      <script type="text/javascript">
                        document.write('<p><b>' + navigator.userAgent + '<\/b><\/p>');
                      </script>
                      <noscript>
                        <p>{$_SERVER['HTTP_USER_AGENT']}</p>
                      </noscript>
                    </li>
    
                    <li><a name="script-engine-test" id="script-engine-test"
                      >This ECMAScript implementation</a><script type="text/javascript">
                        var
                          bCanDetect = isMethod(this, "ScriptEngine"),
                      
                          /* No array or loop here for backwards compatibility */
                          out = "";
                     
                        if (bCanDetect)
                        {
                          out += ":<p><b>" + ScriptEngine();
  
                          if (isMethod(this, "ScriptEngineMajorVersion"))
                          {
                            out += " " + ScriptEngineMajorVersion();
  
                            if (isMethod(this, "ScriptEngineMinorVersion"))
                            {
                              out += "." + ScriptEngineMinorVersion();
  
                              if (isMethod(this, "ScriptEngineBuildVersion"))
                              {
                                out += "." + ScriptEngineBuildVersion();
                              }
                            }
                          }
  
                          out += "<\/b><\/p>";
                        }
                        else
                        {
                          out = " cannot be detected directly.";
  
                          if (typeof navigator != "undefined")
                          {
                            var inferVersion = function (version, versionMap, fallback) {
                              function gte(v1, v2)
                              {
																v1 = v1.split(".");
																v2 = v2.split(".");
																for (var i = 0, len = v1.length; i < len; ++i)
																{
																  if (parseInt(v1[i], 10) < parseInt(v2[i], 10))
																  {
																    return false;
																  }
																}
																
																return true;
															}
															
                              var s = "";
                              
                              for (var i = versionMap.length; i--;)
                              {
                                var mapping = versionMap[i];
                                if (gte(version, mapping[0]))
                                {
                                  s = mapping[1];
                                  break;
                                }
                              }

                              if (!s && fallback)
                              {
                                s = fallback;
                              }

                              return s;
                            };
                            
                            out += " Inference suggests it is<p><b>";
  
                            var ua = navigator.userAgent || "";
      
                            if (typeof window != "undefined"
                                && getFeature(window, "opera"))
                            {
                              out += "Opera ECMAScript";
                            }
                            else if (ua.indexOf("Konqueror") > -1)
                            {
                              out += "KJS (Konqueror JavaScript)";
                            }
                            else if (ua.indexOf("WebKit") > -1)
                            {
                              var m = null;
                              
                              if (isMethod(ua, "match"))
                              {
                                if (ua.indexOf("Chrome") > -1)
                                {
                                  m = ua.match(/\bChrome\/(\d+\.\d+(\.\d+)?)\b/);

                                  if (m) out += " at least";

                                  out += " Google V8";
                                  
                                  if (m)
                                  {
                                    var
                                      s = inferVersion(m[1],
                                        [
                                          [ "2.0.172", "0.4"],
                                          [ "3.0.195", "1.2"],
                                          [ "4.0.249", "1.3"],
                                          [ "5.0.375", "2.1"],
                                          [ "6.0.472", "2.2"],
                                          [ "7.0.517", "2.3.11.22"],
                                          [ "8.0.552", "2.4.9.19"],
                                          [ "9.0.597", "2.5.9.6"],
                                          ["10.0.648", "3.0.12.30"],
                                          ["11.0.696", "3.1.8.16"],
                                          ["12.0.742", "3.2.10.21"],
                                          ["13.0.782", "3.3.10.17"],
                                          ["14.0.835", "3.4.14.2"]
                                        ],
                                        "0.3");

                                    if (s) out += " " + s;
                                  }
                                }
                                else
                                {
                                  out += "Apple JavaScriptCore";
  
                                  m = ua.match(/\bAppleWebKit\/(\d+\.\d+(\.\d+)*)\b/);

                                  if (m) out += " " + m[1];
                                }
                              }
                            }
                            else if (typeof netscape != "undefined" || ua.indexOf("Gecko") > -1)
                            {
                              m = null;
                              
                              if (isMethod(ua, "match"))
                              {
                                m = ua.match(/\brv:(\d+\.\d+(\.\d+)*)\b/);
                              }
                             
                              if (m) out += " at least";
                            
                              out += " Netscape/Mozilla.org JavaScript&#8482";
  
                              if (m)
                              {
                                s = inferVersion(m[1],
                                  [
																		["0.6",   "1.5"],
                                    ["1.8",   "1.6"],
                                    ["1.8.1", "1.7"],
                                    ["1.9",   "1.8"],
                                    ["1.9.1", "1.8.1"],
                                    ["1.9.2", "1.8.2"],
                                  ]);
  
                                if (s) out += " " + s;
                              }
                            }
                          
                            out += "<\/b><\/p>but I could be wrong.";
                          }
                        }
  
                        document.write(out);
                      </script>
                    </li>
                  </ul>
HTML;

// $testcase = isset($_REQUEST['test']) && $_REQUEST['test'] === '1';
$testcase = true;

$features = new FeatureList(array(
  'versions' => array(
    'ecmascript' => '<a href="#ecmascript">ECMAScript</a>',
    /* FIXME: Need late evaluation here because of repetition */
    ''           => <<<HTML
This <abbr title="implementation">impl.</abbr>{$footnotes->add('this-impl', '', $scriptEngineTest, '')}<!--<br>
<input type="submit" name="submitResults" value="Submit results">-->
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
    'javascript' => '1.5',
    'jscript'    => '5.6',
    'v8'         => '2.5.9.6',
    'jsc'        => '533.17.8',
    'opera'      => '6.06',
    'kjs'        => '3.5.9'
  ),

  'urns' => array(
    'mdc'     => 'https://developer.mozilla.org/en/',
    'js15ref' => 'mdc:Core_JavaScript_1.5_Reference/',
    'msdn'    => 'http://msdn.microsoft.com/en-us/library/',
    'es3'     => 'http://www.mozilla.org/js/language/E262-3.pdf'),

  'testcase' => $testcase,
    
  'items' => array(
    new ScriptFeature(array(
      'anchors'    => array('!', 'opNotEqual'),
      'title'      => 'Strict Not Equal/Nonidentity operator',
      'content'    => '<code>!==</code>',
      'versions'   => array(
        'ecmascript' => array(3,
          'urn' => 'es3:#page=74',
          'section' => '11.9.5'),
        ''           => '"1 !== \"1\""',
        'javascript' => array('1.3',
          'urn'    => 'js15ref:Operators:Comparison_Operators',
          'tested' => true),
        'jscript'    => array('1.0',
          'tested' => '5.1.5010',
          'urn' => 'msdn:ky6fyhws%28VS.85%29.aspx'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '412.6.2'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('3.5.9', 'tested' => true)
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>&quot;\u<var>hhhh</var>&quot; : string</code>',
      'title' => 'Unicode escape sequence in String literal',
      'versions' => array(
        'ecmascript' => array(1,
          'section' => '7.7.4/7.8.4'),
        ''           => '"\\u20AC" == "€"',
        'javascript' => 1.3,
        'jscript'    => array('3.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '6.06'),
        'kjs'        => array('tested' => '4.3.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => getTestLink(
        "alert('The following should be in one line:\\n\\nfoo\\\nbar')",
        '&quot;<var>foo</var>\<br><var>bar</var>&quot; : string'),
      'title' => 'Escaped newline in String literal',
      'versions' => array(
        'ecmascript' => array(5,
          'section' => '7.8.4'),
        'javascript' => array('', 'tested' => '1.8.1'),
        'jscript'    => array('', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('', 'tested' => '525.13'),
        'opera'      => array('tested' => '-',
          'footnote' => $footnotes->add('esc-newline-opera', '',
            'Opera 5.02 to 7.02 read escaped newline')),
        'kjs'        => array('', 'tested' => '4.3.2'),
      )
    )),
    
    new ScriptFeature(array(
      'title'      => 'Unary plus (converts to Number)',
      'content'    => getTestLink(
        'window.alert(+"042")',
        '+<var>expression</var> : number'),
      'versions' => array(
        'ecmascript' => 1,
        '' => '"+\'42\' == 42"',
        'javascript' => array('1.3',      'tested' => true),
        'jscript'    => array('3.1.3510', 'tested' => true),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('3.5.9', 'tested' => true),
      )
    )),
    
    new ScriptFeature(array(
      'title'      => 'RegExp literal with unescaped forward slash in character class',
      'content'    => '<code>/[/]/ :&nbsp;RegExp</code>',
      'versions'   => array(
        'ecmascript' => array(5, 'section' => '7.8.5'),
        ''           => '"\'/\'.match(/[/]/).length == 1"',
  			'javascript' => array('tested' => '1.5'),
        'jscript'    => array('tested' => '5.1.5010'),
        'v8'         => array('tested' => '2.5.9.6'),
        'jsc'        => array('tested' => '531.22.7'),
        'opera'      => array('tested' => '7.02'),
        'kjs'        => array('tested' => '4.4.5'),
      )
    )),
    
    new ScriptFeature(array(
      'title'      => 'RegExp literal with empty negated character range',
      'content'    => '<code>/[^]/ :&nbsp;RegExp</code>',
      'versions'   => array(
        'ecmascript' => 3,
        ''           => '"\'\\\\n\'.match(/[^]/).length == 1"',
    		'javascript' => array('tested' => '1.5'),
        'jscript'    => array('tested' => '-'),
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '530.17'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.3'),
      )
    )),
    
    new ScriptFeature(array(
      'title'      => 'RegExp literal with only optional global and case-insensitive modifier',
      'content'    => '<code>/<var>&hellip;</var>/</code>[<code>g</code>][<code>i</code>]
        <code>: RegExp</code>',
      'versions'   => array(
        'ecmascript' => '-',
        ''           => '"\'aA\'.match(/a/gi).length == 2"',
        'javascript' => array('1.2',
          'urn'    => 'js15ref:Global_Objects:RegExp',
          'tested' => true),
        'jscript'    => array('3.1.3510',
          'urn'    => 'msdn:jscript7/html/jsobjregexpression.asp',
          'tested' => true),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('3.5.9', 'tested' => true),
      )
    )),
    
    new ScriptFeature(array(
      'title'      => 'RegExp literal with optional multiline modifier',
      'content'    => '<code>/<var>&hellip;</var>/</code>'
        . '[<code>g</code>][<code>i</code>][<code>m</code>]'
        . '<code>: RegExp</code>',
      'versions'   => array(
        'ecmascript' => 3,
        ''           => '"\'a\\\\nA\'.match(/^a$/gim).length == 2"',
        'javascript' => array('1.5', 'tested' => true),
        'jscript'    => array('5.5.6330', 'tested' => true),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
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
        'opera'      => array('tested' => '-'),
        'kjs'       => '-',
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
        'opera'      => array('tested' => '7.02'),
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
        'opera'      => array('tested' => '7.02'),
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
        'opera'      => array('tested' => '7.02'),
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
        'opera'      => array('tested' => '7.02'),
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
        'opera'      => array('tested' => '6.06'),
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
        'opera'      => array('tested' => '5.02'),
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
        'opera'      => array('tested' => '-'),
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
        'javascript' => array('tested'  => '1.0',
          'footnote' => $footnotes->add('equals-JavaScript', '',
            'deprecated since 1.4 <em>for comparison of two
             <code>JSObject</code> objects</em>; use the
             <code>JSObject<span class="punct">.</span>equals</code>
             method instead')),
        'jscript'    => array('1.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '3.5.9'),
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
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.3.2'),
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
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.3.4'),
      )
    )),
    
    new ScriptFeature(array(
      'title' => 'Array initializer with trailing comma',
      'content' => '<code>[<var>value</var>,&nbsp;] : Array</code>',
      'versions' => array(
        'ecmascript' => 3,
        ''           => '"[42,].length == 1"',
        'javascript' => 1.3,
        'jscript'    => array('', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '7.02',
          'footnote' => $footnotes->add('array-init-opera', '',
            '5.02 and 6.06 show length 2, should be 1')),
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
        [<code>if (<var>condition</var>)</code>]<code>]
        :&nbsp;Array</code>
HTML
      , 'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'mdc:docs/New_in_JavaScript_1.7#Array_comprehensions',
          'footnote' => $footnotes->add('decl-ver', 'V',
            'Version needs to be declared in order to use this feature')),
        'jscript'    => '-',
        'v8'         => array('tested' => '-'),
        'jsc'        => '-',
        'opera'      => array('tested' => '-'),
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
        'v8'         => array('tested' => '-'),
        'jsc'        => '-',
        'opera'      => array('tested' => '-'),
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
        '' => '"({a: \'b\'}).a == \'b\'"',
        'ecmascript' => 3,
        'javascript' => array(1.3, 'tested' => 1.3),
        'jscript'    => array('3.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
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
        'opera'      => array('tested' => '-'),
        'kjs'        => array('tested' => '4.3.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>abstract</code>',
      'anchors' => array('a'),
      'versions' => array(
        'javascript' => '2.0',
        'jscript'    => '7.0',
        'v8'         => array('tested' => '-'),
        'ecmascript' => 4
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>new ActiveXObject("<var>serverName</var>.<var>typeName</var>"</code>[<code>,
        <var>location</var> : String</code>]<code>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        ''           => 'isMethod(_global, "ActiveXObject")',
        'javascript' => '-',
        'jscript'    => '3.0',
        'v8'         => array('tested' => '-'),
        'opera'      => array('tested' => '-'),
      )
    )),

    new ScriptFeature(array(
      'content' => '<code>arguments</code>',
      'anchors' => array('arguments'),
      'versions' => array(
        'ecmascript' => 1,
        ''           => '"function f() { return typeof arguments != \'undefined\' && arguments; };"
                         + " var a = f(); a && typeof a != \'undefined\'"',
        'javascript' => array(1.1,
          'urn' => 'js15ref:Functions:arguments'),
        'jscript'    => array('1.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
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
        'jscript'    => array('3.0*', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.3.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="arguments.caller" id="arguments.caller"><code>arguments.caller
        : Function|null</code></a>',
      'versions' => array(
        'ecmascript' => '-',
        ''           => '"function f1() { return typeof arguments != \'undefined\' && arguments.caller; };"
                         + "function f2() { return f1(); };"
                         + "f2() == f2"',
        'javascript' => array('1.1',
          'footnote' => $footnotes->add('arguments.caller-JS1.3', '',
                          'deprecated since 1.3')
        ),
        'jscript'    => array('-',
          'footnote' => $footnotes->add('arguments.caller-JScript', '',
                          'see&nbsp;<a href="#Function.prototype.caller"
                           ><code>Function.prototype.caller</code></a>')
        ),
        'v8'         => array('tested' => '-'),
        'jsc'        => array('tested' => '-'),
        'opera'      => array('tested' => '-'),
        'kjs'        => array('tested' => '-'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="arguments.length" id="arguments.length"><code>arguments.length : number|int</code></a>',
      'versions' => array(
        'ecmascript' => '1',
        ''           => '"function f() { return typeof arguments != \'undefined\' && arguments; };"
                         + " var a = f(); a && typeof a != \'undefined\' && typeof a.length == \'number\'"',
        'javascript' => '1.1',
        'jscript'    => array('5.5', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '1.3'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.3.4'),
      )
    )),

    new ScriptFeature(array(
      'title' => 'Array constructor/factory',
      'content' => '<code title="Array constructor/factory">Array(<var>&hellip;</var>)</code>',
      'versions' => array(
        'ecmascript' => '1',
        ''           => 'isMethod(_global, "Array") && Array(2).length == 2',
        'javascript' => '1.1',
        'jscript'    => '2.0',
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.every(<var>iterable</var>,
        <var>callback</var> : Function) : boolean</code>',
      'versions' => array(
        'ecmascript' => '-',
        ''           => 'isMethod(_global, "Array", "every")',
        'javascript' => array(1.6,
          'urn' => 'js15ref:Global_Objects/Array/every'),
        'jscript'    => '-',
        'v8'         => array('tested' => '-'),
        'opera'      => array('tested' => '-'),
        'kjs'        => array('tested' => '-'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.isArray(<var>arg</var>) : boolean</code>',
      'versions' => array(
        'ecmascript' => array('5',
          'section' => '15.4.3.2'),
        ''           => 'isMethod(_global, "Array", "isArray")',
        'javascript' => '',
        'jscript'    => '',
        'v8'         => array('tested' => '2.1'),
        'opera'      => '',
        'kjs'        => array('tested' => '-'),
        )
    )),
    
    new ScriptFeature(array(
      'content' => '<code><var>array</var>.length :&nbsp;number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.1',
        'jscript' => ''
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.some(<var>iterable</var>,
        <var>callback</var> : Function) : boolean</code>',
      'versions' => array(
        'ecmascript' => '-',
        ''           => 'isMethod(_global, "Array", "some")',
        'javascript' => '1.6',
        'jscript' => '-',
        'v8'         => array('tested' => '-'),
        'opera'      => array('tested' => '-'),
        'kjs'        => array('tested' => '-'),
        )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype : Array</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => '!!getFeature(_global, "Array", "prototype")',
        'javascript' => array('assumed' => '1.1'),
        'jscript'    => array('2.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.concat(</code>[<code><var>item1</var></code>[<code>,
        <var>item2</var></code>[<code>, <var>&hellip;</var></code>]]]<code>)
        : Array</code>',
      'versions' => array(
        'ecmascript' => '3',
        ''           => 'isMethod(_global, "Array", "prototype", "concat")',
        'javascript' => '1.2',
        'jscript'    => '3.0',
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.constructor : Array</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => 'getFeature(_global, "Array", "prototype", "constructor") == getFeature(_global, "Array")',
        'javascript' => array('1.1'),
        'jscript'    => '',
        'v8'         => array('tested' => '2.1'),
        'opera'      => '',
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.every(<var>callback</var>
        : Function</code>[<code>, <var>thisValue</var></code>]<code>)
        : boolean</code>',
      'versions' => array(
        'ecmascript' => array('5',
          'section' => '15.4.4.16'),
        ''           => 'isMethod(_global, "Array", "prototype", "every")',
        'javascript' => '1.6',
        'jscript'    => '-',
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '-'),
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.filter(<var>callback</var>
        :&nbsp;Function</code>[<code>, <var>thisArg</var>
        :&nbsp;Object</code>]<code>) :&nbsp;number|int</code>',
      'versions' => array(
        'ecmascript' => array('5',
          'section' => '15.4.4.20'),
        ''           => 'isMethod(_global, "Array", "prototype", "filter")',
        'javascript' => '1.6',
        'jscript'    => '',
        'v8'         => array('tested' => '2.1'),
        'opera'      => '',
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.forEach(<var>callback</var>
        :&nbsp;Function</code>[<code>, <var>thisArg</var>
        :&nbsp;Object</code>]<code>) :&nbsp;number|int</code>',
      'versions' => array(
        'ecmascript' => array('5',
          'section' => '15.4.4.18'),
        ''           => 'isMethod(_global, "Array", "prototype", "forEach")',
        'javascript' => '1.6',
        'jscript'    => '',
        'v8'         => array('tested' => '2.1'),
        'opera'      => '',
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.indexOf(<var>searchElement</var></code>[<code>,
        <var>fromIndex</var> : Number|int</code>]<code>) : number|int</code>',
      'versions' => array(
        'ecmascript' => array('5',
          'section' => '15.4.4.14'),
        ''           => 'isMethod(_global, "Array", "prototype", "indexOf")',
        'javascript' => '1.6',
        'jscript'    => '-',
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '-'),
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.join(<var>separator</var> : String)
        : string</code>',
      'versions' => array(
        'ecmascript' => '1',
        ''           => '"var a; isMethod(_global, \'Array\', \'prototype\', \'join\')"
                         + " && (a = new Array(\'1\', \'2\')).join() == \'1,2\'"
                         + " && a.join(\'|\') == \'1|2\'"',
        'javascript' => '1.1',
        'jscript'    => '2.0',
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.lastIndexOf(<var>searchElement</var></code>[<code>,
        <var>fromIndex</var> : Number|int</code>]<code>) : number|int</code>',
      'versions' => array(
        'ecmascript' => array('5',
          'section' => '15.4.4.15'),
        ''           => 'isMethod(_global, "Array", "prototype", "lastIndexOf")',
        'javascript' => '1.6',
        'jscript'    => '',
        'v8'         => array('tested' => '2.1'),
        'opera'      => '',
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.length : number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        ''           => '"var a = getFeature(_global, \'Array\', \'prototype\');"
                        + " a && typeof a.length == \'number\'"
                        + " && (new Array(\'1\', \'2\')).length == 2"',
        'javascript' => '1.1',
        'jscript'    => '2.0',
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.map(<var>callback</var>
        :&nbsp;Function</code>[<code>, <var>thisArg</var>
        :&nbsp;Object</code>]<code>) :&nbsp;number|int</code>',
      'versions' => array(
        'ecmascript' => array('5',
          'section' => '15.4.4.19'),
        ''           => 'isMethod(_global, "Array", "prototype", "map")
                         && !/jsx/.test(Array.prototype.map)',
        'javascript' => '1.6',
        'jscript'    => array('9.0',
          'footnote' => $footnotes->add('std-doc-only', '',
            'Only in standards document mode')
        ),
        'v8'         => array('tested' => '2.1'),
        'opera'      => '',
        'kjs'        => '',
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.pop()</code>',
      'versions' => array(
        'ecmascript' => '3',
        ''           => '"var a; isMethod(_global, \'Array\', \'prototype\', \'pop\')"
                        + " && (a = new Array(\'1\', \'2\')).pop() == \'2\'"
                        + " && typeof a[1] == \'undefined\'"',
        'javascript' => '1.2',
        'jscript'    => '5.5',
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.push(</code>[<code><var>item1</var></code>[<code>,
        <var>item2</var></code>[<code>,
        <var>&hellip;</var></code>]]]<code>) : number|int</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => array('1.2',
          'footnote' => $footnotes->add('push-return', '',
            'Since 1.3: returns the new length of the array rather than the last element added to the array.'
          )),
        'jscript'    => '5.5',
        'opera'      => array('tested' => '5.02'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.reduce(<var>callback</var>
        :&nbsp;Function</code>[<code>, <var>initialValue</var></code>]<code>) : any</code>',
      'versions' => array(
        'ecmascript' => array('5',
          'section' => '15.4.4.21'),
        'javascript' => '1.8',
        'jscript'    => '',
        'opera'      => '',
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.reduceRight(<var>callback</var>
        :&nbsp;Function</code>[<code>, <var>initialValue</var></code>]<code>) : any</code>',
      'versions' => array(
        'ecmascript' => array('5',
          'section' => '15.4.4.22'),
        'javascript' => '1.8',
        'jscript'    => '',
        'opera'      => '',
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.reverse() : Array</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.1',
        'jscript'    => '2.0',
        'opera'      => array('tested' => '5.02'),
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.shift()</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.2',
        'jscript'    => '5.5',
        'opera'      => array('tested' => '5.02'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.slice(<var>start</var>
        :&nbsp;Number|int</code>[<code>,
        <var>end</var> : Number|int</code>]<code>) : Array</code>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.2',
        'jscript'    => '3.0',
        'opera'      => array('tested' => '5.02',
          'footnote' => $footnotes->add('slice-opera', '',
            'Opera 6.06 does not support negative values for <var>start</var>')),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.some(<var>callback</var>
        :&nbsp;Function</code>[<code>,
        <var>thisValue</var></code>]<code>) : boolean</code>',
      'versions' => array(
        'ecmascript' => array('5',
          'section' => '15.4.4.17'),
        'javascript' => '1.6',
        'jscript'    => '-',
        'opera'      => array('tested' => '-'),
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.sort(</code>[<code><var>comparator</var>
        : Function</code>]<code>) : Array</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => array('1.1',
          'footnote' =>
              $footnotes->add('sort-JS1.1', '',
                '1.1: Does not work on some platforms; converts undefined elements to null')
            . $footnotes->add('sort-JS1.2', '',
                '1.2: Sorts undefined elements to the end of the array')
            . $footnotes->add('sort-JS1.8', '', '1.8: Stable sort')
        ),
        'jscript'    => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a
        href="javascript:a=new(Array(1,2,3));alert(a.splice(1,1,4));alert(a);"
        onclick="var a = new Array(1,2,3); alert(a.splice(1,1,4)); return !!alert(a);"
      ><code>Array.prototype.splice(<var>start</var> : Number|int,
        <var>deleteCount</var> : Number|int</code>[<code>,
        <var>item1</var></code>[<code>, <var>item2</var></code>[<code>,
        <var>&hellip;</var></code>]]]<code>) :&nbsp;Array</code></a>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => array('1.2',
          'footnote' => $footnotes->add('slice-JS1.3', '',
            'since 1.3: returns an array containing the removed elements')
        ),
        'jscript' => array('5.5*', 'tested' => '5.5.6330'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Array.prototype.toSource() :&nbsp;string</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '1.3',
        'jscript' => '',
      )
    )),

    new ScriptFeature(array(
      'content' => '<code>Array.prototype.toString() :&nbsp;string</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.1',
        'jscript' => '',
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a href="javascript:a=new(Array(\'1\'));a.unshift(0);alert(a);"
        onclick="var a = new Array(\'1\'); a.unshift(0); return !!alert(a);"
      ><code>Array.prototype.unshift() : number|int</code></a>',
      'versions' => array(
        'ecmascript' => '3',
        'javascript' => '1.2?',
        'jscript' => '5.5'
      )
    )),

    new ScriptFeature(array(
      'content' => '<code>boolean</code>',
      'anchors' => array('b'),
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
        'jscript'    => array('2.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Boolean.prototype.toSource() :&nbsp;string</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '1.3',
        'jscript' => '',
      )
    )),

    new ScriptFeature(array(
      'content' => '<code>Boolean.prototype.toString() :&nbsp;string</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.1',
        'jscript' => '',
      )
    )),

    new ScriptFeature(array(
      'content' => '<code>Boolean.prototype.valueOf() :&nbsp;boolean</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.1',
        'jscript' => '',
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
        'jscript'    => array('2.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="d" id="d"></a><code>Date.prototype.getFullYear() : number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getMilliseconds() : number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCDate() : number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCDay() : number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCFullYear() : number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCHours() : number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCMilliseconds() : number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCMinutes() : number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCMonth() : number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.getUTCSeconds() : number|int</code>',
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
      'content' => '<code>Date.prototype.setFullYear(<var>year</var> : Number|int</code>[<code>,
        <var>month</var> : Number|int</code>[<code>,
        <var>date</var> : Number|int</code>]]<code>) :&nbsp;number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setMilliseconds(<var>Number|int</var>) : number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCDate(<var>Number|int</var>) : number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCDay(<var>Number|int</var>) : number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
      
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCFullYear(<var>year</var> :&nbsp;Number|int</code>[<code>,
        <var>month</var> :&nbsp;Number|int</code>[<code>,
        <var>date</var> :&nbsp;Number|int</code>]]<code>) :&nbsp;number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCHours(<var>hours</var> :&nbsp;Number|int</code>[<code>,
        <var>minutes</var> :&nbsp;Number|int</code>[<code>,
        <var>seconds</var> :&nbsp;Number|int</code>]]<code>) :&nbsp;number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCMilliseconds(<var>Number|int</var>) : number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCMinutes(<var>minutes</var> :&nbsp;Number|int</code>[<code>,
        <var>seconds</var> :&nbsp;Number|int</code>[<code>,
        <var>ms</var> :&nbsp;Number|int</code>]]<code>) :&nbsp;number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCMonth(<var>month</var> : Number|int</code>[<code>,
        <var>date</var> : Number|int</code>]<code>) :&nbsp;number|int</code>',
      'versions' => array(
        'ecmascript' => '1',
        'javascript' => '1.3',
        'jscript' => '3.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.setUTCSeconds(<var>seconds</var> :&nbsp;Number|int</code>[<code>,
      <var>ms</var> : Number|int</code>]<code>) :&nbsp;number|int</code>',
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
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '3.5.9'),
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
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '3.5.9'),
      )
    )),
        
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toISOString() :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toISOString")
               && "(new Date()).toISOString()"',
        'ecmascript' => 5,
        'javascript' => array('tested' => '1.8.1'),
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '-'),
        'kjs'        => array('tested' => '-'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toJSON(</code>[<code><var>key</var></code>]<code>) :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toJSON")
               && "(new Date()).toJSON()"',
        'ecmascript' => 5,
        'javascript' => array('tested' => '1.8.1'),
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '-'),
        'kjs'        => array('tested' => '-'),
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
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '3.5.9'),
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
        'v8'         => array('tested' => '-'),
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
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('525.13', 'tested' => true),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('3.5.9', 'tested' => true),
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
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '3.5.9'),
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
        'v8'         => array('tested' => '-'),
        'jsc'        => '-',
        'opera'      => array('tested' => '-'),
        'kjs'        => '-',
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
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '3.5.9'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toTimeString() :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toTimeString")
               && "(new Date()).toTimeString()"',
        'ecmascript' => 3,
        'javascript' => array('1.5', 'tested' => '1.5'),
        'jscript'    => array('tested' => '5.5.6330'),
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '3.5.9'),
      )
    )),
       
    new ScriptFeature(array(
      'content' => '<code>Date.prototype.toUTCString() :&nbsp;string</code>',
      'versions' => array(
        '' => 'isMethod(Date, "prototype", "toUTCString")
               && "(new Date()).toUTCString()"',
        'ecmascript' => 1,
        'javascript' => array('tested' => '1.3'),
        'jscript'    => array('tested' => '5.1.5010'),
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '3.5.9'),
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
        'ecmascript' => array(5,
          'section' => '12.15'),
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
      'content' => '<code>Error.prototype.number :&nbsp;number|int</code>',
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
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('3.5.9', 'tested' => true),
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
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('3.5.9', 'tested' => true),
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
        'opera'      => array('tested' => '5.02'),
       'kjs'        => array('3.5.9', 'tested' => true),
      )
    )),

    new ScriptFeature(array(
      'content' => '<code>Function.prototype :&nbsp;Function</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => '!!getFeature(_global, "Function", "prototype")',
        'javascript' => array('assumed' => '1.1'),
        'jscript'    => array('2.0', 'tested' => '5.1.5010'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '-'),
      )
    )),
    
    
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.arity :&nbsp;number|int</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => array('1.2',
          'footnote' => $footnotes->add('arity-JS1.4', '',
            'deprecated since 1.4')
        ),
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
        'javascript' => array('1.0',
          'footnote' => $footnotes->add('Function.prototype.arguments-JS1.4', '',
            'deprecated since 1.4; use
             <a href="#arguments"><code>arguments</code></a> instead')
        ),
        'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.arguments.callee :&nbsp;Function</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array('1.2',
          'footnote' => $footnotes->add('Function.prototype.arguments.callee-JS1.4',
            '', 'deprecated since 1.4; use
                <a href="#arguments.callee"><code>arguments.callee</code></a>
                instead')
        ),
        'jscript' => '5.6'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.arguments.length :&nbsp;number|int</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array('1.0',
          'footnote' => $footnotes->add('Function.prototype.arguments.length-JS1.4',
            '', 'deprecated since 1.4; use
                <a href="#arguments.length"><code>arguments.length</code></a>
                instead')
        ),
        'jscript' => ''
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.call(</code>[<code><var>thisArg</var>
        :&nbsp;Object|undefined</code>[<code>,
        <var>arg1</var></code>[,<code> <var>arg2</var>,
        <var>&hellip;</var></code>]]<code>)</code>',
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
        ''           => '"function f1() { return f1.caller; };"
                         + "function f2() { return f1(); };"
                         + "f2() == f2"',
        'javascript' => array('tested' => '1.0'),
        'jscript'    => array('2.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '522.15.5'),
        'opera'      => array('tested' => '9.62'),
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.length :&nbsp;number|int</code>',
      'versions' => array(
        'ecmascript' => '',
        'javascript' => '',
        'jscript' => '2.0'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Function.prototype.prototype : Object</code>',
      'versions' => array(
        'ecmascript' => '-',
        ''           => 'typeof Function != "undefined"
                         && getFeature(Function, "prototype", "prototype")
                         && typeof Function.prototype.prototype == "object"',
        'javascript' => array('tested' => '1.8.2',
          'footnote' => $footnotes->add('Fun-proto-JavaScript', '',
            'tested in 1.8.2 only')),
        'jscript'    => array('-',
          'footnote' => $footnotes->add('Fun-proto-JScript', '',
            'tested in 5.0 and 6.0 only, 8.x and 9.x Preview contributed by LRN')),
        'v8'         => array('tested' => '-'),
        'jsc'        => array('-',
          'footnote' => $footnotes->add('Fun-proto-JSC', '',
            'Safari 4.0.5 contributed by LRN')),
        'opera'      => array('-',
          'footnote' => $footnotes->add('Fun-proto-Opera', '',
            '9.52 contributed by LRN')),
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
      'content' => '<a name="g" id="g"></a><code><var>Generator</var>.close()</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'mdc:New_in_JavaScript_1.7#Closing_a_generator',
          'footnote' => $footnotes->add('decl-ver')),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code><var>Generator</var>.next()</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'mdc:docs/New_in_JavaScript_1.7#Generators',
          'footnote' => $footnotes->add('decl-ver')),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code><var>Generator</var>.send(<var>expression</var>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'mdc:docs/New_in_JavaScript_1.7#Resuming_a_generator_at_a_specific_point',
          'footnote' => $footnotes->add('decl-ver')),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code><var>Generator</var>.throw(<var>expression</var>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'mdc:docs/New_in_JavaScript_1.7#Exceptions_in_generators',
          'footnote' => $footnotes->add('decl-ver')),
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
        'jscript'    => array('3.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.4'),
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
          'urn' => 'mdc:docs/New_in_JavaScript_1.7#Iterators'),
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
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '-'),
        'opera'      => array('tested' => '-'),
        'kjs'        => '-',
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
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '-'),
        'opera'      => array('tested' => '-'),
        'kjs'        => '-',
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="l" id="l"></a><a name="let" id="let"><code
        title="Block scoping: let statement"
      >let&nbsp;(<var>assignment</var></code>[<code>, <var>&#8230;</var></code>]<code>)
      {&nbsp;</code>[<code><var>statements</var></code>]<code>&nbsp;}</code></a>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'mdc:docs/New_in_JavaScript_1.7#Block_scope_with_let',
          'footnote' => $footnotes->add('decl-ver')),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'title' => 'Block scoping: let expression',
      'content' => <<<HTML
        <code title="Block scoping: let expression">let&nbsp;(<var>assignment</var></code>[<code>,
        <var>&#8230;</var></code>]<code>)&nbsp;<var>expression</var></code>
HTML
      , 'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'mdc:docs/New_in_JavaScript_1.7#Block_scope_with_let',
          'footnote' => $footnotes->add('decl-ver')),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'title' => 'Block scoping: let definition',
      'content' => <<<HTML
        <code title="Block scoping: let definition">let&nbsp;<var>assignment</var></code>[<code>,
        <var>&#8230;</var></code>]
HTML
      , 'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(
          'urn' => 'mdc:docs/New_in_JavaScript_1.7#Block_scope_with_let',
          'footnote' => $footnotes->add('decl-ver')),
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
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
       'kjs'        => array('3.5.9', 'tested' => true),
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
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('3.5.9', 'tested' => true),
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
        'ecmascript' => 1,
        ''           => 'typeof NaN == "number" && isNaN(NaN)',
        'javascript' => 1.3,
        'jscript'    => array('3.0', 'tested' => '5.1.5010'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.4'),
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
        ''           => 'typeof Number != "undefined"
                         && typeof Number.NaN == "number"
                         && isNaN(Number.NaN)',
        'javascript' => '',
        'jscript'    => array('2.0', 'tested' => '5.1.5010',
          'urn' => 'msdn:jscript7/html/jspronannumber.asp'),
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '5.02'),
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
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Number.prototype.toString() :&nbsp;string</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => 'isMethod(42, "toString")',
        'javascript' => array('tested' => '1.2'),
        'jscript'    => array('tested' => '5.1.5010'),
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.4'),
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
      'content' => '<code>Object.defineProperties(<var>o</var> :&nbsp;Object,
        <var>properties</var> :&nbsp;Object)
        :&nbsp;Object</code>',
      'versions' => array(
        ''           => '"var o = new Object(),"
                        + " b = isMethod(Object, \'defineProperties\')"
                        + "   && Object.defineProperties(o, {"
                        + "        a: {"
                        + "          value: {b: \'c\'},"
                        + "          writable: false,"
                        + "          configurable: false,"
                        + "          enumerable: false"
                        + "        },"
                        + "        b: {"
                        + "          value: {c: \'d\'},"
                        + "          writable: false,"
                        + "          configurable: false,"
                        + "          enumerable: false"
                        + "        }"
                        + "      })"
                        + "   && (typeof o.a == \'object\') && o.a"
                        + "   && (o.a.b == \'c\')"
                        + "   && (o.a = 42)"
                        + "   && (o.a != 42)"
                        + "   && (typeof o.b == \'object\') && o.b"
                        + "   && (o.b.c == \'d\')"
                        + "   && (o.b = 42)"
                        + "   && (o.b != 42);"
                        + " delete o.a;"
                        + " delete o.b;"
                        + " b = b && (typeof o.a != \'undefined\')"
                        + "   && (typeof o.b != \'undefined\');"
                        + " if (b) {"
                        + "   var found = false;"
                        + "   for (var p in o)"
                        + "     if (p == \'a\' || p == \'b\')"
                        + "       { found = true; break; }"
                        + " }"
                        + " b && !found"',
            'ecmascript' => array(5,
          'section' => '15.2.3.7'),
        'javascript' => array('tested' => '-'),
        'jscript'    => array('tested' => '-'),
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '533.16'),
        'opera'      => array('tested' => '-'),
        'kjs'        => array('tested' => '-'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.defineProperty(<var>o</var> :&nbsp;Object,
        <var>property</var> :&nbsp;String, <var>attr</var> :&nbsp;Object)
        :&nbsp;Object</code>',
      'versions' => array(
        ''           => '"var o = new Object(),"
                        + " b = isMethod(Object, \'defineProperty\')"
                        + "   && Object.defineProperty(o, \'a\', {"
                        + "        value: {b: \'c\'},"
                        + "        writable: false,"
                        + "        configurable: false,"
                        + "        enumerable: false"
                        + "      })"
                        + "   && (typeof o.a == \'object\') && o.a"
                        + "   && (o.a.b == \'c\')"
                        + "   && (o.a = 42)"
                        + "   && (o.a != 42);"
                        + " delete o.a;"
                        + " b = b && (typeof o.a != \'undefined\');"
                        + " if (b)"
                        + " {"
                        + "   var found = false;"
                        + "   for (var p in o)"
                        + "     if (p == \'a\') { found = true; break; }"
                        + " }"
                        + " b && !found"',
        'ecmascript' => array(5,
          'section' => '15.2.3.6'),
        'javascript' => array('tested' => '-'),
        'jscript'    => array('tested' => '-'),
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '533.16'),
        'opera'      => array('tested' => '-'),
        'kjs'        => array('tested' => '-'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.getOwnPropertyNames(<var>o</var> :&nbsp;Object) :&nbsp;Array</code>',
      'versions' => array(
        '' => 'isMethod(Object, "getOwnPropertyNames")',
        'ecmascript' => array(5,
          'section' => '15.2.3.4'),
        'v8'         => array('tested' => 2.1),
        'opera'      => array('tested' => '-'),
        'kjs'        => array('tested' => '-'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.getPrototypeOf(<var>o</var> :&nbsp;Object) :&nbsp;Object</code>',
      'versions' => array(
        '' => 'isMethod(Object, "getPrototypeOf")',
        'ecmascript' => array(5,
          'section' => '15.2.3.2'),
            'javascript' => array('1.8.1', 'tested' => '1.8.1'),
        'jscript'    => '-',
        'v8'         => array('tested' => '2.0.6'),
        'opera'      => array('tested' => '-'),
        'kjs'        => array('tested' => '-'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.prototype :&nbsp;Object</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => '!!getFeature(_global, "Object", "prototype")',
        'javascript' => array('assumed' => '1.1'),
        'jscript'    => array('2.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
    
    
    new ScriptFeature(array(
      'content' => '<code>Object.prototype.__defineGetter__(<var>propertyName</var>
        :&nbsp;String, <var>getter</var> :&nbsp;Function)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => '1.5',
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.prototype.__defineSetter__(<var>propertyName</var>
        :&nbsp;String, <var>setter</var> :&nbsp;Function)</code>',
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
          'urn' => 'mdc:docs/New_in_JavaScript_1.7#Iterators'),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>Object.prototype.__proto__</code>',
      'versions' => array(
        'ecmascript' => '-',
        ''           => 'jsx.object._hasOwnProperty(getFeature(_global, "Object", "prototype"), "__proto__")',
        'javascript' => '1.3',
        'jscript'    => '-',
        'v8'         => array('tested' => '2.0'),
        'opera'      => array('tested' => '-'),
        'kjs'        => array('tested' => '4.4.4'),
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
        'opera'      => '',
        'kjs'        => array('3.2', 'documented' => 3.2, 'tested' => '3.5.9'),
      )
    )),

    new ScriptFeature(array(
      'content' => '<code>Object.prototype.isPrototypeOf(<var>Object</var>)
         :&nbsp;boolean</code>',
      'versions' => array(
        ''           => 'isMethod(Object.prototype, "isPrototypeOf")',
        'ecmascript' => array(3, 'section' => '15.2.4.6'),
        'javascript' => array('tested' => '1.5'),
        'jscript'    => array('tested' => '5.5'),
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.3.4'),
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
      'content' => '<code>String.fromCharCode(<var title="unsigned integer">Number|uint</var>)</code>',
      'versions' => array(
        '' => "String.fromCharCode(0x20AC) == '€'",
        'ecmascript' => 1,
        'javascript' => array(1.2, 'tested' => 1.3),
        'jscript'    => array('3.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '6.06',
          'comment' => '5.02 does not support Unicode'),
        'kjs'        => array('tested' => '4.3.2'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>String.prototype</code>',
      'versions' => array(
        'ecmascript' => 1,
        ''           => '!!getFeature(_global, "String", "prototype")',
        'javascript' => array('assumed' => '1.1'),
        'jscript'    => array('2.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '2.1'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.4.4'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>String.prototype.charCodeAt(<var title="unsigned integer">Number|uint</var>)</code>',
      'versions' => array(
        '' => "'x'.charCodeAt(0) == 120",
        'ecmascript' => array(1, 'generic' => true),
        'javascript' => array(1.2, 'tested' => 1.3),
        'jscript'    => array('3.0', 'tested' => '5.1.5010'),
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '5.02'),
        'kjs'        => array('tested' => '4.3.2'),
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
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '7.02'),
        'kjs'        => array('tested' => '4.3.2'),
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
      'content' => '<code>String.prototype.substr(<var>start</var></code>[<code>,
        <var>length</var></code>]<code>)</code>',
      'versions' => array(
        'ecmascript' => array('3',
          'section' => 'B.2.3'),
        ''           => "isMethod(String.prototype, 'substr')
                         && 'ab'.substr(-1) == 'b'",
        'javascript' => array('1.2', 'tested' => '1.2'),
        'jscript' => array('-',
          'footnote' => $footnotes->add('Str-proto-substr-JScript', '',
            'Does not support negative values'
            . ' [<a href=""'
            . ' onclick="window.alert(\'&quot;XV&quot;.substr(-1, 1) === &quot;\' + &quot;XV&quot;.substr(-1, 1) + \'&quot;\');'
            . ' return false"'
            . '>test case</a>]'
          )
        ),
        'v8'         => array('tested' => '2.1'),
        'jsc'        => array('tested' => '530.17'),
        'kjs'        => array('tested' => '4.3.4'),
        'opera'      => array('tested' => '5.02'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>String.prototype.trim()</code>',
      'versions' => array(
        '' => "isMethod(String.prototype, 'trim')
               && ' x '.trim().length == 1",
        'ecmascript' => 5,
        'javascript' => array('1.8.1', 'tested' => '1.8.1'),
        'jscript'    => '-',
        'jsc'        => array('tested' => '-'),
        'opera'      => array('tested' => '-'),
        'kjs'        => '-',
      ),
    )),
    
    new ScriptFeature(array(
      'content' => '<code><var>string</var>[<var
        >Number</var>|<var title="unsigned integer">uint</var>]</code>',
      'title' => 'String subscripting',
      'versions' => array(
        '' => "'x'[0] == 'x'",
        'ecmascript' => '-',
        'javascript' => array('1.0', 'tested' => '1.3'),
        'jscript'    => '-',
        'jsc'        => array('tested' => '525.13'),
        'opera'      => array('tested' => '-'),
        'kjs'        => array('tested' => '4.3.2'),
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<a name="switch" id="switch"><code>switch&nbsp;(<var>expression</var>)&nbsp;{
      case&nbsp;<var>value</var>:&nbsp;<var>statements</var>;&nbsp;</code>[<code>break;</code>]
      <var>&hellip;</var>
      <code>default:&nbsp;<var>statements</var>;&nbsp;</code>[<code>break;</code>]<code>&nbsp;}</code></a>',
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
          'urn' => 'msdn:4yahc5d8(VS.85).aspx'),
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
        'ecmascript' => '-',
        'javascript' => array('1.0',
          'urn' => 'http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html',
          'footnote' => $footnotes->add('window-JS1.4', '',
            'removed in <a href="#javascript">1.4</a>;
             <a href="https://developer.mozilla.org/en/docs/DOM:window"
                >Gecko&nbsp;DOM feature</a> since
                <a href="#javascript">1.5</a>')
        ),
        'jscript' => '-',
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>window.setInterval(<var>string</var>,
        <var>msec</var>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.2,
          'urn' => 'http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html#1203669',
          'footnote' => $footnotes->add('setInterval-JS1.4', '',
            'removed in <a href="#javascript">1.4</a>;
             <a href="https://developer.mozilla.org/en/docs/DOM:window.setInterval"
                >Gecko&nbsp;DOM feature</a> since <a href="#javascript">1.5</a>')
        ),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>window.setInterval(<var>functionReference</var>,
        <var>msec</var></code>[<code>, <var>arg1</var></code>[<code>,
        <var>&hellip;</var>, <var>argN</var></code>]]<code>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array('1.2',
          'footnote' => $footnotes->add('setInterval-JS1.4')
        ),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>window.setTimeout(<var>string</var>,
        <var>msec</var>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array('1.0',
          'urn' => 'http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html#1203758',
          'footnote' => $footnotes->add('setTimeout-JS1.4', '',
            'removed in <a href="#javascript">1.4</a>;
             <a href="https://developer.mozilla.org/en/docs/DOM:window.setTimeout"
                >Gecko&nbsp;DOM feature</a> since <a href="#javascript">1.5</a>')
        ),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'content' => '<code>window.setTimeout(<var>functionReference</var>,
        <var>msec</var></code>[<code>, <var>arg1</var></code>[<code>,
        <var>&hellip;</var>, <var>argN</var></code>]]<code>)</code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.2,
          'tooltip' => $footnotes->add('setTimeout-JS1.4')
        ),
        'jscript' => '-'
      )
    )),
    
    new ScriptFeature(array(
      'title' => 'Generator expression',
      'content' => '<code title="Generator expression">yield
        <var>expression</var></code>',
      'versions' => array(
        'ecmascript' => '-',
        'javascript' => array(1.7,
          'urn' => 'mdc:docs/New_in_JavaScript_1.7#Generators',
          'footnote' => $footnotes->add('decl-ver')),
        'jscript' => '-' )
    )),
  ),
));

?>
