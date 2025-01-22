<?php
$idtest=1;
$path ="../app/candidatos/";
$ident = json_decode(base64_decode(post("ident")), true);
$var = json_decode(base64_decode(post("param")), true);

$accion= $var["accion"];

if (array_key_exists('idempresa', $var)) {
	$idempresa = $var['idempresa'];
}

if (array_key_exists('idcandidato', $ident)) {
	$idcandidato = $ident['idcandidato'];
}
if (array_key_exists('idusuario', $ident)) {
	$idusuario = $ident['idusuario'];
}
if (array_key_exists('idperfil', $ident)) {
	$idperfil = $ident['idperfil'];
} else {
	$idperfil= $var["idperfil"];
}

$nombreEmpresa='';
$valor='';
$valorEmp='';
$color='';
$colorEmp='';

include_once($path.'models/compatibilidad_model.php');
include_once('../app/common/models/common_data_models.php');
$datos=new resultados_test();

$compromisoCandidato=$datos->get_result_test_compromiso($idcandidato);
$mostrarCompromisoCandidato = is_array($compromisoCandidato) && count($compromisoCandidato) > 0;

if ($mostrarCompromisoCandidato){
	if (($compromisoCandidato[0]["rdo"]>=0) && ($compromisoCandidato[0]["rdo"]<=4)){
		$valor='BAJO'; $color='#ff0000';
	} elseif (($compromisoCandidato[0]["rdo"]>=5) && ($compromisoCandidato[0]["rdo"]<=7)){
		$valor='MEDIO'; $color='#ffed00';
	} elseif (($compromisoCandidato[0]["rdo"]>=8) && ($compromisoCandidato[0]["rdo"]<=10)){
		$valor='ALTO'; $color='#25eb02';
	}
}
$descripcionCompromiso=$datos->get_descripcion_compromiso($valor);
$descripcionCompromiso= base64_encode(htmlconvert($descripcionCompromiso[0]["texto"])) ;

//$compromisoEmpresa=$datos->get_empresa_compromiso($idempresa);
//$mostrarCompromisoEmpresa = is_array($compromisoEmpresa) && count($compromisoEmpresa) > 0;
$mostrarCompromisoEmpresa = false;

if ($mostrarCompromisoEmpresa){
	if (($compromisoEmpresa[0]["rdo"]>=0) && ($compromisoEmpresa[0]["rdo"]<=4)){
		$valorEmp='BAJO'; $colorEmp='#ff0000';
	} elseif (($compromisoEmpresa[0]["rdo"]>=5) && ($compromisoEmpresa[0]["rdo"]<=7)){
		$valorEmp='MEDIO'; $colorEmp='#ffed00';
	} elseif (($compromisoEmpresa[0]["rdo"]>=8) && ($compromisoEmpresa[0]["rdo"]<=10)){
		$valorEmp='ALTO'; $colorEmp='#25eb02';
	}
}

$result_test=$datos->get_result_test($idcandidato,$idempresa);
$mostrar = is_array($result_test) && count($result_test) > 0;

require_once($path.'views/plantilla_perfil_candidato.php');
?>