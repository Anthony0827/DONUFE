<?php
include_once('../../../jcapLib/jcap.php');
//foreach ($_REQUEST as $key => $value) {	echo " $key = ".$value; }
include_once($jcap_config['raiz'].'/app/common/models/limpiar_directorio_archivocv.php');

$directorio = '../../../archivoscv/';
$archivoUpload=$_FILES["archivo_cv"]['name'];
$tamano = $_FILES["archivo_cv"]['size'];
$tipo = $_FILES["archivo_cv"]['type'];

if (!empty($archivoUpload)) {
	if ($tamano>$jcap_config['maxUploadBytes']) {
		$salida = array(
			"estatus" => "error",
			"mensaje" => "Error : el tamaño permitido es ".(($jcap_config['maxUploadBytes']/1024)/1024)." mg y tiene: ".$tamano
		);
	} else {
		$nombre = str_replace(" ", "",$_FILES["archivo_cv"]['name']);
		$nombre = preg_replace('([^A-Za-z0-9.])', '', $nombre);
		$nombre=explode(".",$nombre);
		if (count($nombre)>1) {
			$NombreFinal = date("Ymd-Hi")."-".$nombre[0].".".$nombre[count($nombre)-1];
		} else {
			$NombreFinal = date("Ymd-Hi")."-".$nombre[0];
		}

		if (!copy($_FILES["archivo_cv"]['tmp_name'], $directorio.$NombreFinal)) { 
			$salida = array(
				"estatus" => "error",
				"mensaje" => "Error : al copiar el archivo ".$archivoUpload." de tamaño: ".$tamano,
				"ruta" =>  $directorio.$NombreFinal
			);
		} else { 
			$salida = array(
				"estatus" => "listo",
				"mensaje" => "Archivo subido correctamente !",
				"archivocv" => $NombreFinal,
				"tipo" => $tipo
			);
		}
	}
	echo json_encode($salida);
}
exit();
?>