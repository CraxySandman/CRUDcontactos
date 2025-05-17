<?php

include_once("modelo/Contacto.php");
session_start();

$sMensaje = "";
$sAccion = "";
$sClave = "";
$sTextoBtn = "Borrar";
$oDatosContacto = new Contacto();
$bEditarCampos = false;
$bEditarClave = false;

/* Verificar sesión activa */
if (isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])) {
  /* Validar datos recibidos */
  if (
    isset($_POST["txtClave"]) && !empty($_POST["txtClave"]) &&
    isset($_POST["txtOpe"]) && !empty($_POST["txtOpe"])
  ) {
    $sAccion = $_POST["txtOpe"];
    $sClave = $_POST["txtClave"];
    if ($sAccion != 'a') {
      $oDatosContacto->setId($sClave);
      try {
        if (!$oDatosContacto->buscar()) {
          $sMensaje = "Contacto no existe";
        }
      } catch (Exception $ex) {
        error_log($ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage(), 0);
        $sMensaje = "Error en base de datos, comunicarse con el administrador";
      }
    }

    if ($sAccion == 'a') {
      $bEditarCampos = true;
      $bEditarClave = true;
      $sTextoBtn = "Agregar";
    } else if ($sAccion == 'm') {
      $bEditarCampos = true; // la clave no se edita
      $sTextoBtn = "Modificar";
    }
    // Si es borrado, se mantiene todo deshabilitado
  } else {
    $sMensaje = "Faltan datos";
  }
} else {
  $sMensaje = "Falta establecer el login";
}

if ($sMensaje == "") {
  include_once("vistas/cabecera.html");
} else {
  header("Location: error.php?sError=" . $sMensaje);
  exit();
}
?>
<div class="layout">
<div>
<?php include_once("menu.php"); ?>
<?php include_once("vistas/aside.html"); ?>
</div>
<main>

  <form name="formContacto" class="formulario-contacto" action="controles.php" method="post">
    <input type="hidden" name="txtOpe" value="<?php echo $sAccion; ?>">
    <input type="hidden" name="txtClave" value="<?php echo $sClave; ?>" />

    <label>Nombre:</label>
    <input type="text" name="txtNombre" <?php echo ($bEditarCampos ? '' : ' disabled '); ?>
      value="<?php echo $oDatosContacto->getNombreSolo(); ?>" />

    <label>Apellido Paterno:</label>
    <input type="text" name="txtApePat" <?php echo ($bEditarCampos ? '' : ' disabled '); ?>
      value="<?php echo $oDatosContacto->getApPaterno(); ?>" />

    <label>Apellido Materno:</label>
    <input type="text" name="txtApeMat" <?php echo ($bEditarCampos ? '' : ' disabled '); ?>
      value="<?php echo $oDatosContacto->getApMaterno(); ?>" />

    <label>Número:</label>
    <input type="text" name="txtNum" <?php echo ($bEditarCampos ? '' : ' disabled '); ?>
      value="<?php echo $oDatosContacto->getTelefono(); ?>" />

    <label>Dirección:</label>
    <input type="text" name="txtDir" <?php echo ($bEditarCampos ? '' : ' disabled '); ?>
      value="<?php echo $oDatosContacto->getDireccion(); ?>" />

    <label>Email:</label>
    <input type="text" name="txtEmail" <?php echo ($bEditarCampos ? '' : ' disabled '); ?>
      value="<?php echo $oDatosContacto->getEmail(); ?>" />

    <div class="form-botones">
      <input type="submit" value="<?php echo $sTextoBtn; ?>"
        onClick="return evalua(txtNombre, txtApePat, txtApeMat, txtNum, txtDir, txtEmail);" />

      <input type="submit" name="Submit" value="Cancelar" onClick="formContacto.action='contactos.php';">
    </div>
  </form>
</main>
</div>
