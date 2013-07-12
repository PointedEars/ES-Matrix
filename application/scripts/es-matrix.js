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
    properties.filterColumns = filterColumns;
    properties.addTitles = true;

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
          var req = new jsx.net.http.Request();
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
