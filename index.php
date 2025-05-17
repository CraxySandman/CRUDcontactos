<?php include "vistas/cabecera.html" ?>
<div class= "layout">
<div>
<?php include_once("menu.php"); ?>
<?php include_once("vistas/aside.html"); ?>
</div>
<main>
<div class="login">
  <form class="login-box" method="post" action="login.php">
    <label>Clave: </label>
    <input type="text" name="clave" required="true" />
    <label>Contrase&ntilde;a: </label>
    <input type="password" name="contrasena" required="true" />
    <input type="submit" value="Enviar" />
  </form>
</div>
  </main>
  </div>
<?php include "vistas/pie.html" ?>
