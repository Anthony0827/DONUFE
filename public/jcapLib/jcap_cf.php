<?php
/**------------------------------------------------------------------------
 *  AUTOR: Juan Carlos Aleman Paez
 *  email: jcaleman@gmail.com
 *  FECHA ACTUALIZACION: 17/02/2020
 *  VERSION: 2
 *-------------------------------------------------------------------------
 * @package jcapLib
 */
ini_set("memory_limit","128M");
ini_set("upload_max_filesize","64M");
ini_set("post_max_size","96M");
set_time_limit(600);
$jcap_config = array(
	"fechaActual"          => date("Y/m/d"),
	"fechaActualBD"        => date("Y-m-d"),
	"fechaSistema"         => date("d/m/Y"),
	"archivoConfiguracion" => "jcapLib/jcap.conf",
	"cantidadPaginas"      => 8,
	"cantidadRegistros"    => 15,
	"maxUpload"            => "10M",
	"maxUploadBytes"       => 10485760,
	"maxExecutionTime"     => 100
);

global $idusuario;
if ($idusuario=="") {	$idusuario=@$_REQUEST["idusuario"]; }

global $enlace;
global $idusuario;

if ($idusuario=="") { $idusuario=@$_REQUEST["idusuario"]; }
//=======================================================================================================//
/* PARA COLOCAR EL NOMBRE DEL ARCHIVO QUE DE ALGUN ERROR */
//=======================================================================================================//
$nombre_menu_programa = array_key_exists("menu_programa", $_REQUEST) ? $_REQUEST["menu_programa"] : "";
$nombre_menu_programa = str_replace("../","",$nombre_menu_programa);
$nombre_menu_programa = str_replace("/","-",$nombre_menu_programa);
$_SESSION["nombre_menu_programa"] = $nombre_menu_programa;

$flash = array_key_exists("flash", $_GET) ? $_GET["flash"] : "";
$flash = array_key_exists("flash", $_REQUEST) ? $_REQUEST["flash"] : $flash;
$_SESSION['flash'] = html_decode(base64_decode($flash));
//=======================================================================================================//
?>