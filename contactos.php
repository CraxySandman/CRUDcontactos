<?php

include_once("modelo/Usuario.php");
include_once("modelo/Contacto.php");
session_start();
$sErr = "";
$sNom = "";
$oUsu = null;

$arrContactos = null;
$oCon = new Contacto();

/*Verificar que exista sesión*/
if (isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])) {
  $oUsu = $_SESSION["usuario"];
  $scve = $oUsu->getClave();
  $sNom = $oUsu->getNombre();
  try {
    $arrContactos = $oCon->buscarTodos($scve);
  } catch (Exception $e) {
    //Enviar el error específico a la bitácora de php (dentro de php\logs\php_error_log
    error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
    $sErr = "Error en base de datos, comunicarse con el administrador";
  }
} else
  $sErr = "Falta establecer el login";

if ($sErr == "") {
  include_once("vistas/cabecera.html");
} else {
  header("Location: error.php?sError=" . $sErr);
  exit();
}
?>
<div class="layout">
  <div>
  <?php include_once("menu.php"); ?>
  <?php include_once("vistas/aside.html"); ?>
  </div>
  <!--</div>-->
<div class="table-container">
<main>
    <h3>Contactos</h3>
    <form name="formTablaGral" method="post" action="crud.php">
      <input type="hidden" name="txtClave">
      <input type="hidden" name="txtOpe">

        <table border="1">
          <thead>
          <tr>
            <td>Clave</td>
            <td>Nombre</td>
            <td>Numero</td>
            <td>Direccion</td>
            <td>email</td>
            <?php if ($_SESSION["tipo"] == "admin"): ?>
            <td>Operaci&oacute;n</td>
            <?php endif; ?>
          </tr>
          </thead>
          <tbody>
          <?php
          if ($arrContactos != null) {
            foreach ($arrContactos as $oContacto) {
              ?>
              <tr>
                <td class="llave"><?php echo $oContacto->getId(); ?></td>
                <td><?php echo $oContacto->getNombre(); ?></td>
                <td><?php echo $oContacto->getTelefono(); ?></td>
                <td><?php echo $oContacto->getDireccion(); ?></td>
                <td><?php echo $oContacto->getEmail(); ?></td>


                <?php if ($_SESSION["tipo"] == "admin"): ?>
                  <td>
                    <input type="submit" name="Submit" value="Modificar"
                      onClick="txtClave.value=<?php echo $oContacto->getId(); ?>; txtOpe.value='m'">
                    <!-- #region <input type="submit" name="Submit" value="Borrar"
                  onClick="txtClave.value=<?php echo $oContacto->getId(); ?>; txtOpe.value='b'"> -->
                    <button type="button" onclick="popup( '¿Seguro que quiere eliminar este contacto?',
                'Nombre: <?php echo $oContacto->getNombre(); ?>',
                'Telefono: <?php echo $oContacto->getTelefono(); ?>',
                'Direccion: <?php echo $oContacto->getDireccion(); ?>',
                'Email: <?php echo $oContacto->getEmail(); ?>', 'controles.php',
                <?php echo $oContacto->getId(); ?>)">
                      Borrar
                    </button>
                  </td>
                <?php endif; ?>

              </tr>
              <?php
            }//foreach
          } else {
            ?>
            <tr>
              <td colspan="2">No hay datos</td>
            </tr>
            <?php
          }
          ?>
          </tbody>
        </table>
      
      <?php if ($_SESSION["tipo"] == "admin"): ?>
      <input type="submit" name="Submit" value="Crear Nuevo" onClick="txtClave.value='<?php echo $scve ?>';txtOpe.value='a'">
      <?php endif; ?>
    </form>
  </main>
  <script src="js/popup.js"></script>
   </div>
</div>
