function strReplace (needle, replacement, haystack, global)
{
  var i,
      lastIndex = 0,
      replacementLen = replacement.length;

  while ((i = haystack.indexOf(needle, lastIndex)) > -1)
  {
    haystack = haystack.substring(0, i)
             + replacement
             + haystack.substring(i + replacementLen);
    if (!global)
    {
      break;
    }

    lastIndex = i + replacementLen;
  }

  return haystack;
}

//function ScriptEngine () { return "JScript";}
//function ScriptEngineMajorVersion () { return "42"; }
//function ScriptEngineMinorVersion () { return "23"; }
//function ScriptEngineBuildVersion () { return "1337"; }

var implementation = jsx.object.isMethod(this, "ScriptEngine") ? ScriptEngine() : '';
if (implementation)
{
  implementation = strReplace("<", "&gt;", strReplace('"', "&quot;", implementation, true), true);
  var version = '';
  if (jsx.object.isMethod(this, "ScriptEngineMajorVersion"))
  {
    version = ScriptEngineMajorVersion();

    if (jsx.object.isMethod(this, "ScriptEngineMinorVersion"))
    {
      version += "." + ScriptEngineMinorVersion();

      if (jsx.object.isMethod(this, "ScriptEngineBuildVersion"))
      {
        version += "." + ScriptEngineBuildVersion();
      }
    }

    if (version)
    {
      version = strReplace("<", "&gt;", strReplace('"', "&quot;", version, true), true);
    }
  }

  document.write(
    '<input type="hidden" name="implementation" value="' + implementation + '">'
    + '<input type="hidden" name="version" value="' + version + '">');
}