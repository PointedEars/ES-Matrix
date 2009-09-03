<?php
  require('cgi_buffer/php/prepend.php');                 

  $modi = @filemtime(__FILE__);
  header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $modi) . ' GMT');

  // Cached resource expires in HTTP/1.0 caches 24h after last retrieval
  header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <title>ECMAScript Support Matrix</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <style type="text/css">
      body {
        background-color:white;
        color:black;
        font-family: sans-serif;
      }

      p {
        text-align: justify;        
      }

      [title] {
        cursor:help;
      }

      a[title] {
        cursor:pointer;
      }
      
      acronym, abbr {
        border-bottom: 1px dotted black;
      }
      
      table {
        border-collapse:collapse;
      }
      
      #features-table {
        width: 100%;
      }
    
      thead {
        border-left:1px solid black;
        border-top:1px solid black;
        border-right:1px solid black;
        border-bottom:1px solid gray;
        color:#000;
        background-color:#ccc;
      }
      
      tbody {
        border-left:1px solid black;
        border-top:1px solid gray;
        border-right:1px solid black;
        border-bottom:1px solid black;
      }

      /*
       * Not for IE 6 and below.
       * Bugfix for IE 7 follows in Conditional Comments below.
       */  
      table>tbody.scroll {
        border-top: 0;
        border-left-color: gray;
        height: 23em;
        overflow: auto;
        /*
         * In current implementations, the scrollbar is displayed within
         * the tbody area, so we disable horizontal scrolling for that ...
         */
        overflow-x: hidden !important;
      }

      /*
       * ... and make enough room so that the text won't flow under the
       * vertical scrollbar.  However, that is still a dirty hack as we
       * assume that the vertical scrollbar is not wider than 20px.  
       */ 
      table>tbody.scroll td:last-child {
        padding-right: 20px;
      }

      /* bottom-border fix for Geckos */
      table>tbody.scroll code, 
      table>tbody.scroll span {
        background-color: transparent !important;
      }
      
      tr {
        vertical-align:baseline;
      }

      th, td {
        padding: 5px;
        text-align: left;
        font-size: small;
      }

      th *, td * {
        font-size: small;
      }

      table.versions th, table.versions td {
      }

      th {
        font-weight:bold;
      }
      
      .future {
        border-left:1px dotted black;
      }
      
      .tested {
        font-weight: bold;
      }
    </style>
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

    <script type="text/javascript" src="types.js"></script>
    <script type="text/javascript" src="dhtml.js"></script>
    <script type="text/javascript">
      var scroller, origHeight;
      
      function toggleScroll()
      {
        if (scroller)
        {
          var bScrollable =
            (dhtml.getStyleProperty(scroller, 'height') != "auto");

          dhtml.setStyleProperty(
            scroller,
            'height',
            bScrollable ? 'auto' : origHeight + 'px');

          dhtml.setStyleProperty(
            scroller,
            'overflow',
            bScrollable ? 'visible' : 'scroll');
        }
        else
        {
          alert("Sorry, this feature is not supported by your user agent.");
        }
      }

      function initScroller()
      {
      }
      
      if (dhtml.isMethodType(typeof getComputedStyle))
      {
        initScroller = function()
        {
          var btToggleScroll;
          if ((scroller = dhtml.getElem('id', 'scroller'))
              && (btToggleScroll = dhtml.getElem('id', 'btToggleScroll')))
          {
            btToggleScroll.style.display = "";
            origHeight = parseInt(getComputedStyle(scroller, null).height, 10);

            // Firefox tbody-scroll bug workaround
            toggleScroll();
            toggleScroll();
          }
        }
      }
    </script>
  </head>
  <body onload="initScroller();">
    <h1><a name="top" id="top"
      >ECMAScript Support Matrix</a></h1>

    <p style="text-align:left"
      >Copyright &copy; 2005&#8211;<?php echo gmdate('Y', $modi); ?>
      Thomas Lahn &lt;<a href="mailto:js@PointedEars.de"
      >js@PointedEars.de</a>&gt;</p>

    <p style="text-align:left">Last&nbsp;modified:
      <?php echo gmdate('Y-m-d\TH:i:s+00:00', $modi); ?></p>

    <p style="text-align:left">Available online at
      &lt;<a href="<?php
        $s = 'http://' . $_SERVER['HTTP_HOST']
          . preg_replace('|\.[^.]+$|', '', $_SERVER['SCRIPT_NAME']);
        echo $s;
        ?>"
        ><?php echo $s; ?></a>&gt;.</p>
    
    <?php
      if ($_SERVER['QUERY_STRING'] == 'redir')
      {
        ?><p><strong>You have been redirected to here because the URI that
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
      <li><a href="#actionscript">ActionScript Version Information</a></li>
      <li><a href="#ecmascript">ECMAScript Implementation Information</a></li>
    </ul>
  
    <h2><a name="features" id="features">Language&nbsp;Features</a></h2>

    <p>The following table lists all features of ECMAScript implementations 
      that are not part of the first versions/editions of all of these
      languages, with the version/edition that introduced it; furthermore,
      information about features that have been deprecated is included.
      That means if a <em>language</em> feature is not listed here, you
      can consider it to be universally supported.</p>
      
    <p><strong>The content of this table is based on what I could find in
      vendor's online documentations to date and on occasions where I could
      test the respective feature; <em>it does not claim to be accurate or
      complete</em> (please not how each feature is marked).  Any
      correction/addition as to how things really are is welcome and will
      be credited where it is due.</strong></p>
    
    <h3>Thanks to:</h3>
      
    <ul>
      <li>Michael Winter &lt;<a href="mailto:m.winter@blueyonder.co.uk"
        >m.winter@blueyonder.co.uk</a>&gt; for tests with IE&nbsp;4.01
        and NN&nbsp;4.08: Message-ID&nbsp;<a
          href="http://groups.google.com/groups?as_umsgid=urctf.17012$iz3.5930@text.news.blueyonder.co.uk"
          >&lt;urctf.17012$iz3.5930@text.news.blueyonder.co.uk&gt;</a></li>
    </ul>
    
    <table id="features-table">
      <thead>
        <tr>
          <th>Feature<script type="text/javascript">
              if (typeof initScroller != "undefined")
              {
                document.write(
                  '<br><input type="button" value="Toggle table&nbsp;body'
                  + ' scrollability" onclick="toggleScroll();"'
                  + ' style="display:none" id="btToggleScroll">');
              }
            </script><br>
            <a href="#!">!</a>
            <?php
              for ($i = ord('a'), $max = ord('z') ; $i <= $max; $i++)
              {
                $s = chr($i);
                echo '<a href="#' . $s . '">' . strtoupper($s) . '</a> ';
              }
            ?></th>
          <th><a href="#javascript">JavaScript Version</a></th>
          <th><a href="#jscript">JScript Version</a></th>
          <th><a href="#ecmascript">ECMAScript Edition</a></th>
          <th><a href="#actionscript">ActionScript Version</a></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="3"><table>
              <tr>
                <th>Legend:</th>
                <td>Untested documented feature</td>
                <td class="tested">Feature availability confirmed by test</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td colspan="3">* discrepancy between the vendor's documentation
            and the real implementation</td>
        </tr>
        <tr>
          <td colspan="3">? unconfirmed contribution by other people</td>
        </tr>
        <tr>
          <td colspan="3"><table>
              <tr>
                <th><sup><a href="#decl-ver" name="#fn-decl-ver">[1]</a></sup></th>
                <td>Version needs to be declared in order to use this feature</td>
              </tr>
            </table></td>
        </tr>
      </tfoot>
      <tbody class="scroll" id="scroller">
<?php
$features = new FeatureList(array(
  'urns' => array(
    'mdc'     => 'http://developer.mozilla.org/en/docs/',
    'js15ref' => 'mdc:Core_JavaScript_1.5_Reference:',
    'msdn'    => 'http://msdn.microsoft.com/library/en-us/',
    'es3'     => 'http://www.mozilla.org/js/language/E262-3.pdf'),

  'items' => array(
    new Feature(array(
      'anchors'    => array('!', 'opNotEqual'),
      'title'      => 'Strict Not Equal/Nonidentity operator',
      'content'    => '<code>!==</code>',
      'javascript' => array('1.3',
        'urn' => 'js15ref:Operators:Comparison_Operators'),
      'jscript'    => array('1.0',
        'urn' => 'msdn:jscript7/html/jsgrpcomparison.asp'),
      'ecmascript' => array('3',
        'urn' => 'es3:?page=74')
    )),
    
    new Feature(array(
      'title'      => 'RegExp literal with only optional global and case-insensitive modifier',
      'content'    => '<code>/<var>regularExpression</var>/</code>[<code>g</code<][<code>i</code>]',
      'javascript' => array('1.2',
        'urn' => 'js15ref:Global_Objects:RegExp'),
      'jscript'    => array('3.1.3510',
        'urn'    => 'msdn:jscript7/html/jsobjregexpression.asp',
        'tested' => true),
      'ecmascript' => '-'
    )),
  )
));
?>
        <tr>
          <td><code title="RegExp literal with optional multiline modifier"
            >/<var>regularExpression</var>/</code>[<code>g</code>][<code>i</code>][<code>m</code>]</td>
          <td>1.5</td>
          <td class="tested">5.5.6330</td>
          <td>3</td>
          <td></td>
        </tr>
        <tr>
          <td><code title="Label"><var>label</var>:</code></td>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Statements:label"
            >1.2</a></td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsstmlabeled.asp"
            >3.0</a></td>
          <td>3</td>
          <td></td>
        </tr>
        
        <?php //include 'es-matrix.inc.php'; ?>
        <tr>
          <td><code title="Type declaration"><var>identifier</var> <span
            class="punct">:</span> <var>type</var></code></td>
          <td>2.0</td>
          <td>7.0</td>
          <td>4</td>
        </tr>
        <tr>
          <td><code title="Equal operator"
            class="punct">==</code></td>
          <td>1.0; deprecated since 1.4 <em>for comparison of two
            <code>JSObject</code> objects</em>, use the
            <code>JSObject.equals</code> method instead</td>
          <td>1.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code title="Strict Equal/Identity operator"
            class="punct">===</code></td>
          <td>1.3</td>
          <td>1.0</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code title="Array literal"><span class="punct" 
            >[</span><var>value</var><span class="punct">,</span> ...<span
              class="punct">]</span></code></td>
          <td>1.3</td>
          <td>2.0</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code title="Array comprehension"><span class="punct" 
            >[</span><var>expression1</var> <span class="rswd">for</span>
            <var>var1</var> <span class="rswd">in</span> <var>expression2</var><span
            class="punct">]</span></code></td>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Array_comprehensions"
            >1.7</a></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code title="Destructuring assignment"><var>[</var><span
            class="rswd">var</span><var>]</var> <span class="punct" 
            >[</span><var>var1</var><span class="punct">,</span>
            <var>[var2</var><span class="punct">,</span>&nbsp;<var>]</var><span
            class="punct">,</span> <var>var3</var><span class="punct">,</span>
            <var>&hellip;</var><span class="punct">]&nbsp;=</span>
            <var>Array</var></code></td>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Destructuring_assignment"
            >1.7</a></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><a href="javascript:alert('\u20AC')"
            onclick="return !!alert('\u20AC');"><code
            title="Unicode escape sequence in String literal"
            ><span class="punct">&quot;\</span>u<var>hhhh</var><span
            class="punct">&quot;</span></code></a>, <a
            href="javascript:alert(/\u20AC/)"
            onclick="return !!alert(/\u20AC/);"><code
            title="Unicode escape sequence in RegExp literal"><span
            class="punct">/\</span>u<var>hhhh</var><span class="punct" 
            >/</span></code></a></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code title="Object literal"><span class="punct" 
            >{</span><var>name</var><span class="punct">:</span>
            <var>value</var><span class="punct">,</span> ...<span
            class="punct">}</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>3</td>
        </tr>
        <tr>
          <td><a name="a" id="a"></a><code class="rswd">abstract</code></td>
          <td>2.0</td>
          <td>7.0</td>
          <td>4</td>
        </tr>
        <tr>
          <td><code><span class="ident">ActiveXObject</span><span
            class="punct">(</span>...<span class="punct">)</span></code></td>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><a name="arguments" id="arguments"
            ><code class="ident">arguments</code></a></td>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Functions:arguments"
            >1.1</a></td>
          <td>1.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><a name="arguments.callee" id="arguments.callee"
            href="javascript:void((function(){alert(arguments.callee);})())"
            onclick="return !!(function(){alert(arguments.callee);})();"
            ><code><span class="ident">arguments</span><span
            class="punct">.</span><span
            class="ident">callee</span></code></a></td>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Functions:arguments:callee"
            >1.2</a></td>
          <td>3.0*</td>
          <td>1</td>
        </tr>
        <tr>
          <td><a name="arguments.caller" id="arguments.caller"><code><span
            class="ident">arguments</span><span class="punct">.</span><span
            class="ident">caller</span></code></a></td>
          <td>1.1; deprecated since 1.3</td>
          <td>- (see&nbsp;<code><a href="#Function.prototype.caller"
            >Function.prototype.caller</a></code>)</td>
          <td>-</td>
        </tr>
        <tr>
          <td><a name="arguments.length" id="arguments.length"><code><span
            class="ident">arguments</span><span class="punct">.</span><span
            class="ident">length</span></code></a></td>
          <td>1.1</td>
          <td>5.5</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span class="ident">Array</span><span
            class="punct">(</span>...<span class="punct">)</span></code></td>
          <td>1.1</td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">every</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.6</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">some</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.6</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">concat</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.2</td>
          <td>3.0</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">every</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.6</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">indexOf</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.6</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">join</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.1</td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">length</span></code></td>
          <td>1.1</td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">pop</span><span
            class="punct">()</span></code></td>
          <td>1.2</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">push</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.2</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">reverse</span><span
            class="punct">()</span></code></td>
          <td>1.1</td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">shift</span><span
            class="punct">()</span></code></td>
          <td>1.2</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">slice</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.2</td>
          <td>3.0</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">some</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.6</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">sort</span><span
            class="punct">(</span></code>[<code><var
            >comparator</var></code>]<code><span
            class="punct">)</span></code></td>
          <td>1.1</td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><a href="javascript:a=new(Array(1,2,3));alert(a.splice(1,1,4));alert(a);"
            onclick="var a = new Array(1,2,3); alert(a.splice(1,1,4)); return !!alert(a);"
            ><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">splice</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></a></td>
          <td>1.2; no return value before 1.3</td>
          <td>5.5*</td>
          <td>3</td>
        </tr>
        <tr>
          <td><a href="javascript:a=new(Array('1'));a.unshift(0);alert(a);"
            onclick="var a = new Array('1'); a.unshift(0); return !!alert(a);"
            ><code><span
            class="ident">Array</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">unshift</span><span
            class="punct">()</span></code></a></td>
          <td>1.2?</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <td><a name="b" id="b"></a><code class="rswd">boolean</code></td>
          <td>2.0</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatBoolean.asp"
            >7.0</a></td>
          <td>4</td>
        </tr>
        <tr>
          <td><code><span class="ident">Boolean</span><span
            class="punct">(</span>...<span class="punct">)</span></code></td>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Global_Objects:Boolean"
            >1.1</a></td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code class="rswd">byte</code></td>
          <td>2.0</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatbyte.asp"
            >7.0</a></td>
          <td>4</td>
        </tr>
        <tr>
          <td><a name="c" id="c"></a><code>@cc_on</code></td>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code class="rswd">char</code></td>
          <td>2.0</td>
          <td>7.0</td>
          <td>4</td>
        </tr>
        <tr>
          <td><code><span class="rswd">class</span></code></td>
          <td>2.0</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatchar.asp"
            >7.0</a></td>
          <td>4</td>
        </tr>
        <tr>
          <td><code class="rswd">const</code></td>
          <td>1.5</td>
          <td>7.0</td>
          <td>4</td>
        </tr>
        <tr>
          <td><a name="d" id="d"></a><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">getFullYear</span><span
            class="punct">()</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">getMilliseconds</span><span
            class="punct">()</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">getUTCDate</span><span
            class="punct">()</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">getUTCDay</span><span
            class="punct">()</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">getUTCFullYear</span><span
            class="punct">()</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">getUTCHours</span><span
            class="punct">()</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">getUTCMilliseconds</span><span
            class="punct">()</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">getUTCMinutes</span><span
            class="punct">()</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">getUTCMonth</span><span
            class="punct">()</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">getUTCSeconds</span><span
            class="punct">()</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">getVarDate</span><span
            class="punct">()</span></code></td>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">setFullYear</span><span
            class="punct">(</span><var>integer</var><span
            class="punct">)</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">setMilliseconds</span><span
            class="punct">(</span><var>integer</var><span
            class="punct">)</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">setUTCDate</span><span
            class="punct">(</span><var>integer</var><span
            class="punct">)</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">setUTCDay</span><span
            class="punct">(</span><var>integer</var><span
            class="punct">)</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">setUTCFullYear</span><span
            class="punct">(</span><var>integer</var><span
            class="punct">)</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">setUTCHours</span><span
            class="punct">(</span><var>integer</var><span
            class="punct">)</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">setUTCMilliseconds</span><span
            class="punct">(</span><var>integer</var><span
            class="punct">)</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">setUTCMinutes</span><span
            class="punct">(</span><var>integer</var><span
            class="punct">)</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">setUTCMonth</span><span
            class="punct">(</span><var>integer</var><span
            class="punct">)</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Date</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">setUTCSeconds</span><span
            class="punct">(</span><var>integer</var><span
            class="punct">)</span></code></td>
          <td>1.3</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code>@debug</code></td>
          <td>-</td>
          <td>7.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code class="ident">debugger</code></td>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code class="rswd">decimal</code></td>
          <td>-</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatDecimal.asp"
            >7.0</a></td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">decodeURI</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.5</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">decodeURIComponent</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.5</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code class="rswd">delete</code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span class="rswd">do</span>...<span
            class="rswd">while</span></code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code class="rswd">double</code></td>
          <td>2.0</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatdouble.asp"
            >7.0</a></td>
          <td>4</td>
        </tr>
        <tr>
          <td><a name="e" id="e"></a><code><span
            class="ident">encodeURI</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.5</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">encodeURIComponent</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.5</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code class="rswd">enum</code></td>
          <td>2.0</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span class="ident">Enumerator</span><span
            class="punct">(</span>...<span class="punct">)</span></code></td>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span class="ident">Error</span><span
            class="punct">(</span>...<span class="punct">)</span></code></td>
          <td>?</td>
          <td>5.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Error</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">description</span></code></td>
          <td>?</td>
          <td>5.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Error</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">message</span></code></td>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Error</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">name</span></code></td>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Error</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">number</span></code></td>
          <td>?</td>
          <td>5.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code class="rswd">expando</code></td>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><a name="f" id="f"></a><code class="rswd">final</code></td>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code class="rswd">float</code></td>
          <td>2.0</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatfloat.asp"
            >7.0</a></td>
          <td>4</td>
        </tr>
        <tr>
          <td><code><span class="rswd">for each</span> <span
            class="punct">(</span>[<span class="rswd">var</span>]
            <var>identifier</var> <span class="rswd">in</span>
            <var>expression</var><span
            class="punct">)</span></code></td>
          <td>1.6</td>
          <td>-</td>
          <td>E4X</td>
        </tr>
        <tr>
          <td><code><span class="ident">Function</span><span
            class="punct">(</span>...<span class="punct">)</span></code></td>
          <td>1.1</td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span class="rswd">function get</span>
            <var>identifier</var><span class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span class="rswd">function set</span>
            <var>identifier</var><span class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span class="punct">=</span> 
            <a href="javascript:(function foo(){window.alert(42)})()"
               onclick="(function foo(){window.alert(42)})(); return false"
               ><span class="rswd">function</span>
            <var>identifier</var><span class="punct">(</span>...<span
            class="punct">)</span></a></code></td>
          <td>1.2</td>
          <td>1.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span class="punct">=</span>
            <a href="javascript:(function(){window.alert(42)})()"
               onclick="(function(){window.alert(42)})(); return false"
               ><span class="rswd">function</span><span
            class="punct">(</span>...<span class="punct">)</span></a></code></td>
          <td>1.3*</td>
          <td class="tested">3.1.3510</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Function</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">arity</span></code></td>
          <td>1.2; deprecated since 1.4</td>
          <td>?</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Function</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">apply</span><span class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.3</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Function</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">arguments</span></code></td>
          <td>1.0; deprecated since 1.4, use <a href="#arguments"
            ><code>arguments</code></a></td>
          <td>2.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Function</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">arguments</span><span class="punct">.</span><span
            class="ident">callee</span></code></td>
          <td>1.2; deprecated since 1.4, use <code><a href="#arguments.callee"
            >arguments.callee</a></code></td>
          <td>5.6</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Function</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">arguments</span><span class="punct">.</span><span
            class="ident">length</span></code></td>
          <td>1.0; deprecated since 1.4, use <a href="#arguments.length"
            ><code>arguments.length</code></a></td>
          <td>?</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Function</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">call</span><span class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Global_Objects:Function:call"
                 >1.3</a></td>
          <td>?</td>
          <td>?</td>
        </tr>
        <tr>
          <td><a name="Function.prototype.caller" id="Function.prototype.caller"
            ><code><span
            class="ident">Function</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">caller</span></code></a></td>
          <td>- (see&nbsp;<code><a href="#arguments.caller"
            >arguments.caller</a></code>)</td>
          <td>2.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Function</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">length</span></code></td>
          <td>?</td>
          <td>2.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Function</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">toSource</span><span
            class="punct">()</span></code></td>
          <td>1.3</td>
          <td>?</td>
          <td>?</td>
        </tr>
        <tr>
          <td><a name="g" id="g"></a><code><var>Generator</var><span
            class="punct">.</span><span class="ident">close</span><span
            class="punct">()</span></code></td>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Closing_a_generator"
            >1.7</a><sup><a href="#fn-decl-ver" name="decl-ver">[1]</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><var>Generator</var><span
            class="punct">.</span><span class="ident">next</span><span
            class="punct">()</span></code></td>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Generators"
            >1.7</a><sup><a href="#fn-decl-ver">[1]</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><var>Generator</var><span
            class="punct">.</span><span class="ident">send</span><span
            class="punct">(</span><var>expression</var><span
            class="punct">)</span></code></td>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Resuming_a_generator_at_a_specific_point"
            >1.7</a><sup><a href="#fn-decl-ver">[1]</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><var>Generator</var><span
            class="punct">.</span><span class="ident">throw</span><span
            class="punct">(</span><var>expression</var><span
            class="punct">)</span></code></td>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Exceptions_in_generators"
            >1.7</a><sup><a href="#fn-decl-ver">[1]</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">GetObject</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td>Global object</td>
          <td>1.0</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><a name="h" id="h"></a><code class="rswd"
            >hide</code></td>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><a name="i" id="i"></a><code>@if</code></td>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code class="ident">Infinity</code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code class="rswd">import</code></td>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><var>"<span class="str">string</span>"</var>
            <span class="rswd">in</span> <var>objRef</var></code></td>
          <td>1.4</td>
          <td>5.0</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code class="rswd">instanceof</code></td>
          <td>1.4</td>
          <td>5.0</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code class="rswd">int</code></td>
          <td>2.0</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatint.asp"
            >7.0</a></td>
          <td>4</td>
        </tr>
        <tr>
          <td><code class="rswd">interface</code></td>
          <td>2.0</td>
          <td>7.0</td>
          <td>4</td>
        </tr>
        <tr>
          <td><code class="rswd">internal</code></td>
          <td>2.0</td>
          <td>7.0</td>
          <td>4</td>
        </tr>
        <tr>
          <td><code><span class="ident">isFinite</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span class="ident">Iterator</span><span
            class="punct">(</span><var>objRef
            </var><span
            class="punct">)</span></code></td>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Iterators"
            >1.7</a></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><a name="l" id="l"></a><a name="let" id="let"><code
            title="Block scoping: let statement"><span
            class="rswd">let</span>&nbsp;<span class="punct"
            >(</span><var>assignment</var><var>[</var><span class="punct"
            >, </span><var>&#8230;</var><var>]</var><span class="punct"
            >) {</span>&nbsp;<var>[</var><var>statements</var><var
            >]</var>&nbsp;<span class="punct">}</span></code></a></td>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Block_scope_with_let"
            >1.7</a><sup><a href="#fn-decl-ver">[1]</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code
            title="Block scoping: let expression"><span
            class="rswd">let</span>&nbsp;<span class="punct"
            >(</span><var>assignment</var><var>[</var><span class="punct"
            >, </span><var>&#8230;</var><var>]</var><span class="punct"
            >)</span>&nbsp;<var>expression</var></code></td>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Block_scope_with_let"
            >1.7</a><sup><a href="#fn-decl-ver">[1]</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code
            title="Block scoping: let definition"><span
            class="rswd">let</span>&nbsp;<var>assignment</var><var>[</var><span
            class="punct">, </span><var>&#8230;</var><var>]</var></code></td>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Block_scope_with_let"
            >1.7</a><sup><a href="#fn-decl-ver">[1]</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code class="rswd">long</code></td>
          <td>2.0</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsdatlong.asp"
            >7.0</a></td>
          <td>4</td>
        </tr>
        <tr>
          <td><a name="m" id="m"></a><a name="n" id="n"></a><code class="ident"
            >NaN</code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Number</span><span class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>?</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsobjnumber.asp"
            >1.0</a></td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Number</span><span class="punct">.</span><span
            class="ident">MAX_VALUE</span></code></td>
          <td>?</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jspromaxvalue.asp"
            >2.0</a></td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Number</span><span class="punct">.</span><span
            class="ident">MIN_VALUE</span></code></td>
          <td>?</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsprominvalue.asp"
            >2.0</a></td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Number</span><span class="punct">.</span><span
            class="ident">NaN</span></code></td>
          <td>?</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jspronannumber.asp"
            >2.0</a></td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Number</span><span class="punct">.</span><span
            class="ident">NEGATIVE_INFINITY</span></code></td>
          <td>?</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jspronegativeinf.asp"
            >2.0</a></td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Number</span><span class="punct">.</span><span
            class="ident">POSITIVE_INFINITY</span></code></td>
          <td>?</td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jspropositiveinf.asp"
            >2.0</a></td>
          <td>?</td>
        </tr>
        <tr>
          <td><a name="o" id="o"></a><code><span
            class="ident">Object</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Object</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">__iterator__</span></code></td>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Iterators"
            >1.7</a></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Object</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">__proto__</span></code></td>
          <td>1.3</td>
          <td>-</td>
          <td>-</td>
          <td>2.0</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Object</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">constructor</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.1</td>
          <td>2.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Object</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">hasOwnProperty</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.5</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Object</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">isPrototypeOf</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Object</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">propertyIsEnumerable</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">Object</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">prototype</span></code></td>
          <td>?</td>
          <td>2.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code class="rswd">override</code></td>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><a name="p" id="p"></a><code class="rswd">package</code></td>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code>@position</code></td>
          <td>-</td>
          <td>7.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">print</span><span
            class="punct">(</span><var>string</var><span
            class="punct">)</span></code></td>
          <td>-</td>
          <td>7.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code class="rswd">private</code></td>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code class="rswd">protected</code></td>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code class="rswd">public</code></td>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><a name="q" id="q"></a><a name="r" id="r"></a><code><span
            class="ident">RegExp</span><span
            class="punct">(</span><var>...</var></code>[<code><span
            class="punct">,</span> <span class="str"
            >&quot;</span></code>[<code class="str"
            >g</code>][<code class="str">i</code>]<code class="str"
            >&quot;</code>]<code><span
            class="punct">)</span></code></td>
          <td>1.2</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span class="ident">RegExp</span><span
            class="punct">(</span><var>...</var></code>[<code><span
            class="punct">,</span> <span class="str"
            >&quot;</span></code>[<code class="str"
            >g</code>][<code class="str">i</code>][<code
            class="str">m</code>]<code class="str"
            >&quot;</code>]<code><span
            class="punct">)</span></code></td>
          <td>1.5</td>
          <td>3.0</td>
          <td>3</td>
        </tr>
        <tr>
          <td>{<code class="ident">RegExp</code> | <code><var
            >reArray</var></code>}<code><span class="punct"
            >.</span></code>{<code class="ident">$_</code>
            | <code class="ident">input</code>}</td>
          <td>1.2</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span class="ident">RegExp</span><span
            class="punct">.</span>{<span class="ident">$&amp;</span> | <span
            class="ident">lastMatch</span>}</code></td>
          <td>1.2</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span class="ident">RegExp</span><span
            class="punct">.</span>{<span class="ident">$+</span> | <span
            class="ident">lastParen</span>}</code></td>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span class="ident">RegExp</span><span
            class="punct">.</span>{<span class="ident">$`</span> | <span
            class="ident">leftContext</span>}</code></td>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span class="ident">RegExp</span><span
            class="punct">.</span>{<span class="ident">$'</span> | <span
            class="ident">rightContext</span>}</code></td>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">RegExp</span><span class="punct">.</span><span
            class="ident">$</span><var>integer</var></code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code>{<span
            class="ident">RegExp</span> | <var>reArray</var>}<span
            class="punct">.</span><span class="ident">index</span></code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">RegExp</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">compile</span><span
            class="punct">(</span><var>...</var><span
            class="punct">)</span></code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">RegExp</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">exec</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">RegExp</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">global</span></code></td>
          <td>1.2</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">RegExp</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">ignoreCase</span></code></td>
          <td>1.2</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">RegExp</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">multiline</span></code></td>
          <td>1.2</td>
          <td>5.5</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">RegExp</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">source</span></code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><a name="s" id="s"></a><code class="rswd">sbyte</code></td>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span class="ident"><a
            href="javascript:void(alert(ScriptEngine()))"
            >ScriptEngine</a></span><span
            class="punct">()</span></code></td>
          <td>-</td>
          <td>2.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span class="ident"><a
            href="javascript:void(alert(ScriptEngineBuildVersion()))"
            >ScriptEngineBuildVersion</a></span><span
            class="punct">()</span></code></td>
          <td>-</td>
          <td>2.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span class="ident"><a
            href="javascript:void(alert(ScriptEngineMajorVersion()))"
            >ScriptEngineMajorVersion</a></span><span
            class="punct">()</span></code></td>
          <td>-</td>
          <td>2.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span class="ident"><a
            href="javascript:void(alert(ScriptEngineMinorVersion()))"
            >ScriptEngineMinorVersion</a></span><span
            class="punct">()</span></code></td>
          <td>-</td>
          <td>2.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code>@set</code></td>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code class="rswd">short</code></td>
          <td>?</td>
          <td>7.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><a href="#opNotEqual" title="!==">Strict Not Equal/Nonidentity operator</a></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td><code><span
            class="ident">String</span><span class="punct">.</span><span
            class="ident">fromCharCode</span><span
            class="punct">(</span><var>integer</var><span
            class="punct">)</span></code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><a href="javascript:alert('x'.charCodeAt(0))"
            onclick="return !!alert('x'.charCodeAt(0));"><code><span
            class="ident">String</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">charCodeAt</span><span
            class="punct">(</span><var>integer</var><span
            class="punct">)</span></code></a></td>
          <td>?</td>
          <td>3.0*</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">String</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">concat</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">String</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">localeCompare</span><span
            class="punct">(</span><var>string</var><span
            class="punct">)</span></code></td>
          <td>?</td>
          <td>5.5</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">String</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">match</span><span
            class="punct">(</span><var>RegExp</var><span
            class="punct">)</span></code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">String</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">replace</span><span
            class="punct">(</span><var>string|RegExp</var><span
            class="punct">,</span> <var>string</var><span
            class="punct">)</span></code></td>
          <td>1.2</td>
          <td>1.0</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">String</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">replace</span><span
            class="punct">(</span><var>string|RegExp</var><span
            class="punct">,</span> <var>Function</var><span
            class="punct">)</span></code></td>
          <td class="tested">1.3</td>
          <td class="tested">5.5.6330</td>
          <td class="tested">3</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">String</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">search</span><span
            class="punct">(</span><var>RegExp</var><span
            class="punct">)</span></code></td>
          <td>?</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">String</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">slice</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.0</td>
          <td>3.0</td>
          <td>?</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">String</span><span class="punct">.</span><span
            class="ident">prototype</span><span class="punct">.</span><span
            class="ident">split</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>1.1</td>
          <td>3.0</td>
          <td>1</td>
        </tr>
        <tr>
          <td><a name="switch" id="switch"><code><span
            class="rswd">switch</span>&nbsp;<span class="punct"
            >(</span><var>expression</var><span class="punct"
            >)&nbsp;{</span> <span class="rswd">case</span>&nbsp;<var
            >value</var><span class="punct">:</span>&nbsp;<var
            >statements</var>;&nbsp;</code>[<code><span class="rswd"
            >break</span><span class="punct">;</span></code>]
            <var>...</var>
            <code><span class="rswd">default</span><span class="punct"
            >:</span>&nbsp;<var>statements</var><span class="punct"
            >;</span>&nbsp;</code>[<code><span class="rswd">break</span><span
            class="punct">;</span></code>]<code>&nbsp;<span class="punct"
            >}</span></code></a></td>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Statements:switch"
            >1.2</a></td>
          <td><a href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsstmswitch.asp"
            >3.0</a></td>
          <td>3</td>
        </tr>
        <tr>
          <td><a name="t" id="t"></a><a name="throw" id="throw"><code><span
            class="rswd">throw</span>&nbsp;<var
            >expression</var></code></a></td>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Statements:throw"
            >1.4</a></td>
          <td class="tested">5.1.5010</td>
          <td>3</td>
        </tr>
        <tr>
          <td><a name="try" id="try"><code><span
            class="rswd">try</span>&nbsp;<span class="punct"
            >{</span></code>&nbsp;[<code><var
            >statements</var></code>]&nbsp;<code><span class="punct">}</span>
            <span class="rswd">catch</span>&nbsp;<span class="punct"
            >(</span><var>identifier</var><span class="punct"
            >)</span>&nbsp;<span class="punct">{</span>&nbsp;</code>[<code><var
            >statements</var></code>]&nbsp;<code><span class="punct"
            >}</span></code></a></td>
          <td><a href="http://developer.mozilla.org/en/docs/Core_JavaScript_1.5_Reference:Statements:try...catch"
            >1.4</a></td>
          <td class="tested"><a
            href="http://msdn.microsoft.com/library/en-us/jscript7/html/jsstmtrycatch.asp"
            >5.1.5010</a></td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span class="rswd">try</span>&nbsp;<span class="punct"
            >{</span></code>&nbsp;[<code><var
            >statements</var></code>]&nbsp;<code><span class="punct">}</span>
            <span class="rswd">finally</span>&nbsp;<span class="punct"
            >{</span>&nbsp;</code>[<code><var
            >statements</var></code>]&nbsp;<code><span class="punct"
            >}</span></code></td>
          <td>1.4</td>
          <td>-</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span class="rswd">try</span>&nbsp;<span class="punct"
            >{</span></code>&nbsp;[<code><var
            >statements</var></code>]&nbsp;<code><span class="punct">}</span>
            <span class="rswd">catch</span>&nbsp;<span class="punct"
            >(</span><var>identifier</var><span class="punct"
            >)</span>&nbsp;<span class="punct">{</span>&nbsp;</code>[<code><var
            >statements</var></code>]&nbsp;<code><span class="punct"
            >}</span>
            <span class="rswd">finally</span>&nbsp;<span class="punct"
            >{</span>&nbsp;</code>[<code><var
            >statements</var></code>]&nbsp;<code><span class="punct"
            >}</span></code></td>
          <td>1.4</td>
          <td>5.0</td>
          <td>3</td>
        </tr>
        <tr>
          <td><code><span class="rswd">try</span>&nbsp;<span class="punct"
            >{</span></code>&nbsp;[<code><var
            >statements</var></code>]&nbsp;<code><span class="punct">}</span>
            <span class="rswd">catch</span>&nbsp;<span class="punct"
            >(</span><var>identifier</var>&nbsp;<span class="rswd"
            >if</span>&nbsp;<var>expression</var><span class="punct"
            >)</span>&nbsp;<span class="punct">{</span>&nbsp;</code>[<code><var
            >statements</var></code>]&nbsp;<code><span class="punct"
            >}</span>
            </code>[<code><span class="rswd">catch</span>&nbsp;<span
            class="punct">(</span><var>identifier</var><span class="punct"
            >)</span>&nbsp;<span class="punct">{</span>&nbsp;</code>[<code><var
            >statements</var></code>]&nbsp;<code class="punct"
            >}</code>]<br>
            [<code><span class="rswd">finally</span>&nbsp;<span
            class="punct">{</span>&nbsp;</code>[<code><var
            >statements</var></code>]&nbsp;<code><span class="punct"
            >}</span></code>]</td>
          <td>1.5</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><a name="u" id="u"></a><code class="ident"><a
            name="undefined" id="undefined">undefined</a></code></td>
          <td>1.3</td>
          <td>5.5</td>
          <td>1</td>
        </tr>
        <tr>
          <td><a name="v" id="v"></a><code><span
            class="ident">VBArray</span><span
            class="punct">.</span><span
            class="ident">prototype</span><span
            class="punct">.</span><span
            class="ident">dimensions</span><span
            class="punct">()</span></code></td>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">VBArray</span><span
            class="punct">.</span><span
            class="ident">prototype</span><span
            class="punct">.</span><span
            class="ident">getItem</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span
            class="ident">VBArray</span><span
            class="punct">.</span><span
            class="ident">prototype</span><span
            class="punct">.</span><span
            class="ident">lbound</span><span
            class="punct">(</span>...<span
            class="punct">)</span></code></td>
          <td>-</td>
          <td>3.0</td>
          <td>-</td>
        </tr>
        <tr>
          <td><a name="w" id="w"></a><code class="ident">window</code></td>
          <td><a href="http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html"
            >1.0</a>; removed in <a href="#javascript">1.4</a>;
            <a href="http://developer.mozilla.org/en/docs/DOM:window"
               >Gecko&nbsp;DOM feature</a>
            since <a href="#javascript">1.5</a></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span class="ident">window</span><span
            class="punct">.</span><span
            class="ident">setInterval</span><span
            class="punct">(</span><var>string</var>,
            <var>msec</var><span class="punct">)</span></code></td>
          <td><a href="http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html#1203669"
            >1.2</a>; removed in <a href="#javascript">1.4</a>;
            <a href="http://developer.mozilla.org/en/docs/DOM:window.setInterval"
               >Gecko&nbsp;DOM feature</a> since <a href="#javascript">1.5</a></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span class="ident">window</span><span
            class="punct">.</span><span
            class="ident">setInterval</span><span
            class="punct">(</span><var>functionReference</var>,
            <var>msec</var></code>[<code>, <var>arg1</var></code>[<code>, ...,
            <var>argN</var></code>]]<code><span
            class="punct">)</span></code></td>
          <td>1.2; removed in 1.4;
            Gecko&nbsp;DOM feature since 1.5</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span class="ident">window</span><span
            class="punct">.</span><span
            class="ident">setTimeout</span><span
            class="punct">(</span><var>string</var>,
            <var>msec</var><span class="punct">)</span></code></td>
          <td><a href="http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html#1203758"
            >1.0</a>; removed in <a href="#javascript">1.4</a>;
            <a href="http://developer.mozilla.org/en/docs/DOM:window.setTimeout"
               >Gecko&nbsp;DOM feature</a> since <a href="#javascript">1.5</a></td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code><span class="ident">window</span><span
            class="punct">.</span><span
            class="ident">setTimeout</span><span
            class="punct">(</span><var>functionReference</var>,
            <var>msec</var></code>[<code>, <var>arg1</var></code>[<code>, ...,
            <var>argN</var></code>]]<code><span
            class="punct">)</span></code></td>
          <td><a href="http://research.nihonsoft.org/javascript/ClientReferenceJS13/window.html#1203758"
            >1.2</a>; removed in 1.4;
            Gecko&nbsp;DOM feature since 1.5</td>
          <td>-</td>
          <td>-</td>
        </tr>
        <tr>
          <td><code title="Generator expression"><span class="rswd">yield</span>
            <var>expression</var></code></td>
          <td><a href="http://developer.mozilla.org/en/docs/New_in_JavaScript_1.7#Generators"
            >1.7</a><sup><a href="#fn-decl-ver">[1]</a></sup></td>
          <td>-</td>
          <td>-</td>
        </tr>
      </tbody>
    </table>

    <h2><a name="javascript" id="javascript">JavaScript Version
      Information</a><sup>1)</sup></h2>
    <table class="versions">
      <thead>
        <tr>
          <td></td>
          <th>JavaScript&nbsp;<a
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
          <th><a href="http://www.mozilla.org/js/language/js20/">2.0</a></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="11"><sup>1)</sup> Version information from the
            JavaScript Guides and References; release dates from <a
            href="about:">about:</a>&nbsp;documents,
            <a href="http://www.mozilla.org/releases/cvstags.html"
            >mozilla.org</a> and
            <a href="http://en.wikipedia.org/wiki/Mozilla_Firefox#History"
            >Wikipedia</a>.</td>
        </tr>
      </tfoot>
      <tbody>
        <tr>
          <th><a href="http://browser.netscape.com/">Netscape (Navigator)</a></th>
          <td>2.0 (1996-03)</td>
          <td>3.0 (1996-08)</td>
          <td>4.0&#8211;4.05 (1997-06)</td>
          <td>4.06&#8211;4.8 (1998&#8211;2002)</td>
          <td>-</td>
          <td>6.x&#8211;8.1.3 (2000-11-14 &#8211;&nbsp;2007-04-02)</td>
          <td>-</td>
          <td>9.0b1 (2007-06-05)</td>
          <td></td>
          <td></td>
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
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.org/products/mozilla1.x/"
                 >Mozilla Application&nbsp;Suite</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>0.6&#8211;1.8a6 (2000-11
            &#8211;&nbsp;2005-01)</td>
          <td>1.8b1 (2005-02)</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.org/projects/seamonkey/"
                 >SeaMonkey</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>1.0&#8211;1.0.9 (2005-09-15
            &#8211;&nbsp;2007-05-30)</td>
          <td>1.1a<br>
            (2006-08-30)</td>
          <td>2.0a<br>
            (2007?)</td>
          <td></td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.com/firefox/"
                 >Mozilla Phoenix/Firebird/Firefox</a></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>Phoenix&nbsp;0.1 &#8211;&nbsp;Firefox&nbsp;1.0.x<br>
            (2002-09-23 &#8211;&nbsp;2006-04-13)</td>
          <td>Firefox&nbsp;1.1a1&#8211;2.0a3<br>
            (2005-05-31 &#8211;&nbsp;2006-05-26)</td>
          <td>2.0b1<br>
            (2006-07-12)</td>
          <td>3.0a2<br>
            (2007-02-07)</td>
          <td></td>
        </tr>
        <tr>
          <th><a href="http://www.mozilla.org/js/language/Epimetheus.html"
                 >mozilla.org Epimetheus</a></th>
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
      </tbody>
    </table>

    <h2><a name="jscript" id="jscript"
      >JScript Version Information</a><sup>2)</sup></h2>
    <table class="versions">
      <thead>
        <tr>
          <td></td>
          <th>JScript&nbsp;1.0</th>
          <th>2.0</th>
          <th>3.0</th>
          <th>3.1.3510</th>
          <th>4.0</th>
          <th>5.0</th>
          <th>5.1.5010</th>
          <th>5.5.6330</th>
          <th>5.6.8819</th>
          <th>5.7.5730</th>
          <th>7.0 (.NET)</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="11"><sup>2)</sup> Version information from <a
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
          <td></td>
        </tr>
        <tr>
          <th><a href="http://microsoft.com/iis/"
                 >Microsoft Internet Information Server</a></th>
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
          <td>.NET (2002)</td>
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
          <td>2003 (2003-04)</td>
          <td></td>
          <td></td>
          <td></td>
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
          <td>1.0 (2000-07)</td>
        </tr>
      </tbody>
    </table>

    <h2><a name="actionscript" id="actionscript"
      >ActionScript Version Information</a><sup>3)</sup></h2>
    <table class="versions">
      <thead>
        <tr>
          <td></td>
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

    <h2><a name="ecmascript" id="ecmascript">ECMAScript Implementation
      Information</a></h2>
      
    <p>The following table provides a rough overview of ECMAScript Editions
      and relations between them and versions of their implementations.  Note
      that conforming implementations are allowed to <em>extend</em> ECMAScript,
      so these are <em>by no means</em> 1:n relations, instead more like a
      comparison based on most common language features.</p>
      
    <p style="text-align:left"
       >See <a href="#features">Language&nbsp;Features</a>
       above for details.</p>
      
    <table class="versions">
      <thead>
        <tr>
          <td></td>
          <th>ECMAScript&nbsp;Edition&nbsp;1</th>
          <th>2</th>
          <th>3</th>
          <th>4 (Working&nbsp;Draft)</th>
        </tr>
        <tr>
          <td></td>
          <td><a href="http://www.mozilla.org/js/language/"
            >June&nbsp;1997</a></td>
          <td><a href="http://www.mozilla.org/js/language/"
            >August&nbsp;1998</a></td>
          <td><a href="http://www.ecma-international.org/publications/standards/Ecma-262.htm"
            >December&nbsp;1999</a> &#8211;&nbsp;<a
            href="http://developer.mozilla.org/en/docs/JavaScript_Language_Resources#JavaScript_1.x">March&nbsp;2000</a></td>
          <td><a href="http://www.mozilla.org/js/language/es4/"
            >August&nbsp;2000 &#8211;&nbsp;June&nbsp;2003&#8212;</a></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th><a href="#javascript">JavaScript</a></th>
          <td>1.1, 1.3, 1.4</td>
          <td></td>
          <td>1.5&#8211;1.8</td>
          <td>2.0</td>
        </tr>
        <tr>
          <th><a href="#jscript">JScript</a></th>
          <td>1.0</td>
          <td></td>
          <td>5.5, 5.6</td>
          <td>7.0 (.NET)</td>
        </tr>
        <tr>
          <th><a href="http://www.opera.com/docs/specs/js/ecma/">Opera</a></th>
          <td></td>
          <td></td>
          <td>6.0 (2001-12)</td>
          <td></td>
        </tr>
      </tbody>
    </table>

    <table class="versions" style="margin-top:1em">
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
      <a href="http://validator.w3.org/check/referer"><img
        src="../media/valid-html401.png"
        style="border: 0"
        alt="Valid HTML 4.01"
        ></a><br>
      <a href="http://eclipse.org/"><img
        src="../media/eclipse-built-on-white.jpg"
        alt="built on eclipse"
        style="border: 0"
        ></a>
    </div>
  </body>
</html>
<?php
  require('cgi_buffer/php/cgi_buffer.php');                 
?>