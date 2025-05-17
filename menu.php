
<aside>
  <ul>

    

    <?php
    if (isset($_SESSION["usuario"])) {

      echo '<li><a href="inicio.php">Inicio</a></li>';

      echo '<li><a href="contactos.php">Contactos</a></li>';

      echo '<li><a href="logout.php">Cerrar Sesion</a></li>';

      
    }else{
      echo '<li><a href="index.php">Inicio</a></li>';
    }
    ?>
  </ul>
  </aside>

