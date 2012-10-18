function body_load ()
{
  jsx.string.hyphenation.loadDictionary("application/scripts/hyphenation-en.js");
  var elements = new Array();
  elements[0] = document.getElementById('abstract');
  elements[1] = document.getElementById('foreword');
  jsx.dom.hyphenate(elements);

  synhl();
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
        '<textarea name="code[' + target.id.match(/\d+/)[0] + ']" style="width: 100%; height: 3em">'
      + target.innerHTML
      + '</textarea>'
      + '<input type="hidden" name="controller" value="feature">'
      + '<input type="hidden" name="action" value="save">'
      + '<button type="submit" name="metadataOnly" value="1" style="clear: both; float: right">'
      + 'Save</button>';
  }
}
