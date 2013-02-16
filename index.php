<?php
/* DEBUG */
// phpinfo();

require_once 'es-matrix.inc.php';

$encoding = mb_detect_encoding(file_get_contents(__FILE__));
header("Content-Type: text/html" . ($encoding ? "; charset=$encoding" : ""));

$modi = max(array(
  @filemtime(__FILE__),
  @filemtime('es-matrix.inc.php'),
  @filemtime('style.css'),
  @filemtime('table.js')
));

header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $modi) . ' GMT');

/* Cached resource expires in HTTP/1.1 caches 24h after last retrieval */
header('Cache-Control: max-age=86400, s-maxage=86400, must-revalidate, proxy-revalidate');

/* Cached resource expires in HTTP/1.0 caches 24h after last retrieval */
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
  <head>
<!--     <script type="text/javascript" src="https://getfirebug.com/firebug-lite.js"></script> -->
    <meta http-equiv="Content-Type" content="text/html<?php
      if ($encoding)
      {
        echo "; charset= $encoding";
      }
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
    <!--[if lt IE 7]>
      <style type="text/css">
        /* IE 6 does not support position:fixed */
        #header {
          margin-top: 0;
        }
        
        #toc {
          margin-top: 1em;
          padding: 0;
          height: auto;
          border-style: solid none none none;
        }
      </style>
    <![endif]-->
    
    <script type="text/javascript"
            src="../../builder?<?php
              if ($_SERVER['HTTP_HOST'] === 'localhost')
              {
                ?>&amp;debug=1&amp;verbose=1&amp;<?php
              }
              ?>src=object,types,dom/xpath,http,regexp,test/debug,dom,dom/css,dom/events,test/es-matrix/table"></script>
    <script type="text/javascript">
      /* Import methods into global namespace */
      var _global = jsx.global;
      var test = jsx.debug.test;
      var isMethod = jsx.object.isMethod;
      var getFeature = jsx.object.getFeature;

      function initTooltips()
      {
        /* Imports */
        var createEventListener = jsx.dom.createEventListener;
        var addEventListener = jsx.dom.addEventListener;
        var addClassName = jsx.dom.css.addClassName;

        function tooltipMover(tooltip, e)
        {
          if (typeof e.offsetX != "undefined" && typeof e.offsetY != "undefined")
          {
            if (tooltip)
            {
              tooltip.style.left = e.offsetX + "px";
              tooltip.style.top = e.offsetY + "px";
            }
  
            e.preventDefault();
            e.stopPropagation();
          }
        }
                
        var elements = document.links;
        
        for (var i = 0, len = elements.length; i < len; ++i)
        {
          var element = elements[i];
          if (element.title)
          {
            var tooltip = document.createElement("span");
            if (!tooltip)
            {
              break;
            }

            addClassName(element, "tooltip");

            tooltip.className = "tooltip";
            tooltip.appendChild(document.createTextNode(element.title));
            element.title = "";
            element.appendChild(tooltip);

            var f = (function(tooltip) {
              return function(e) {
                tooltipMover(tooltip, e);
              };
            })(tooltip);

            var listener = createEventListener(f);
            
            addEventListener(element, "mouseover", listener);
            addEventListener(element, "mousemove", listener);
            addEventListener(element, "touchstart", listener);
            addEventListener(element, "touchmove", listener);
          }
        }
      }
    </script>
    <!-- <script type="text/javascript" src="/scripts/anti-SOPA.js"></script> -->
  </head>
  
  <body onload="/* antiSOPA('the ECMAScript\xA0Support\xA0Matrix'); */ alternateRows(); synhl(); scroller.init(); // initTooltips();">
    <div id="header">
      <h1><a name="top" id="top">ECMAScript Support Matrix</a></h1>
      <p class="subtitle">There is no javascript.</p>
    
      <p style="text-align: left">
        Copyright &copy; 2005&#8211;<?php echo gmdate('Y', $modi); ?>
          Thomas Lahn
          &lt;<a href="<?php echo randomEsc('mailto:js@PointedEars.de'); ?>"
          ><?php echo randomEsc('js@PointedEars.de'); ?></a>&gt;
          (<a href="#contributors">contributors</a>)</p>
    
      <div>
        <p style="margin-bottom: 0; text-align: left">
          Last&nbsp;modified:
          <?php echo gmdate('Y-m-d\TH:i:s+00:00', $modi); ?>
        </p>
    
        <ul class="horizontal">
          <li><a
            href="http://PointedEars.de/websvn/log.php?repname=es-matrix&amp;path=%2Ftrunk%2F&amp;isdir=1&amp;showchanges=1"
          >Change&nbsp;log</a></li>
          <li><a
            href="http://PointedEars.de/websvn/listing.php?repname=es-matrix&amp;path=%2Ftrunk%2F"
            title="Subversion repository browser"
          >SVN</a></li>
        </ul>
      </div>
    
      <p style="clear: left; text-align: left">
        Available online at <a
          href="<?php
                   $s = 'http://PointedEars.de/scripts/test/es-matrix/';
                   echo $s;
                 ?>"
        ><?php echo $s; ?></a>
      </p>
  
      <div><a href="#toc">Table of contents</a></div>
    </div>
    
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
    <div id="toc">
      <h2>Table of contents</h2>
      
      <div><a href="#top">&#8593; Top of document</a></div>
      
      <ul>
        <li><a href="#foreword">Foreword and rationale</a></li>
        <li><a href="#features">Language features</a></li>
        <li><a href="#version-info">Version information</a>
          <ul>
            <li><a href="#javascript">Netscape/Mozilla.org JavaScript</a></li>
            <li><a href="#jscript">Microsoft JScript</a></li>
            <li><a href="#v8">Google V8</a></li>
            <li><a href="#jsc">Apple JavaScriptCore</a></li>
            <li><a href="#opera">Opera ECMAScript</a></li>
            <li><a href="#actionscript">Adobe ActionScript</a></li>
            <li><a href="#ecmascript">ECMAScript compatibility</a></li>
            <li><a href="#timeline">Timeline</a></li>
          </ul></li>
        <li><a href="#contributors">List of contributors</a></li>
      </ul>
    </div>
    
    <div>
      <h2 style="margin-top: 1em; padding-top: 1em; border-top: 1px solid black"
          ><a name="foreword" id="foreword">Foreword and Rationale</a></h2>
      
          <blockquote>
            <p style="margin-bottom: 0; font-style: italic"
               ><!--<span lang="x-vulcan">&gt;Oren'uh pa'shi-nahpau.
                Oren'uh fai-tukh t'natyan — nam-tor vellar heh ri nam-tor.&lt;</span><br>
                (-->“Learn to think clearly.
                Learn to distinguish: what is, and what seems to be.”<!--)--></p>
            <div style="text-align: right"> —&nbsp;Surak<?php
    //              echo $this->footnotes->add('vli', null, 'see also:
    //                <a href="http://stogeek.com/wiki/Category:Vulcan_Language_Institute"
    //                   >Vulcan Language Institute</a>', ''); ?></div>
          </blockquote>
  
          <p>In a discussion, especially a technical one, it is very
             important that all participants know what is being talked
             about, so that misunderstandings can be avoided.  <em>Clear
             language</em> is required.  It can be achieved only by
             using terms that are <em>well-defined</em>; they should be
             unambiguous and one should be able to look them up
             in official reference material.</p>
            
          <p>Some people talk about a programming language they call
             “javascript”.  This is supposed to be one fully specified
             and universally implemented programming language that
             provides, in dialects to a varying degree, the
             capabilities to manipulate runtime environments such as
             web browsers.</p>
             
          <p>In fact, <strong>there is no “javascript”</strong>;
             there is <em>JavaScript</em>.  This is not just
             a matter of letter case: JavaScript is the name
             of <em>one</em> implementation of a standard for an
             extensible scripting language, <em>ECMAScript</em>.</p>
           
          <p>“A <em>scripting language</em> is a programming language
             that is used to manipulate, customise, and automate
             the facilities of an existing system.”<?php
               echo $footnotes->add('es5.1', null,
                 'Ecma&nbsp;International (2011&#8209;06).
                  <a href="http://www.ecma-international.org/publications/files/ECMA-ST/Ecma-262.pdf"
                     ><i>Standard ECMA&#8210;262. ECMAScript Language Specification.</i>
                      5.1 Edition.</a> (retrieved 2011&#8209;08&#8209;27)')
             ?>  The <em>ECMAScript Language Specification</em>
             is a standard for scripting languages.  It is published
             in <em>Editions</em>.
             Several current versions of scripting languages
             are implementations of an Edition of ECMAScript.
             But its first Edition was based itself on two scripting
             languages that were already implemented for use in
             web browsers: Netscape JavaScript 1.1 and Microsoft
             JScript 1.0.<?php
               echo $footnotes->add('es1', null,
                 'Ecma&nbsp;International (1997-06).
                  <a href="http://www.ecma-international.org/publications/files/ECMA-ST-ARCH/ECMA-262,%201st%20edition,%20June%201997.pdf"
                     ><i>ECMAScript Language Specification (1st edition)</i></a> (retrieved 2012&#8209;12&#8209;10)')
             ?></p>
             
          <p><strong>There are no dialects of “javascript”</strong>;
             there are <em>several implementations of ECMAScript</em>
             that are widely distributed, primarily through web browsers.
             The features that allow one to manipulate web browsers
             are <em>not</em> part of any such programming language;
             they are environment-dependent implementations of
             language-independent
             <abbr title="API: Application Programming Interface">API</abbr>s
             for which a <em>language binding</em> is specified <?php
               echo $footnotes->add('binding', null,
                 'See <a href="http://www.w3.org/TR/2003/REC-DOM-Level-2-HTML-20030109/ecma-script-binding.html"
                  >W3C DOM Level 2 HTML</a> for an example of language binding.');
             ?> so they it can
             be used with that programming language.<?php
               echo $footnotes->add('legacy', null,
                 'The distinction between core language and browser API
                  was not made in Netscape JavaScript before version 1.4.
                  JavaScript was designed to be the programming language
                  for scripts in Netscape Navigator, therefore the
                  Netscape API was part of JavaScript. This changed
                  when JavaScript needed to work server-side in
                  Netscape Enterprise Server as well.');
            ?></p>
        
          <h3>The same, but not the same</h3>
          
          <p>Superficially, ECMAScript implementations are very similar.
             It is therefore tempting to discuss them in a simplified way
             using an umbrella term such as “javascript”.<?php
               echo $footnotes->add('cljs-FAQ', null,
                 '<a href="http://jibbering.com/faq/">comp.lang.javascript FAQ</a>');
             ?> But this approach is not without problems.
             ECMAScript gives its conforming implementations a wide latitude.
             The Editions of ECMAScript and their implementations
             have been developed in parallel, and are partially
             informing each other.  Also, some implementations
             are not conforming in some features.  As a result,
             ECMAScript implementations are in fact very different
             from one another.</p>
             
          <p>It does matter which implementation is being discussed.
             Using ambiguous umbrella terms, without providing a
             clear definition for them, cannot be considered
             appropriate style in a technical discussion.</p>
          
          <p>Hence, for lack of a better alternative, the precise
             and equally concise term <strong>ECMAScript implementation(s)</strong>
             should be used when talking about features that several
             implementations (ought to) have in common (per
             the ECMAScript Language Specification).  And whenever
             it was talked about one particular implementation, its proper
             name should be used, like <strong>Netscape/Mozilla.org JavaScript</strong>
             or simply <strong>JavaScript</strong> (if there is doubt,
             "™" might be added to emphasize that the implementation
             is meant).  <strong>In all other instances, the term
             “JavaScript” (in any letter case) should <em>not</em>
             be used.</strong></p>
        
          <h3>What is the Matrix?</h3>
              
          <p>This overview&nbsp;– the <em>ECMAScript Support Matrix</em> –
             began as a comparison of different “JavaScript” features and,
             as time passed and understanding grew, evolved into a comparison
             between the major ECMAScript implementations, detailing
             the differences, the quirks and the bugs.  It has been serving
             its author (and its dedicated readers) for years in writing
             client-side scripts that work cross-browser, and has been helping
             to see the distinction between core language features, and APIs
             with language binding, like the DOM.  (The features of the latter
             API will be compared in another Matrix.)</p>
                       
          <p>Whenever you read from this author that key line from arguably
             <a href="http://en.wikipedia.org/wiki/The_Matrix"
                title="The Matrix movie on Wikipedia"
                >the most groundbreaking hacker movie</a>
             &#8213;“The Matrix has you!”&#8213; a suggestion
             is being considered as a
             <a href="#contributors">contribution</a> to this work.
             See below.</p>
    </div>
    
    <div>
      <h2><a name="features" id="features">Language&nbsp;Features</a></h2>
      
      <div><a href="#toc">&#8593; Table of contents</a></div>
      
      <p>The following table lists all features of ECMAScript implementations
        that are not part of the first versions/editions of all of these
        languages, with the version/edition that introduced it; furthermore,
        information about features that have been deprecated is included.
        That means if a <em>language</em> feature is not listed here, you can
        consider it to be universally supported.</p>
      
      <p>In addition, features have been
        <span class="safe"><span class="visual">highlighted with a greenish
        background color</span></span> if this author considers them
        <em>safe</em> to use without prior feature test even when they do not
        appear to be formally specified or to be supported among all versions
        of all implementations considered here.  This is based on the fact
        that all minimum versions of the implementations that a&nbsp;feature
        requires can be considered obsolete because the user&nbsp;agents known
        to implement them can be considered obsolete (see the respective
        <a href="#version-info">version information</a> for details).  Note
        that this assessment is likely to be subject to change as more
        implementations are evaluated.  If taken as a&nbsp;recommendation
        for design decisions, it should be taken as a light&nbsp;one.</p>
      
      <!-- <p>In contrast, features have been
        <span class="unsafe"><span class="visual">highlighted with a yellowish
        background color</span></span> if this author considers them
        <em>unsafe</em>; that is, it is strongly recommended not to use them
        without feature test and fallback, or only in a limited
        environment.</p> -->
      
      <p><strong>The content of this table is based on what could be found in
        vendor's online documentations to date and on occasions where the
        respective features could be tested; <em>it does not claim to be
        accurate or complete</em> (please note how each feature is marked).
        Any correction/addition as to how things really are is welcome and
        will be <a href="#contributors">credited</a> where it is due.</strong></p>
      
      <h3>Known Display Problems</h3>
      <ul>
        <li><b>Firefox&nbsp;3.0.x:</b> If the scrollable table body
          flows out of the table, you are observing
          <a href="https://bugzilla.mozilla.org/show_bug.cgi?id=423823"
             title="Bug 135236 (VERIFIED FIXED): Overflowing tbody rows render background color for overflowing rows" class="closed"
             >Bug&nbsp;423823</a>, fixed since
          <a href="http://www.mozilla-europe.org/en/firefox/3.0.2/releasenotes/"
             >Firefox&nbsp;3.0.2</a>.
          <em>The Firefox&nbsp;3.0 branch has met its
          <a href="#javascript">end-of-life on 2010-03-30&nbsp;CE</a></em>.
          If you are still using Firefox&nbsp;3.0.x as your primary browser, you
          are strongly recommended to <a href="http://www.mozilla.com/firefox/"
          >update&nbsp;Firefox</a> (but see below).  As an alternative, you can
          toggle table body scrollability.</li>
        <li><b>Firefox&nbsp;4.0+:</b> The support for scrollable table body
          has been removed per
          <a
            href="https://bugzilla.mozilla.org/show_bug.cgi?id=28800"
            title="Bug 28800 (RESOLVED FIXED): Remove the ability for rowgroups to scroll (e.g. &quot;tbody style=&quot;overflow:auto&quot;&gt;)"
          >Bug&nbsp;28800</a>.  This violates the
          <a  href="http://www.w3.org/TR/css3-box/#overflow"
              title="CSS3 Basic Box Model">CSS3 Basic Box Model</a>
          specification, which is only a Working Draft at the time of writing
          but is intended to replace the corresponding parts of CSS 2.1.
          If you want this useful feature (back), please comment on and vote for
          <a href="https://bugzilla.mozilla.org/show_bug.cgi?id=674214#c6"
             title="Bug 674214 (RESOLVED INVALID): Add the ability for rowgroups to scroll (e.g. &lt;tbody style=&quot;overflow:auto&quot;&gt;)"
             >Bug&nbsp;67421</a>.</li>
      </ul>
      
      <p>Since both of these were regressions, this author deems it necessary
        not to cover any of them with a workaround.</p>
    </div>
        
    <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST">
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
                  <li>Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1;
                      Trident/5.0; SLCC2; .NET CLR 2.0.50727;
                      .NET CLR 3.5.30729; .NET CLR 3.0.30729;
                      Media Center PC 6.0; InfoPath.3; .NET CLR 1.1.4322;
                      .NET4.0C)</li>
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
                  <li>Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)
                      AppleWebKit/533.16 (KHTML, like Gecko) Version/5.0
                      Safari/533.16</li>
                </ul>
              </li>
              <li>Opera ECMAScript
                <ul>
                  <!-- <li>Mozilla/4.0 (Windows 3.95;DE) Opera 3.60 [de]</li> -->
                  <li>Mozilla/4.0 (compatible; MSIE 5.0; Windows NT 5.1)
                      Opera 5.02 [en]</li>
                  <li>Mozilla/4.0 (compatible; MSIE 5.0; Windows XP)
                      Opera 6.06 [en]</li>
                  <li>Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 5.1)
                      Opera 7.02 [en]</li>
                  <li>Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en)
                      Opera 8.0</li>
                  <!-- <li>Opera/9.27 (Windows NT 5.1; U; en)</li>
                  <li>Opera/9.52 (Windows NT 5.1; U; en)</li>
                  <li>Opera/9.62 (Windows NT 5.1; U; en) Presto/2.1.1</li>
                  <li>Opera/9.64 (Windows NT 5.1; U; en) Presto/2.1.1</li>
                  <li>Opera/9.64 (X11; Linux i686; U; en) Presto/2.1.1</li>
                  <li>Opera/9.80 (X11; Linux i686; U; en) Presto/2.2.15
                      Version/10.00</li>
                  <li>Opera/9.80 (X11; Linux i686; U; en) Presto/2.2.15
                      Version/10.10</li> -->
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
      <tbody id="scroller" class="scroll">
       <?php $features->printItems(); ?>
      </tbody>
    </table>
    </form>
    
    <?php $footnotes->flush(); ?>

    <div>
      <h2><a name="version-info" id="version-info">Version Information</a></h2>
  
      <div><a href="#toc">&#8593; Table of contents</a></div>
  
      <ul>
        <li><a href="#javascript">Netscape/Mozilla.org JavaScript</a></li>
        <li><a href="#jscript">Microsoft JScript</a></li>
        <li><a href="#v8">Google V8</a></li>
        <li><a href="#jsc">Apple JavaScriptCore</a></li>
        <li><a href="#opera">Opera ECMAScript</a></li>
        <li><a href="#actionscript">Adobe ActionScript</a></li>
        <li><a href="#ecmascript">ECMAScript compatibility</a></li>
        <li><a href="#timeline">Timeline</a></li>
      </ul>
      
      <h3><a name="javascript" id="javascript">Netscape/Mozilla.org&nbsp;JavaScript
      Version Information</a><a href="#fn-javascript"><sup>1)</sup></a></h3>
  
      <div><a href="#version-info">&#8593; Version information</a></div>
    </div>
    
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
            href="http://web.archive.org/wp.netscape.com/eng/mozilla/3.0/handbook/javascript/"
            title="JavaScript Guide for JavaScript 1.1 (archived at the Internet Wayback Machine)"
            >1.1</a></th>
          <th><a
            href="http://research.nihonsoft.org/javascript/jsref/"
            title="Client-side JavaScript 1.2 Reference (archived at Nihonsoft Research)"
            >1.2</a></th>
          <th><a
            href="http://research.nihonsoft.org/javascript/ClientReferenceJS13/"
            title="Client-side JavaScript 1.3 Reference (archived at Nihonsoft Research)"
            >1.3</a></th>
          <th><a
            href="http://research.nihonsoft.org/javascript/CoreReferenceJS14/"
            title="Core JavaScript 1.4 Reference (archived at Nihonsoft Research)"
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
          <th><a
            href="https://developer.mozilla.org/en/JavaScript/New_in_JavaScript/1.8.5"
            title="New in JavaScript 1.8.5"
            >1.8.5</a></th>
          <th><a
            href="https://developer.mozilla.org/en/Firefox_for_developers#JavaScript"
            title="Firefox 5 for developers: JavaScript"
            >1.8.6</a></th>
          <th><a href="http://replay.waybackmachine.org/20061205033609/http://www.mozilla.org/js/language/js20/"
                 >2.0</a> (historic)</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="14"><a name="fn-javascript" id="fn-javascript"
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
          <th colspan="15">Implementations</th>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.org/js/spidermonkey/"
                 >Netscape/Mozilla.org SpiderMonkey</a> (in C)</th>
          <td>1.0</td>
          <td>1.1</td>
          <td>1.2</td>
          <td>1.3</td>
          <td>1.4</td>
          <td>1.5</td>
          <td>1.6</td>
          <td>1.7</td>
          <td>1.8</td>
          <td>1.8.1 (<a
            href="https://developer.mozilla.org/En/SpiderMonkey/Internals/Tracing_JIT"
            >TraceMonkey</a>)</td>
          <td>1.8.2</td>
          <td>1.8.5 (<a
            href="https://wiki.mozilla.org/JaegerMonkey">JägerMonkey</a>)</td>
          <td>1.8.6</td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.org/js/language/Epimetheus.html"
                 >Mozilla.org Epimetheus</a> (in C++)</th>
          <td colspan="13"></td>
          <td>+</td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.org/rhino/"
                 >Netscape/Mozilla.org Rhino</a> (in Java)</th>
          <td colspan="4"></td>
          <td>1.4R3 (<span title="1999-05-10">1999</span>)</td>
          <td><a href="http://www.mozilla.org/rhino/rhino15R1.html"
                 >1.5R1</a>&#8211;<a
                 href="http://www.mozilla.org/rhino/rhino15R5.html"
                 >1.5R5</a>
            (<span title="2000-09-10 &#8211;&nbsp;2004-03-25">2000&#8211;2004</span>)</td>
          <td><a href="http://www.mozilla.org/rhino/rhino16R1.html"
                 >1.6R1</a>&#8211;<a
                 href="https://developer.mozilla.org/en/New_in_Rhino_1.6R7"
                 >1.6R7</a>
            (<span title="2004-11-29 &#8211;&nbsp;2007-08-20">2004&#8211;2007</span>)</td>
          <td><a href="https://developer.mozilla.org/en/New_in_Rhino_1.7R1"
                 >1.7R1</a>&#8211;<a
                 href="https://developer.mozilla.org/en/New_in_Rhino_1.7R2"
                 >1.7R2</a>
            (<span title="2008-03-06 &#8211;&nbsp;2009-03-22">2008&#8211;2009</span>)</td>
          <td><a href="https://developer.mozilla.org/en/New_in_Rhino_1.7R3"
                 >1.7R3</a>
            (2011&#8209;06&#8209;03)</td>
        </tr>
    
        <tr class="header">
          <th colspan="15">Layout Engines</th>
        </tr>
        <tr>
          <th><a href="https://developer.mozilla.org/en/docs/Gecko">Netscape/Mozilla.org
          <abbr title="Next Generation Layout Engine">NGLayout</abbr>/Gecko</a></th>
          <td colspan="5"></td>
          <td>0.6&#8211;1.8a6</td>
          <td>1.8b1&#8211;1.8</td>
          <td>1.8.1</td>
          <td>1.9</td>
          <td>1.9.1</td>
          <td>1.9.2</td>
          <td>1.9.3, 2.0</td>
          <td>5.0</td>
        </tr>
    
        <tr class="header">
          <th colspan="15">Web Browsers</th>
        </tr>
        <tr>
          <th><a href="http://browser.netscape.com/">Netscape
            Navigator/Browser</a>&nbsp;<span
            title="Development discontinued">&#8224;</span></th>
          <td>Navigator 2.0&nbsp;<span title="End-of-life">&#8224;</span>
            (<span title="1996-03">1996</span>)</td>
          <td>3.0&nbsp;<span title="End-of-life">&#8224;</span> (<span title="1996-08">1996</span>)</td>
          <td>4.0&#8211;4.05&nbsp;<span title="End-of-life">&#8224;</span>
            (<span title="1997-06">1997</span>)</td>
          <td>4.06&#8211;4.8&nbsp;<span title="End-of-life">&#8224;</span>
            (<span title="1998-08-17 &#8211;&nbsp;2002-08">1998&#8211;2002</span>)</td>
          <td>-</td>
          <td>Navigator&nbsp;6.x &#8211;&nbsp;Browser&nbsp;8.1.3&nbsp;<span
            title="End-of-life">&#8224;</span><br>
            (<span title="2000-11-14 &#8211;&nbsp;2007-04-02">2000&#8211;2007</span>)</td>
          <td>-</td>
          <td>Navigator&nbsp;9.0b1 &#8211;&nbsp;9.0.0.6&nbsp;<span
            title="End-of-life">&#8224;</span><br>
          (<span title="2007-06-05 &#8211;&nbsp;2008-02-29">2007&#8211;2008</span>)</td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.com/firefox/">Mozilla
            Phoenix/Firebird/Firefox</a></th>
          <td colspan="5"></td>
          <td>Phoenix&nbsp;0.1 &#8211;&nbsp;Firefox&nbsp;1.0.8&nbsp;<span
            title="End-of-life">&#8224;</span><br>
            (<span title="2002-09-23 &#8211;&nbsp;2006-04-13">2002&#8211;2006</span>)</td>
          <td>Firefox&nbsp;1.5a1&#8211;1.5.0.12&nbsp;<span
            title="End-of-life">&#8224;</span><br>
            (<span title="2005-05-31 &#8211;&nbsp;2006-05-26">2005&#8211;2007</span>)</td>
          <td>2.0b1&#8211;2.0.0.18&nbsp;<span title="End-of-life"
            >&#8224;</span><br>
            (<span title="2006-07-12 &#8211;&nbsp;2008-11-12">2006&#8211;2008</span>)</td>
          <td>3.0a2&#8211;3.0.19&nbsp;<span title="End-of-life"
            >&#8224;</span><br>
            (<span title="2007-02-07 &#8211;&nbsp;2010-03-30">2007&#8211;2010</span>)</td>
          <td>3.1a1&#8211;3.5.19&nbsp;<span title="End-of-life"
            >&#8224;</span><br>
            (<span title="2008&#8209;07&#8209;28 &#8211;&nbsp;2011&#8209;04&#8209;28"
                   >2008&#8211;2011</span>)</td>
          <td>3.6a1&#8211;3.6.19<br>
            (2010&#8209;01&#8209;21 &#8211;&nbsp;2011&#8209;07&#8209;11)</td>
          <td>3.7a1&#8211;4.0.1&nbsp;<span title="End-of-life"
            >&#8224;</span><br>
            (<span title="2010&#8209;02&#8209;10 &#8211;&nbsp;2011&#8209;04&#8209;28"
                   >2010&#8211;2011</span>)</td>
          <td>5.0&#8211;5.0.1<br>
            (2011&#8209;06&#8209;21 &#8211;&nbsp;2011&#8209;07&#8209;11)</td>
        </tr>
    
        <tr class="header">
          <th colspan="15">Other Clients</th>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.org/products/mozilla1.x/">Mozilla
            Application&nbsp;Suite</a>&nbsp;<span
            title="Development discontinued">&#8224;</span></th>
          <td colspan="5"></td>
          <td>0.6&#8211;1.8a6&#8211;1.7.13&nbsp;<span title="End-of-life">&#8224;</span><br>
            (<span title="2000-12-06 &#8211;&nbsp;2006-04-21">2000&#8211;2006</span>)</td>
          <td>1.8b1&nbsp;<span title="End-of-life">&#8224;</span><br>
            (<span title="2005-02-23">2005</span>)</td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.org/projects/seamonkey/">Mozilla
          SeaMonkey</a></th>
          <td colspan="6"></td>
          <td>1.0a&#8211;1.0.9&nbsp;<span title="End-of-life">&#8224;</span><br>
            (<span title="2005-09-15 &#8211;&nbsp;2007-05-30">2005&#8211;2007</span>)</td>
          <td>1.1a&#8211;1.1.19&nbsp;<span title="End-of-life">&#8224;</span><br>
            (<span title="2006-08-30 &#8211;&nbsp;2010-03-16">2006&#8211;2010</span>)</td>
          <td>&nbsp;</td>
          <td>2.0a1&#8211;2.0.12<br>
            (2008&#8209;10&#8209;05 &#8211;&nbsp;2011&#8209;03&#8209;02)</td>
          <td>&nbsp;</td>
          <td>2.1a1&#8211;2.1<br>
            (2010&#8209;05&#8209;18 &#8211;&nbsp;2011&#8209;06&#8209;10)</td>
          <td>2.2b1&#8211;2.2<br>
            (2011&#8209;06&#8209;22 &#8211;&nbsp;2011&#8209;07&#8209;07)</td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.com/thunderbird/">Mozilla
          Thunderbird</a></th>
          <td colspan="5"></td>
          <td>0.1&#8211;1.0.8&nbsp;<span title="End-of-life">&#8224;</span><br>
            (<span title="2003-07-28 &#8211;&nbsp;2006-04-21">2003&#8211;2006</span>)</td>
          <td>1.1a1&#8211;1.5.0.14&nbsp;<span title="End-of-life">&#8224;</span><br>
            (<span title="2005-06-02 &#8211;&nbsp;2007-12-19">2005&#8211;2007</span>)</td>
          <td>2.0a1&#8211;2.0.0.24&nbsp;<span title="End-of-life">&#8224;</span><br>
            (<span title="2006-07-28 &#8211;&nbsp;2010-03-15">2006&#8211;2010</span>)</td>
          <td>3.0a1, 3.0a2&nbsp;<span title="End-of-life">&#8224;</span><br>
            (<span title="2008-05-13, 2008-08-12">2008</span>)</td>
          <td>3.0a3&#8211;3.0.11&nbsp;<span title="End-of-life">&#8224;</span><br>
            (<span title="2008-10-14 &#8211;&nbsp;2010-12-09">2008&#8211;2010</span>)</td>
          <td>3.1a1&#8211;3.1.12<br>
            (2010&#8209;02&#8209;03 &#8211;&nbsp;2011&#8209;08&#8209;16)</td>
          <td>3.3a1&#8211;3.3a3<br>
            (2010&#8209;11&#8209;23 &#8211;&nbsp; 2011&#8209;01&#8209;20)</td>
          <td>5.0b1&#8211;5.0<br>
            (2011&#8209;06&#8209;02 &#8211;&nbsp;2011&#8209;06&#8209;28)</td>
        </tr>
    
        <tr class="header">
          <th colspan="15">Web Servers</th>
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
        </tr>
        <tr>
          <th><a href="http://firecat.nihonsoft.org/">NihonSoft
          firecat</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>1.0.x Beta4 (2008)</td>
        </tr>
      </tbody>
    </table>
    
    <div>
      <h3><a name="jscript" id="jscript">Microsoft&nbsp;JScript Version
      Information</a><a href="#fn-jscript"><sup>2)</sup></a></h3>
   
      <div><a href="#version-info">&#8593; Version information</a></div>
    </div>
    
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
          <th>7.0 (.NET)</th>
          <th><a
            href="http://msdn.microsoft.com/en-us/library/72bd815a%28VS.71%29.aspx"
            title="JScript 7.1 (.NET) documentation"
          >7.1 (.NET)</a></th>
          <th><a
            href="http://msdn.microsoft.com/en-us/library/72bd815a%28VS.80%29.aspx"
            title="JScript 8.0 documentation"
          >8.0</a></th>
          <th>9.0.16421
           (<a href="http://en.wikipedia.org/wiki/Chakra_(JavaScript_engine)"
               >Chakra</a>)</th>
          <th><a
            href="http://msdn.microsoft.com/en-us/library/72bd815a.aspx"
            title="JScript 10.0 documentation"
          >10.0</a></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="16"><a name="fn-jscript" id="fn-jscript"
            >2)</a><a href="#jscript" class="backref">&#8593;</a>
            Version information from <a
              href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsoriVersionInformation.asp"
            ><acronym title="Microsoft Developer Network">MSDN</acronym>&nbsp;Library</a>;
            release&nbsp;dates from MSDN&nbsp;Library, <a
              href="http://www.blooberry.com/indexdot/history/ie.htm"
              title="Browser History: Windows Internet Explorer"
            >blooberry.com</a> and <a href="http://en.wikipedia.org/">Wikipedia</a>,
            end-of-life&nbsp;(&#8224;) dates from <a
             href="http://support.microsoft.com/gp/lifeselectindex"
              >support.microsoft.com</a>.<br>
            <em>Note that the language version supported by an environment
            may be greater than specified here due to security updates.
            When in doubt, use the <a href="#script-engine-test"
            >script engine test above</a> to determine the true version.</em>
          </td>
        </tr>
      </tfoot>
      <tbody>
        <tr class="header">
          <th colspan="18">Implementations</th>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/net/">Microsoft .NET Framework</a></th>
          <td colspan="12"></td>
          <td>1.0 (2002-01)</td>
          <td>1.1 (2003)</td>
          <td>2.0&#8211;3.5&nbsp;SP1 (2005&#8211;2008)</td>
          <td></td>
          <td>4.0&#8212; (2010-04-12&#8212;)</td>
        </tr>
    
        <tr class="header">
          <th colspan="18">Web Browsers</th>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/ie/">Microsoft Internet Explorer</a></th>
          <td>3.0&nbsp;<span title="End-of-life">&#8224;</span><br>
            <span class="nowrap">(1996-08</span> <a
            href="http://en.wikipedia.org/wiki/Common_Era"
          ><acronym title="Common Era">CE</acronym></a>)</td>
          <td></td>
          <td class="nowrap">4.0 <span title="End-of-life">&#8224;</span><br>
            (1997-09)</td>
          <td class="nowrap">4.01 <span title="End-of-life">&#8224;</span><br>
          	(1997-11)</td>
          <td></td>
          <td>5.0&nbsp;<span title="End-of-life">&#8224;</span><br>
            <span class="nowrap">(1999-03</span>
            <span class="nowrap">&#8211; 2005-06)</span></td>
          <td class="nowrap">5.01 <span title="End-of-life">&#8224;</span></td>
          <td>5.5&nbsp;<span title="End-of-life">&#8224;</span><br>
            <span class="nowrap">(2000-07</span>
            <span class="nowrap">&#8211;&nbsp;2005-12)</span></td>
          <td>6.0 for <abbr title="Windows 95 and 98">Win9x</abbr>/NT/XP&nbsp;<span title="End-of-life">&#8224;</span><br>
            <span class="nowrap">(2001-10)</span></td>
          <td>7.0 for <abbr title="Windows">Win</abbr>XP+<br>
            <span class="nowrap">(2006-10)</span></td>
          <td>8.0 beta 1 for <abbr title="Windows">Win</abbr>XP SP2+<br>
            <span class="nowrap">(2008-03)</span></td>
          <td>8.0 beta&nbsp;2 for <abbr title="Windows">Win</abbr>XP SP2+<br>
            <span class="nowrap">(2008-08)</span></td>
          <td colspan="3"></td>
          <td><span title="9.0.8112.16421">9.0</span> for Vista SP2+ / Server&nbsp;2008<br>
            (2011&#8209;03&#8209;14)</td>
        </tr>
    
        <tr class="header">
          <th colspan="18">Web Servers</th>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/iis/">Microsoft Internet
          Information Server/Services</a></th>
          <td colspan="2"></td>
          <td>4.0&nbsp;<span title="End-of-life">&#8224;</span><br>
            <span class="nowrap">(1998&#8211;2002)</span></td>
          <td colspan="5"></td>
          <td>5.1&#8211;6.0&nbsp;<span title="End-of-life">&#8224;</span><br>
            <span class="nowrap">(2000&#8211;2005)</span></td>
          <td colspan="2">7.0<br>
            <span class="nowrap">(2008)</span></td>
          <td>7.5<br>
            <span class="nowrap">(2009)</span></td>
        </tr>
    
        <tr class="header">
          <th colspan="18">Operating Systems</th>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/windows/">Microsoft Windows</a></th>
          <td></td>
          <td>NT&nbsp;4.0&nbsp;<span title="End-of-life">&#8224;</span><br>
            <span class="nowrap">(1996)</span></td>
          <td colspan="4"></td>
          <td>2000&nbsp;<span title="End-of-life">&#8224;</span><br>
            <span class="nowrap">(2000-02</span>
            <span class="nowrap">&#8211;&nbsp;2005-06)</span></td>
          <td><acronym title="Millennium Edition">Me</acronym>&nbsp;<span
            title="End-of-life">&#8224;</span><br>
            <span class="nowrap">(2000-09</span>
            <span class="nowrap">&#8211;&nbsp;2005-12)</span></td>
          <td><abbr title="eXPeriment^H^H^H^Hence ;-)">XP</abbr><br>
            <span class="nowrap">(2001-10)</span></td>
          <td colspan="2">Vista<br>
            <span class="nowrap">(2008-03)</span></td>
          <td>7<br>
            <span class="nowrap">(2009-10)</span></td>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/windowsserver2003/"
                 >Microsoft Windows Server</a></th>
          <td colspan="8"></td>
          <td>2003<br>
            <span class="nowrap">(2003-04)</span></td>
          <td colspan="2">2008<br>
            <span class="nowrap">(2008-02)</span></td>
          <td>2008&nbsp;R2<br>
            <span class="nowrap">(2009-09)</span></td>
          <td colspan="2">&nbsp;</td>
          <td>2008</td>
          <td>&nbsp;</td>
          <td>2008&nbsp;R2</td>
        </tr>
    
        <tr class="header">
          <th colspan="18"><acronym
            title="Integrated Development Environment"
          >IDE</acronym>s</th>
        </tr>
        <tr>
          <th><a href="http://www.microsoft.com/visualstudio/en-us/products"
                 >Microsoft Visual Studio</a></th>
          <td colspan="4"></td>
          <td>6.0&nbsp;<span title="End-of-life">&#8224;</span><br>
            <span class="nowrap">(1998&#8211;2005)</span></td>
          <td colspan="7"></td>
          <td>.NET&nbsp;7.0<br>(2002)</td>
          <td>.NET&nbsp;7.1<br>(2003)</td>
          <td>8.0&#8211;9.0<br>(2005&#8211;2008)</td>
          <td></td>
          <td>10.0&#8212;<br>(2010-04-12&#8212;)</td>
        </tr>
      </tbody>
    </table>
    
    <div>
      <h3><a name="v8" id="v8">Google&nbsp;V8 Version
      Information</a></h3>
   
      <div><a href="#version-info">&#8593; Version information</a></div>
    </div>
    
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
          <th>2.2</th>
          <th>2.3.11.22</th>
          <th>2.4.9.19</th>
          <th>2.5.9.6</th>
          <th>3.0.12.18</th>
          <th>3.1.4.0</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th><a href="http://www.google.com/chrome/">Google Chrome</a></th>
          <td>0.2&#8211;1.0<br>
            (2008-09&nbsp;<a
            href="http://en.wikipedia.org/wiki/Common_Era"
          ><acronym title="Common Era">CE</acronym></a>&#8212;2008-12)</td>
          <td>2.0<br>
            (2009-05)</td>
          <td>3.0<br>
            (2009-10)</td>
          <td>4.0.249<br>
            (2010-01-25)</td>
          <td>5.0.307<br>
            (2010-01-30)</td>
          <td>5.0.342<br>
            (2010-04-07)</td>
          <td>6.0.466.0<br>
            (2010-07-15)</td>
          <td>7.0.517<br>
            (2010-10-21)</td>
          <td>8.0.552<br>
            (2010-12-02)</td>
          <td>9.0.597<br>
            (2011-02-03)</td>
          <td>10.0.648<br>
            (2011-03-11)</td>
          <td>11.0.672<br>
            (2011-03-08)</td>
        </tr>
      </tbody>
    </table>
  
    <div>
      <h3><a name="jsc" id="jsc">Apple&nbsp;JavaScriptCore Version
        Information</a></h3>
        
      <div><a href="#version-info">&#8593; Version information</a></div>
    </div>

    <table class="versions"
      summary="Apple JavaScriptCore versions and the user agents that support them"
    >
      <thead>
        <tr>
          <th></th>
          <th>JavaScriptCore&nbsp;48&#8211;312.6</th>
          <th>412&#8211;419.13</th>
          <th>522.11&#8211;523.10</th>
          <th>525.13</th>
          <th>525.19</th>
          <th>525.27.1</th>
          <th>530.17</th>
          <th>531.9</th>
          <th>531.21.8</th>
          <th>531.22.7</th>
          <th>533.16</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th><a href="http://apple.com/safari/">Apple Safari</a></th>
          <td>0.8&#8211;1.3.2&nbsp;<span title="End-of-life">&#8224;</span><br>
            (2003&#8211;2006&nbsp;<a
            href="http://en.wikipedia.org/wiki/Common_Era"
            ><acronym title="Common Era">CE</acronym></a>)</td>
          <td>2.0&#8211;2.0.4<br>
            (2005-04 &#8211;&nbsp;2006-01)</td>
          <td>3.0&#8211;3.0.4<br>
             (2007-06 &#8211;&nbsp;2007-10)</td>
          <td>3.1<br>
            (2008-03)</td>
          <td>3.1.2<br>
            (2008-06)</td>
          <td>3.2.1<br>
            (2008-11)</td>
          <td>4.0<br>
            (2009-06)</td>
          <td>4.0.3<br>
            (2009-08)</td>
          <td>4.0.4<br>
            (2009-11)</td>
          <td>4.0.5<br>
            (2010-03-11)</td>
          <td>5.0<br>
            (2010-06-07)</td>
        </tr>
      </tbody>
    </table>

    <div>
      <h3><a name="opera" id="opera">Opera&nbsp;ECMAScript Version
        Information</a></h3>
        
      <div><a href="#version-info">&#8593; Version information</a></div>
    </div>

    <table class="versions"
      summary="Opera ECMAScript versions and the user agents that support them"
    >
      <thead>
        <tr>
          <th></th>
          <th>Opera&nbsp;ECMAScript&nbsp;3.60</th>
          <th>5.02</th>
          <th>6.06</th>
          <th>7.02</th>
          <th>8.0</th>
          <th>9.27</th>
          <th>9.52</th>
          <th>9.62</th>
          <th>9.64</th>
          <th>10.10</th>
          <th>10.50</th>
          <th>10.51</th>
          <th>10.54</th>
          <th>10.63</th>
          <th>11.50</th>
        </tr>
      </thead>
      <tbody>
        <tr class="header">
          <th colspan="16">Implementations</th>
        </tr>
        <tr>
          <td></td>
          <td colspan="3">Linear A</td>
          <td colspan="3">Linear B</td>
          <td colspan="4">Futhark</td>
          <td colspan="5">Carakan</td>
        </tr>
        <tr class="header">
          <th colspan="16">Layout Engines</th>
        </tr>
        <tr>
          <td></td>
          <td colspan="3">Elektra</td>
          <td colspan="2">Presto 1.0</td>
          <td>2.0</td>
          <td>2.1</td>
          <td colspan="2">2.1.1</td>
          <td>2.4</td>
          <td colspan="3">2.5</td>
          <td>2.6</td>
          <td>2.7</td>
        </tr>
        <tr class="header">
          <th colspan="16">Web Browsers</th>
        </tr>
        <tr>
          <th><a href="http://opera.com/">Opera Browser</a></th>
          <td>3.60&nbsp;<span title="End-of-life">&#8224;</span><br>
            (1999-05)</td>
          <td>5.02&nbsp;<span title="End-of-life">&#8224;</span><br>
          	(2000-12)</td>
          <td>6.06<br>
            (2001-11)</td>
          <td>7.02<br>
            (2003&#8211;2005)</td>
          <td>8.0<br>
            (2005&#8211;2008)</td>
          <td>9.27<br>
            (2008)</td>
          <td>9.52<br>
            (2008)</td>
          <td>9.62<br>
            (2008&#8211;2009)</td>
          <td>9.64<br>
            (2009)</td>
          <td>10.10<br>
            (2009&#8211;2010)</td>
          <td>10.50<br>
            (2010-03-02)</td>
          <td>10.51<br>
            (2010-03-22)</td>
          <td>10.54<br>
            (2010-06-21)</td>
          <td>10.63<br>
            (2010-10-12)</td>
          <td>11.50<br>
            (2011-06-28)</td>
        </tr>
      </tbody>
    </table>

    <div>
      <h3><a name="actionscript" id="actionscript"
        >Macromedia/Adobe&nbsp;ActionScript Versions</a><a
        href="#fn-actionscript"><sup>3)</sup></a></h3>
    
      <div><a href="#version-info">&#8593; Version information</a></div>
    </div>
    
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
    
    <div>
      <h3><a name="ecmascript" id="ecmascript">ECMAScript Compatibility</a></h3>
      
      <div><a href="#version-info">&#8593; Version information</a></div>
      
      <p>The following table provides a rough overview of ECMAScript Editions
      and relations between them and versions of their implementations. Note
      that conforming implementations are allowed to <em>extend</em>
      ECMAScript, so these are <em>by no means</em> 1:n relations; instead,
      this is the result of a comparison of most common language features.</p>
      
      <p style="text-align: left">See <a href="#features">Language&nbsp;Features</a>
      above for details.</p>
    </div>
    
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
          <td colspan="2"></td>
          <td>2.0 (2004)</td>
          <td>3.0 (2008&#8212;)</td>
        </tr>
        <tr>
          <th><a href="#javascript">JavaScript</a></th>
          <td>1.1, 1.3, 1.4</td>
          <td></td>
          <td>1.5&#8211;1.8.1.x</td>
          <td>2.0</td>
          <td>1.8.1&#8212; (2008-05&#8212;)</td>
        </tr>
        <tr>
          <th><a href="#jsc">JavaScriptCore</a></th>
        </tr>
        <tr>
          <th><a href="#jscript">JScript</a></th>
          <td>1.0 (1996)</td>
          <td></td>
          <td>5.5&#8212; (2000&#8212;)</td>
          <td>7.0&#8212; (2000&#8212;)</td>
        </tr>
        <tr>
          <th>KJS</th>
          <td colspan="2"></td>
          <td>1.0</td>
          <td>-</td>
        </tr>
        <tr>
          <th><a href="http://www.opera.com/docs/specs/js/ecma/">Opera</a></th>
          <td colspan="2"></td>
          <td>6.0 (2001-12)</td>
        </tr>
        <tr>
          <th><a href="#v8">V8</a></th>
          <td colspan="2"></td>
          <td>0.3</td>
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
    
    <h3><a name="timeline" id="timeline">Timeline</a></h3>

    <div><a href="#version-info">&#8593; Version information</a></div>
    
    <table class="timeline">
      <thead>
        <tr>
          <th rowspan="2">Date</th>
          <th colspan="2">1996</th>
          <th>1997</th>
          <th>1998</th>
          <th>1999</th>
          <th>2000</th>
          <th>2001</th>
          <th>2002</th>
          <th>2003</th>
          <th>2004</th>
          <th>2005</th>
          <th>2006</th>
          <th colspan="4">2007</th>
          <th colspan="2">2008</th>
          <th>2009</th>
          <th colspan="2">2010</th>
          <th>2011</th>
        </tr>
        <tr>
          <th>1996-03</th>
          <th>1996-08</th>
          <th>1997-06</th>
          <th>1998-08</th>
          <th>1999-05</th>
          <th>2000-11</th>
          <th></th>
          <th>2002-08</th>
          <th></th>
          <th>2004-11</th>
          <th></th>
          <th>2006-07</th>
          <th>2007-02</th>
          <th>2007-04</th>
          <th>2007-06</th>
          <th>2007-08</th>
          <th>2008-02</th>
          <th>2008-07</th>
          <th></th>
          <th>2010-01</th>
          <th>2010-03</th>
          <th>2011-03</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th rowspan="8">JavaScript</th>
          <td class="blue">1.0</td>
          <td class="blue">1.1</td>
          <td class="blue">1.2</td>
          <td colspan="5" class="blue">1.3</td>
        </tr>
        <tr>
          <td colspan="4"></td>
          <td colspan="2" class="blue">1.4</td>
        </tr>
        <tr>
          <td colspan="5"></td>
          <td colspan="9" class="blue">1.5</td>
        </tr>
        <tr>
          <td colspan="9"></td>
          <td colspan="7" class="blue">1.6</td>
        </tr>
        <tr>
          <td colspan="11"></td>
          <td colspan="10" class="blue">1.7</td>
        </tr>
        <tr>
          <td colspan="13"></td>
          <td colspan="8" class="blue">1.8</td>
        </tr>
        <tr>
          <td colspan="17"></td>
          <td colspan="5" class="blue">1.8.1</td>
        </tr>
        <tr>
          <td colspan="19"></td>
          <td colspan="3" class="blue">1.8.2</td>
        </tr>
        <tr>
          <th>Rhino</th>
          <td colspan="4"></td>
          <td colspan="2" class="blue">1.4R3</td>
        </tr>
        <tr>
          <th rowspan="2">Netscape</th>
          <td class="blue">Navigator 2.0</td>
          <td class="blue">3.0</td>
          <td class="nowrap blue">4.0 &#8211; 4.05</td>
          <td colspan="5" class="blue">4.06 &#8211; 4.8</td>
        </tr>
        <tr>
          <td colspan="5"></td>
          <td colspan="9" class="blue">Navigator 6.x &#8211;&nbsp;Browser 8.1.3</td>
          <td colspan="3" class="blue">Navigator 9.0b1 &#8211;&nbsp;9.0.0.6</td>
        </tr>
        <tr>
          <th>JScript</th>
          <td></td>
          <td class="blue">1.0</td>
          <td colspan="2" class="blue">3.0</td>
          <td class="blue">3.1</td>
          <td class="nowrap blue">4.0 &#8211; 4.1</td>
          <td colspan="3" class="blue">5.0</td>
          <td colspan="2" class="blue">5.1</td>
          <td colspan="3" class="blue">5.5</td>
          <td colspan="11" class="blue">5.6</td>
          <td colspan="7" class="blue">5.7</td>
          <td colspan="24" class="blue">5.8</td>
        </tr>
        <tr>
          <th>Internet Explorer</th>
          <td></td>
          <td class="blue">3.0</td>
          <td colspan="2" class="blue">4.0</td>
          <td class="blue">4.01</td>
        </tr>
        <tr>
          <th>ECMAScript</th>
          <td colspan="2"></td>
          <td colspan="2" class="blue">1</td>
          <td colspan="5" class="blue">2</td>
          <td colspan="4" class="blue">3</td>
          <td colspan="25" class="blue">4</td>
          <td></td>
          <td colspan="18" class="blue">5</td>
        </tr>
        <tr>
          <th>Opera</th>
          <td colspan="7"></td>
          <td class="blue">3.60</td>
        </tr>
      </tbody>
    </table>
    
    <div>
      <h2><a name="contributors" id="contributors">List of Contributors</a></h2>
  
      <div><a href="#toc">&#8593; Table of contents</a></div>
      
      <p><em>Thanks to (in alphabetical order):</em></p>
    </div>
    
    <ul>
      <li><a href="http://asenbozhilov.com/">Asen Bozhilov
        (<span lang="bg">Асен Божилов</span>)</a>
        &lt;<a href="<?php echo randomEsc('mailto:asen.bozhilov@gmail.com'); ?>"
        ><?php echo randomEsc('asen.bozhilov@gmail.com'); ?></a>&gt;
        for corrections on ECMAScript Editions and feature suggestions</li>
      <li>BootNic &lt;<a href="<?php echo randomEsc('mailto:bootnic.bounce@gmail.com'); ?>"
        ><?php echo randomEsc('bootnic.bounce@gmail.com'); ?></a>&gt;
        for helping with the scrollable tbody workaround for IE: Message-ID&nbsp;<a
        href="http://groups.google.com/groups/search?as_umsgid=20100305112229.454328ac@bootnic.eternal-september.org"
        >&lt;20100305112229.454328ac@bootnic.eternal-september.org&gt;</a></li>
      <li><a href="http://perfectionkills.com/">Juriy&nbsp;'kangax'&nbsp;Zaytsev
        (<span lang="ru">Юрий Зайцев</span>)</a>
        &lt;<a href="<?php echo randomEsc('mailto:kangax@gmail.com'); ?>"
        ><?php echo randomEsc('kangax@gmail.com'); ?></a>&gt;
        for tests with Safari&nbsp;2.0.2: Message-ID&nbsp;<a
        href="http://groups.google.com/groups/search?as_umsgid=MpOdnVEQCfgNMN_WnZ2dnUVZ_rNi4p2d@giganews.com"
        >&lt;MpOdnVEQCfgNMN_WnZ2dnUVZ_rNi4p2d@giganews.com&gt;</a></li>
      <li>Michael&nbsp;Winter
        &lt;<a href="<?php echo randomEsc('mailto:m.winter@blueyonder.co.uk'); ?>"
        ><?php echo randomEsc('m.winter@blueyonder.co.uk'); ?></a>&gt;
        for tests with IE&nbsp;4.01 and NN&nbsp;4.08: Message-ID&nbsp;<a
        href="http://groups.google.com/groups/search?as_umsgid=urctf.17012$iz3.5930@text.news.blueyonder.co.uk"
        >&lt;urctf.17012$iz3.5930@text.news.blueyonder.co.uk&gt;</a></li>
      
    </ul>
    
    <div id="footer">
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
