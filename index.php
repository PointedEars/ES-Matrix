<?php
  /* DEBUG */
  // phpinfo();
  
  require_once 'es-matrix.inc.php';
  
  $encoding = mb_detect_encoding(file_get_contents(__FILE__));
  header("Content-Type: text/html; charset=$encoding");
  
  $modi = max(array(
    @filemtime(__FILE__),
    @filemtime('es-matrix.inc.php'),
    @filemtime('style.css'),
    @filemtime('table.js')));

  header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $modi) . ' GMT');
  
  /* Cached resource expires in HTTP/1.0 caches 24h after last retrieval */
  header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php
      echo $encoding;
      ?>">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <meta http-equiv="Content-Style-Type" content="text/css">
    
    <title>ECMAScript Support Matrix</title>

    <meta name="DCTERMS.alternative" content="ES Matrix">
    <meta name="DCTERMS.audience" content="Web developers">
    <meta name="DCTERMS.available" content="2009-12-15T04:06:35+00:00">
    <meta name="DCTERMS.contributor" content="Michael Winter &lt;<?php
      echo randomEsc('m.winter@blueyonder.co.uk');
      ?>&gt;">
    <meta name="DCTERMS.contributor" content="Juriy 'kangax' Zaytsev &lt;<?php
      echo randomEsc('kangax@gmail.com');
      ?>&gt;">
    <meta name="DCTERMS.contributor" content="BootNic &lt;<?php
      echo randomEsc('bootnic.bounce@gmail.com');
      ?>&gt;">
    <meta name="DCTERMS.created" content="2005-11-29T00:42:12+01:00">
    <meta name="DCTERMS.creator" content="Thomas 'PointedEars' Lahn &lt;<?php
      echo randomEsc('js@PointedEars.de');
      ?>&gt;">
    <meta name="DCTERMS.date" content="<?php
      echo gmdate('Y-m-d\TH:i:s+00:00', $modi);
      ?>">
    
    <link rel="stylesheet" href="/styles/tooltip.css" type="text/css">
    <link rel="stylesheet" href="../../style.css" type="text/css">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="not-ns4.css" type="text/css" media="all">
    <link rel="alternate stylesheet" href="ct.css" type="text/css" title="c't">
    <!--[if IE 7]>
      <style type="text/css">
        /* IE 7: Support for scrollable tbody is buggy;
          disabled because height: auto for the row appears to fix it */
        /*
        table>tbody.scroll {
          height: auto;
          overflow: visible;
          border-top: 1px;
          border-left-color: black;
        }
        */
      </style>
    <![endif]-->
    
    <script type="text/javascript" src="../../object.js"></script>
    <script type="text/javascript" src="../../types.js"></script>
    <script type="text/javascript" src="../debug.js"></script>
    <script type="text/javascript" src="../../dhtml.js"></script>
    <script type="text/javascript" src="table.js"></script>
  </head>
  
  <body onload="alternateRows(); synhl(); scroller.init();">
    <h1><a name="top" id="top">ECMAScript Support Matrix</a></h1>
    
    <p style="text-align: left">Copyright &copy;
      2005&#8211;<?php echo gmdate('Y', $modi); ?>
      Thomas Lahn
      &lt;<a href="<?php echo randomEsc('mailto:js@PointedEars.de'); ?>"
      ><?php echo randomEsc('js@PointedEars.de'); ?></a>&gt;
      (<a href="#contributors">contributors</a>)</p>
    
    <p style="text-align: left">Last&nbsp;modified:
      <?php echo gmdate('Y-m-d\TH:i:s+00:00', $modi); ?>
      (<a href="diff?type=changelog">change&nbsp;log</a>)
      (<a href="diff" title="Differences to previous revision">diff</a>)</p>
    
    <p style="text-align: left">Available online at <a
       href="<?php
               $s = 'http://PointedEars.de/scripts/test/es-matrix/';
               echo $s;
             ?>"
       ><?php echo $s; ?></a></p>
    
<?php
  if ($_SERVER['QUERY_STRING'] == 'redir')
  {
?>
    <p><strong>You have been redirected here because the URI that was used
      to access this resource is obsolete, and may stop working in the future.
      Please update your bookmarks using the link/URI above. If you followed
      a link from another site, please notify its webmaster about
      the change.</strong></p>
<?php
  }
?>
    
    <h2 style="margin-top: 1em; padding-top: 1em; border-top: 1px solid black"
        ><a name="toc" id="toc">Table of Contents</a></h2>
    
    <div><a href="#top">&#8593; top of document</a></div>
    
    <ul>
      <li><a href="#features">Language features</a></li>
      <li><a href="#javascript">Netscape/Mozilla.org JavaScript version information</a></li>
      <li><a href="#jscript">Microsoft JScript version information</a></li>
      <li><a href="#v8">Google V8 version information</a></li>
      <li><a href="#jsc">Apple JavaScriptCore version information</a></li>
      <li><a href="#actionscript">Adobe ActionScript version information</a></li>
      <li><a href="#ecmascript">ECMAScript compatibility</a></li>
      <li><a href="#contributors">List of contributors</a></li>
    </ul>
    
    <h2><a name="features" id="features">Language&nbsp;Features</a></h2>
    
    <div><a href="#toc">&#8593; table of contents</a></div>
    
    <p>The following table lists all features of ECMAScript implementations
      that are not part of the first versions/editions of all of these
      languages, with the version/edition that introduced it; furthermore,
      information about features that have been deprecated is included. That
      means if a <em>language</em> feature is not listed here, you can
      consider it to be universally supported.</p>
    
    <p>In addition, features have been
      <span class="safe"><span class="visual">highlighted with a greenish
      background color</span></span> if this author considers them
      <em>safe</em> to use without prior feature test even when they do not
      appear to be universally supported. This assessment is mostly based on
      the fact that the versions of the implementations the features require
      can be considered obsolete because the user agents known to implement
      them can be considered obsolete. Note that this assessment is likely
      to be subject to change as more implementations are evaluated. If taken
      as a recommendation for design decisions, it should be taken as
      a light one.</p>
    
    <!-- <p>In contrast, features have been
      <span class="unsafe"><span class="visual">highlighted with a yellowish
      background color</span></span> if this author considers them
      <em>unsafe</em>; that is, it is recommended not to use them without
      feature test and fallback, or only in a controlled environment.</p> -->
    
    <p><strong>The content of this table is based on what could be found in
      vendor's online documentations to date and on occasions where the
      respective features could be tested; <em>it does not claim to be
      accurate or complete</em> (please note how each feature is marked).
      Any correction/addition as to how things really are is welcome and
      will be <a href="#contributors">credited</a> where it is due.</strong></p>
        
    <p><em>If you are using Firefox&nbsp;3.0 and the scrollable table body
      flows out of the table, you are observing <a
      href="https://bugzilla.mozilla.org/show_bug.cgi?id=423823"
      title="Bug 135236 (VERIFIED FIXED): Overflowing tbody rows render background color for overflowing rows"
      class="closed"
      >Bug&nbsp;423823</a>, fixed since <a
      href="http://www.mozilla-europe.org/en/firefox/3.0.2/releasenotes/"
      >Firefox&nbsp;3.0.2</a>.<br>
      Since this was a regression, this author deems it necessary not to cover
      it with a workaround. Because new versions also include a number of <a
      href="http://www.mozilla.org/security/known-vulnerabilities/firefox30.html"
      >security fixes</a>, you are strongly recommended to <a
      href="http://www.mozilla.com/firefox/"
      >update&nbsp;Firefox</a>. As an alternative, you can toggle table body
      scrollability.</em></p>
    
    <table
        id="features-table"
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
            $features->printHeaders();
          ?>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="8">
            <table summary="Legend">
              <tr>
                <th>Legend:</th>
                <td class="assumed">Untested assumed availability</td>
                <td>Untested documented feature</td>
                <td class="tested">Feature availability confirmed by test</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="8">* discrepancy between the vendor's documentation
            and the real implementation</td>
        </tr>
        <tr>
          <td colspan="8">? unconfirmed contribution by other people</td>
        </tr>
        <tr>
          <td colspan="8">
            <table summary="Footnotes">
              <tr>
                <th class="nowrap"><a name="fn-this-ua"><sup>1</sup></a>
                  <a href="#this-ua" class="backref">&#8593;</a></th>
                <td>
                  <ul>
                    <li>This user agent:
                      <script type="text/javascript">
                        document.write('<p><b>' + navigator.userAgent + '<\/b><\/p>');
                      </script>
                      <noscript>
                        <p><?php echo $_SERVER['HTTP_USER_AGENT']; ?></p>
                      </noscript>
                    </li>
    
                    <li><a name="script-engine-test" id="script-engine-test"
                      >This ECMAScript implementation</a><script type="text/javascript">
                        var
                          jsx_object = jsx.object,
                          bCanDetect = jsx_object.isMethod(this, "ScriptEngine"),
                      
                          /* No array or loop here for backwards compatibility */
                          out = "";
                     
                        if (bCanDetect)
                        {
                          out += ":<p><b>" + ScriptEngine();
  
                          if (jsx_object.isMethod(this, "ScriptEngineMajorVersion"))
                          {
                            out += " " + ScriptEngineMajorVersion();
  
                            if (jsx_object.isMethod(this, "ScriptEngineMinorVersion"))
                            {
                              out += "." + ScriptEngineMinorVersion();
  
                              if (jsx_object.isMethod(this, "ScriptEngineBuildVersion"))
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
                              var s = "";
                              
                              for (var i = 0, len = versionMap.length; i < len; ++i)
                              {
                                var mapping = versionMap[i];
                                if (version >= mapping[0])
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
                              var m = null;
                              
                              if (jsx_object.isMethod(ua, "match"))
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
                                          ["5.0.342", "2.1"],
                                          ["5.0.307", "2.0"],
                                          ["4.0.249", "1.3"],
                                          ["3.0",     "1.2"],
                                          ["2.0",     "0.4"]
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
                              
                              if (jsx_object.isMethod(ua, "match"))
                              {
                                m = ua.match(/\brv:(\d+\.\d+(\.\d+)*)\b/);
                              }
                             
                              if (m) out += " at least";
                            
                              out += " Netscape/Mozilla.org JavaScript<sup>TM<\/sup>";
  
                              if (m)
                              {
                                s = inferVersion(m[1],
                                  [
                                    ["1.9.2", "1.8.2"],
                                    ["1.9.1", "1.8.1"],
                                    ["1.9",   "1.8"],
                                    ["1.8.1", "1.7"],
                                    ["1.8",   "1.6"],
                                    ["0.6",   "1.5"]
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
                </td>
              </tr>
              <tr>
                <th class="nowrap"><a name="fn-generic"><sup>G</sup></a>
                  <a href="#generic" class="backref">&#8593;</a></th>
                <td>This method is intentionally specified or implemented as <em>generic</em>;
                  it does not require that its <code class="rswd">this</code>
                  value be an object of the same type. Therefore, it can be
                  transferred to other kinds of objects for use as a method.</td>
              </tr>
              <tr>
                <th class="nowrap"><a name="fn-decl-ver"><sup>V</sup></a>
                  <a href="#decl-ver" class="backref">&#8593;</a></th>
                <td>Version needs to be declared in order to use this feature</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="8">
            <p><a name="tested" id="tested">When a feature has been marked as
            <span class="tested">tested</span>, the following user&nbsp;agents
              have been used for the tests:</a></p>
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
                  <li>Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.5)
                      Gecko/20091112 Iceweasel/3.5.5 (like Firefox/3.5.5;
                      Debian-3.5.5-1)</li>
                  <li>Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.6)
                      Gecko/20091216 Iceweasel/3.5.6 (like Firefox/3.5.6;
                      Debian-3.5.6-1)</li>
                  <li>Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.3)
                      Gecko/20100404 Iceweasel/3.6.3 (like Firefox/3.6.3)</li>
                </ul>
              </li>
              <li><span title="Microsoft JScript">JScript</span>
                <ul>
                  <li>Mozilla/4.0 (compatible; MSIE 4.01; Windows NT 5.0)</li>
                  <li>Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.1; .NET
                      CLR 1.1.4322; .NET CLR 2.0.50727)</li>
                  <li>Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET
                      CLR 1.1.4322; .NET CLR 2.0.50727)</li>
                  <li>Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET
                      CLR 1.1.4322; .NET CLR 2.0.50727)</li>
                  <li>Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1;
                      Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727)</li>
                </ul>
              </li>
              <li><abbr title="Google V8">V8</abbr>
                <ul>
                  <li>Mozilla/5.0 (X11; U; Linux i686; en-US)
                      AppleWebKit/532.5 (KHTML, like Gecko) Chrome/4.0.249.43
                      Safari/532.5</li>
                  <li>Mozilla/5.0 (X11; U; Linux i686; en-US)
                      AppleWebKit/533.2 (KHTML, like Gecko) Chrome/5.0.342.9
                      Safari/533.2</li>
                </ul></li>
              <li><abbr title="Apple WebKit JavaScriptCore">JSC</abbr>
                <ul>
                  <li>Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-us)
                      AppleWebKit/412.6.2 (KHTML, like Gecko) Safari/412.2.2
                      (Safari&nbsp;2.0)</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)
                      AppleWebKit/525.13 (KHTML, like Gecko) Version/3.1
                      Safari/525.13</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE)
                      AppleWebKit/525.19 (KHTML, like Gecko) Version/3.1.2
                      Safari/525.21</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE)
                      AppleWebKit/525.27.1 (KHTML, like Gecko) Version/3.2.1
                      Safari/525.27.1</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE)
                      AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0
                      Safari/530.17</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)
                      AppleWebKit/531.9 (KHTML, like Gecko) Version/4.0.3
                      Safari/531.9.1</li>
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)
                      AppleWebKit/531.21.8 (KHTML, like Gecko) Version/4.0.4
                      Safari/531.21.10</li>
                </ul>
              </li>
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
                  <li>Opera/9.80 (X11; Linux i686; U; en) Presto/2.2.15
                      Version/10.00</li>
                  <li>Opera/9.80 (X11; Linux i686; U; en) Presto/2.2.15
                      Version/10.10</li>
                </ul>
              </li>
    
              <li><acronym title="Konqueror JavaScript">KJS</acronym>
                <ul>
                  <li>Mozilla/5.0 (compatible; Konqueror/3.5;
                      Linux 2.6.29.4-20090531.213230+0200; X11; i686; de, en_US)
                      KHTML/3.5.10 (like Gecko) (Debian package 4:3.5.10.dfsg.1-2)</li>
                  <li>Mozilla/5.0 (compatible; Konqueror/4.3;
                      Linux 2.6.31.1-20090928.230129+0200; X11; i686; de)
                      KHTML/4.3.2 (like Gecko)</li>
                </ul>
              </li>
            </ul>
          </td>
        </tr>
      </tfoot>
      <tbody class="scroll" id="scroller">
        <?php $features->printItems(); ?>
      </tbody>
    </table>
    
    <h2><a name="javascript" id="javascript">Netscape/Mozilla.org&nbsp;JavaScript
    Version Information</a><a href="#fn-javascript"><sup>1)</sup></a></h2>

   <div><a href="#toc">&#8593; table of contents</a></div>
    
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
            title="JavaScript Guide for JavaScript 1.1"
          >1.1</a></th>
          <th><a
            href="http://research.nihonsoft.org/javascript/jsref/"
            title="Client-side JavaScript 1.2 Reference"
          >1.2</a></th>
          <th><a
            href="http://research.nihonsoft.org/javascript/ClientReferenceJS13/"
            title="Client-side JavaScript 1.3 Reference"
          >1.3</a></th>
          <th><a
            href="http://research.nihonsoft.org/javascript/CoreReferenceJS14/"
            title="Core JavaScript 1.4 Reference"
          >1.4</a></th>
          <th><a
            href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference"
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
          >1.8.2</a></th>
          <th><a href="http://www.mozilla.org/js/language/js20/">2.0</a></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="13"><a name="fn-javascript" id="fn-javascript"
            >1)</a><a href="#javascript" class="backref">&#8593;</a>
            Version information from the JavaScript Guides and References;
            release dates from <a href="about:">about:</a>&nbsp;documents,
            <a href="http://www.mozilla.org/releases/cvstags.html">mozilla.org</a>
            and <a href="http://en.wikipedia.org/wiki/Mozilla_Firefox#History"
                   >Wikipedia</a>.</td>
        </tr>
      </tfoot>
      <tbody>
        <tr class="header">
          <th colspan="13">Implementations</th>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.org/js/spidermonkey/"
                 >Netscape/Mozilla.org SpiderMonkey</a></th>
          <td>1.0</td>
          <td>1.1</td>
          <td>1.2</td>
          <td>1.3</td>
          <td>1.4</td>
          <td>1.5</td>
          <td>1.6</td>
          <td>1.7</td>
          <td>1.8</td>
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
        <tr>
          <th><a href="http://www.mozilla.org/rhino/"
                 >Netscape/Mozilla.org Rhino</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>1.4R3 (1999-05)</td>
          <td><a href="http://www.mozilla.org/rhino/rhino15R1.html"
                 >1.5R1</a>&#8211;<a
                 href="http://www.mozilla.org/rhino/rhino15R5.html"
                 >1.5R5</a> (2000-09 &#8211;&nbsp;2004-03)</td>
          <td><a href="http://www.mozilla.org/rhino/rhino16R1.html"
                 >1.6R1</a>&#8211;<a
                 href="https://developer.mozilla.org/en/New_in_Rhino_1.6R7"
                 >1.6R7</a> (2004-11 &#8211;&nbsp;2007-08)</td>
          <td><a href="https://developer.mozilla.org/en/New_in_Rhino_1.7R1"
                 >1.7R1</a>&#8211;<a
                 href="https://developer.mozilla.org/en/New_in_Rhino_1.7R2"
                 >1.7R2</a>&#8212; (2008-03 &#8211;&nbsp;2009-03&#8212;)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
    
        <tr class="header">
          <th colspan="13">Layout Engines</th>
        </tr>
        <tr>
          <th><a href="https://developer.mozilla.org/en/docs/Gecko">Netscape/Mozilla.org
          NGLayout/Gecko</a></th>
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
    
        <tr class="header">
          <th colspan="13">Web Browsers</th>
        </tr>
        <tr>
          <th><a href="http://browser.netscape.com/">Netscape
          Navigator/Browser</a></th>
          <td>Navigator 2.0 (1996-03)</td>
          <td>3.0 (1996-08)</td>
          <td>4.0&#8211;4.05 (1997-06)</td>
          <td>4.06&#8211;4.8 (1998&#8211;2002)</td>
          <td>-</td>
          <td>Navigator&nbsp;6.x &#8211;&nbsp;Browser&nbsp;8.1.3 (2000-11-14
          &#8211;&nbsp;2007-04-02)</td>
          <td>-</td>
          <td>Navigator&nbsp;9.0b1 &#8211;&nbsp;9.0.0.6&nbsp;<span
            title="End-of-life"
          >&#8224;</span><br>
          (2007-06-05 &#8211;&nbsp;2008-02-29)</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.com/firefox/">Mozilla
          Phoenix/Firebird/Firefox</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>Phoenix&nbsp;0.1 &#8211;&nbsp;Firefox&nbsp;1.0.x&nbsp;<span
            title="End-of-life"
          >&#8224;</span><br>
          (2002-09-23 &#8211;&nbsp;2006-04-13)</td>
          <td>Firefox&nbsp;1.5a1 &#8211;2.0a3&nbsp;<span title="End-of-life">&#8224;</span><br>
          (2005-05-31 &#8211;&nbsp;2006-05-26)</td>
          <td>2.0b1 &#8211;2.0.0.18&nbsp;<span title="End-of-life">&#8224;</span><br>
          (2006-07-12 &#8211;&nbsp;2008-11-12)</td>
          <td>3.0a2 &#8211;3.0.15b&#8212;<br>
          (2007-02-07 &#8211;&nbsp;2009-10-20&#8212;)</td>
          <td>3.5.x<br>
          (2009-06-30&#8212;)</td>
          <td>3.6&#8212;<br>
          (2010-01-21&#8212;)</td>
          <td></td>
        </tr>
    
        <tr class="header">
          <th colspan="13">Other Clients</th>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.org/products/mozilla1.x/">Mozilla
          Application&nbsp;Suite</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>0.6&#8211;1.8a6 (2000-12-06 &#8211;&nbsp;2005-01-12)</td>
          <td>1.8b1&#8211;1.7.13&nbsp;<span title="End-of-life">&#8224;</span><br>
          (2005-02-23 &#8211;&nbsp;2006-04-21)</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.org/projects/seamonkey/">Mozilla
          SeaMonkey</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>1.0&#8211;1.0.9 (2005-09-15 &#8211;&nbsp;2007-05-30)</td>
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
          <th><a href="http://www.mozilla.com/thunderbird/">Mozilla
          Thunderbird</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>2.0a1 &#8212;2.0.0.23&#8212; (2006-07-28
          &#8211;&nbsp;2009-01-03&#8212;)</td>
          <td>3.0a1<br>
          (2008-05-14&#8212;)</td>
          <td></td>
          <td></td>
        </tr>
    
        <tr class="header">
          <th colspan="13">Web Servers</th>
        </tr>
        <tr>
          <th><a href="http://wp.netscape.com/enterprise/">Netscape
          Enterprise&nbsp;Server</a>/<br>
          <a href="http://en.wikipedia.org/wiki/iPlanet"
            title="Wikipedia: iPlanet"
          >iPlanet</a>&nbsp;Web&nbsp;Server/<br>
          <a href="http://en.wikipedia.org/wiki/Sun_ONE"
            title="Wikipedia: Sun ONE"
          >Sun&nbsp;ONE</a> Web&nbsp;Server/<br>
          <a href="http://www.sun.com/software/products/appsrvr/">Sun
          Java&nbsp;System Web&nbsp;Server</a></th>
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
    
    <h2><a name="jscript" id="jscript">Microsoft&nbsp;JScript Version
    Information</a><a href="#fn-jscript"><sup>2)</sup></a></h2>
 
    <div><a href="#toc">&#8593; table of contents</a></div>
    
    <table class="versions"
      summary="JScript versions and the user agents that support them"
    >
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
          <th><a
            href="http://msdn2.microsoft.com/en-us/library/hbxc2t98.aspx"
            title="JScript 5.6 documentation"
          >5.6.6626</a> &#8211;&nbsp;5.6.8819</th>
          <th>5.7.5730</th>
          <th>5.7.17184</th>
          <th>5.8.18241</th>
          <th>.NET 7.0</th>
          <th><a
            href="http://msdn.microsoft.com/en-us/library/72bd815a%28VS.71%29.aspx"
            title="JScript .NET 7.0 documentation"
          >.NET 7.1</a></th>
          <th><a
            href="http://msdn.microsoft.com/en-us/library/72bd815a%28VS.80%29.aspx"
            title="JScript .NET 8.0 documentation"
          >.NET 8.0</a></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="15"><a name="fn-jscript" id="fn-jscript"
            >2)</a><a href="#jscript" class="backref">&#8593;</a>
            Version information from <a
              href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsoriVersionInformation.asp"
            ><acronym title="Microsoft Developer Network">MSDN</acronym>&nbsp;Library</a>;
            release&nbsp;dates from MSDN&nbsp;Library, <a
              href="http://www.blooberry.com/indexdot/history/ie.htm"
              title="Browser History: Windows Internet Explorer"
            >blooberry.com</a> and <a href="http://en.wikipedia.org/">Wikipedia</a>.<br>
            <em>Note that the language version supported by an environment
            may be greater than specified here due to security updates.
            When in doubt, use the <a href="#script-engine-test"
            >script engine test above</a> to determine the true version.</em>
          </td>
        </tr>
      </tfoot>
      <tbody>
        <tr class="header">
          <th colspan="16">Implementations</th>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/net/">Microsoft .NET Framework</a></th>
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
          <td>1.0 (2000-02)</td>
          <td>1.1 (2003)</td>
          <td>2.0&#8211;4.0 (2005&#8211;2010)</td>
        </tr>
    
        <tr class="header">
          <th colspan="16">Web Browsers</th>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/ie/">Microsoft Internet Explorer</a></th>
          <td>3.0 (1996-08&nbsp;<a
            href="http://en.wikipedia.org/wiki/Common_Era"
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
          <td>7.0 for <abbr title="Windows">Win</abbr>XP+ (2006-10)</td>
          <td>8.0 beta 1 for <abbr title="Windows">Win</abbr>XP SP2+
            (2008-03)</td>
          <td>8.0 beta 2 for <abbr title="Windows">Win</abbr>XP SP2+
            (2008-08)</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
    
        <tr class="header">
          <th colspan="16">Web Servers</th>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/iis/">Microsoft Internet
          Information Server/Services</a></th>
          <td></td>
          <td></td>
          <td>4.0</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>5.1&#8211;6.0</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
    
        <tr class="header">
          <th colspan="16">Operating Systems</th>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/windows/">Microsoft Windows</a></th>
          <td></td>
          <td>NT&nbsp;4.0 (1996)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>2000 (2000-02)</td>
          <td><acronym title="Millennium Edition">Me</acronym> (2000-09)</td>
          <td><abbr title="eXPeriment^H^H^H^Hence ;-)">XP</abbr> (2001-10)</td>
          <td>Vista (2008-03)</td>
          <td></td>
          <td>7<br>(2009-10)</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/windowsserver2003/">Microsoft
          Windows Server</a></th>
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
          <td></td>
        </tr>
    
        <tr class="header">
          <th colspan="16"><acronym
            title="Integrated Development Environment"
          >IDE</acronym>s</th>
        </tr>
        <tr>
          <th><a href="http://www.microsoft.com/visualstudio/en-us/products">Microsoft Visual Studio</a></th>
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
          <td>7.0&nbsp;.NET (2002)</td>
          <td>7.1 (2003)</td>
          <td>8.0&nbsp;(2005) &#8211;10.0&nbsp;(2010)</td>
        </tr>
      </tbody>
    </table>
    
    <h2><a name="v8" id="v8">Google&nbsp;V8 Version
    Information</a></h2>
 
    <div><a href="#toc">&#8593; table of contents</a></div>
    
    <table class="versions"
      summary="V8 versions and the user agents that support them"
    >
      <thead>
        <tr>
          <th></th>
          <th>V8&nbsp;0.3</th>
          <th>0.4</th>
          <th>1.2</th>
          <th>1.3</th>
          <th>2.0</th>
          <th>2.1</th>
        </tr>
      </thead>
      <tbody>
        <tr class="odd">
          <th><a href="http://www.google.com/chrome/">Google Chrome</a></th>
          <td>0.2&#8211;1.0 (2008-09&nbsp;<a
            href="http://en.wikipedia.org/wiki/Common_Era"
          ><acronym title="Common Era">CE</acronym></a>&#8212;2008-12)</td>
          <td>2.0 (2009-05)</td>
          <td>3.0 (2009-10)</td>
          <td>4.0.249 (2010-01-25)</td>
          <td>5.0.307 (2010-01-30)</td>
          <td>5.0.342</td>
        </tr>
      </tbody>
    </table>

    <h2><a name="jsc" id="jsc">Apple&nbsp;JavaScriptCore Version
    Information</a></h2>
 
    <div><a href="#toc">&#8593; table of contents</a></div>
    
    <table class="versions"
      summary="JavaScript Core versions and the user agents that support them"
    >
      <thead>
        <tr>
          <th></th>
          <th>JavaScriptCore&nbsp;412.6.2</th>
          <th>525.13</th>
          <th>525.19</th>
          <th>525.27.1</th>
          <th>530.17</th>
          <th>531.9</th>
          <th>531.21.8</th>
        </tr>
      </thead>
      <tbody>
        <tr class="odd">
          <th><a href="http://apple.com/safari/">Apple Safari</a></th>
          <td>2.0 (2005-04&nbsp;<a
            href="http://en.wikipedia.org/wiki/Common_Era"
          ><acronym title="Common Era">CE</acronym></a>)</td>
          <td>3.1 (2008-03)</td>
          <td>3.1.2 (2008-06)</td>
          <td>3.2.1 (2008-11)</td>
          <td>4.0 (2009-06)</td>
          <td>4.0.3 (2009-08)</td>
          <td>4.0.4 (2009-11)</td>
        </tr>
      </tbody>
    </table>
    
    <h2><a name="actionscript" id="actionscript">Macromedia/Adobe&nbsp;ActionScript
    Versions</a><a href="#fn-actionscript"><sup>3)</sup></a></h2>
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
          <td colspan="9"><a name="fn-actionscript" id="fn-actionscript"
            >3)</a><a href="#actionscript" class="backref">&#8593;</a>
            Version information from <a
              href="http://macromedia.com/software/flash/"
            >Macromedia</a></td>
        </tr>
      </tfoot>
      <tbody>
        <tr>
          <th><a href="http://macromedia.com/software/flash/">Macromedia
          Flash</a></th>
          <td>5.0&#8211;MX (2000&#8211;2003)</td>
          <td>7.1.1 (MX 2004)&#8212; (2004&#8212;)</td>
        </tr>
      </tbody>
    </table>
    
    <h2><a name="ecmascript" id="ecmascript">ECMAScript Compatibility</a></h2>
    
    <div><a href="#toc">&#8593; table of contents</a></div>
    
    <p>The following table provides a rough overview of ECMAScript Editions
    and relations between them and versions of their implementations. Note
    that conforming implementations are allowed to <em>extend</em>
    ECMAScript, so these are <em>by no means</em> 1:n relations; instead,
    this is the result of a comparison of most common language features.</p>
    
    <p style="text-align: left">See <a href="#features">Language&nbsp;Features</a>
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
          <th>4<br>
          (Working&nbsp;Draft; abandoned)</th>
          <th>5</th>
          <th>6<br>
          ("Harmony", Working&nbsp;Draft)</th>
        </tr>
        <tr>
          <th></th>
          <td><a href="http://www.mozilla.org/js/language/">June&nbsp;1997</a></td>
          <td><a href="http://www.mozilla.org/js/language/">August&nbsp;1998</a></td>
          <td><a
            href="http://www.ecma-international.org/publications/standards/Ecma-262.htm"
          >December&nbsp;1999</a> &#8211;&nbsp;<a
            href="http://developer.mozilla.org/en/docs/JavaScript_Language_Resources#JavaScript_1.x"
          >March&nbsp;2000</a></td>
          <td><a href="http://www.ecmascript.org/">August&nbsp;2000
          &#8211;&nbsp;June&nbsp;2003 &#8211;&nbsp;2008</a></td>
          <td><a href="http://www.ecmascript.org/">April&nbsp;2009 &#8211;&nbsp;December&nbsp;2009</a></td>
          <td><a href="http://www.ecmascript.org/">April&nbsp;2009&#8212;</a></td>
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
          <td>1.5&#8211;1.8.1.x</td>
          <td>2.0</td>
          <td>1.8.1 (2008-05)</td>
          <td></td>
        </tr>
        <tr>
          <th><a href="#jsc">JavaScriptCore</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th><a href="#jscript">JScript</a></th>
          <td>1.0 (1996)</td>
          <td></td>
          <td>5.5 (2000)</td>
          <td>.NET (2000)</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>KJS</th>
          <td></td>
          <td></td>
          <td>1.0</td>
          <td>-</td>
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
        <tr>
          <th><a href="#v8">V8</a></th>
          <td></td>
          <td></td>
          <td>0.3</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
    
    <table class="versions" style="margin-top: 1em"
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
          <th><a href="#actionscript">ActionScript</a></th>
          <td>2.0</td>
        </tr>
        <tr>
          <th><a href="#javascript">JavaScript</a></th>
          <td>1.6+</td>
        </tr>
        <tr>
          <th><a href="#jsc">JavaScriptCore</a></th>
          <td>-</td>
        </tr>
        <tr>
          <th><a href="#jscript">JScript</a></th>
          <td>-</td>
        </tr>
        <tr>
          <th>KJS</th>
          <td>-</td>
        </tr>
        <tr>
          <th><a href="http://www.opera.com/docs/specs/js/ecma/">Opera</a></th>
          <td>-</td>
        </tr>
        <tr>
          <th><a href="#v8">V8</a></th>
          <td>-</td>
        </tr>
      </tbody>
    </table>
    
    <h2><a name="contributors" id="contributors">List of Contributors</a></h2>

    <div><a href="#toc">&#8593; table of contents</a></div>
    
    <p><em>Thanks to:</em></p>
    
    <ul>
      <li>Michael&nbsp;Winter
        &lt;<a href="<?php echo randomEsc('mailto:m.winter@blueyonder.co.uk'); ?>"
        ><?php echo randomEsc('m.winter@blueyonder.co.uk'); ?></a>&gt;
        for tests with IE&nbsp;4.01 and NN&nbsp;4.08: Message-ID&nbsp;<a
        href="http://groups.google.com/groups/search?as_umsgid=urctf.17012$iz3.5930@text.news.blueyonder.co.uk"
        >&lt;urctf.17012$iz3.5930@text.news.blueyonder.co.uk&gt;</a></li>
      <li><a href="http://perfectionkills.com/">Juriy&nbsp;'kangax'&nbsp;Zaytsev</a>
        &lt;<a href="<?php echo randomEsc('mailto:kangax@gmail.com'); ?>"
        ><?php echo randomEsc('kangax@gmail.com'); ?></a>&gt;
        for tests with Safari&nbsp;2.0.2: Message-ID&nbsp;<a
        href="http://groups.google.com/groups/search?as_umsgid=MpOdnVEQCfgNMN_WnZ2dnUVZ_rNi4p2d@giganews.com"
        >&lt;MpOdnVEQCfgNMN_WnZ2dnUVZ_rNi4p2d@giganews.com&gt;</a></li>
      <li>BootNic &lt;<a href="<?php echo randomEsc('mailto:bootnic.bounce@gmail.com'); ?>"
        ><?php echo randomEsc('bootnic.bounce@gmail.com'); ?></a>&gt;
        for helping with the scrollable tbody workaround for IE: Message-ID&nbsp;<a
        href="http://groups.google.com/groups/search?as_umsgid=20100305112229.454328ac@bootnic.eternal-september.org"
        >&lt;20100305112229.454328ac@bootnic.eternal-september.org&gt;</a></li>
    </ul>
    
    <div style="margin-top: 1em; border-top: 1px solid black; padding-top: 1em">
    <div><a href="http://validator.w3.org/check/referer"
            ><img src="/media/valid-html401.png" style="border: 0"
                  alt="Valid HTML 4.01"></a></div>
    <p>built with<br>
    <a href="http://www.eclipse.org/"
       ><img src="/media/eclipse.jpg" alt="eclipse"
             style="border: 0; width: 131px; height: 68px"
             ></a></p>
    </div>
  </body>
</html>