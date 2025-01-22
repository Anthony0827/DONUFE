<?php
date_default_timezone_set('Europe/Madrid');
require_once('PHPMailer-5.2/class.phpmailer.php');
require_once 'PHPMailer-5.2/class.smtp.php';


/**
 * Diseño de las cabeceras para los correos
 */
$_cabeceras = <<<cabecera
MIME-Version: 1.0
Content-Transfer-Encoding: 8Bit
Content-Type: text/html; charset="utf-8"
Reply-to: {$jcap_config['emailFrom']}
From: {$jcap_config['organismo']} <{$jcap_config['emailFrom']}>
Errors-To: {$jcap_config['emailFrom']}\r\n
cabecera;

/**
 * Diseño del mensaje al pie para los correos
 */
$_pie = <<<pie
<br><br><br>
Esta es una cuenta de correo no supervisada, por favor no escriba a esta
direcci&oacute;n. Para cualquier comentario o consulta escr&iacute;banos a "{$jcap_config['emailInfo']}"
pie;

function asunto_mail($asunto) {
	return '=?UTF-8?Q?' . quoted_printable_encode($asunto) . '?=';
}

function enviar_correo($tipo,$datos_correo) {
	global $jcap_config, $_cabeceras, $_pie;
	
	$path = dirname(dirname(__FILE__))."/app/templates/";
	$plantilla_correo="";

	if (gettype($datos_correo) == "array") {

		$nombreEmpresa = $datos_correo['nombreEmpresa'] ? $datos_correo['nombreEmpresa'] : '';
		$nombre = $datos_correo['nombre'];
		$correo = $datos_correo['email'];
		$datos_correo["organismo"]=$jcap_config["organismo"];
		$datos_correo["urlSite"]=$jcap_config["urlSite"];
		$datos_correo["emailInfo"]=$jcap_config["emailInfo"];
		$urlApp="";
		$urlAppSi="";
		$urlAppNo="";

		switch ($tipo) {
			case "activacionRegistroCandidato":
				$asunto = asunto_mail("Activar mi cuenta candidato {$jcap_config['organismo']}");
				$query = base64_encode("accion=ActivarCandidato&k=" . $datos_correo['tokenActivacion']);
				$urlApp = "{$jcap_config['urlSite']}/activarcandidato/$query";
				$plantilla_correo=$path."activacion_candidato.html";
			break;
			case "ActivacionEmpresa":
				$asunto = asunto_mail("Activar mi cuenta {$jcap_config['organismo']}");
				$query = base64_encode("accion=ActivarEmpresa&k=" . $datos_correo['tokenActivacion']);
				$urlApp = "{$jcap_config['urlSite']}/activarempresa/$query";
				$plantilla_correo=$path."activacion_empresa.html";
			break;			
			case "confirmacioRegistroEmpresa":
				$asunto = asunto_mail("Notificación Registro Perfil Empresa");
				$plantilla_correo=$path."confirmacio_registro_empresa.html";			
			break;
			case "password":
				$asunto = asunto_mail("Acceso a su cuenta {$jcap_config['organismo']}");
				$urlApp = "{$jcap_config['urlSite']}";
				$plantilla_correo=$path."activacion_password.html";
			break;
			case "invitacionCandidato":
				$asunto = asunto_mail("Invitacion al proceso de evaluacion {$jcap_config['organismo']}");
				$query = base64_encode("accion=activarInvitacion&k=" . $datos_correo['tokenActivacion']);
				$urlApp = "{$jcap_config['urlSite']}/activarInvitacion/$query";
				$plantilla_correo=$path."invitacion_candidato.html";
			break;
			case "invitacionCandidatoPDI":
				$asunto = asunto_mail("Invitacion al PDI {$jcap_config['organismo']}");
				$query = base64_encode("accion=activarInvitacion&k=" . $datos_correo['tokenActivacion']);
				$urlAppPDI = "{$jcap_config['urlSitePDI']}/activarInvitacionPDI/$query";
				$plantilla_correo=$path."invitacion_candidato_pdi.html";
			break;			
			case "validacion":
				$cuerpo  = "<p><strong>Verifique su cuenta {$jcap_config['organismo']}</strong></p>\r\n";
				$cuerpo .= "<p>Usted se ha registrado con esta direcci&oacute;n de correo en nuestro\r\n";
				$cuerpo .= " sistema, para finalizar el proceso de\r\n";
				$cuerpo .= " registro haga clic <a href=\"$urlApp\">aqu&iacute;</a>.</p>\r\n";
				$cuerpo .= "<p>Si su gestor de correo no le permite hacer clic en el enlace, copie\r\n";
				$cuerpo .= " y pegue la direccion mostrada a continuaci&oacute;n en una nueva ventana de\r\n";
				$cuerpo .= " su navegador.</p><p>$urlApp</p>";
			break;
			case "alertaRegistroEmpresa":
				$correo = $jcap_config["emailInfo"];
				$asunto = asunto_mail("Notificación Registro Empresa:".$nombreEmpresa);
				$query = base64_encode("accion=ActivarEmpresa&k=" . $datos_correo['tokenActivacion']);
				$urlApp = "{$jcap_config['urlSite']}/activarempresa/$query";
				$plantilla_correo=$path."alerta_registro_empresa.html";
			break;
			case "solicitudAutorizacionCandidato":
				$asunto = asunto_mail("Una empresa quiere saber más de ti");
				$querySi = base64_encode("accion=autorizarSolicitud&k=" . $datos_correo['tokenActivacion']);
				$urlAppSi = "{$jcap_config['urlSite']}/autorizarSolicitud/$querySi";
				$queryNo = base64_encode("accion=denegarSolicitud&k=" . $datos_correo['tokenActivacion']);
				$urlAppNo = "{$jcap_config['urlSite']}/denegarSolicitud/$queryNo";
				$plantilla_correo=$path."solicitud_autorizacion_candidato.html";		
			break;
			case "recuperarContrasena":
				$asunto = asunto_mail("Recuperar contraseña Kulture");
				$query = $datos_correo['token'];
				$urlApp = "{$jcap_config['urlSite']}/recuperarcontrasena/$query";
				$plantilla_correo=$path."recuperar_contrasena.html";
			break;
			case "ParaEntrevista":
				$asunto = asunto_mail("ENTREVISTA: Ya tenemos fecha");
				$querySi = base64_encode("accion=confirmarEntrevista&k=".$datos_correo['tokenActivacion']);
				$urlAppSi = "{$jcap_config['urlSite']}/confirmarEntrevista/$querySi";
				$queryNo = base64_encode("accion=desaprobarEntrevista&k=".$datos_correo['tokenActivacion']);
				$urlAppNo = "{$jcap_config['urlSite']}/desaprobarEntrevista/$queryNo";
				$plantilla_correo=$path."notificacion_entrevista.html";
			break;
			case "Descartado":
				$asunto = asunto_mail("Información Candidatura- ".$datos_correo['puesto']);
				$plantilla_correo=$path."notificacion_descartado.html";
			break;
			case "AprobadoEntrevista":
				$correo = $jcap_config["emailInfo"];
				$asunto = asunto_mail("Notificación de Aprobado en Entrevista");
				$plantilla_correo=$path."alerta_aprobadoentrevista.html";
			break;
			case "DescartadoEntrevista":
				$asunto = asunto_mail("Información Candidatura- ".$datos_correo['puesto']);
				$plantilla_correo=$path."notificacion_descartado.html";
			break;			
	    }
		if ($urlApp!=""){
			$datos_correo["urlApp"]=$urlApp;
		}
		if ($urlAppPDI!=""){
			$datos_correo["urlAppPDI"]=$urlAppPDI;
		}
		if ($urlAppSi!=""){
			$datos_correo["urlAppSi"]=$urlAppSi;
		}
		if ($urlAppNo!=""){
			$datos_correo["urlAppNo"]=$urlAppNo;
		}
	    
	    if ($plantilla_correo!="") {
			$cuerpo = getTemplateEmail($plantilla_correo,$datos_correo);    	
	    }
	    //escribirtxt("../_log_sucesos/send_emails.txt", json_encode($datos_correo));
		return enviar_correo_PHPMailer("$correo",$asunto,$cuerpo);
	}
}

function getTemplateEmail($plantilla, $datos_correo){
	$template = file_get_contents($plantilla);
	/*Quitar Saltos de linea*/
	$template = strtr($template, array("\r"=>"","\n"=>""));

	/*Quitar espacios en blanco dobles*/
	$template = preg_replace("/\s+/"," ",$template);

	/*Quitar espacios entre caracteres ><*/
	$template = str_replace("> <", "><", $template);

	/*Remplazo de variables*/
	if (gettype($datos_correo) == "array") {
		$translation = array (	
			"{organismo}" => $datos_correo["organismo"],
			"{emailInfo}" => $datos_correo["emailInfo"], 
			"{urlSite}" => $datos_correo["urlSite"], 
			"{urlSitePDI}" => $datos_correo["urlSitePDI"], 
			"{urlApp}" => $datos_correo["urlApp"], 
			"{urlAppPDI}" => $datos_correo["urlAppPDI"], 
			"{urlAppSi}" => $datos_correo["urlAppSi"], 
			"{urlAppNo}" => $datos_correo["urlAppNo"], 
			"{nombreEmpresa}" => $datos_correo["nombreEmpresa"], 
			"{direccion}" => $datos_correo["direccion"], 
			"{nombre}" => $datos_correo["nombre"], 
			"{email}" => $datos_correo["email"], 
			"{clave}" => $datos_correo['clave'],
			"{tokenActivacion}" => $datos_correo["tokenActivacion"], 
			"{mensaje}" => $datos_correo["mensaje"],
			"{cif}" => $datos_correo["cif"],
			"{username}" => $datos_correo["username"],
			"{tlfempresa}" => $datos_correo["tlfempresa"],
			"{telefono}" => $datos_correo["telefono"],
			"{cantidadempleados}" => $datos_correo["cantidadempleados"],
			"{fecharegistro}" => $datos_correo["fecharegistro"],
			"{provincia}" => $datos_correo["provincia"],
			"{localidad}" => $datos_correo["localidad"],
			"{tipoEmpresa}" => $datos_correo["tipoEmpresa"],
			"{sector}" => $datos_correo["sector"],
			"{educacion}" => $datos_correo["educacion"],
			"{perfil}" => $datos_correo["perfil"],
			"{puesto}" => $datos_correo["puesto"],
			"{jornada}" => $datos_correo["jornada"],
			"{disponibilidad}" => $datos_correo["disponibilidad"],
			"{salario}" => $datos_correo["salario"],
			"{experiencia}" => $datos_correo["experiencia"],
			"{situacionlaboral}" => $datos_correo["situacionlaboral"],
			"{fechaentrevista}" => $datos_correo["fechaentrevista"],
			"{horaentrevista}" => $datos_correo["horaentrevista"],
		);
		$template = strtr($template, $translation);
	}
	$template = textconvertHtml($template);

	return $template;
}

function textconvertHtml($cadena) {
	$trad = array("á"=>"&aacute;", "Á" =>"&Aacute;", "é"=>"&eacute;", "É"=>"&Eacute;", "í"=>"&iacute;", "Í"=>"&Iacute;", "ó"=>"&oacute;", "Ó"=>"&Oacute;", "ú"=>"&uacute;", "Ú"=>"&Uacute;", "ñ"=>"&ntilde;", "Ñ"=>"&Ntilde;", "&quot;"=>'"', "&acute;"=>'´', "&apos;"=>"'", "Â"=>"");
	$trans_html = strtr($cadena, $trad) ;
	return $trans_html;
}

function enviar_correo_PHPMailer($destinatario,$subject,$message){
	global $jcap_config;
	$SPLangDir    = "phpmailer/language/";
	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	//Tell PHPMailer to use SMTP
	$mail->isSMTP(); //or $mail-> isSendMail();
	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 0;
	$mail->Timeout=60;
	$mail->Helo = $jcap_config["dominio"]; //Muy importante para que llegue a hotmail y otros
	//Set the hostname of the mail server
	$mail->Host = 'gnld1031.siteground.eu';
	//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	//$mail->Port = 25;
	//$mail->Port = 465;
	$mail->Port = 587;
	//Set the encryption system to use - ssl (deprecated) or tls
	$mail->SMTPSecure = 'tls';
	//$mail->SMTPSecure = 'ssl';
	//Whether to use SMTP authentication
	$mail->SMTPAuth = true;
	//Username to use for SMTP authentication - use full email address for gmail
	$mail->Username = $jcap_config["emailFrom"];
	//Password to use for SMTP authentication
	$mail->Password = $jcap_config["passEmailFrom"];
	//Set who the message is to be sent from
	$mail->setFrom($jcap_config["emailFrom"], $jcap_config["organismo"]);
	//Set an alternative reply-to address
	//$mail->addReplyTo($jcap_config["emailFrom"],$jcap_config["dominio"]);
	//Set who the message is to be sent to
	$mail->addAddress($destinatario);
	//Set the subject line
	$mail->Subject = $subject;
	//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
	$mail->Body = $message;
	$mail->IsHTML(true);
	//send the message, check for errors
	if (!$mail->send()) {
	    return "Error: " . $mail->ErrorInfo;
	    escribirtxt("../_log_sucesos/error_send_emails.txt", $mail->ErrorInfo."\n");
	} else {
	    return "Sent";
	}
}
?>