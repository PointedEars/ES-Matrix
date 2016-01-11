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

es_matrix.engineInfo = new jsx.engine.EngineInfo();
es_matrix.implementation = es_matrix.engineInfo.getFullName();
es_matrix.implVersion = es_matrix.engineInfo.getVersion();

if (!es_matrix.engineInfo.isInferred())
{
  es_matrix.implStr = strReplace("<", "&gt;",
    strReplace('"', "&quot;", es_matrix.implementation, true), true);

  if (es_matrix.implVersion)
  {
    es_matrix.implVerStr = strReplace("<", "&gt;",
      strReplace('"', "&quot;", es_matrix.implVersion, true), true);
  }

  /* document.write() is OK: *//*jshint -W060*/
  document.write(
    '<input type="hidden" name="implementation" value="' + (es_matrix.implStr || "") + '">'
    + '<input type="hidden" name="version" value="' + (es_matrix.implVerStr || "") + '">');
}
