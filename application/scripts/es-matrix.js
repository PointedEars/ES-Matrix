/* NOTE: Stick to basic features for maximum backwards compatility */
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

function body_load ()
{
  safeTwitter(document, 'script', 'twitter-wjs');

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

    var table = new jsx.dom.widgets.Table(
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

  synhl();
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
            target.innerHTML = synhl(response.responseText);
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
          childNodes: [unsynhl(oldHTML)]
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
    document.write(inputs.join("\n") + _createMarkupFromObj(span));
  }
}