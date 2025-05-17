<?php

include_once("modelo/Usuario.php");
session_start();
$sErr="";
$sCve="";
$sNom="";
$sPwd="";
$oUsu = new Usuario();
	/*Verificar que hayan llegado los datos*/
	if (isset($_POST["clave"]) && !empty($_POST["clave"]) &&
		isset($_POST["contrasena"]) && !empty($_POST["contrasena"])){
		$sCve = $_POST["clave"];
		$sPwd = $_POST["contrasena"];
		$oUsu->setClave($sCve);
		$oUsu->setPwd($sPwd);
		try{
			if ( $oUsu->buscarCvePwd() ){
				$_SESSION["usuario"] = $oUsu;
        $_SESSION["tipo"] = $oUsu->getTipoUsuario();
			}
			else{
				$sErr = "Usuario desconocido";
			}
		}catch(Exception $e){
			error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
			$sErr = "Error al acceder a la base de datos";
		}
	}
	else
		$sErr = "Faltan datos";
	//Enviar encabezado sin formato HTTP
	if ($sErr == "")
		header("Location: inicio.php");
	else
		header("Location: error.php?sError=".$sErr);
?>
