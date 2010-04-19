/**
 * Toggles the scrollability of the body of the scroller table.
 * 
 * @param bVerbose : boolean
 *   If <code>true</code>, displays an error message if toggling
 *   is not possible.
 */

function Scrollable(target, sClassName, iMaxHeight, callback)
{
  if (!target)
  {
    return throwThis("", "target must be a string or an object reference");
  }

  this.target = (isMethod(target, "valueOf") && typeof target.valueOf() == "string")
              ? dom.getElementById(target)
              : target;
  if (!this.target)
  {
    return;
  }

  if (!sClassName || typeof sClassName.valueOf() != "string")
  {
    return throwThis("", "sClassName must be a string");
  }

  this.className = sClassName;

  if (!iMaxHeight || typeof iMaxHeight.valueOf() != "number")
  {
    return throwThis("", "iMaxHeight must be a number");
  }
  
  this.maxHeight = iMaxHeight;

  if (this.target.offsetHeight < this.maxHeight)
  {
    if (typeof callback == "function")
    {
      callback(this);
    }

    /* Firefox tbody-scroll bug workaround */
    this.toggleScroll();
    this.toggleScroll();
  }
  else
  {
    dom.removeClassName(this.target, this.className);
  }
}

Scrollable.prototype.toggleScroll = function (bVerbose) {
  var target = this.target;
  if (target)
  {
    var className = this.className;
    
    if (target.className == className)
    {
      dom.removeClassName(target, className);
    }
    else
    {
      dom.addClassName(target, className, true);
    }
    
    return true;
  }
  
  if (bVerbose)
  {
    window.alert("Sorry, this feature is not supported by your user agent.");
  }
  
  return false;
};

var scroller = new Object();
/**
 * Initializes the scrollable toggle
 */
scroller.init = function () {
  scroller = new Scrollable('scroller', 'scroll', 400,
    function () {
      var btToggleScroll;
      if ((btToggleScroll = dom.getElem('id', 'btToggleScroll')))
      {
        btToggleScroll.style.display = "";
      }
    });
};

function HTMLSerializer(properties)
{
  this.tagName = properties.tagName;
  this.attributes = properties.attributes;
}

/**
 * Returns the string representation of this object.
 * 
 * @return string The properties of this object represented as a
 *   SGML-conforming start tag.
 */
HTMLSerializer.prototype.toString = function() {
  var res = [];
  
  var tagName = this.tagName;
  if (tagName)
  {
    res.push(tagName);
  }

  var attrs = this.attributes;
  for (var i = 0, len = attrs && attrs.length; i < len; i++)
  {
    var attr = attrs[i];
    
    if (attr.name == "style")
    {
      res.push(' style="');
      var sp = attr.value.properties;
      for (var j = 0, len2 = sp && sp.length; j < len2; j++)
      {
        res.push(sp[j].name, ": ", sp[j].value);
      }
      res.push('"');
    }
    else
    {
      res.push(" ", attr.name, '="', attr.value, '"');
    }
  }
  
  res = res.join("");
  
  if (tagName)
  {
    res = "<" + res + ">";
  }
  
  return res;
};

/**
 * @return Object
 */
HTMLSerializer.prototype.toObject = function(o) {
  if (!o)
  {
    var tagName = this.tagName;

    if (tagName)
    {
      o = document.createElement(tagName);
      if (!o)
      {
        return o;
      }
    }
    else
    {
      o = {};
    }
  }

  var attrs = this.attributes;
  for (var i = 0, len = attrs && attrs.length; i < len; ++i)
  {
    var attr = attrs[i];
    
    switch (attr.name)
    {
      case "style":
        var sp = attr.value.properties;
        for (var j = 0, len2 = sp && sp.length; j < len2; ++j)
        {
          o.style[sp[j].name] = sp[j].value;
        }
        break;
      
      case "onclick":
        o[attr.name] = new Function(attr.value);
        break;
        
      default:
        o[attr.name] = attr.value;
    }
  }
  
  return o;
};

/**
 * Prints the scrollable toggle button
 */
function printScrollButton()
{
  var button = new HTMLSerializer({
    tagName: "input",
    attributes: [
      {name: "type",    value: "button"},
      {name: "value",   value: "Toggle table\xA0body scrollability"},
      {name: "onclick", value: "scroller.toggleScroll(true);"},
      {
        name: "style",
        value: {
          properties: [
            {name: "display", value: "none"}
          ]
        }
      },
      {name: "id", value: "btToggleScroll"}
    ]
  });
          
  tryThis(
    /**
     * Writes the button in the document (HTML only)
     */
    function() {
      document.write(button);
    },
    /**
     * If writing fails (XHTML et al.), inserts the button in the document
     */
    function() {
      var o = document.getElementById("atoz");
      if (o)
      {
        o.insertBefore(button.toObject(), o.firstChild.nextSibling);
      }
    });
}

/**
 * Sets or appends an alternating <code>class</code> attribute value
 * to all rows of all <code>tbody</code> elements in the document so as
 * to distinguish (and format) odd and even rows.
 * 
 * @param restrictToRows : number
 *   If <tt>1</tt>, only consider odd rows;
 *   if <tt>2</tt>, only consider even rows;
 *   if <code>undefined</code>, consider all rows.
 */
function alternateRows(restrictToRows)
{
  var
    allRows = isNaN(restrictToRows),
    tbodies = dhtml.gEBTN("tbody");
  
  for (var i = tbodies && tbodies.length; i--;)
  {
    /* TODO */
//    if (!isNaN(restrictToRows)
//        && dom.getComputedStyle(tbodies.rows[restrictToRows+1], null, "color") == )
//    {
//
//    }
    
    for (var rows = tbodies[i].rows, j = rows.length; j--;)
    {
      if (allRows || (j - restrictToRows) % 2)
      {
        var o = rows[j];
      
        var currentClass = o.className;
        if (!/\b(odd|even)\b/i.test(currentClass))
        {
          /* NOTE: the first (odd) row has index 0 (even); 0 % 2 == 0 converts to false */
          o.className =
            (j % 2 ? "even" : "odd") + (currentClass ? " " + currentClass : "");
        }
      }
    }
  }
}