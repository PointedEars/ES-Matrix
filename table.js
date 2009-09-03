var scroller, origHeight;

/**
 * Toggles the scrollability of the body of the scroller table.
 * 
 * @param bVerbose : boolean
 *   If <code>true</code>, displays an error message if toggling
 *   is not possible.
 * @return undefined
 */
function toggleScroll(bVerbose)
{
  if (scroller)
  {
    var bScrollable = (dhtml.getStyleProperty(scroller, 'height') != "auto");

    if (dhtml.setStyleProperty(scroller, 'height',
          bScrollable ? 'auto' : origHeight + 'px')
        &&
        dhtml.setStyleProperty(scroller, 'overflow',
          bScrollable ? 'visible' : 'scroll'))
    {
      return true;
    }
  }
  
  if (bVerbose)
  {
    window.alert("Sorry, this feature is not supported by your user agent.");
  }
}

/**
 * Initializes the scrollable toggle
 */
function initScroller() {
  // overridden later
}

/**
 * Prints the scrollable toggle button
 */
function printScrollButton() {
  // overridden later
}

if (typeof document != "undefined"
    && isMethod(document, "defaultView", "getComputedStyle"))
{
  /**
   * Overrides the function declared above.
   */ 
  initScroller = function() {
    var btToggleScroll;
    if ((scroller = dhtml.getElem('id', 'scroller'))
        && (btToggleScroll = dhtml.getElem('id', 'btToggleScroll')))
    {
      btToggleScroll.style.display = "";
      origHeight = parseFloat(
        document.defaultView.getComputedStyle(scroller, null).height, 10);

      // Firefox tbody-scroll bug workaround
      toggleScroll();
      toggleScroll();
    }
  };
  
  /**
   * Overrides the function declared above.
   */ 
  printScrollButton = function() {
    if (typeof initScroller != "undefined")
    {
      var button = {
        tagName: "input",
        attributes: [
          {name: "type",    value: "button"},
          {name: "value",   value: "Toggle table\xA0body scrollability"},
          {name: "onclick", value: "toggleScroll(true);"},
          {
            name: "style",
            value: {
              properties: [
                {name: "display", value: "none"}
              ] 
            }
          },
          {name: "id", value: "btToggleScroll"}
        ],
        
        /**
         * Returns the string representation of this object.
         * 
         * @return string The properties of this object represented as a
         *   SGML-conforming start tag.  
         */
        toString: function() {
          var res = [];
          if (this.tagName)
          {
            res.push(this.tagName);
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
          return "<" + res.join("") + ">";
        },
        
        /**
         * @return Object
         */
        toObject: function(o) {
          var attrs = this.attributes;
          for (var i = 0, len = attrs && attrs.length; i < len; i++)
          {
            var attr = attrs[i];
            
            switch (attr.name)
            {
              case "style":
                var sp = attr.value.properties;
                for (var j = 0, len2 = sp && sp.length; j < len2; j++)
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
        }
      };
              
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
            var inp = document.createElement(button.tagName);
            
            if (inp)
            {
              o.insertBefore(button.toObject(inp), o.firstChild.nextSibling);
            }
          }
          o = br = inp = null;
        });
    }    
  };
}

/**
 * Sets or appends an alternating <code>class</code> attribute value
 * to all rows of all <code>tbody</code> elements in the document so as
 * to distinguish (and format) odd and even rows. 
 */
function alternateRows()
{
  var tbodies = dhtml.gEBTN("tbody");
  for (var i = tbodies && tbodies.length; i--;)
  {
    for (var rows = tbodies[i].rows, j = rows.length; j--;)
    {
      var o = rows[j];
      var currentClass = dhtml.getAttr(o, "class");
      if (!/\b(odd|even)\b/i.test(currentClass))
      {
        dhtml.setAttr(o, "class",
          (j % 2 ? "odd" : "even") + (currentClass ? " " + currentClass : ""));
      }
    }
  } 
}