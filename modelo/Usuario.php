<?php
/*
Archivo:  Usuario.php
Objetivo: clase que encapsula la información de un usuario
Autor:
*/

include_once("AccesoDatos.php");

class Usuario
{
  private $nClave = 0;
  private $sPwd = "";
  private $sTipoUsuario = "";
  private $sNombre = "";
  private $oAD;

  public function getTipoUsuario()
  {
    return $this->sTipoUsuario;
  }
  public function setTipoUsuario($valor)
  {
    $this->sTipoUsuario = $valor;
  }
  public function getClave()
  {
    return $this->nClave;
  }
  public function setClave($valor)
  {
    $this->nClave = $valor;
  }

  public function getPwd()
  {
    return $this->sPwd;
  }
  public function setPwd($valor)
  {
    $this->sPwd = $valor;
  }

  public function getNombre()
  {
    return $this->sNombre;
  }

  public function setNombre($valor)
  {
    $this->sNombre = $valor;
  }

  public function buscarCvePwd()
  {
    $bRet = false;
    $sQuery = "";
    $arrRS = null;
    if (($this->nClave == 0 || $this->sPwd == ""))
      throw new Exception("Usuario->buscar: faltan datos");
    else {
      $sQuery = "SELECT clave_usuario , apPaterno, apMaterno, nombre , contrasena , tipo_usuario
					   FROM usuarios
					   WHERE clave_usuario = " . $this->nClave . "
					   AND contrasena = '" . $this->sPwd . "'";
      //Crear, conectar, ejecutar, desconectar
      $oAD = new AccesoDatos();
      if ($oAD->conectar()) {
        $arrRS = $oAD->ejecutarConsulta($sQuery);
        $oAD->desconectar();
        if ($arrRS != null) {
          $this->setClave($arrRS[0][0]);
          $this->setNombre($arrRS[0][1] ." ". $arrRS[0][2] ." ". $arrRS[0][3]);
          $this->setPwd($arrRS[0][4]);
          if ($arrRS[0][5] == 1) {
            $this->setTipoUsuario("admin");
          } else {
            $this->setTipoUsuario("visualizador");
          }
          $bRet = true;
        }
      }
    }
    return $bRet;
  }
}
?>