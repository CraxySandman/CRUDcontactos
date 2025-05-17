function evalua(oNombre, oApePat, oApeMat, oNum, oDir, oEmail) {
  var sErr = "";
  var bRet = false;

  if (oNombre.disabled == false && oNombre.value == "")
    sErr = sErr + "\n Falta nombre";

  if (oApePat.disabled == false && oApePat.value == "")
    sErr = sErr + "\n Falta apellido paterno";

  if (oApeMat.disabled == false && oApeMat.value == "")
    sErr = sErr + "\n Falta apellido Materno";

  if (oNum.disabled == false && oNum.value == "")
    sErr = sErr + "\n Falta numero";

  if (oDir.disabled == false && oDir.value == "")
    sErr = sErr + "\n Falta direccion";

  if (oEmail.disabled == false && oEmail.value == "")
    sErr = sErr + "\n Falta email";

  if (sErr == "") bRet = true;
  else alert(sErr);

  return bRet;
}

