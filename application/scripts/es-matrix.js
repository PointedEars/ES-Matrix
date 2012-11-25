var es_matrix = new Object();

function body_load ()
{
  jsx.string.hyphenation.loadDictionary("application/scripts/hyphenation-en.js");
  var elements = new Array();
  elements[0] = document.getElementById('abstract');
  elements[1] = document.getElementById('foreword');
  if (elements[0])
  {
    jsx.dom.hyphenate(elements);
  }

  synhl();

  var filterColumns = new Array();
  filterColumns[0] = new Object();
  filterColumns[0].index = 0;
  filterColumns[0].ignoreCase = true;
  var properties = new Object();
  properties.filterColumns = filterColumns;
  var table = new jsx.dom.widgets.Table(
    document.getElementById("features-table"),
    null,
    properties);

  var filter = document.forms[0].elements["filter"];
  es_matrix.timeout = new jsx.dom.timeout.Timeout(function () {
    table.applyFilter(filter.value);
  });
}

function table_click (e)
{
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
      && target.firstChild.tagName.toLowerCase() != "textarea")
  {
    target.innerHTML =
        '<form action="index-db.php" method="POST">'
      + '<textarea name="code" style="width: 100%; height: 3em">'
      + unsynhl(target.innerHTML)
      + '</textarea>'
      + '<input type="hidden" name="controller" value="feature">'
      + '<input type="hidden" name="action" value="save">'
      + '<input type="hidden" name="id" value="' + target.id.match(/\d+/)[0] + '">'
      + '<button type="submit" name="metadataOnly" value="1" style="clear: both; float: right">'
      + 'Save</button>'
      + '</form>';
  }
}
