/* NOTE: No array or loop here for backwards compatibility */
es_matrix.out = "";

if (es_matrix.engineInfo.isInferred())
{
  es_matrix.out = " cannot be detected directly.";

  if (es_matrix.implementation && es_matrix.implVersion)
  {
    es_matrix.out += " Inference suggests it is<p><b>";

    if (es_matrix.engineInfo.isMinVersion())
    {
      es_matrix.out += "at least ";
    }

    es_matrix.out += es_matrix.implementation
      + " " + es_matrix.implVersion
      + "<\/b><\/p>but I could be wrong.";
  }
}
else
{
  es_matrix.out += ":<p><b>" + es_matrix.engineInfo.toString() + "<\/b><\/p>";
}

document.write(es_matrix.out);