function inferVersion (version, versionMap, fallback)
{
  function gte(v1, v2)
  {
    v1 = v1.split(".");
    v2 = v2.split(".");
    for (var i = 0, len = v1.length; i < len; ++i)
    {
      if (parseInt(v1[i], 10) < parseInt(v2[i], 10))
      {
        return false;
      }
    }

    return true;
  }

  var s = "";

  for (var i = versionMap.length; i--;)
  {
    var mapping = versionMap[i];
    if (gte(version, mapping[0]))
    {
      s = mapping[1];
      break;
    }
  }

  if (!s && fallback)
  {
    s = fallback;
  }

  return s;
}

var
  bCanDetect = jsx.object.isMethod(this, "ScriptEngine"),

  /* No array or loop here for backwards compatibility */
  out = "";

if (bCanDetect)
{
  out += ":<p><b>" + ScriptEngine();

  if (jsx.object.isMethod(this, "ScriptEngineMajorVersion"))
  {
    out += " " + ScriptEngineMajorVersion();

    if (jsx.object.isMethod(this, "ScriptEngineMinorVersion"))
    {
      out += "." + ScriptEngineMinorVersion();

      if (jsx.object.isMethod(this, "ScriptEngineBuildVersion"))
      {
        out += "." + ScriptEngineBuildVersion();
      }
    }
  }

  out += "<\/b><\/p>";
}
else
{
  out = " cannot be detected directly.";

  if (typeof navigator != "undefined")
  {
    out += " Inference suggests it is<p><b>";

    var ua = navigator.userAgent || "";

    if (typeof window != "undefined"
        && jsx.object.getFeature(window, "opera"))
    {
      out += "Opera ECMAScript";
    }
    else if (ua.indexOf("Konqueror") > -1)
    {
      out += "KJS (Konqueror JavaScript)";
    }
    else if (ua.indexOf("WebKit") > -1)
    {
      var m = null;

      if (jsx.object.isMethod(ua, "match"))
      {
        if (ua.indexOf("Chrome") > -1)
        {
          m = ua.match(/\bChrome\/(\d+\.\d+(\.\d+)?)\b/);

          if (m)
          {
            out += " at least";
          }

          out += " Google V8";

          if (m)
          {
            var
              s = inferVersion(m[1],
                [
                  [ "2.0.172", "0.4"],
                  [ "3.0.195", "1.2"],
                  [ "4.0.249", "1.3"],
                  [ "5.0.375", "2.1"],
                  [ "6.0.472", "2.2"],
                  [ "7.0.517", "2.3.11.22"],
                  [ "8.0.552", "2.4.9.19"],
                  [ "9.0.597", "2.5.9.6"],
                  ["10.0.648", "3.0.12.30"],
                  ["11.0.696", "3.1.8.16"],
                  ["12.0.742", "3.2.10.21"],
                  ["13.0.782", "3.3.10.17"],
                  ["14.0.835", "3.4.14.2"],
                  ["15.0.874", "3.5.10.9"],
                  ["16.0.891", "3.6.4"],
                  ["17.0.963", "3.7.12.29"],
                  ["18.0.1025", "3.8.9.19"],
                  ["19.0.1084", "3.9.24.7"],
                  ["20.0.1132", "3.10.6.0"],
                  ["21.0.1180", "3.11.10.6"],
                  ["22.0.1229", "3.12.19.4"],
                  ["23.0.1271", "3.13.7.1"],
                  ["24.0.1297", "3.14.4.1"],
                  ["25.0.1364", "3.15.11.5"],
                  ["26.0.1410", "3.16.14.9"],
                  ["27.0.1453", "3.17.6.14"],
                  ["28.0.1500", "3.18.5.5"],
                  ["29.0.1530", "3.19.9"]
                ],
                "0.3");

            if (s)
            {
              out += " " + s;
            }
          }
        }
        else
        {
          out += "Apple JavaScriptCore";

          m = ua.match(/\bAppleWebKit\/(\d+\.\d+(\.\d+)*)\b/);

          if (m)
          {
            out += " " + m[1];
          }
        }
      }
    }
    else if (typeof netscape != "undefined" || ua.indexOf("Gecko") > -1)
    {
      m = null;

      if (jsx.object.isNativeMethod(ua, "match"))
      {
        m = ua.match(/\brv:(\d+\.\d+(\.\d+)*)\b/);
      }

      if (m)
      {
        out += " at least";
      }

      out += " Netscape/Mozilla.org JavaScript&#8482";

      if (m)
      {
        s = inferVersion(m[1],
          [
            ["0.6",   "1.5"],
            ["1.8",   "1.6"],
            ["1.8.1", "1.7"],
            ["1.9",   "1.8"],
            ["1.9.1", "1.8.1"],
            ["1.9.2", "1.8.2"]
          ]);

        if (s)
        {
          out += " " + s;
        }
      }
    }

    out += "<\/b><\/p>but I could be wrong.";
  }
}

document.write(out);