<?php
/*
Archivo:  controles.php

Autor:
*/
include_once("modelo\Contacto.php");
session_start();

$sErr=""; $sOpe = ""; $sCve = "";
$oContacto = new Contacto();

	/*Verificar que exista la sesión*/
	if (isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])){
		/*Verifica datos de captura mínimos*/
		if (isset($_POST["txtClave"]) && !empty($_POST["txtClave"]) &&
			isset($_POST["txtOpe"]) && !empty($_POST["txtOpe"])){
			$sOpe = $_POST["txtOpe"];
			$sCve = $_POST["txtClave"];
			$oContacto->setId($sCve);

			if ($sOpe != "b"){
				$oContacto->setCveUsu($_POST["txtClave"]);
				$oContacto->setNombre($_POST["txtNombre"]);
				$oContacto->setApPaterno($_POST["txtApePat"]);
				$oContacto->setApMaterno($_POST["txtApeMat"]);
        $oContacto->setTelefono($_POST["txtNum"]);
        $oContacto->setDireccion($_POST["txtDir"]);
        $oContacto->setEmail($_POST["txtEmail"]);
			}
			try{
				if ($sOpe == 'a')
					$nResultado = $oContacto->insertar();
				else if ($sOpe == 'b')
					$nResultado = $oContacto->borrar();
				else
					$nResultado = $oContacto->modificar();

				if ($nResultado != 1){
					$sError = "Error en bd";
				}
			}catch(Exception $e){
				//Enviar el error específico a la bitácora de php (dentro de php\logs\php_error_log
				error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
				$sErr = "Error en base de datos, comunicarse con el administrador";
			}
		}
		else{
			$sErr = "Faltan datos";
		}
	}
	else
		$sErr = "Falta establecer el login";

	if ($sErr == "")
		header("Location: contactos.php");
	else
		header("Location: error.php?sError=".$sErr);
	exit();
?>