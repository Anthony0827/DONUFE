<?php

$idprog = rqst("idprog", 0);
$idusuario = rqst("idusuario", 0);
$idtipousuario = rqst("idtipousuario", 0);
$loginusuario = rqst("loginusuario");
$nombreusuario = rqst("nombreusuario");
$idorganismo = rqst("idorganismo", 0);
$nombreorganismo = rqst("nombreorganismo");
$idperfilusuario = rqst("idperfilusuario", 0);
$menu_programa_selec = rqst("menu_programa_selec", 0);
$menu_programa = rqst("menu_programa", 0);


$anoppto = rqst("anoppto", 0);
$idmoneda = rqst("idmoneda", 0);
$nombremoneda = rqst("nombremoneda");
$decimales = rqst("decimales", 0);
$menu_ticket = rqst("menu_ticket");
$velocidad = rqst("velocidad");

$boton_agregar = rqst("boton_agregar");
$boton_modificar = rqst("boton_modificar");
$boton_eliminar = rqst("boton_eliminar");
//===================================
// Validacion del ticket del usuario.
//===================================
/*if (!validarticket($menu_ticket)) {
	echo '<script language="javascript" type="text/javascript">window.parent.document.location.href = "../index.php?men=La sesion ha caducado."; </script>';
	exit();
}*/

?>
<input type="hidden" name="idusuario"            id="idusuario"            value="<?php echo $idusuario; ?>">
<input type="hidden" name="idtipousuario"        id="idtipousuario"        value="<?php echo $idtipousuario; ?>" >
<input type="hidden" name="loginusuario"         id="loginusuario"         value="<?php echo $loginusuario; ?>">
<input type="hidden" name="nombreusuario"        id="nombreusuario"        value="<?php echo $nombreusuario; ?>">
<input type="hidden" name="idorganismo"          id="idorganismo"          value="<?php echo $idorganismo; ?>">
<input type="hidden" name="nombreorganismo"      id="nombreorganismo"      value="<?php echo $nombreorganismo; ?>">
<input type="hidden" name="idperfilusuario"      id="idperfilusuario"      value="<?php echo $idperfilusuario; ?>">
<input type="hidden" name="anoppto"              id="anoppto"              value="<?php echo $anoppto; ?>">
<input type="hidden" name="idusuarioanulacion"   id="idusuarioanulacion"   value="<?php echo $idusuario; ?>">
<input type="hidden" name="boton_agregar"        id="boton_agregar"        value="<?php echo $boton_agregar; ?>">
<input type="hidden" name="boton_modificar"      id="boton_modificar"      value="<?php echo $boton_modificar; ?>">
<input type="hidden" name="boton_eliminar"       id="boton_eliminar"       value="<?php echo $boton_eliminar; ?>">
<input type="hidden" name="idmoneda"             id="idmoneda"             value="<?php echo $idmoneda ?>">
<input type="hidden" name="nombremoneda"         id="nombremoneda"         value="<?php echo $nombremoneda ?>">
<input type="hidden" name="decimales"            id="decimales"            value="<?php echo $decimales ?>">
<input type="hidden" name="menu_ticket"          id="menu_ticket"          value="<?php echo $menu_ticket ?>">
<input type="hidden" name="idprogramaselec"      id="idprogramaselec"      value="<?php echo $menu_programa_selec ?>">
<input type="hidden" name="nombre_menu_programa" id="nombre_menu_programa" value="<?php echo $menu_programa ?>">
