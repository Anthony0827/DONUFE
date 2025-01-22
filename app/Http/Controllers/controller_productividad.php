<?php
$path ="../app/candidatos/";
$idtest=1;
$ident = json_decode(base64_decode(post("ident")), true);
$var = json_decode(base64_decode(post("param")), true);

if (array_key_exists('idcandidato', $ident)) {
	$idcandidato = $ident['idcandidato'];
}
if (array_key_exists('idusuario', $ident)) {
	$idusuario = $ident['idusuario'];
}
if (array_key_exists('idperfil', $ident)) {
	$idperfil = $ident['idperfil'];
}

$accion= $var["accion"];

if ($accion=="actualizarRegistros") {

	include_once($path.'models/actualizar_datos_candidato.php');

} elseif ($accion=="leidoInstruciones") { 

	include_once($path.'models/datos_candidato_model.php');
	$dcm=new datosCandidato_model();
	$datos=$dcm->leidoInstruciones($idcandidato);

	if ((count($datos) > 0) && $datos["leidoinstruciones"] == 1) {
		$salida = array(
			"estatus" => "listo",	
			"mensaje" => "Registro con exito... "
		);
	} else {
		$salida = array(
			"estatus" => "errorRegistro",	
			"mensaje" => "Ocurrio un problema al actualizar... "
		);		
	}
	echo json_encode($salida);

} else {

	include_once($path.'models/datos_candidato_model.php');

	$dcm=new datosCandidato_model();
	$datos=$dcm->get_datos($idcandidato);
	$mostrar = is_array($datos) && count($datos) > 0;
	$option_rangoedad = generar_options('default','candidatos_rango_edad', 'idrangoedad', 'rangoedad', 'rangoedad');
	//require_once($path.'views/plantilla_datos_candidato.php');
	require_once($path.'views/plantilla_productividad.php');
}
?>