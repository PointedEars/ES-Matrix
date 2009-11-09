<?php
  if (! isset ($start_debug))
  {
    require('../../cgi_buffer/php/prepend.php');
  }

  $modi = @filemtime(__FILE__);
  header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $modi) . ' GMT');

  // Cached resource expires in HTTP/1.0 caches 24h after last retrieval
  header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <meta http-equiv="Content-Style-Type" content="text/css">
    
    <title>ECMAScript Support Matrix</title>
    
    <link rel="stylesheet" href="/styles/tooltip.css" type="text/css">
    <link rel="stylesheet" href="../../style.css" type="text/css">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="not-ns4.css" type="text/css" media="all">
    <link rel="alternate stylesheet" href="ct.css" type="text/css" title="c't">
    <!--[if IE 7]>
      <style type="text/css">
        /* IE 7: Support for scrollable tbody is buggy */

        table>tbody.scroll {
          height: auto;
          overflow: visible;
          border-top: 1px;
          border-left-color: black;
        }
      </style>
    <![endif]-->

    <script type="text/javascript" src="../../object.js"></script>
    <script type="text/javascript" src="../../types.js"></script>
    <script type="text/javascript" src="../debug.js"></script>
    <script type="text/javascript" src="../../dhtml.js"></script>
    <script type="text/javascript" src="table.js"></script>
  </head>
  
  <body onload="alternateRows(); synhl(); initScroller();">
    <h1><a name="top" id="top"
      >ECMAScript Support Matrix</a></h1>

    <p style="text-align:left"
      >Copyright &copy; 2005&#8211;<?php echo gmdate('Y', $modi); ?>
      Thomas Lahn &lt;<a href="mailto:js@PointedEars.de"
      >js@PointedEars.de</a>&gt;</p>

    <p style="text-align:left">Last&nbsp;modified:
      <?php echo gmdate('Y-m-d\TH:i:s+00:00', $modi); ?>
      (<a href="CHANGELOG">changelog</a>)</p>

    <p style="text-align:left">Available online at
      &lt;<a href="<?php
        $s = 'http://' . $_SERVER['HTTP_HOST']
          . preg_replace('/(index\.)?[^\/]*$/', '', $_SERVER['SCRIPT_NAME']);
        echo $s;
        ?>"
        ><?php echo $s; ?></a>&gt;.</p>
    
    <?php
      if ($_SERVER['QUERY_STRING'] == 'redir')
      {
      	?><p><strong>You have been redirected here because the URI that
        was used to access this resource is obsolete, and may stop working
        in the future.  Please update your bookmarks using the link/URI above.
        If you followed a link from another site, please notify its webmaster
        about the change.</strong></p><?php
      }
    ?>

    <h2 style="margin-top:1em; padding-top:1em; border-top:1px solid black"
        ><a name="contents" id="contents">Contents</a></h2>
    
    <ul>
      <li><a href="#language-features">Language Features</a></li>
      <li><a href="#javascript">JavaScript Version Information</a></li>
      <li><a href="#jscript">JScript Version Information</a></li>
      <li><a href="#jsc">JavaScriptCore Version Information</a></li>
      <li><a href="#actionscript">ActionScript Version Information</a></li>
      <li><a href="#ecmascript">ECMAScript Compatibility</a></li>
    </ul>
  
    <h2><a name="features" id="features">Language&nbsp;Features</a></h2>

    <p>The following table lists all features of ECMAScript implementations
       that are not part of the first versions/editions of all of these
       languages, with the version/edition that introduced it; furthermore,
       information about features that have been deprecated is included.
       That means if a <em>language</em> feature is not listed here, you
       can consider it to be universally supported.</p>
      
    <p>In addition, features have been <span class="safe"><span
       class="visual">highlighted with a greenish background
       color</span></span> if this author considers them
       <em>safe</em> to use without prior feature test even when they do not
       appear to be universally supported. This assessment is mostly based on
       the fact that the versions of the implementations the features require
       can be considered obsolete because the user agents known to implement
       them can be considered obsolete. Note that this assessment is likely
       to be subject to change as more implementations are evaluated.
       If taken as a recommendation for design decisions, it should be taken
       as a light one.</p>
    
    <p>In contrast, features have been <span class="unsafe"><span
       class="visual">highlighted with a  yellowish background
       color</span></span> if this author considers them
       <em>unsafe</em>; that is, it is recommended not to use them without
       feature test and fallback, or only in a controlled environment.</p>
             
    <p><strong>The content of this table is based on what could be found
       in vendor's online documentations to date and on occasions where
       the respective features could be tested; <em>it does not claim to
       be accurate or complete</em> (please note how each feature is marked).
       Any correction/addition as to how things really are is welcome and will
       be credited where it is due.</strong></p>
    
    <h3>Thanks to:</h3>
      
    <ul>
      <li>Michael Winter &lt;<a href="mailto:m.winter@blueyonder.co.uk"
        >m.winter@blueyonder.co.uk</a>&gt; for tests with IE&nbsp;4.01
        and NN&nbsp;4.08: Message-ID&nbsp;<a
          href="http://groups.google.com/groups?as_umsgid=urctf.17012$iz3.5930@text.news.blueyonder.co.uk"
          >&lt;urctf.17012$iz3.5930@text.news.blueyonder.co.uk&gt;</a></li>
    </ul>

    <p><em>If you are using Firefox&nbsp;3.0 and the scrollable
      table body flows out of the table, you are observing
      <a href="https://bugzilla.mozilla.org/show_bug.cgi?id=423823"
         title="Bug 135236 (VERIFIED FIXED): Overflowing tbody rows render background color for overflowing rows"
         class="closed"
         >Bug&nbsp;423823</a>, fixed since <a
      href="http://www.mozilla-europe.org/en/firefox/3.0.2/releasenotes/"
      >Firefox&nbsp;3.0.2</a>.<br>
      Since this was a regression, this author deems it necessary not
      to cover it with a workaround.  Because new versions also include
      a number of <a
      href="http://www.mozilla.org/security/known-vulnerabilities/firefox30.html"
      >security fixes</a>, you are strongly recommended to <a
      href="http://www.mozilla.com/firefox/">update&nbsp;Firefox</a>.
      As an alternative, you can toggle table body scrollability.</em></p>

    <table id="features-table"
           summary="Language features and the first editions of ECMAScript or first versions of the implementations that introduced or supported them"
           >
      <thead>
        <tr>
          <th id="atoz">Feature <script type="text/javascript">
              printScrollButton();
            </script><br>
            <a href="#!">!</a>
            <?php
              for ($i = ord('a'), $max = ord('z'); $i <= $max; $i++)
              {
                $s = chr($i);
                echo '<a href="#' . $s . '">' . strtoupper($s) . '</a> ';
              }
            ?></th>
<?php
  require_once 'es-matrix.inc.php';
  $features->printHeaders();
?>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="8"><table summary="Legend">
              <tr>
                <th>Legend:</th>
                <td class="assumed">Untested assumed availability</td>
                <td>Untested documented feature</td>
                <td class="tested">Feature availability confirmed by test</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td colspan="8">* discrepancy between the vendor's documentation
            and the real implementation</td>
        </tr>
        <tr>
          <td colspan="8">? unconfirmed contribution by other people</td>
        </tr>
        <tr>
          <td colspan="8"><table summary="Footnotes">
              <tr>
                <th><sup><a href="#this-ua" name="fn-this-ua">1</a></sup></th>
                <td>
                  <ul>
                    <li>This user agent:
                      <script type="text/javascript">
                        document.write('<p><b>' + navigator.userAgent + '<\/b><\/p>');
                      </script>
                      <noscript>
                        <p><?php
                          echo $_SERVER['HTTP_USER_AGENT'];
                        ?></p>
                      </noscript></li>
                      
                    <li>This ECMAScript implementation<script type="text/javascript">
                        var
                          jsx_object = jsx.object,
                          bCanDetect = jsx_object.isMethod(null, "ScriptEngine"),
                          
                          /* No array or loop here for backwards compatibility */
                          out = "";
                         
                        if (bCanDetect)
                        {
                          out += ":<p><b>" + ScriptEngine();

                          if (jsx_object.isMethod(null, "ScriptEngineMajorVersion"))
                          {
                            out += " " + ScriptEngineMajorVersion();

                            if (jsx_object.isMethod(null, "ScriptEngineMinorVersion"))
                            {
                              out += "." + ScriptEngineMinorVersion();
  
                              if (jsx_object.isMethod(null, "ScriptEngineBuildVersion"))
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
                            out += " Inference suggests it is<p><b>";

                            var ua = navigator.userAgent || "";

                            if (typeof window != "undefined"
                                && jsx_object.getFeature(window, "opera"))
                            {
                              out += "Opera ECMAScript";
                            }
                            else if (ua.indexOf("Konqueror") > -1)
                            {
                              out += "KJS (Konqueror JavaScript)";
                            }
                            else if (ua.indexOf("WebKit") > -1)
                            {
                              out += "Apple JavaScriptCore";
                            }
                            else if (typeof netscape != "undefined" || ua.indexOf("Gecko") > -1)
                            {
                              if (jsx_object.isMethod(ua, "match"))
                              {
                                var m = ua.match(/\brv:(\d+\.\d+(\.\d+)*)\b/);
                              }
                               
                              if (m) out += " at least";
                              
                              out += " Netscape/Mozilla.org JavaScript<sup>TM<\/sup>";

                              if (m)
                              {
                                var rv = m[1];

                                if (rv >= "1.9.1")
                                {
                                  var s = "1.8.1";
                                }
                                else if (rv >= "1.9")
                                {
                                  s = "1.8";
                                }
                                else if (rv >= "1.8.1")
                                {
                                  s = "1.7";
                                }
                                else if (rv >= "1.8")
                                {
                                  s = "1.6";
                                }
                                else if (rv >= "0.6")
                                {
                                  s = "1.5";
                                }

                                if (s) out += " " + s;
                              }
                            }
                            
                            out += "<\/b><\/p>but I could be wrong.";
                          }
                        }

                        document.write(out);
                      </script></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <th><sup><a href="#generic" name="fn-generic">G</a></sup></th>
                <td>This method is intentionally specified or implemented as <em>generic</em>;
                    it does not require that its <code class="rswd">this</code> value
                    be an object of the same type.  Therefore, it can be transferred
                    to other kinds of objects for use as a method.
                </td>
              </tr>
              <tr>
                <th><sup><a href="#decl-ver" name="fn-decl-ver">V</a></sup></th>
                <td>Version needs to be declared in order to use this feature</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td colspan="8">
            <p><a name="tested" id="tested">When a feature has been marked as
               <span class="tested">tested</span>, the following
               user&nbsp;agents have been used for the tests:</a></p>
            <ul>
              <li><span title="Netscape/Mozilla.org JavaScript">JavaScript</span>
                <ul>
                  <li>Mozilla/4.78 [de] (Windows NT 5.0; U)</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.13)
                      Gecko/20060410 Firefox/1.0.8</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.12)
                      Gecko/20070508 Firefox/1.5.0.12</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14)
                      Gecko/20080404 Firefox/2.0.0.14</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.9.0.3)
                      Gecko/2008092417 Firefox/3.0.3</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.9.0.4)
                      Gecko/2008102920 Firefox/3.0.4</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.9.0.5)
                      Gecko/2008120122 Firefox/3.0.5</li>
                  <li>Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.11)
                      Gecko/2009061212 Iceweasel/3.0.11 (Debian-3.0.11-1)</li>
                  <li>Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.3)
                      Gecko/20091010 Iceweasel/3.5.3 (Debian-3.5.3-2)</li>
                  <li>Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.4)
                      Gecko/20091028 Iceweasel/3.5.4 (Debian-3.5.4-1)</li>
                </ul></li>
              <li><span title="Microsoft JScript">JScript</span>
                <ul>
                  <li>Mozilla/4.0 (compatible; MSIE 4.01; Windows NT 5.0)</li>
                  <li>Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.1;
                      .NET CLR 1.1.4322; .NET CLR 2.0.50727)</li>
                  <li>Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1;
                      .NET CLR 1.1.4322; .NET CLR 2.0.50727)</li>
                  <li>Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1;
                      .NET CLR 1.1.4322; .NET CLR 2.0.50727)</li>
                  <li>Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0;
                      .NET CLR 1.1.4322; .NET CLR 2.0.50727)</li>
                </ul></li>
              <li><abbr title="Apple WebKit JavaScriptCore">JSCore</abbr>
                <ul>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE)
                      AppleWebKit/525.19 (KHTML, like Gecko)
                      Version/3.1.2 Safari/525.21</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE)
                      AppleWebKit/525.27.1 (KHTML, like Gecko)
                      Version/3.2.1 Safari/525.27.1</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE)
                      AppleWebKit/530.17 (KHTML, like Gecko)
                      Version/4.0 Safari/530.17</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)
                      AppleWebKit/531.9 (KHTML, like Gecko)
                      Version/4.0.3 Safari/531.9.1</li>
                </ul></li>
              <li>Opera ECMAScript
                <ul>
                  <li>Mozilla/4.0 (Windows 3.95;DE) Opera 3.60 [de]</li>
                  <li>Mozilla/4.0 (compatible; MSIE 5.0; Windows NT 5.1)
                      Opera 5.02 [en]</li>
                  <li>Mozilla/4.0 (compatible; MSIE 5.0; Windows XP)
                      Opera 6.06 [en]</li>
                  <li>Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 5.1)
                      Opera 7.02 [en]</li>
                  <li>Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en)
                      Opera 8.0</li>
                  <li>Opera/9.27 (Windows NT 5.1; U; en)</li>
                  <li>Opera/9.52 (Windows NT 5.1; U; en)</li>
                  <li>Opera/9.62 (Windows NT 5.1; U; en) Presto/2.1.1</li>
                  <li>Opera/9.64 (Windows NT 5.1; U; en) Presto/2.1.1</li>
                  <li>Opera/9.64 (X11; Linux i686; U; en) Presto/2.1.1</li>
                  <li>Opera/9.80 (X11; Linux i686; U; en) Presto/2.2.15 Version/10.00</li>
                </ul></li>
 
              <li><acronym title="Konqueror JavaScript">KJS</acronym>
                <ul>
                  <li>Mozilla/5.0 (compatible; Konqueror/3.5;
                      Linux 2.6.29.4-20090531.213230+0200; X11; i686;
                      de, en_US) KHTML/3.5.10 (like Gecko)
                      (Debian package 4:3.5.10.dfsg.1-2)</li>
                  <li>Mozilla/5.0 (compatible; Konqueror/4.3;
                      Linux 2.6.31.1-20090928.230129+0200; X11; i686; de)
                      KHTML/4.3.2 (like Gecko)</li>
                </ul></li>
            </ul>
          </td>
        </tr>
      </tfoot>
      <tbody class="scroll" id="scroller">
<?php
  $features->printItems();
?>
        <?php //include 'includes/es-matrix.inc.php'; ?>
        <tr>
          <th><code title="Equals operator">==</code></th>
          <td><a class="tooltip" href="#equals" name="equals">1.0<span><span>
            (</span>deprecated since 1.4 <em>for comparison of two
            <code>JSObject</code> objects</em>; use the <code>JSObject.equals</code>
            method instead<span>)</span></span></a></td>
          <td>1.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code title="Array initializer">[<var>value</var>, &hellip;]</code></th>
          <td>1.3</td>
          <td>2.0</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code title="Array initializer with trailing comma">[<var>value</var>,&nbsp;]</code></th>
          <td>1.3</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th title="Array comprehension"><code>[<var>expression1</var>
            for (<var>var1</var> in <var>expression2</var>)</code>
            <var>[</var><code>if (<var>expression3</var>)</code><var
            >]</var><code>]</code></th>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Array_comprehensions"
            >1.7</a></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code title="Destructuring assignment"><var>[</var>var<var>]</var> [<var>var1</var>,
            <var>[var2]</var>, <var>var3</var>,
            <var>&hellip;</var>]&nbsp;=
            <var>Array</var></code></th>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Destructuring_assignment"
            >1.7</a></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><a href="javascript:alert('Euro:%20%5Cu20AC')"
            onclick="return !!alert('Euro: \u20AC');"><code
            title="Unicode escape sequence in String literal"
            >&quot;\u<var>hhhh</var>&quot;</code></a>, <a
            href="javascript:alert(/%5Cu20AC/)"
            onclick="return !!alert(/\u20AC/);"><code
            title="Unicode escape sequence in RegExp literal">/\u<var>hhhh</var>/</code></a></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code title="Object initializer with trailing comma">{<var>name</var>:
            <var>value</var>,&nbsp;}</code></th>
          <td>1.3</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><a name="a" id="a"></a><code>abstract</code></th>
          <td>2.0</td>
          <td>7.0</td>
          <td>4</td>
        </tr>
        <tr>
          <th><code>ActiveXObject(&hellip;)</code></th>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><a name="arguments" id="arguments"
            ><code>arguments</code></a></th>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Functions:arguments"
            >1.1</a></td>
          <td>1.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><a name="arguments.callee" id="arguments.callee"
            href="javascript:void((function(){alert(arguments.callee);})())"
            onclick="return !!(function(){alert(arguments.callee);})();"
            ><code>arguments.callee</code></a></th>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Functions:arguments:callee"
            >1.2</a></td>
          <td>3.0*</td>
          <td>1</td>
        </tr>
        <tr>
          <th><a name="arguments.caller" id="arguments.caller"><code>arguments.caller</code></a></th>
          <td><a href="#arguments.caller"
                 class="tooltip">1.1<span><span>; </span>deprecated since 1.3</span></a></td>
          <td><span class="tooltip">-<span> (see&nbsp;<code><a
            href="#Function.prototype.caller"
            >Function.prototype.caller</a></code><span>)</span></span></span></td>
          <td>-</td>
        </tr>
        <tr>
          <th><a name="arguments.length" id="arguments.length"><code>arguments.length</code></a></th>
          <td>1.1</td>
          <td>5.5</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code title="Array constructor/factory">Array(&hellip;)</code></th>
          <td>1.1</td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Array.every(&hellip;)</code></th>
          <td>1.6</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Array.some(&hellip;)</code></th>
          <td>1.6</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Array.prototype.concat(&hellip;)</code></th>
          <td>1.2</td>
          <td>3.0</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>Array.prototype.every(&hellip;)</code></th>
          <td>1.6</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Array.prototype.indexOf(&hellip;)</code></th>
          <td>1.6</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Array.prototype.join(&hellip;)</code></th>
          <td>1.1</td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Array.prototype.length</code></th>
          <td>1.1</td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Array.prototype.pop()</code></th>
          <td>1.2</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>Array.prototype.push(&hellip;)</code></th>
          <td>1.2</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>Array.prototype.reverse()</code></th>
          <td>1.1</td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Array.prototype.shift()</code></th>
          <td>1.2</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>Array.prototype.slice(&hellip;)</code></th>
          <td>1.2</td>
          <td>3.0</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>Array.prototype.some(&hellip;)</code></th>
          <td>1.6</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Array.prototype.sort(</code>[<code><var
            >comparator</var></code>]<code>)</code></th>
          <td>1.1</td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><a href="javascript:a=new(Array(1,2,3));alert(a.splice(1,1,4));alert(a);"
            onclick="var a = new Array(1,2,3); alert(a.splice(1,1,4)); return !!alert(a);"
            ><code>Array.prototype.splice(&hellip;)</code></a></th>
          <td><a href="#Array.prototype.splice" name="Array.prototype.splice"
                 class="tooltip">1.2<span><span>; </span>no return value
                 before 1.3</span></a></td>
          <td>5.5*</td>
          <td>3</td>
        </tr>
        <tr>
          <th><a href="javascript:a=new(Array('1'));a.unshift(0);alert(a);"
            onclick="var a = new Array('1'); a.unshift(0); return !!alert(a);"
            ><code>Array.prototype.unshift()</code></a></th>
          <td>1.2?</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <th><a name="b" id="b"></a><code>boolean</code></th>
          <td>2.0</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatBoolean.asp"
            >7.0</a></td>
          <td>4</td>
        </tr>
        <tr>
          <th><code>Boolean(&hellip;)</code></th>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Global_Objects:Boolean"
            >1.1</a></td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>byte</code></th>
          <td>2.0</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatbyte.asp"
            >7.0</a></td>
          <td>4</td>
        </tr>
        <tr>
          <th><a name="c" id="c"></a><code>@cc_on</code></th>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>char</code></th>
          <td>2.0</td>
          <td>7.0</td>
          <td>4</td>
        </tr>
        <tr>
          <th><code>class</code></th>
          <td>2.0</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatchar.asp"
            >7.0</a></td>
          <td>4</td>
        </tr>
        <tr>
          <th><code>const</code></th>
          <td>1.5</td>
          <td>7.0</td>
          <td>4</td>
        </tr>
        <tr>
          <th><a name="d" id="d"></a><code>Date.prototype.getFullYear()</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.getMilliseconds()</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.getUTCDate()</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.getUTCDay()</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.getUTCFullYear()</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.getUTCHours()</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.getUTCMilliseconds()</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.getUTCMinutes()</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.getUTCMonth()</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.getUTCSeconds()</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.getVarDate()</code></th>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Date.prototype.setFullYear(<var>integer</var>)</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.setMilliseconds(<var>integer</var>)</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.setUTCDate(<var>integer</var>)</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.setUTCDay(<var>integer</var>)</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.setUTCFullYear(<var>integer</var>)</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.setUTCHours(<var>integer</var>)</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.setUTCMilliseconds(<var>integer</var>)</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.setUTCMinutes(<var>integer</var>)</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.setUTCMonth(<var>integer</var>)</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Date.prototype.setUTCSeconds(<var>integer</var>)</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>@debug</code></th>
          <td>-</td>
          <td>7.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>debugger</code></th>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>decimal</code></th>
          <td>-</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatDecimal.asp"
            >7.0</a></td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>decodeURI(&hellip;)</code></th>
          <td>1.5</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>decodeURIComponent(&hellip;)</code></th>
          <td>1.5</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>delete</code></th>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>do&hellip;while</code></th>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>double</code></th>
          <td>2.0</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatdouble.asp"
            >7.0</a></td>
          <td>4</td>
        </tr>
        <tr>
          <th><a name="e" id="e"></a><code>encodeURI(&hellip;)</code></th>
          <td>1.5</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>encodeURIComponent(&hellip;)</code></th>
          <td>1.5</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>enum</code></th>
          <td>2.0</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Enumerator(&hellip;)</code></th>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Error(&hellip;)</code></th>
          <td>?</td>
          <td>5.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Error.prototype.description</code></th>
          <td>?</td>
          <td>5.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Error.prototype.message</code></th>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Error.prototype.name</code></th>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Error.prototype.number</code></th>
          <td>?</td>
          <td>5.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Error.prototype.stack</code></th>
          <td class="tested">1.5</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>expando</code></th>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><a name="f" id="f"></a><code>final</code></th>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>float</code></th>
          <td>2.0</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatfloat.asp"
            >7.0</a></td>
          <td>4</td>
        </tr>
        <tr>
          <th><code>for each ([var]
            <var>identifier</var> in
            <var>expression</var>)</code></th>
          <td>1.6</td>
          <td>-</td>
          <td>E4X</td>
        </tr>
        <tr>
          <th><code>Function(&hellip;)</code></th>
          <td>1.1</td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>function get
            <var>identifier</var>(&hellip;)</code></th>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>function set
            <var>identifier</var>(&hellip;)</code></th>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code title="Expression closure">=
            <a href="javascript:window.alert((function(x)%20x%20*%20x)(2))"
               onclick="eval('window.alert((function(x) x * x)(2)); return false')"
               >function(&hellip;) <var>expression</var></a></code></th>
          <td class="tested">1.8</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Function.prototype.arity</code></th>
          <td><a href="#Function.prototype.arity" name="Function.prototype.arity"
                 class="tooltip">1.2<span><span>; </span>deprecated since 1.4</span></a></td>
          <td>?</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Function.prototype.apply(&hellip;)</code></th>
          <td>1.3</td>
          <td>5.5<span class="tested">.6330</span></td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>Function.prototype.arguments</code></th>
          <td><span class="tooltip">1.0<span><span>; </span>deprecated since 1.4;
            use <a href="#arguments"><code>arguments</code></a>
            instead</span></span></td>
          <td>2.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Function.prototype.arguments.callee</code></th>
          <td><span class="tooltip">1.2<span><span>; </span>deprecated since 1.4;
            use <code><a href="#arguments.callee">arguments.callee</a></code>
            instead</span></span></td>
          <td>5.6</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Function.prototype.arguments.length</code></th>
          <td><span class="tooltip">1.0<span><span>; </span>deprecated since 1.4;
            use <a href="#arguments.length"><code>arguments.length</code></a>
            instead</span></span></td>
          <td>?</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Function.prototype.call(&hellip;)</code></th>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Global_Objects:Function:call"
                 >1.3</a></td>
          <td>5.5<span class="tested">.6330</span></td>
          <td>3</td>
        </tr>
        <tr>
          <th><a name="Function.prototype.caller" id="Function.prototype.caller"
            ><code>Function.prototype.caller</code></a></th>
          <td><span class="tooltip">-<span><span>
              (</span>see&nbsp;<code><a href="#arguments.caller"
              >arguments.caller</a></code><span>)</span></span></span></td>
          <td>2.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Function.prototype.length</code></th>
          <td>?</td>
          <td>2.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Function.prototype.toSource()</code></th>
          <td>1.3</td>
          <td>?</td>
          <td>?</td>
        </tr>
        <tr>
          <th><a name="g" id="g"></a><code><var>Generator</var>.close()</code></th>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Closing_a_generator"
            >1.7</a><sup><a href="#fn-decl-ver" name="decl-ver">V</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code><var>Generator</var>.next()</code></th>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Generators"
            >1.7</a><sup><a href="#fn-decl-ver">V</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code><var>Generator</var>.send(<var>expression</var>)</code></th>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Resuming_a_generator_at_a_specific_point"
            >1.7</a><sup><a href="#fn-decl-ver">V</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code><var>Generator</var>.throw(<var>expression</var>)</code></th>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Exceptions_in_generators"
            >1.7</a><sup><a href="#fn-decl-ver">V</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>GetObject(&hellip;)</code></th>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th>Global object</th>
          <td>1.0</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><a name="h" id="h"></a><code>hide</code></th>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><a name="i" id="i"></a><code>@if</code></th>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Infinity</code></th>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>import</code></th>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code><var>"string"</var>
            in <var>objRef</var></code></th>
          <td>1.4</td>
          <td>5.0</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>instanceof</code></th>
          <td>1.4</td>
          <td>5.0</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>int</code></th>
          <td>2.0</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatint.asp"
            >7.0</a></td>
          <td>4</td>
        </tr>
        <tr>
          <th><code>interface</code></th>
          <td>2.0</td>
          <td>7.0</td>
          <td>4</td>
        </tr>
        <tr>
          <th><code>internal</code></th>
          <td>2.0</td>
          <td>7.0</td>
          <td>4</td>
        </tr>
        <tr>
          <th><code>isFinite(&hellip;)</code></th>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Iterator(<var>objRef
            </var>)</code></th>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Iterators"
            >1.7</a></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><a name="l" id="l"></a><a name="let" id="let"><code
            title="Block scoping: let statement">let&nbsp;(<var>assignment</var><var>[</var>, <var>&#8230;</var><var>]</var>) {&nbsp;<var>[</var><var>statements</var><var
            >]</var>&nbsp;}</code></a></th>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Block_scope_with_let"
            >1.7</a><sup><a href="#fn-decl-ver">V</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code
            title="Block scoping: let expression">let&nbsp;(<var>assignment</var><var>[</var>, <var>&#8230;</var><var>]</var>)&nbsp;<var>expression</var></code></th>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Block_scope_with_let"
            >1.7</a><sup><a href="#fn-decl-ver">V</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code
            title="Block scoping: let definition">let&nbsp;<var>assignment</var><var>[</var>, <var>&#8230;</var><var>]</var></code></th>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Block_scope_with_let"
            >1.7</a><sup><a href="#fn-decl-ver">V</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>long</code></th>
          <td>2.0</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatlong.asp"
            >7.0</a></td>
          <td>4</td>
        </tr>
        <tr>
          <th><a name="m" id="m"></a><code>Math.max(<var>a</var>,
            <var>b</var>)</code></th>
          <td class="tested">1.3</td>
          <td>3.1<span class="tested">.3510</span></td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Math.max(<var>a</var>,
            <var>b</var>, <var>&hellip;</var>)</code></th>
          <td class="tested">1.5</td>
          <td>5.5<span class="tested">.6330</span></td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>Math.min(<var>a</var>,
            <var>b</var>)</code></th>
          <td class="tested">1.3</td>
          <td>3.1<span class="tested">.3510</span></td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Math.min(<var>a</var>,
            <var>b</var>, <var>&hellip;</var>)</code></th>
          <td class="tested">1.5</td>
          <td>5.5<span class="tested">.6330</span></td>
          <td>3</td>
        </tr>
        <tr>
          <th><a name="n" id="n"></a><code>NaN</code></th>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Number(&hellip;)</code></th>
          <td>?</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsobjnumber.asp"
            >1.0</a></td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Number.MAX_VALUE</code></th>
          <td>?</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jspromaxvalue.asp"
            >2.0</a></td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Number.MIN_VALUE</code></th>
          <td>?</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsprominvalue.asp"
            >2.0</a></td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Number.NaN</code></th>
          <td>?</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jspronannumber.asp"
            >2.0</a></td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Number.NEGATIVE_INFINITY</code></th>
          <td>?</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jspronegativeinf.asp"
            >2.0</a></td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Number.POSITIVE_INFINITY</code></th>
          <td>?</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jspropositiveinf.asp"
            >2.0</a></td>
          <td>?</td>
        </tr>
        <tr>
          <th><a name="o" id="o"></a><code>Object(&hellip;)</code></th>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Object.prototype.__defineGetter__(<var>propertyName</var>:&nbsp;string, <var>getter</var>:&nbsp;Function)</code></th>
          <td>1.5</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Object.prototype.__defineSetter__(<var>propertyName</var>:&nbsp;string, <var>setter</var>:&nbsp;Function)</code></th>
          <td>1.5</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Object.prototype.__iterator__</code></th>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Iterators"
            >1.7</a></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Object.prototype.__proto__</code></th>
          <td>1.3</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>Object.prototype.constructor(&hellip;)</code></th>
          <td>1.1</td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><code>Object.prototype.isPrototypeOf(&hellip;)</code></th>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Object.prototype.propertyIsEnumerable(&hellip;)</code></th>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Object.prototype.prototype</code></th>
          <td>?</td>
          <td>2.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>Object.prototype.toSource()</code></th>
          <td>1.0</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>override</code></th>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><a name="p" id="p"></a><code>package</code></th>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>@position</code></th>
          <td>-</td>
          <td>7.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>print(<var>string</var>)</code></th>
          <td>-</td>
          <td>7.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>private</code></th>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>protected</code></th>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>public</code></th>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><a name="q" id="q"></a><a name="r" id="r"></a><code>RegExp(<var>&hellip;</var></code>[<code>, <span class="str"
            >&quot;</span></code>[<code class="str"
            >g</code>][<code>i</code>]<code class="str"
            >&quot;</code>]<code>)</code></th>
          <td>1.2</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>RegExp(<var>&hellip;</var></code>[<code>, <span class="str"
            >&quot;</span></code>[<code class="str"
            >g</code>][<code>i</code>][<code>m</code>]<code class="str"
            >&quot;</code>]<code>)</code></th>
          <td>1.5</td>
          <td>3.0</td>
          <td>3</td>
        </tr>
        <tr>
          <th>{<code>RegExp</code> | <code><var
            >reArray</var></code>}<code>.</code>{<code>$_</code>
            | <code>input</code>}</th>
          <td>1.2</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>RegExp.</code>{<code>$&amp;</code> | <code>lastMatch</code>}</th>
          <td>1.2</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>RegExp.</code>{<code>$+</code> | <code>lastParen</code>}</th>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>RegExp.</code>{<code>$`</code> | <code>leftContext</code>}</th>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>RegExp.</code>{<code>$'</code> | <code>rightContext</code>}</th>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>RegExp.$<var>integer</var></code></th>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th>{<code>RegExp</code> | <code><var>reArray</var></code>}<code>.index</code></th>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>RegExp.prototype.compile(<var>&hellip;</var>)</code></th>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>RegExp.prototype.exec(&hellip;)</code></th>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>RegExp.prototype.global</code></th>
          <td>1.2</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>RegExp.prototype.ignoreCase</code></th>
          <td>1.2</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>RegExp.prototype.multiline</code></th>
          <td>1.2</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>RegExp.prototype.source</code></th>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><a name="s" id="s"></a><code>sbyte</code></th>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code><a
            href="javascript:void(alert(ScriptEngine()))"
            >ScriptEngine</a>()</code></th>
          <td>-</td>
          <td>2.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code><a
            href="javascript:void(alert(ScriptEngineBuildVersion()))"
            >ScriptEngineBuildVersion</a>()</code></th>
          <td>-</td>
          <td>2.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code><a
            href="javascript:void(alert(ScriptEngineMajorVersion()))"
            >ScriptEngineMajorVersion</a>()</code></th>
          <td>-</td>
          <td>2.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code><a
            href="javascript:void(alert(ScriptEngineMinorVersion()))"
            >ScriptEngineMinorVersion</a>()</code></th>
          <td>-</td>
          <td>2.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>@set</code></th>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>short</code></th>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><a href="#opNotEqual" title="!==">Strict Not Equal/Nonidentity operator</a></th>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th><code>String.prototype.concat(&hellip;)</code></th>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>String.prototype.localeCompare(<var>string</var>)</code></th>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>String.prototype.match(<var>RegExp</var>)</code></th>
          <td>1.2 (<span class="tested">1.3</span>)</td>
          <td>3.0</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>String.prototype.replace(<var>string|RegExp</var>, <var>string</var>)</code></th>
          <td>1.2</td>
          <td>1.0</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>String.prototype.replace(<var>string|RegExp</var>, <var>Function</var>)</code></th>
          <td class="tested">1.3</td>
          <td class="tested">5.5.6330</td>
          <td class="tested">3</td>
        </tr>
        <tr>
          <th><code>String.prototype.search(<var>RegExp</var>)</code></th>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>String.prototype.slice(&hellip;)</code></th>
          <td>1.0</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <th><code>String.prototype.split(&hellip;)</code></th>
          <td>1.1</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <th><a name="switch" id="switch"><code>switch&nbsp;(<var>expression</var>)&nbsp;{ case&nbsp;<var
            >value</var>:&nbsp;<var
            >statements</var>;&nbsp;</code>[<code>break;</code>]
            <var>&hellip;</var>
            <code>default:&nbsp;<var>statements</var>;&nbsp;</code>[<code>break;</code>]<code>&nbsp;}</code></a></th>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Statements:switch"
            >1.2</a></td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsstmswitch.asp"
            >3.0</a></td>
          <td>3</td>
        </tr>
        <tr>
          <th><a name="t" id="t"></a><a name="throw" id="throw"><code>throw&nbsp;<var
            >expression</var></code></a></th>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Statements:throw"
            >1.4</a></td>
          <td class="tested">5.1.5010</td>
          <td>3</td>
        </tr>
        <tr>
          <th><a name="try" id="try"><code>try&nbsp;{&nbsp;</code>[<code><var
            >statements</var></code>]&nbsp;<code>}<br>
            catch&nbsp;(<var>identifier</var>)&nbsp;{&nbsp;</code>[<code><var
            >statements</var></code>]&nbsp;<code>}</code></a></th>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Statements:try...catch"
            >1.4</a></td>
          <td class="tested"><a
            href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsstmtrycatch.asp"
            >5.1.5010</a></td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>try&nbsp;{&nbsp;</code>[<code><var
            >statements</var></code>]<code>&nbsp;}<br>
            finally&nbsp;{&nbsp;</code>[<code><var
            >statements</var></code>]<code>&nbsp;}</code></th>
          <td>1.4</td>
          <td>-</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>try&nbsp;{&nbsp;</code>[<code><var
            >statements</var></code>]<code>&nbsp;}<br>
            catch&nbsp;(<var>identifier</var>)&nbsp;{&nbsp;</code>[<code><var
            >statements</var></code>]<code>&nbsp;}<br>
            finally&nbsp;{&nbsp;</code>[<code><var
            >statements</var></code>]<code>&nbsp;}</code></th>
          <td>1.4</td>
          <td>5.0</td>
          <td>3</td>
        </tr>
        <tr>
          <th><code>try&nbsp;{</code>&nbsp;[<code><var
            >statements</var></code>]<code>&nbsp;}<br>
            catch&nbsp;(<var>identifier</var>&nbsp;if&nbsp;<var>expression</var>)&nbsp;{&nbsp;</code>[<code><var
            >statements</var></code>]&nbsp;<code>}</code><br>
            [<code>catch&nbsp;(<var>identifier</var>)&nbsp;{&nbsp;</code>[<code><var
            >statements</var></code>]<code>&nbsp;}</code>]<br>
            [<code>finally&nbsp;{&nbsp;</code>[<code><var
            >statements</var></code>]<code>&nbsp;}</code>]</th>
          <td>1.5</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><a name="typeof" id="typeof"></a><code>typeof <var>expression</var></code></th>
          <td>1.1</td>
          <td>1.0</td>
          <td>1</td>
         </tr>
         <tr>
          <th><a name="u" id="u"></a><code><a
            name="undefined" id="undefined">undefined</a></code></th>
          <td>1.3</td>
          <td>5.5</td>
          <td>1</td>
        </tr>
        <tr>
          <th><a name="v" id="v"></a><code>VBArray.prototype.dimensions()</code></th>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>VBArray.prototype.getItem(&hellip;)</code></th>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>VBArray.prototype.lbound(&hellip;)</code></th>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><a name="w" id="w"></a><code>window</code></th>
          <td><a href="http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html"
            >1.0</a><span class="tooltip">**<span><span>; </span>removed in <a href="#javascript">1.4</a>;
            <a href="http://developer.mozilla.org/en/docs/DOM:window"
               >Gecko&nbsp;DOM feature</a>
            since <a href="#javascript">1.5</a></span></span></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>window.setInterval(<var>string</var>,
            <var>msec</var>)</code></th>
          <td><a href="http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html#1203669"
            >1.2</a><span class="tooltip">**<span><span>; </span>removed in <a href="#javascript">1.4</a>;
            <a href="http://developer.mozilla.org/en/docs/DOM:window.setInterval"
               >Gecko&nbsp;DOM feature</a> since <a href="#javascript">1.5</a></span></span></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>window.setInterval(<var>functionReference</var>,
            <var>msec</var></code>[<code>, <var>arg1</var></code>[<code>, &hellip;,
            <var>argN</var></code>]]<code>)</code></th>
          <td>1.2<span class="tooltip">**<span><span>; </span>removed in 1.4;
            <a href="http://developer.mozilla.org/en/docs/DOM:window.setInterval"
               >Gecko&nbsp;DOM feature</a> since <a href="#javascript">1.5</a></span></span></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>window.setTimeout(<var>string</var>,
            <var>msec</var>)</code></th>
          <td><a href="http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html#1203758"
            >1.0</a><span class="tooltip">**<span><span>; </span>removed in <a href="#javascript">1.4</a>;
            <a href="http://developer.mozilla.org/en/docs/DOM:window.setTimeout"
               >Gecko&nbsp;DOM feature</a> since <a href="#javascript">1.5</a></span></span></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code>window.setTimeout(<var>functionReference</var>,
            <var>msec</var></code>[<code>, <var>arg1</var></code>[<code>, &hellip;,
            <var>argN</var></code>]]<code>)</code></th>
          <td><a href="http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html#1203758"
            >1.2</a><span class="tooltip">**<span><span>; </span>removed in 1.4;
            <a href="http://developer.mozilla.org/en/docs/DOM:window.setTimeout"
               >Gecko&nbsp;DOM feature</a> since <a href="#javascript">1.5</a></span></span></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><code title="Generator expression">yield
            <var>expression</var></code></th>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Generators"
            >1.7</a><sup><a href="#fn-decl-ver">V</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
      </tbody>
    </table>

    <h2><a name="javascript" id="javascript"
      >Netscape/Mozilla.org&nbsp;JavaScript
       Version Information</a><sup>1)</sup></h2>
    <table class="versions"
           summary="JavaScript versions and the user agents that support them"
           >
      <thead>
        <tr>
          <th class="right">JavaScript</th>
          <th><a
            href="http://e-pla.net/documents/manuals/javascript-1.0/"
            title="JavaScript Authoring Guide for JavaScript 1.0"
            >1.0</a></th>
          <th><a
            href="http://wp.netscape.com/eng/mozilla/3.0/handbook/javascript/"
            title="JavaScript Guide for JavaScript 1.1">1.1</a></th>
          <th><a
            href="http://research.nihonsoft.org/javascript/jsref/"
            title="Client-side JavaScript 1.2 Reference">1.2</a></th>
          <th><a
            href="http://research.nihonsoft.org/javascript/ClientReferenceJS13/"
            title="Client-side JavaScript 1.3 Reference">1.3</a></th>
          <th><a
            href="http://research.nihonsoft.org/javascript/CoreReferenceJS14/"
            title="Core JavaScript 1.4 Reference">1.4</a></th>
          <th><a href
           ="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference"
            title="Core JavaScript 1.5 Reference"
            >1.5</a></th>
          <th><a
            href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.6"
            title="New in JavaScript 1.6"
            >1.6</a></th>
          <th><a
            href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7"
            title="New in JavaScript 1.7"
            >1.7</a></th>
          <th><a
            href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.8"
            title="New in JavaScript 1.8"
            >1.8</a></th>
          <th><a
            href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.8.1"
            title="New in JavaScript 1.8.1"
            >1.8.1</a></th>
          <th><a
            href="https://developer.mozilla.org/En/Firefox_3.6_for_developers#JavaScript"
            title="New in JavaScript 1.8.2"
            >1.8.2</a> (future)</th>
          <th><a href="http://www.mozilla.org/js/language/js20/">2.0</a></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="13"><sup>1)</sup> Version information from the
            JavaScript Guides and References; release dates from <a
            href="about:">about:</a>&nbsp;documents,
            <a href="http://www.mozilla.org/releases/cvstags.html"
            >mozilla.org</a> and
            <a href="http://en.wikipedia.org/wiki/Mozilla_Firefox#History"
            >Wikipedia</a>.</td>
        </tr>
      </tfoot>
      <tbody>
        <tr class="heading">
          <th colspan="13">Implementations</th>
        </tr>
        <tr>
          <th>Netscape/Mozilla.org SpiderMonkey</th>
          <td>1.0</td>
          <td>1.1</td>
          <td>1.2</td>
          <td>1.3</td>
          <td>1.4</td>
          <td>1.5</td>
          <td>1.6</td>
          <td>1.7</td>
          <td>1.8</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th>Mozilla.org TraceMonkey</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>1.8.1</td>
          <td>1.8.2</td>
          <td>-</td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.org/js/language/Epimetheus.html"
                 >Mozilla.org Epimetheus</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>+</td>
        </tr>
   
        <tr class="heading">
          <th colspan="13">Layout Engines</th>
        </tr>
        <tr>
          <th><a href="https://developer.mozilla.org/en/docs/Gecko"
                 >Netscape/Mozilla.org NGLayout/Gecko</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>0.6&#8211;1.8a6</td>
          <td>1.8b1&#8211;1.8</td>
          <td>1.8.1</td>
          <td>1.9</td>
          <td>1.9.1</td>
          <td>1.9.2</td>
          <td></td>
        </tr>
        
        <tr class="heading">
          <th colspan="13">Web Browsers</th>
        </tr>
        <tr>
          <th><a href="http://browser.netscape.com/">Netscape Navigator/Browser</a></th>
          <td>Navigator 2.0 (1996-03)</td>
          <td>3.0 (1996-08)</td>
          <td>4.0&#8211;4.05 (1997-06)</td>
          <td>4.06&#8211;4.8 (1998&#8211;2002)</td>
          <td>-</td>
          <td>Navigator&nbsp;6.x &#8211;&nbsp;Browser&nbsp;8.1.3 (2000-11-14 &#8211;&nbsp;2007-04-02)</td>
          <td>-</td>
          <td>Navigator&nbsp;9.0b1
            &#8211;&nbsp;9.0.0.6&nbsp;<span title="End-of-life">&#8224;</span><br>
            (2007-06-05 &#8211;&nbsp;2008-02-29)</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.com/firefox/"
                 >Mozilla Phoenix/Firebird/Firefox</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>Phoenix&nbsp;0.1 &#8211;&nbsp;Firefox&nbsp;1.0.x&nbsp;<span title="End-of-life">&#8224;</span><br>
            (2002-09-23 &#8211;&nbsp;2006-04-13)</td>
          <td>Firefox&nbsp;1.5a1 &#8211;2.0a3&nbsp;<span title="End-of-life">&#8224;</span><br>
            (2005-05-31 &#8211;&nbsp;2006-05-26)</td>
          <td>2.0b1 &#8211;2.0.0.18&nbsp;<span title="End-of-life">&#8224;</span><br>
            (2006-07-12 &#8211;&nbsp;2008-11-12)</td>
          <td>3.0a2 &#8211;3.0.15b&#8212;<br>
            (2007-02-07 &#8211;&nbsp;2009-10-20&#8212;)</td>
          <td>3.5&#8212;<br>
            (2009-06-30&#8212;)</td>
          <td></td>
          <td></td>
        </tr>
        
        <tr class="heading">
          <th colspan="13">Other Clients</th>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.org/products/mozilla1.x/"
                 >Mozilla Application&nbsp;Suite</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>0.6&#8211;1.8a6
            (2000-12-06 &#8211;&nbsp;2005-01-12)</td>
          <td>1.8b1&#8211;1.7.13&nbsp;<span title="End-of-life">&#8224;</span><br>
            (2005-02-23 &#8211;&nbsp;2006-04-21)</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.org/projects/seamonkey/"
                 >Mozilla SeaMonkey</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>1.0&#8211;1.0.9 (2005-09-15
            &#8211;&nbsp;2007-05-30)</td>
          <td>1.1a&#8211;1.1.17&#8212;<br>
            (2006-08-30 &#8211;&nbsp;2009-06-22&#8212;)</td>
          <td>2.0a1<br>
            (2008-10-05)</td>
          <td>2.0a2 &#8211;2.0RC2&#8212;<br>
            (2008-12-10 &#8211;&nbsp;2009-10-10&#8212;)</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.com/thunderbird/"
                 >Mozilla Thunderbird</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>2.0a1 &#8212;2.0.0.23&#8212;
            (2006-07-28 &#8211;&nbsp;2009-01-03&#8212;)</td>
          <td>3.0a1<br>
            (2008-05-14&#8212;)</td>
          <td></td>
          <td></td>
        </tr>
        
        <tr class="heading">
          <th colspan="13">Web Servers</th>
        </tr>
        <tr>
          <th><a href="http://wp.netscape.com/enterprise/"
                 >Netscape Enterprise&nbsp;Server</a>/<br>
              <a href="http://en.wikipedia.org/wiki/iPlanet"
                 title="Wikipedia: iPlanet">iPlanet</a>&nbsp;Web&nbsp;Server/<br>
              <a href="http://en.wikipedia.org/wiki/Sun_ONE"
                 title="Wikipedia: Sun ONE">Sun&nbsp;ONE</a>
              Web&nbsp;Server/<br>
              <a href="http://www.sun.com/software/products/appsrvr/"
                >Sun Java&nbsp;System Web&nbsp;Server</a></th>
          <td></td>
          <td>2.0</td>
          <td>3.0</td>
          <td></td>
          <td>4.0/<a href="http://docs.sun.com/source/816-5930-10/"
            title="iPlanet Web Server, Enterprise Edition Server-Side JavaScript 1.4 Guide"
            >4.1</a> (1999)</td>
          <td>6.0</td>
          <td>?</td>
          <td>?</td>
          <td>?</td>
          <td>?</td>
          <td>?</td>
          <td>?</td>
        </tr>
      </tbody>
    </table>

    <h2><a name="jscript" id="jscript"
      >Microsoft&nbsp;JScript Version Information</a><sup>2)</sup></h2>
    <table class="versions"
           summary="JScript versions and the user agents that support them">
      <thead>
        <tr>
          <th class="right">JScript</th>
          <th>1.0</th>
          <th>2.0</th>
          <th>3.0</th>
          <th>3.1.3510</th>
          <th>4.0</th>
          <th>5.0</th>
          <th>5.1.5010</th>
          <th>5.5.6330</th>
          <th><a href="http://msdn2.microsoft.com/en-us/library/hbxc2t98.aspx"
                 title="JScript 5.6 documentation">5.6</a>.6626
                 &#8211;&nbsp;5.6.8819</th>
          <th>5.7.5730</th>
          <th>5.7.17184</th>
          <th>5.8.18241</th>
          <th><a href="http://msdn2.microsoft.com/en-us/library/72bd815a(VS.71).aspx"
                 title="JScript .NET documentation">7.0 (.NET)</a></th>
          <th><a href="http://msdn.microsoft.com/en-us/library/72bd815a.aspx"
                 title="JScript .NET documentation">8.0 (.NET)</a></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="15"><sup>2)</sup> Version information from <a
            href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsoriVersionInformation.asp"
            ><acronym title="Microsoft Developer Network"
            >MSDN</acronym>&nbsp;Library</a>; release&nbsp;dates from
            MSDN&nbsp;Library,
            <a href="http://www.blooberry.com/indexdot/history/ie.htm"
               title="Browser History: Windows Internet Explorer"
               >blooberry.com</a> and <a href="http://en.wikipedia.org/"
               >Wikipedia</a>.</td>
        </tr>
      </tfoot>
      <tbody>
        <tr class="heading">
          <th colspan="15">Implementations</th>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/net/"
                 >Microsoft .NET Framework</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>1.0&#8211;3.5 (2000-07 &#8211;&nbsp;2008)</td>
          <td></td>
        </tr>
              
        <tr class="heading">
          <th colspan="15">Web Browsers</th>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/ie/"
                 >Microsoft Internet Explorer</a></th>
          <td>3.0 (1996-08&nbsp;<a href="http://en.wikipedia.org/wiki/Common_Era"
            ><acronym title="Common Era">CE</acronym></a>)</td>
          <td></td>
          <td>4.0 (1997-10)</td>
          <td>4.01 (for&nbsp;<abbr title="Windows NT">WinNT</abbr>)</td>
          <td></td>
          <td>5.0 (1999-03)</td>
          <td>5.01 (for&nbsp;<abbr title="Windows NT">WinNT</abbr>)</td>
          <td>5.5 (2000-07)</td>
          <td>6.0 for <abbr title="Windows 95 and 98">Win9x</abbr>/NT/XP
            (2001-10)</td>
          <td>7.0 for <abbr title="Windows">Win</abbr>XP (2006-10)</td>
          <td>8.0 beta 1 for <abbr title="Windows">Win</abbr>XP+ (2008-03-06)</td>
          <td>8.0 beta 2 for <abbr title="Windows">Win</abbr>XP+ (2008-08-27)</td>
          <td></td>
          <td></td>
        </tr>
        
        <tr class="heading">
          <th colspan="15">Web Servers</th>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/iis/"
                 >Microsoft Internet Information Server/Services</a></th>
          <td></td>
          <td></td>
          <td>4.0</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        
        <tr class="heading">
          <th colspan="15">Operating Systems</th>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/windows/"
                 >Microsoft Windows</a></th>
          <td></td>
          <td>NT&nbsp;4.0 (1996)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>2000 (2000-02)</td>
          <td><acronym title="Millennium Edition">Me</acronym>
            (2000-09)</td>
          <td><abbr title="eXPeriment^H^H^H^Hence ;-)">XP</abbr>
            (2001-10)</td>
          <td>Vista (2008-03)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/windowsserver2003/"
                 >Microsoft Windows Server</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>2003 (2003-04)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        
        <tr class="heading">
          <th colspan="15"><acronym title="Integrated Development Environment">IDE</acronym>s</th>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/vs/"
                 >Microsoft Visual Studio</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>6.0 (1998)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>.NET (2002&#8211;2008)</td>
          <td></td>
        </tr>
      </tbody>
    </table>

    <h2><a name="jscore" id="jscore"
      >Apple&nbsp;JavaScriptCore Version Information</a></h2>
    <table class="versions"
           summary="JavaScript Core versions and the user agents that support them"
           >
      <thead>
        <tr>
          <th></th>
          <th>JavaScriptCore&nbsp;525.19</th>
        </tr>
      </thead>
      <tbody>
        <tr class="odd">
          <th><a href="http://apple.com/safari/"
                 >Apple Safari</a></th>
          <td>3.1.2 (2008&nbsp;<a href="http://en.wikipedia.org/wiki/Common_Era"
            ><acronym title="Common Era">CE</acronym></a>)</td>
        </tr>
      </tbody>
    </table>

    <h2><a name="actionscript" id="actionscript"
      >Macromedia/Adobe&nbsp;ActionScript Versions</a><sup>3)</sup></h2>
    <table class="versions"
           summary="ActionScript versions and the user agents that support them"
           >
      <thead>
        <tr>
          <th></th>
          <th>ActionScript&nbsp;1.0</th>
          <th>2.0</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="9"><sup>3)</sup> Version information from <a
            href="http://macromedia.com/software/flash/"
            >Macromedia</a></td>
        </tr>
      </tfoot>
      <tbody>
        <tr>
          <th><a href="http://macromedia.com/software/flash/"
                 >Macromedia Flash</a></th>
          <td>5.0&#8211;MX (2000&#8211;2003)</td>
          <td>7.1.1 (MX 2004)&#8212;
            (2004&#8212;)</td>
        </tr>
      </tbody>
    </table>

    <h2><a name="ecmascript" id="ecmascript">ECMAScript Compatibility</a></h2>
      
    <p>The following table provides a rough overview of ECMAScript Editions
      and relations between them and versions of their implementations.  Note
      that conforming implementations are allowed to <em>extend</em> ECMAScript,
      so these are <em>by no means</em> 1:n relations; instead, this is the
      result of a comparison of most common language features.</p>
      
    <p style="text-align:left"
       >See <a href="#features">Language&nbsp;Features</a>
       above for details.</p>
      
    <table class="versions"
           summary="ECMAScript editions and versions of implementations that implement them best"
           >
      <thead>
        <tr>
          <td></td>
          <th>ECMAScript&nbsp;Edition&nbsp;1</th>
          <th>2</th>
          <th>3</th>
          <th>4<br>(Working&nbsp;Draft; abandoned)</th>
          <th>5<br>(Working&nbsp;Draft)</th>
          <th>6<br>("Harmony", Working&nbsp;Draft)</th>
        </tr>
        <tr>
          <th></th>
          <td><a href="http://www.mozilla.org/js/language/"
            >June&nbsp;1997</a></td>
          <td><a href="http://www.mozilla.org/js/language/"
            >August&nbsp;1998</a></td>
          <td><a href="http://www.ecma-international.org/publications/standards/Ecma-262.htm"
            >December&nbsp;1999</a> &#8211;&nbsp;<a
            href="http://developer.mozilla.org/en/docs/JavaScript_Language_Resources#JavaScript_1.x">March&nbsp;2000</a></td>
          <td><a href="http://www.ecmascript.org/"
            >August&nbsp;2000 &#8211;&nbsp;June&nbsp;2003
             &#8211;&nbsp;2008</a></td>
          <td><a href="http://www.ecmascript.org/"
            >April&nbsp;2009&#8212;</a></td>
          <td><a href="http://www.ecmascript.org/"
            >April&nbsp;2009&#8212;</a></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th><a href="#actionscript">ActionScript</a></th>
          <td></td>
          <td></td>
          <td>2.0 (2004)</td>
          <td>3.0 (2008&#8212;)</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th><a href="#javascript">JavaScript</a></th>
          <td>1.1, 1.3, 1.4</td>
          <td></td>
          <td>1.5&#8211;1.8</td>
          <td>2.0</td>
          <td>1.8.1&#8212; (2009-06-30&#8212;)</td>
          <td></td>
        </tr>
        <tr>
          <th><a href="#jscript">JScript</a></th>
          <td>1.0</td>
          <td></td>
          <td>5.5, 5.6</td>
          <td>7.0 (.NET)</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th><a href="http://www.opera.com/docs/specs/js/ecma/">Opera</a></th>
          <td></td>
          <td></td>
          <td>6.0 (2001-12)</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>

    <table class="versions" style="margin-top:1em"
           summary="Editions of ECMAScript for XML and implementations that implement them best"
           >
      <thead>
        <tr>
          <td></td>
          <th>ECMAScript&nbsp;for&nbsp;XML (E4X)</th>
        </tr>
        <tr>
          <td></td>
          <td><a
    href="http://www.ecma-international.org/publications/standards/Ecma-357.htm"
            >June&nbsp;2004</a></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th><a href="#javascript">JavaScript</a></th>
          <td>1.6+</td>
        </tr>
        <tr>
          <th><a href="#actionscript">ActionScript</a></th>
          <td>2.0</td>
        </tr>
      </tbody>
    </table>

    <div style="margin-top: 1em; border-top: 1px solid black;">
      <div><a href="http://validator.w3.org/check/referer"><img
              src="/media/valid-html401.png"
              style="border: 0"
              alt="Valid HTML 4.01"
              ></a></div>
      <p>built with<br>
        <a href="http://www.eclipse.org/"><img
           src="/media/eclipse.jpg"
           alt="eclipse"
           style="border: 0; width: 131px; height: 68px"
           ></a></p>
    </div>
  </body>
</html>
<?php
  if (! isset ($start_debug))
  {
    require('../../cgi_buffer/php/cgi_buffer.php');
  }
?>