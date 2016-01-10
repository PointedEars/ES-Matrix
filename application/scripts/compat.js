/* Compatibility library, no warnings for: */
/* Object() *//*jshint -W010*/
/* eval()   *//*jshint -W061*/

if (typeof jsx == "undefined")
{
  var jsx = new Object();
}

if (typeof jsx.options == "undefined")
{
  jsx.options = new Object();
}

jsx.options.enableTry = false;

function clearErrorHandler () {
  window.onerror = null;
  return true;
}

window.onerror = clearErrorHandler;
eval("try { jsx.options.enableTry = true; } catch (e) {}");
clearErrorHandler();
