/* This is a library, symbols are used elsewhere: *//*jshint -W098*/
/*
 * NOTE: Stick to basic features for maximum backwards compatility,
 * so no warnings for
 */
/* new Array()  *//*jshint -W009*/
/* new Object() *//*jshint -W010*/
/* ==           *//*jshint -W041*/
var es_matrix = new Object();

function safeTwitter (d, s, id)
{
  var _isMethod = jsx.object.isMethod;

  var js,
       fjs = _isMethod(d, "getElementsByTagName")
               ? d.getElementsByTagName(s)[0]
               : new Object(),
       p   = String(d.location).indexOf("http:") == 0
               ? 'http'
               : 'https';
  if (_isMethod(d, "getElementById") && !d.getElementById(id))
  {
    js = _isMethod(d, "createElement")
           ? d.createElement(s)
           : new Object();
    js.id = id;
    js.src = p + '://platform.twitter.com/widgets.js';
    if (fjs.parentNode)
    {
      fjs.parentNode.insertBefore(js, fjs);
    }
  }
}

function publicTwitter ()
{
  for (var i = es_matrix.twitterButtons.length; i--;)
  {
    es_matrix.twitterButtons[i].onclick = null;
  }

  var _removeChild = jsx.dom.removeChild;
  for (i = es_matrix.twitterInfoButtons.length; i--;)
  {
    var infoButton = es_matrix.twitterInfoButtons[i];
    _removeChild(infoButton.parentNode, infoButton);
  }

  safeTwitter(document, 'script', 'twitter-wjs');

  return false;
}

function body_load ()
{
  var twitterButtons = es_matrix.twitterButtons = jsx.dom.css.getElemByClassName("twitter");
  if (twitterButtons && twitterButtons.length > 0)
  {
    var _createNodeFromObj = jsx.dom.createNodeFromObj;
    var _insertBefore = jsx.dom.insertBefore;

    var infoButton = new Object();
    infoButton.type = "a";
    infoButton.attributes = new Object();
    infoButton.attributes.href = "http://www.heise.de/ct/artikel/2-Klicks-fuer-mehr-Datenschutz-1333879.html";
    infoButton.className = "twitter-privacy";

    var child = new Object();
    child.type = "img";
    var attributes = child.attributes = new Object();
    attributes.src = "/media/video/img/buttons/twitter-privacy-info.png";
    attributes.width = 23;
    attributes.height = 20;
    attributes.alt = "(more information)";
    attributes.title =
        "If you enable the button on the left by selecting it,"
      + " information will be transferred to and perhaps stored in servers"
      + " located in the United States of America, which can infringe upon"
      + " your privacy.  Select this for further information (in German)"
      + " on heise online.";

    infoButton.childNodes = new Array();
    infoButton.childNodes[0] = child;

    var infoButtons = es_matrix.twitterInfoButtons = new Array();

    for (var i = twitterButtons.length; i--;)
    {
      var button = twitterButtons[i];
      button.title =
          "An extra click is protecting your privacy here."
        + "  Select this to enable the Twitter buttons in this document,"
        + " which will already transfer information to servers located in"
        + " the United States of America.  Once enabled, you can use them"
        + " to follow me and/or share this on Twitter.";

      var textNode = _createNodeFromObj(" ");
      _insertBefore(button.parentNode, textNode, button.nextSibling);

      var infoButtonNode = infoButtons[infoButtons.length] = _createNodeFromObj(infoButton);
      _insertBefore(button.parentNode, infoButtonNode, textNode.nextSibling);
    }
  }

  jsx.string.hyphenation.loadDictionary("application/scripts/hyphenation-en.js");

  var elements = new Array();
  elements[0] = document.getElementById('abstract');
  elements[1] = document.getElementById('foreword');
  elements[2] = document.getElementById('features');
  if (elements[0])
  {
    jsx.dom.hyphenate(elements);
  }

  var filterColumnIndex = 0;

  var filter = document.forms[0].elements["filter"];
  if (!filter)
  {
    /*
     * In Edit mode, there is no form for the filter input,
     * and the first column (index 0) contains Edit/Delete commands.
     */
    es_matrix.editMode = true;
    filter = document.getElementById("filter");
    filterColumnIndex = 1;
  }

  if (filter)
  {
    var filterColumns = new Array();
    filterColumns[0] = new Object();
    filterColumns[0].index = filterColumnIndex;
    filterColumns[0].ignoreCase = true;

    var properties = new Object();
    properties.addTitles = true;
    properties.filterColumns = filterColumns;
    properties.highlightMatches = true;

    var scroller = document.getElementById("scroller");
    if (scroller
        && jsx.dom.css.getComputedStyle(scroller, null, "overflow") != "auto")
    {
      jsx.dom.removeClassName(scroller, "scroll");
    }

    var table = document.getElementById("features-table");

    /* Testcase tooltips */
    var tbody = table.tBodies[0];
    var _addClassName = jsx.dom.addClassName;

    tbody.onmouseover = jsx.dom.createEventListener(function (e) {
      var target = e.target;
      if (target.tagName.toLowerCase() == "td" && target.id)
      {
        var tooltip = document.getElementById(target.id + "-tooltip");
        if (!tooltip)
        {
          if (target.title)
          {
            _addClassName(target, "tooltip-container", true);
            tooltip = document.createElement("div");
            if (tooltip)
            {
              tooltip.id = target.id + "-tooltip";
              tooltip.className = "tooltip";
              tooltip.innerHTML = target.title.replace(/\r?\n|\r/g, "<br>");
              target.title = "";
              target.removeAttribute("title");
              target.appendChild(tooltip);
            }
          }
        }

        if (tooltip)
        {
          tooltip.scrollLeft = 0;
          tooltip.scrollTop = 0;
        }
      }
    });

    /* Filters */
    table = new jsx.dom.widgets.Table(
      document.getElementById("features-table"),
      null,
      properties);

    var timeout = es_matrix.timeout = new jsx.dom.timeout.Timeout(function () {
      table.applyFilter(filter.value);
    });

    es_matrix.timeout2 = new jsx.dom.timeout.Timeout((function () {
      if (jsx.object.areHostMethods(window, "history", ["pushState", "replaceState"]))
      {
        return function () {
          var history = window.history;
          var value = filter.value;
          var title = "Filter: " + value;
          var url = "?filter=" + encodeURIComponent(value);
          if (history.state == null)
          {
            history.pushState(value, title, url);
          }
          else
          {
            history.replaceState(value, title, url);
          }
        };
      }

      return function () {};
    }()), 2000);

    /* Filter on pre-filled filter control */
    if (filter.value)
    {
      timeout.run();
    }
  }

  /* imported: *//*jshint -W117*/
  synhl();
  /*jshint +W117*/
}

var req;

function es_matrix_edit (link)
{
  if (!req)
  {
    req = new jsx.net.http.Request();
  }

  var me = this;

  req.setURL(link.href);
  req.setData('xhr=1');
  req.setSuccessListener(function (response) {
    /* Add/show edit links */

    /* Modify edit link */
    me.edit_href = link.getAttribute("href");
    me.edit_onclick = link.onclick;
    me.edit_textContent = link.textContent;
    link.href = me.endEdit_href;
    link.onclick = function () {
      return es_matrix.endEdit(this);
    };
    link.textContent = me.endEdit_textContent;
  });

  if (req.send())
  {
    console.log(req);
    return false;
  }
}
es_matrix.edit = es_matrix_edit;

function es_matrix_endEdit (link)
{
  if (!req)
  {
    req = new jsx.net.http.Request();
  }

  var me = this;

  req.setURL(link.href);
  req.setData('xhr=1');
  req.setSuccessListener(function (response) {
    /* Hide edit links */

    /* Restore edit link */
    link.href = me.edit_href;
    link.onclick = me.edit_onclick;
    link.textContent = me.edit_textContent;
  });

  if (req.send())
  {
    console.log(req);
    return false;
  }
}
es_matrix.endEdit = es_matrix_endEdit;

function table_click (e)
{
  if (!es_matrix.editMode)
  {
    return false;
  }

  var target = e && (e.target || e.srcElement);
  if (!target)
  {
    return false;
  }

  if (target.nodeType == 3)
  {
    target = target.parentNode;
  }

  if (target.tagName.toLowerCase() == "th"
      && target.parentNode.cells[1] == target
      && target.firstChild.nodeName.toLowerCase() != "form")
  {
    var oldHTML = target.innerHTML;
    jsx.dom.removeChildren(target, target.childNodes);
    target.appendChild(jsx.dom.createNodeFromObj({
      type: "form",
      properties: {
        action: "index-db",
        method: "POST",
        onsubmit: function (ev) {
          if (!req)
          {
            req = new jsx.net.http.Request();
          }
          req.getDataFromForm(this, true);
          req.setData(req.data + "&xhr=1");
          req.setSuccessListener(function (response) {
            /* synhl() is imported *//*jshint -W117*/
            target.innerHTML = synhl(response.responseText);
            /*jshint +W117*/
          });

          if (req.send())
          {
            console.log(req);
            return false;
          }
        }
      },
      childNodes: [
        {
          type: "textarea",
          properties: {
            name: "code",
            style: {
              width: "100%",
              height: "3em"
            }
          },
          childNodes: [
            /* imported: *//*jshint -W117*/
            unsynhl(oldHTML)
            /*jshint +W117*/
          ]
        },
        {
          type: "input",
          properties: {
            type: "hidden",
            name: "controller",
            value: "feature"
          }
        },
        {
          type: "input",
          properties: {
            type: "hidden",
            name: "action",
            value: "save"
          }
        },
        {
          type: "input",
          properties: {
            type: "hidden",
            name: "id",
            value: target.id.match(/\d+/)[0]
          }
        },
        {
          type: "button",
          properties: {
            type: "submit",
            name: "metadataOnly",
            value: "1",
            style: {
              clear: "both",
              "float": "right"
            }
          },
          childNodes: ["Save"]
        }
      ]
    }));

//    .innerHTML =
//        '<form action="index-db.php" method="POST">'
//      + '<textarea name="code" style="width: 100%; height: 3em">'
//      + unsynhl(target.innerHTML)
//      + '</textarea>'
//      + '<input type="hidden" name="controller" value="feature">'
//      + '<input type="hidden" name="action" value="save">'
//      + '<input type="hidden" name="id" value="' + target.id.match(/\d+/)[0] + '">'
//      + '<button type="submit" name="metadataOnly" value="1" style="clear: both; float: right">'
//      + 'Save</button>'
//      + '</form>';
  }
}

function es_matrix_write (s)
{
  var ns = document.documentElement.getAttribute("xmlns");
  var scripts;
  if (ns)
  {
    scripts = document.getElementsByTagNameNS(ns, "script");
  }
  else
  {
    scripts = document.getElementsByTagName("script");
  }

  if (scripts && scripts.length > 0)
  {
    var lastScript = scripts[scripts.length - 1];
    result2 = !!jsx.dom.insertBefore(lastScript.parentNode,
      document.createTextNode(s), lastScript.nextSibling);
  }
}

function es_matrix_Result (testcaseId, value)
{
  this.testcaseId = testcaseId;
  this.value = value;
}

function es_matrix_collect_results (tdId, results)
{
  /* Imports */
  var _dom = jsx.dom;
  var _createElementFromObj = _dom.createElementFromObj;
  var _createMarkupFromObj = _dom.createMarkupFromObj;

  var count = 0;
  var inputs = new Array();
  var resultsStr = new Array();

  var supports_DOM1 = es_matrix.supportsDOM1;
  if (typeof supports_DOM1 == "undefined")
  {
    supports_DOM1 = es_matrix.supportsDOM1 =
      jsx.object.isHostMethod(document, "createElement");
  }

  if (supports_DOM1)
  {
    var result_cell = _dom.getElementById(tdId);

    /* If this cell does not support appendChild(), assume none does */
    supports_DOM1 = es_matrix.supportsDOM1 =
      jsx.object.isHostMethod(result_cell, "appendChild");
  }

  for (var i = 0, len = results.length; i < len; ++i)
  {
    var result = results[i];
    var value = result.value;
    if (value)
    {
      ++count;
    }

    var input = new Object();
    input.type = "input";
    var attrs = input.attributes = new Object();
    attrs.type = "hidden";
    attrs.name = 'results[' + result.testcaseId + ']';
    attrs.value = (value ? '1' : '0');

    if (supports_DOM1)
    {
      var input = _createElementFromObj(input);
      if (input)
      {
        result_cell.appendChild(input);
      }
      else
      {
        supports_DOM1 = es_matrix.supportsDOM1 = false;
      }
    }

    if (!supports_DOM1)
    {
      inputs[inputs.length] = _createMarkupFromObj(input);
    }

    resultsStr[resultsStr.length] =
      "Test " + (i + 1) + ": " + (value ? "passed" : "failed");
  }

  var span = new Object();
  span.type = "span";
  (span.attributes = new Object()).title = resultsStr.join("\n");
  span.childNodes = new Array(
    ((len > 0 && count == len) ? "+" : (count == 0 ? String.fromCharCode(8722) : "*"))
  );

  if (supports_DOM1)
  {
    result_cell.appendChild(_createElementFromObj(span));
  }
  else
  {
    /* document.write() is OK as fallback: *//*jshint -W060*/
    document.write(inputs.join("\n") + _createMarkupFromObj(span));
  }
}
