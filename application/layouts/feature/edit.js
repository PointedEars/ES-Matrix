"use strict";

function TestcaseControl (oTarget, oParent, oProperties)
{
  TestcaseControl._super.apply(this, arguments);
}

TestcaseControl.extend(jsx.dom.widgets.Section, {
  elementType: "article",

  init: function () {
    var _widgets = jsx.dom.widgets;
    this._title = new _widgets.Input(null, this._target);
    this._code = new _widgets.TextArea(null, this._target);
    this._enclose = new _widgets.CheckBox(null, this._target, {
      label: "Enclose in double-quotes"
    });
    this._alt = new _widgets.Input(null, this._target, {
      label: new _widgets.Label(null, this._target, {
        innerHTML: [
          "Alternative ",
          {
            type: "code",
            childNodes: ["type"]
          },
          " attribute value"
        ]
      })
    });
  }
});

function deleteTestcase(deleteButton, id)
{
  var form = deleteButton.form;
  var prefixes = ["title", "code"];
  for (var i = prefixes.length; i--;)
  {
    var prefix = prefixes[i];
    var control = form.elements["testcase_" + prefix + id];
    control.parentNode.removeChild(control);

  }

  var label = document.getElementById("testcase_quoted" + id);
  label.parentNode.removeChild(label);
  var idCount = id + 1;
  var otherCheckbox;
  while ((otherCheckbox = form.elements["testcase_quoted[" + idCount + "]"]))
  {
    otherCheckbox.name = "testcase_quoted[" + (idCount - 1) + "]";
    ++idCount;
  }

  label = document.getElementById("testcase_alt_type" + id);
  label.parentNode.removeChild(label);

  deleteButton.parentNode.removeChild(deleteButton);
}

var _createElement = jsx.dom.createElementFromObj;

function addTestcase (addButton)
{
  var testcases = addButton.form.elements["testcase_title[]"];
  var numTestcases;
  if (testcases)
  {
    if (testcases.length)
    {
      numTestcases = testcases.length;
    }
    else
    {
      numTestcases = 1;
    }
  }
  else
  {
    numTestcases = 0;
  }

  var input = _createElement({
    type: "input",
    properties: {
      type: "text",
      name: "testcase_title[]",
      id: "testcase_title" + numTestcases,
      value: "",
      style: {
        width: "99%"
      }
    }
  });

  var textarea = _createElement({
    type: "textarea",
    properties: {
      name: "testcase_code[]",
      id: "testcase_code" + numTestcases,
      cols: 80,
      rows: 5,
      style: {
        width: "99%"
      }
    }
  });

  var label = _createElement({
    type: "label",
    properties: {
      id: "testcase_quoted" + numTestcases,
      style: {
        "float": "left",
      }
    },
    childNodes: [
      {
        type: "input",
        properties: {
          type: "checkbox",
          name: "testcase_quoted["+ numTestcases + "]",
          value: "1",
        }
      },
      "Enclose in double-quotes"
    ]
  });

  var label2 = _createElement({
    type: "label",
    properties: {
      id: "testcase_alt_type" + numTestcases,
      style: {
        "float": "left",
        marginLeft: "1em"
      }
    },
    childNodes: [
      "Alternative ",
      {
        type: "code",
        childNodes: [
          "type"
        ]
      },
      " attribute value: ",
      {
        type: "input",
        properties: {
          name: "testcase_alt_type[]",
          size: 50
        }
      }
    ]
  });

  var deleteButton = _createElement({
    type: "button",
    properties: {
      type: "button",
      className: "delete",
      onclick: (function (id) {
        return function () {
          deleteTestcase(this, id);
        };
      }(numTestcases)),
      style: {
        "float": "right",
        marginBottom: "1em"
      }
    },
    childNodes: [
      "Delete"
    ]
  });

  if (deleteButton.type != "button")
  {
    deleteButton.setAttribute("type", "button");
  }

  var parentNode = addButton.parentNode;
  parentNode.insertBefore(input, addButton);
  parentNode.insertBefore(textarea, addButton);
  parentNode.insertBefore(label, addButton);
  parentNode.insertBefore(label2, addButton);
  parentNode.insertBefore(deleteButton, addButton);
  input.focus();
}

function cloneTestcase (cloneButton)
{
  addTestcase(cloneButton);
}