<?php
/*
Archivo:  Contacto.php
Objetivo: clase que encapsula la información de un contacto
Autor:
*/

include_once("AccesoDatos.php");

class Contacto
{
  private $nId = 0;
  private $sApPaterno = "";
  private $sApMaterno = "";
  private $sNombre = "";
  private $sTelefono = "";
  private $sEmail = "";
  private $sDireccion = "";
  private $nCveUsu = null;
  private $oAD;

  public function getCveUsu() {
    return $this->nCveUsu;
  }

  public function setCveUsu($nValor) {
    $this->nCveUsu = $nValor;
  }

  public function getId() {
    return $this->nId;
  }

  public function setId($nValor) {
    $this->nId = $nValor;
  }

  public function getNombre() {
    return $this->sApPaterno . " " . $this->sApMaterno . " " . $this->sNombre;
  }

  public function getNombreSolo() {
    return $this->sNombre;
  }

  public function getApPaterno() {
    return $this->sApPaterno;
  }

  public function getApMaterno() {
    return $this->sApMaterno;
  }

  public function setApPaterno($sApPaterno) {
    $this->sApPaterno = $sApPaterno;
  }

  public function setApMaterno($sApMaterno) {
    $this->sApMaterno = $sApMaterno;
  }

  public function setNombre($sNombre) {
    $this->sNombre = $sNombre;
  }

  public function getTelefono() {
    return $this->sTelefono;
  }

  public function setTelefono($sTelefono) {
    $this->sTelefono = $sTelefono;
  }

  public function getEmail() {
    return $this->sEmail;
  }

  public function setEmail($sEmail) {
    $this->sEmail = $sEmail;
  }

  public function getDireccion() {
    return $this->sDireccion;
  }

  public function setDireccion($sDireccion) {
    $this->sDireccion = $sDireccion;
  }

  public function buscarTodos($nCveUsu) {
    $oAccesoDatos = new AccesoDatos();
    $sQuery = "";
    $arrRS = null;
    $aLinea = null;
    $oContacto = null;
    $j = 0;
    $arrResultado = [];

    if ($oAccesoDatos->conectar()) {
      $sQuery = "SELECT id_contacto, apPaterno, apMaterno, nombre, numero, direccion, email
                 FROM contactos 
                 WHERE clv_usu = " . $nCveUsu . " 
                 ORDER BY id_contacto";
      $arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
      $oAccesoDatos->desconectar();

      if ($arrRS) {
        foreach ($arrRS as $aLinea) {
          $oContacto = new Contacto();
          $oContacto->setId($aLinea[0]);
          $oContacto->setApPaterno($aLinea[1]);
          $oContacto->setApMaterno($aLinea[2]);
          $oContacto->setNombre($aLinea[3]);
          $oContacto->setTelefono($aLinea[4]);
          $oContacto->setDireccion($aLinea[5]);
          $oContacto->setEmail($aLinea[6]);

          $arrResultado[$j] = $oContacto;
          $j++;
        }
      }
    }
    return $arrResultado;
  }

  public function buscar() {
    $oAccesoDatos = new AccesoDatos();
    $sQuery = "";
    $arrRS = null;
    $bRet = false;

    if ($this->nId == 0)
      throw new Exception("Contacto->buscar(): faltan datos");
    
    if ($oAccesoDatos->conectar()) {
      $sQuery = "SELECT id_contacto, apPaterno, apMaterno, nombre, numero, direccion, email
                 FROM contactos
                 WHERE id_contacto = " . $this->nId;
      $arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
      $oAccesoDatos->desconectar();

      if ($arrRS) {
        $this->nId = $arrRS[0][0];
        $this->sApPaterno = $arrRS[0][1];
        $this->sApMaterno = $arrRS[0][2];
        $this->sNombre = $arrRS[0][3];
        $this->sTelefono = $arrRS[0][4];
        $this->sDireccion = $arrRS[0][5];
        $this->sEmail = $arrRS[0][6];
        $bRet = true;
      }
    }
    return $bRet;
  }

  public function insertar() {
    $oAccesoDatos = new AccesoDatos();
    $sQuery = "";
    $nAfectados = -1;

    if ($this->sNombre == "" || $this->sApPaterno == "" || $this->sApMaterno == "" || $this->sTelefono == "")
      throw new Exception("Contacto->insertar(): faltan datos");

    if ($oAccesoDatos->conectar()) {
      $sQuery = "INSERT INTO contactos (apPaterno, apMaterno, nombre, numero, direccion, email, clv_usu)
                 VALUES ('" . $this->sApPaterno . "', '" . $this->sApMaterno . "', '" . $this->sNombre . "',
                         '" . $this->sTelefono . "', '" . $this->sDireccion . "', '" . $this->sEmail . "', " . $this->nCveUsu . ")";
      $nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
      $oAccesoDatos->desconectar();
    }

    return $nAfectados;
  }

  public function modificar() {
    $oAccesoDatos = new AccesoDatos();
    $sQuery = "";
    $nAfectados = -1;

    if ($this->sNombre == "" || $this->sApPaterno == "" || $this->sApMaterno == "" || $this->sTelefono == "")
      throw new Exception("Contacto->modificar(): faltan datos");

    if ($oAccesoDatos->conectar()) {
      $sQuery = "UPDATE contactos
                 SET apPaterno = '" . $this->sApPaterno . "',
                     apMaterno = '" . $this->sApMaterno . "',
                     nombre = '" . $this->sNombre . "',
                     numero = '" . $this->sTelefono . "',
                     direccion = '" . $this->sDireccion . "',
                     email = '" . $this->sEmail . "'
                 WHERE id_contacto = " . $this->nId;
      $nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
      $oAccesoDatos->desconectar();
    }

    return $nAfectados;
  }

  public function borrar() {
    $oAccesoDatos = new AccesoDatos();
    $sQuery = "";
    $nAfectados = -1;

    if ($this->nId == 0)
      throw new Exception("Contacto->borrar(): faltan datos");

    if ($oAccesoDatos->conectar()) {
      $sQuery = "DELETE FROM contactos WHERE id_contacto = " . $this->nId;
      $nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
      $oAccesoDatos->desconectar();
    }

    return $nAfectados;
  }
}
?>
