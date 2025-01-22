<?php

/******************************************************************************/
/*                         Configuracion del Sistema                          */
/******************************************************************************/
include_once('jcap_cf.php');
$jcap_config['raiz'] = dirname(dirname(__FILE__));
$conf = "{$jcap_config['raiz']}/{$jcap_config['archivoConfiguracion']}";
if (file_exists($conf)) {
	include_once $conf;
	if (!empty($vregistro)) {
		$jcap_config = array_merge($jcap_config, $vregistro[0]);
	}
}
/******************************************************************************/
/*                  Libreria de conexion a la base de datos                   */
/******************************************************************************/
include_once($jcap_config['raiz']. '/jcapLib/jcapbd.php');

/******************************************************************************/
/*               Funciones de comprobacion en la base de datos                */
/******************************************************************************/
function CompruebaExiste($StrSQL){
	$conn = ConexionBD::crear('default');
	$rsdatos = $conn->ejecutar($StrSQL);
	if ($rsdatos->getCantRegistros() > 0): $Retorno = 1; else: $Retorno = 0; endif;
	return $Retorno;
}

function Comprobar($nTabla,$nCampo,$nValor){
	if (is_numeric($nValor)):
		$StrSQL= "Select $nCampo From $nTabla where $nCampo = $nValor";
	else:
		$StrSQL= "Select $nCampo From $nTabla where $nCampo = '$nValor'";
	endif;
	$conn = ConexionBD::crear('default');
	$res = $conn->ejecutar($StrSQL);
	if ($res->getCantRegistros() > 0): $Retorno = 1; else: $Retorno = 0; endif;
	$conn->desconectar();
	return $Retorno;
}

function checkExistsTable($db, $table) {
	$conn = ConexionBD::crear($db);
	$res = $conn->ejecutar("SELECT Table_Name FROM information_schema.TABLES WHERE Table_Name='$table' AND TABLE_SCHEMA='$db'");
	if ($res->getCantRegistros() > 0) { return true; } else { return false; }
}

function intcheck($db, $table, $field, $findvalue) {
	$conn = ConexionBD::crear($db);
	$res = $conn->ejecutar("select $field from $table where $field = '$findvalue'");
	if ($res->getCantRegistros() > 0) { return true; } else { return false; }
}

function BuscaDatoUsuario($idusuario, $nCampo) {
	$sql="Select * from jcap_usuarios where idusuario = $idusuario";
	$conn = ConexionBD::crear('default');
	$res = $conn->ejecutar($sql);
	$rsdatos = $res->proximo();
	if (!empty($rsdatos)): $valor = $rsdatos[$nCampo]; else: $valor = ""; endif;
	$conn->desconectar();
	return $valor;
}

/******************************************************************************/
/*                     Nueva clase de paginacion de jcap                       */
/******************************************************************************/
class Paginacion {
	public $paginaActual;
	public $intervaloActual;
	private $_registros;
	private static $configCantPaginas;
	public static $configCantRegistros;
	private $_sufijo;

	public function __construct($cantidad_registros = 0, $sufijo_funcion = "", $pag_actual = null, $intervalo = null) {
		$this->_registros = $cantidad_registros;
		$this->_sufijo = $sufijo_funcion;
		if (null === $pag_actual) {
			$key = "paginaActual{$sufijo_funcion}";
			$this->paginaActual = array_key_exists($key, $_REQUEST) ? $_REQUEST[$key] : 1;
		} else {
			$this->paginaActual = $pag_actual;
		}
		if (null === $intervalo) {
			$key = "intervaloActual{$sufijo_funcion}";
			$this->intervaloActual = array_key_exists($key, $_REQUEST) ? $_REQUEST[$key] : 1;
		} else {
			$this->intervaloActual = $intervalo;
		}
	}

	public function __get($name) {
		switch ($name) {
			case 'offset': return $this->getOffset();
			case 'cantPaginas': return self::$configCantPaginas;
			case 'cantRegistros': return self::$configCantRegistros;
		}
	}

	public function getOffset() {
		return ($this->paginaActual - 1) * self::$configCantRegistros;
	}

	public function crearPaginacion() {
		$sufijo_funcion      = $this->_sufijo;
		$cantidad_paginas    = ceil($this->_registros / self::$configCantRegistros);
		$cantidad_intervalos = ceil($cantidad_paginas / self::$configCantPaginas);

		if ($this->intervaloActual <= 1) {
			$valor_inicial = 1;
		} else {
			$valor_inicial = (self::$configCantPaginas * ($this->intervaloActual - 1)) + 1;
		}

		$valor_final = $valor_inicial + self::$configCantPaginas;

		$offset = intval($this->getOffset());

		$desde = $offset + 1;
		$hasta = $offset + intval(self::$configCantRegistros);

		if ($hasta > $this->_registros) $hasta = intval($this->_registros);

		$desde         = min($desde, $hasta);
		$pag_siguiente =  intval($this->paginaActual) + 1 ;
		$pag_anterior  =  $pag_siguiente - 2;
		$paginacion    = '<ul class="pagination pagination-sm">';
		$paginacion    .= "<li><span><b>" . $desde . " al ".$hasta . "</b> de " . number_format( $this->_registros, 0, ",", "." ) . "</span></li>";

		if ($this->paginaActual > 1) {
			$paginacion .= '<li><a title="Ir a la primera p&aacute;gina" href="javascript:buscar_pagina'.$sufijo_funcion.'(1,1)"><span class="glyphicon glyphicon-step-backward"></span>&nbsp;</a></li>';
			$paginacion .= '<li><a title="P&aacute;gina anterior" href="javascript:buscar_registro'.$sufijo_funcion.'(' . $pag_anterior . ');">&laquo;</a></li>';
		}
		$anterior = $this->intervaloActual - 1;
		$registro_anterior = $valor_inicial - 1;
		if ($anterior != 0)
			$paginacion .= '<li><a href="javascript:buscar_pagina'.$sufijo_funcion.'('. $anterior .', '. $registro_anterior .')">...</a></li>';

		for ($i = $valor_inicial; $i < $valor_final; $i++) {
			if ($i <= $cantidad_paginas) {
				if ($i == $this->paginaActual)  {
					$paginacion .= '<li class="active"><span>' . $i . ' <span class="sr-only">(current)</span></span></li>';
				} else {
					$paginacion .= '<li><a href="javascript:buscar_registro'.$sufijo_funcion.'('. $i .')">'.$i.'</a></li>';
				}
			}
		}

		$siguiente = $this->intervaloActual + 1;
		$registro_proximo = $valor_final;
		if ($this->intervaloActual < $cantidad_intervalos)
			$paginacion .= '<li><a href="javascript:buscar_pagina'.$sufijo_funcion.'('. $siguiente .', '. $registro_proximo .')">...</a></li>';

		if ($this->paginaActual < $cantidad_paginas) {
			$paginacion .= '<li><a title="P&aacute;gina siguiente" href="javascript:buscar_registro' . $sufijo_funcion . '(' . $pag_siguiente . ');">&raquo;</a></li>';
			$paginacion .= '<li><a title="Ir a la &uacute;ltima p&aacute;gina" href="javascript:buscar_pagina'.$sufijo_funcion.'('. $cantidad_intervalos .', '. $cantidad_paginas .')">&nbsp;<span class="glyphicon glyphicon-step-forward"></span></a></li>';
		}
		$paginacion .= '</ul>';
		return $paginacion;
	}

	public function crearObjetos($funcion = "") {
		$sufijo_funcion = $this->_sufijo;
		$text = '<input type="hidden" name="paginaActual'.$sufijo_funcion.'" id="paginaActual'.$sufijo_funcion.'" value="1">';
		$text .= '<input type="hidden" name="intervaloActual'.$sufijo_funcion.'" id="intervaloActual'.$sufijo_funcion.'" value="1">';
		$text .= '<script type="text/javascript">';
		$text .= "function buscar_pagina{$sufijo_funcion}(intervaloActual, registro_inicial) {
						document.getElementById(\"paginaActual{$sufijo_funcion}\").value = registro_inicial;
						document.getElementById(\"intervaloActual{$sufijo_funcion}\").value = intervaloActual;
						{$funcion}
					}

				function reestablecer{$sufijo_funcion}() {
					document.getElementById(\"paginaActual{$sufijo_funcion}\").value = 1;
					document.getElementById(\"intervaloActual{$sufijo_funcion}\").value = 1;
				}

				function buscar_registro{$sufijo_funcion}(valor) {
					if(valor == '') { return; }
					document.getElementById(\"paginaActual{$sufijo_funcion}\").value = valor;
					{$funcion}
				}";
		$text .= "</script>";
		echo $text;
	}

    public static function init() {
        global $jcap_config;

        // Verificar si $jcap_config está definido y no es null
        if (isset($jcap_config) && is_array($jcap_config)) {
            self::$configCantPaginas   = $jcap_config['cantidadPaginas'] ?? 0;
            self::$configCantRegistros = $jcap_config['cantidadRegistros'] ?? 0;
        } else {
            // Manejar el caso en que $jcap_config no esté definido o sea null
            self::$configCantPaginas   = 0;
            self::$configCantRegistros = 0;
            error_log("Error: \$jcap_config no está definido o es null.");
        }
    }
}
Paginacion::init();

/******************************************************************************/
/*                       Validación de Tickets y Sesión                       */
/******************************************************************************/
function realizarValidacionTicket() {
	$temp = rqst("menu_ticket");
	if ($temp != "") {
		$ticket_valido = validarticket($temp);
		if (!$ticket_valido && false === strpos(__FILE__, "server.php")) {
			echo '<script type="text/javascript">location.href = "../index.php?men=La sesion ha caducado.";</script>';
			exit();
		}
	}
}

function crearticket($usuario, $ip) {
	$id_ticket = session_id();
	$conn = ConexionBD::crear('seguridad');
	$SQL="DELETE FROM jcap_usuario_ticket WHERE idusuario='$usuario';";
	$conn->ejecutar($SQL);
	$SQL = "INSERT INTO jcap_usuario_ticket (idusuario,numeroticket,fechaacceso,ip) VALUES ('$usuario', '$id_ticket', NOW(), '$ip');";
	$conn->ejecutar($SQL);
	$conn->desconectar();
	return $id_ticket;
}

function validarticket($id_ticket) {
	$conn = ConexionBD::crear('seguridad');
	$sql = "SELECT numeroticket from jcap_usuario_ticket where numeroticket = '$id_ticket'";
	$rs = $conn->ejecutar($sql);
	if ($rs->getCantRegistros() > 0) {
		$sql = "UPDATE jcap_usuario_ticket set fechaacceso = NOW() where numeroticket = '$id_ticket'";
		$conn->ejecutar($sql);
		return true;
	}
	return false;
}

function existe_ticket_usuario($id_usuario) {
	$sql="SELECT numeroticket from jcap_usuario_ticket  where idusuario = '$id_usuario'";
	$conn = ConexionBD::crear('seguridad');
	$rs = $conn->ejecutar($sql);
	if ($rs->getCantRegistros() > 0) {
		return true;
	}
	return false;
}

function existe_ticket($id_ticket) {
	$sql="SELECT numeroticket from jcap_usuario_ticket  where numeroticket = '$id_ticket'";
	$conn = ConexionBD::crear('seguridad');
	$rs = $conn->ejecutar($sql);
	if ($rs->getCantRegistros() > 0) {
		return true;
	}
	return false;
}

function CerrarSesion($id_ticket) {
	$sql="DELETE FROM jcap_usuario_ticket WHERE numeroticket = '$id_ticket'";
	$conn = ConexionBD::crear('seguridad');
	$rs = $conn->ejecutar($sql);
}


/******************************************************************************/
/*                              Peticiones HTTP                               */
/******************************************************************************/
function rqst($variable, $retorno = null) {
	if (array_key_exists($variable, $_REQUEST)) { 
		$valor = $_REQUEST[$variable];
		if (is_numeric($valor) && $valor == 0)
			return $valor;
		elseif (!empty($valor))
			return $valor;
		else
			return $retorno;
	} else { 
		return $retorno;
	}
}

function post($variable, $retorno = null) {
	if (array_key_exists($variable, $_POST)) { 
		$valor = $_POST[$variable];
		if (is_numeric($valor) && $valor == 0)
			return $valor;
		elseif (!empty($valor))
			return $valor;
		else
			return $retorno;
	} else {
		return $retorno;
	}
}

function get($variable, $retorno = null) {
	if (array_key_exists($variable, $_GET)) {
		$valor = $_GET[$variable];
		if (is_numeric($valor) && $valor == 0)
			return $valor;
		elseif (!empty($valor))
			return $valor;
		else
			return $retorno;
	} else {
		return $retorno;
	}
}

function valida_variable($variable, $valor) {
	$valor = trim($valor);
	if (empty($valor)){
		$array_retorno=array("c_$variable" =>$variable.",","v_$variable" =>"null ,","m_$variable" =>" $variable=null , ");
	} else {
		$array_retorno=array("c_$variable" => $variable.", ", "v_$variable" => "\'$valor\', ", "m_$variable" => " $variable=\'$valor\' , ");
	}
	return $array_retorno;
}

/******************************************************************************/
/*                              Manejo del Grid                               */
/******************************************************************************/
	
$nombres_grid = rqst("nombres_grid");
if ($nombres_grid!="") {
	$mn = explode(",", $nombres_grid);
	
	$allgrids = array();
	for ($x = 0; $x < count($mn); $x++){ 	

		$smlineagrid = rqst($mn[$x]."_smlineagrid",0);
		$smcolumnagrid = rqst($mn[$x]."_smcolumnagrid",0);
		$smcamposgrid = rqst($mn[$x]."_smcamposgrid");

		$smcampos=explode(",",$smcamposgrid);
		$matgrid1=array();
		$matgrid=array();
		
		for ($i = 1; $i <= $smlineagrid; $i++)
		{ 	for ($j = 1; $j <= $smcolumnagrid; $j++)
				{  
					if (empty($_REQUEST[$mn[$x]."_smf".$i."_c".$j])) { 
						$var=""; 
					} 
					else { 
						$var=$_REQUEST[$mn[$x]."_smf".$i."_c".$j]; 
					}
					$matgrid1[$i][$smcampos[$j-1]]=$var;
					
				}
		}
		$cont=1;
		
		for ($i=1;$i<=count($matgrid1);$i++)
		{ 	$sw=0;
			for ($j = 1; $j <= $smcolumnagrid; $j++)
				{   
					if (trim($matgrid1[$i][$smcampos[$j-1]])!="")
						{ $sw=1; }
				}
			if ($sw==1)
			{	
				for ($j = 1; $j <= $smcolumnagrid; $j++)
					{   
						$matgrid[$cont][$smcampos[$j-1]]=$matgrid1[$i][$smcampos[$j-1]];
					}
				$cont=$cont+1;
			}
		}
		$allgrids[$mn[$x]] = $matgrid; 

	}
}



/******************************************************************************/
/*                          Manejo de Secuenciadores                          */
/******************************************************************************/
function BuscaNumeroSecuenciador($nBaseData, $nTabla, $nCampo, $where="") {
	$StrSQL= "SELECT $nCampo From $nTabla $where ORDER BY $nCampo DESC LIMIT 1";
	$conn = ConexionBD::crear($nBaseData);
	$res = $conn->ejecutar($StrSQL);
	$rsdatos = $res->proximo();
	if ($res->getCantRegistros() > 0): $valor = $rsdatos[$nCampo] + 1; else: $valor = 1; endif;
	return $valor;
}

function BuscaNumeroSecuenciador_x_Organismo($nBaseData,$nTabla, $nCampo, $organismo){
	$valor = BuscaNumeroSecuenciador($nBaseData, $nTabla, $nCampo, "where idorganismo=$organismo");
	return $valor;
}

function SecuenciadorMesAnoUsuario($nBaseData,$nTabla,$nCampo,$nWhere) {
	$valor = BuscaNumeroSecuenciador($nBaseData, $nTabla, $nCampo, $nWhere);
	return $valor;
}

function Secuenciador($nom, $ano, $tab, $cam, $let, $tam, $sep="") {
	$sql  ="SELECT valor FROM secuenciadores WHERE nombre= '$nom' AND anopresupuesto=$ano";
	$conn = ConexionBD::crear('default');
	$res  = $conn->ejecutar($sql);
	$rs   = $res->proximo();
	if ($res->getCantRegistros() > 0) { $numero = $rs["valor"] + 1; $sw1=true; } else { $numero = 1;  $sw1=false; }
	if (strlen($tab)>0) {
		$codigo = formcodigo($numero, $ano, $tab, $cam, $let, $tam, $sep );
	} else {
		$codigo = sprintf("%s%s%0{$tam}d", $let, $ano, $numero);
	}
	if ($sw1==true)
		$sql = "UPDATE secuenciadores SET valor =$numero WHERE nombre='$nom'  AND anopresupuesto=$ano";
	else
		$sql= "INSERT INTO secuenciadores (nombre, valor, anopresupuesto) VALUES('$nom', $numero, $ano)";
	$conn->ejecutar($sql);
	return $codigo;
}

function formcodigo($numero, $ano, $tab, $cam, $let, $tam, $sep="" ) {
	$sw2=true;
	$conn = ConexionBD::crear('default');
	while($sw2) {
		if ($ano > 0) {
			$ano = substr($ano, -2);
			$codi = sprintf("%s%02d%s%0{$tam}d", $let, $ano, $sep, $numero);
		} else {
			$codi =sprintf("%s%s%0{$tam}d", $let, $sep, $numero);
		}
		$strsql= "SELECT $cam FROM $tab WHERE $cam='$codi' ORDER BY $cam DESC LIMIT 1";
		$res  = $conn->ejecutar($strsql);
		if ($res->getCantRegistros() > 0) { $numero = $numero+ 1; } else { $sw2=false; break; }
	}
	$conn->desconectar();
	return $codi;
}

function BuscaNumeroSecuenciadorEstado($idEstado) {
	$conn = ConexionBD::crear('default');
	$rs = $conn->ejecutar("SELECT tx_estado FROM zn_estados WHERE id_estado = $idEstado")->proximo();
	$nombre = "UNIDADES_DE_".strtoupper($rs['tx_estado']);
	$letras = substr(strtoupper($rs['tx_estado']),0,3);
	return Secuenciador($nombre, 0, "centro_asistencial", "num_centro", $letras, 3, "-");
}


function Secuenciador_x_Organismo($org, $nom, $ano, $tab, $cam, $let, $tam , $concatena_ano="") {
	$aux_ano = $ano;
	if ($concatena_ano == "N") { $aux_ano=""; }
	$sql="SELECT valor FROM secuenciadores WHERE nombre= '$nom' AND anopresupuesto = $ano AND idorganismo = $org";
	$conn = ConexionBD::crear('default');
	$dat  = $conn->ejecutar($sql);
	$rs   = $dat->proximo();
	if ($dat->getCantRegistros() > 0) { $numero = $rs["valor"] + 1; $sw1=true; } else { $numero = "1";  $sw1=false; }
	if (strlen($tab)>0) {
		$codigo = formcodigo_x_organismo($org,$numero, $nom, $aux_ano, $tab, $cam, $let, $tam );
	} else {
		$codigo = sprintf("%s%s%0{$tam}d", $let, $aux_ano, $numero);
	}
	return $codigo;
}

function formcodigo_x_organismo($organismo, $numero, $nom, $ano, $tab, $cam, $let, $tam ){
	$sw2 = true;
	$aux_ano = $ano;
	$conn = ConexionBD::crear('default');
	while($sw2=true) {
		if ($ano>0) { $ano = substr ($ano, -2); }
		$codi = sprintf("%s%02d%0{$tam}d", $let, $ano, $numero);
		$strsql= "SELECT $cam FROM $tab WHERE $cam = '$codi' AND idorganismo = $organismo ORDER BY $cam DESC LIMIT 1";
		$res = $conn->ejecutar($strsql);
		if ($res->getCantRegistros() > 0) { $numero = $numero+ 1; } else { $sw2=false; break; }
		$res->limpiar();
	}

	$sql="SELECT valor FROM secuenciadores WHERE nombre= '$nom' AND anopresupuesto=$aux_ano AND idorganismo=$organismo";
	$res = $conn->ejecutar($sql);
	if ($res->getCantRegistros() > 0) {
		$sql = "UPDATE secuenciadores SET valor=$numero WHERE nombre='$nom' AND anopresupuesto=$aux_ano AND idorganismo=$organismo";
	} else {
		$sql = "INSERT INTO secuenciadores (nombre, valor, anopresupuesto,idorganismo) VALUES('$nom',$numero ,$aux_ano ,$organismo )";
	}
	$conn->ejecutar($sql);

	return $codi;
}

function Secuenciador_ano_mes_numero_where($org, $nom, $ano, $mes, $dia, $tab, $cam, $let, $tam, $sep="", $where="" ) {
	$sql="SELECT valor FROM secuenciadores WHERE nombre= '$nom' AND anopresupuesto=$ano";
	$conn = ConexionBD::crear('default');
	$dat  = $conn->ejecutar($sql);
	$rs   = $dat->proximo();
	if ($dat->getCantRegistros() > 0) { $numero = $rs["valor"] + 1; $sw1=true; } else { $numero = "1";  $sw1=false; }
	if (strlen($tab)>0) {
		$codigo = formcodigo_ano_mes_numero_where($org, $numero, $nom, $ano, $mes, $dia, $tab, $cam, $let, $tam, $sep, $where );
	} else {
		$codigo = $let . $ano . $sep . $mes . $sep . $dia . substr("0000000000".$numero, -$tam);
	}
	return $codigo;
}

function formcodigo_ano_mes_numero_where($organismo, $numero, $nom, $ano,  $mes, $dia, $tab, $cam, $let, $tam, $sep="", $where="") {
	$sw2=true;
	$aux_ano=$ano;
	if (trim($where) != "") { $where = " and " . $where; }
	$conn = ConexionBD::crear('default');
	while($sw2=true) {
		$codi = $let . $ano . $sep . $mes . $sep . $dia . substr("0000000000".$numero, -$tam);
		$strsql = "SELECT $cam FROM $tab WHERE $cam='$codi' $where ORDER BY $cam DESC LIMIT 1";
		$rs = $conn->ejecutar($strsql);
		if ($rs->getCantRegistros() > 0) { $numero = $numero+ 1; } else { $sw2=false; break; }
		$rs->limpiar();
	}
	$sql = "SELECT valor FROM secuenciadores WHERE nombre= '$nom' AND anopresupuesto=$aux_ano";
	$rs = $conn->ejecutar($sql);
	if ($rs->getCantRegistros() > 0) {
		$sql = "UPDATE secuenciadores SET valor =$numero WHERE nombre='$nom' AND anopresupuesto=$aux_ano";
	} else {
		$sql = "INSERT INTO secuenciadores(nombre, valor, anopresupuesto) VALUES('$nom',$numero ,$aux_ano )";
	}
	$conn->ejecutar($sql);
	return $codi;
}

/******************************************************************************/
/*                    Funciones de información de ejecución                   */
/******************************************************************************/
function dinfo($variable, $descripcion = "_debug") {
	if (g_debug == true)
		echo $descripcion . " => " . $variable . "<br>";
}

function busca_variable($organismoch, $campo) {
	$sql = "SELECT id, cd.idorganismo, c.campo, cd.valor, c.idsistema, c.parametro, c.descripcion
			FROM public.jcap_configuracion c
			INNER JOIN public.jcap_configuracion_detalle cd ON(c.id = cd.idconfiguracion)
			WHERE cd.idorganismo = '$organismoch' AND c.campo='$campo'";
	$conn = ConexionBD::crear('default');
	$dat  = $conn->ejecutar($sql);
	$rs   = $dat->proximo();
	if ($rs!="") {
		$valor = $rs["valor"];
		return $valor;
	}
}

function escribirtxt($donde, $que, $param="w") {
	$tx_archivo = fopen($donde , $param);
	if ($tx_archivo) {
		fputs ($tx_archivo, $que);
	}
	fclose ($tx_archivo);
}


function escribirTrazabilidad($tipo, $descripcion, $origen, $parametros, $respuesta){
	$fecha = date('Y-m-d H:i:s');
	$ip = $_SERVER['REMOTE_ADDR'];
	$sql = "INSERT INTO trazabilidad (tipo, descripcion, origen, parametros, respuesta, fecha, ip) VALUES ('$tipo', '$descripcion', '$origen', '".str_replace("'","\'", $parametros)."', '".str_replace("'","\'", $respuesta)."','$fecha', '$ip')";
	$conn = ConexionBD::crear('default');
	$conn->ejecutar($sql);
}

/******************************************************************************/
/*                             Manejo de fechas                               */
/******************************************************************************/
class IntervaloFechas {
	const PATRON = "/^P((\d+)Y)?((\d+)M)?((\d+)D)?(T((\d+)H)?((\d+)M)?((\d+)S)?)?$/";

	/* Propiedades accesibles a través de los metodos magicos __get() y __set()
	public $y;
	public $m;
	public $d;
	public $h;
	public $i;
	public $s;
	public $negativo;
	*/
	public $dias;
	private $_props;
	private $_fuente;

	public function __construct($intervalo = null) {
		$this->_props = array(
			"y" => array("valor" => 0),
			"m" => array("valor" => 0),
			"d" => array("valor" => 0),
			"h" => array("valor" => 0, "min" => 0, "max" => 23),
			"i" => array("valor" => 0, "min" => 0, "max" => 59),
			"s" => array("valor" => 0, "min" => 0, "max" => 59),
			"negativo" => array("valor" => 0, "min" => 0, "max" => 1)
		);
		$this->dias = false;
		if (!empty($intervalo)) {
			$matches = null;
			$res = preg_match(self::PATRON, $intervalo, $matches);
			if ($res === 0) {
				throw new Exception("Error: El valor \"$intervalo\" no tiene el formato correcto para construir un objeto tipo intervalo", 21);
			} else {
				$this->_props["y"]["valor"] = empty($matches[2]) ? 0 : $matches[2];
				$this->_props["m"]["valor"] = array_key_exists(4, $matches) ? $matches[4] : 0;
				$this->_props["d"]["valor"] = array_key_exists(6, $matches) ? $matches[6] : 0;
				$this->_props["h"]["valor"] = array_key_exists(9, $matches) ? $matches[9] : 0;
				$this->_props["i"]["valor"] = array_key_exists(11, $matches) ? $matches[11] : 0;
				$this->_props["s"]["valor"] = array_key_exists(13, $matches) ? $matches[13] : 0;
				foreach ($this->_props as $key => $value) {
					if (!is_numeric($value["valor"])) $this->_props[$key]["valor"] = 0;
				}
				$this->normalizar();
			}
		}
		$this->_fuente = $intervalo;
	}

	private function normalizar() {
		$t = $this->s + $this->i * 60 + $this->h * 3600;
		$da = intval($t / 86400);
		$t = $t % 86400;
		/* dias*/
		$this->d += $da;

		if (is_numeric($this->dias))
			$this->dias += $da;
		/* Intervalor en segundos */
		$this->_props["h"]["valor"] = intval($t / 3600);
		$t = $t % 3600;
		$this->_props["i"]["valor"] = intval($t / 60);
		$this->_props["s"]["valor"] = $t % 60;
	}

	public function __get($name) {
		$p = array_keys($this->_props);
		$e = array_search($name, $p, true);
		if ($e === false) {
			throw new Exception("Error: No existe la propiedad \"$name\" en la clase IntervaloFechas", 22);
		} else {
			return $this->_props[$name]["valor"];
		}
	}

	public function __set($name, $value) {
		$p = array_keys($this->_props);
		$e = array_search($name, $p, true);
		if ($e === false) {
			throw new Exception("Error: No existe la propiedad \"$name\" en la clase IntervaloFechas", 22);
		} else {
			$value = empty($value) ? 0 : $value;
			if (!is_numeric($value)) {
				throw new Exception("Error: \"$value\" no es un valore numérico válido", 23);
				return;
			} elseif ($value < 0) {
				throw new Exception("Error: La propiedad \"$name\" no acepta valores negativos ($value)", 23);
				return;
			}
			$this->_props[$name]["valor"] = $value;
			$e = array_search($name, array("h", "i", "s", "negativo"), true);
			if ($e !== false) {
				if ($value <= $this->_props[$name]["min"] || $value >= $this->_props[$name]["max"]) {
					if ($name === "negativo") {
						$this->_props[$name]["valor"] = $value % 2;
					} else {
						$this->normalizar();
					}
				}
			}
		}
	}

	public function __isset($name) {
		return isset($this->_props[$name]);
	}

	public function __unset($name) {
		$this->_props[$name]["valor"] = 0;
	}

	public function format($patron) {
		$busqueda = array("%Y", "%y", "%M", "%m", "%D", "%d", "%a", "%H", "%h", "%I", "%i", "%S", "%s", "%R", "%r", "%%");
		$reemplazo = array(
			sprintf("%02d", $this->y), $this->y,
			sprintf("%02d", $this->m), $this->m,
			sprintf("%02d", $this->d), $this->d,
			$this->dias,
			sprintf("%02d", $this->h), $this->h,
			sprintf("%02d", $this->i), $this->i,
			sprintf("%02d", $this->s), $this->s,
			$this->negativo == 0 ? "+" : "-",
			$this->negativo == 0 ? "" : "-",
			"%"
		);
		$resultado = str_replace($busqueda, $reemplazo, $patron);
		return $resultado;
	}
}

class FechaHora {
	/* Constantes de Formato */
	const FECHA_SQL     = "Y-m-d";
	const FECHAHORA_SQL = "Y-m-d H:i:s";
	const HORA_24       = "H:i";
	const HORA_24_SEG   = "H:i:s";
	const HORA_12       = "h:i a";
	const HORA_12_SEG   = "h:i:s a";
	const FECHA         = "d/m/Y";
	const FECHAHORA     = "d/m/Y h:i a";
	const FECHAHORA_SEG = "d/m/Y h:i:s a";
	/* Formatos especiales, no utilizables en la función date */
	const FECHALARGA    = "%s, %d de %s de %d";
	const FECHAMES      = "%d de %s de %d";
	const DIA_SEMANA    = "dia_semana";
	const DIAFECHA      = "diafecha";
	/* Arreglos constantes para formatos de fecha larga */
	private static $DIAS        = array("Domingo","Lunes", "Martes", "Miércoles","Jueves", "Viernes", "Sábado");
	private static $DIAS_CORTO  = array("Dom","Lun", "Mar", "Miér","Jue", "Vie", "Sáb");
	private static $MESES       = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	private static $MESES_CORTO = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sept", "Oct", "Nov", "Dic");

	private static $PATRONES = array(
		'fechahora_seg' => '#^(0?[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/(\d{4})\s+(0?[1-9]|1[0-2]):([0-5][0-9]):([0-5][0-9])\s(am|pm)$#i',
		'fechahora_sql' => '#^(\d{4})\-(0[1-9]|1[0-2])\-(0?[1-9]|[12][0-9]|3[01])\s+([0-1]?[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])(\.\d{1,6})?$#',
		'fechahora' => '#^(0?[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/(\d{4})\s+(0?[1-9]|1[0-2]):([0-5][0-9])\s(am|pm)$#i',
		'fecha' => '#^(0?[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/(\d{4})$#',
		'fecha_sql' => '#^(\d{4})\-(0[1-9]|1[0-2])\-(0?[1-9]|[12][0-9]|3[01])$#',
		'hora_12_seg' => '#^(0?[1-9]|1[0-2]):([0-5][0-9]):([0-5][0-9])\s(am|pm)$#i',
		'hora_24_seg' => '#^([^0-1]?[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$#',
		'hora_12' => '#^(0?[1-9]|1[0-2]):([0-5][0-9])\s(am|pm)$#i',
		'hora_24' => '#^([0-1]?[0-9]|2[0-3]):([0-5][0-9])$#'
	);

	private $_timestamp;
	private $_fuente;

	public function __construct($fechahora = "now") {
		if ($fechahora === "now") {
			$this->_timestamp = time();
		} elseif (is_numeric($fechahora)) {
			$t = intval($fechahora);
			$this->_timestamp = $t;
		} elseif ($fechahora == "" || NULL === $fechahora) {
			$this->_timestamp = NULL;
		} else {
			$t = $this->detectarPatron($fechahora);
			if (false === $t) {
				throw new Exception("Error en formato de la fecha $fechahora; no corresponde con ninguno de los formatos soportados", 20);
			} else {
				$this->_timestamp = $t;
			}
		}
		$this->_fuente = $fechahora;
	}

	private function detectarPatron($fechahora) {
		$patron = null;
		foreach (self::$PATRONES as $key => $value) {
			$matches = null;
			$res = preg_match($value, $fechahora, $matches);
			if ($res >= 1) {
				$patron = $key;
				break;
			}
		}
		$fuente = null;
		$dia = 0; $mes = 0; $ano = 0; $hor = 0;	$min = 0; $seg = 0;
		$t = null;
		switch ($patron) {
			case 'fecha':         list($fuente, $dia, $mes, $ano) = $matches; break;
			case 'fechahora':     list($fuente, $dia, $mes, $ano, $hor, $min, $t) = $matches; break;
			case 'fechahora_seg': list($fuente, $dia, $mes, $ano, $hor, $min, $seg, $t) = $matches; break;
			case 'fecha_sql':     list($fuente, $ano, $mes, $dia) = $matches; break;
			case 'fechahora_sql': list($fuente, $ano, $mes, $dia, $hor, $min, $seg) = $matches; break;
			case 'hora_24':       list($fuente, $hor, $min) = $matches; break;
			case 'hora_24_seg':   list($fuente, $hor, $min, $seg) = $matches; break;
			case 'hora_12':       list($fuente, $hor, $min, $t) = $matches; break;
			case 'hora_12_seg':   list($fuente, $hor, $min, $seg, $t) = $matches; break;
			default: return false;
		}
		if (null !== $t) {
			if (strtolower($t) == "pm" && $hor < 12)
				$hor = $hor + 12;
			elseif (strtolower($t) == "am" && $hor == 12)
				$hor = 0;
		}
		return mktime($hor, $min, $seg, $mes, $dia, $ano);
	}

	private static function aplicarFormato($formato, $tiempo) {
		$formato = empty($formato) ? self::FECHAHORA : $formato;
		if ($formato === self::FECHALARGA) {
			$datos = date("w,j,n,Y", $tiempo);
			list($nDS, $nDia, $nMes, $nAno) = explode(",", $datos);
			$salida = sprintf($formato, self::$DIAS[$nDS], $nDia, self::$MESES[$nMes - 1], $nAno);
		} elseif ($formato === self::FECHAMES) {
			$datos = date("j,n,Y", $tiempo);
			list($nDia, $nMes, $nAno) = explode(",", $datos);
			$salida = sprintf($formato, $nDia, self::$MESES[$nMes - 1], $nAno);
		} elseif ($formato === self::DIA_SEMANA) {
			$datos = date("w", $tiempo);
			$salida = self::$DIAS[$datos];
		} elseif ($formato === self::DIAFECHA) {
			$datos = date("w", $tiempo);
			$salida = sprintf("%s, %s", self::$DIAS[$datos], date(self::FECHA, $tiempo));
		} else {
			$salida = date($formato, $tiempo);
		}
		return $salida;
	}

	public static function crear($fechahora) {
		return empty($fechahora) ? null : new FechaHora($fechahora);
	}

	public static function fechaSistema($formato = null) {
		$tiempo = time();
		return self::aplicarFormato($formato, $tiempo);
	}

	public static function horaSistema() {
		return "Hora: " . date(self::HORA_12);
	}

	public static function getArregloFechas($desde, $hasta) {
		if (!is_a($desde, 'FechaHora')){
			try { $desde = new FechaHora($desde); }
			catch(Exception $e) { return false; }
		}

		if (!is_a($hasta, 'FechaHora')){
			try { $hasta = new FechaHora($hasta); }
			catch(Exception $e) { return false; }
		}

		$salida[] = $desde->format(self::FECHA);
		$inicio = $desde->_timestamp;
		while ($inicio < $hasta->_timestamp) {
			$inicio += 86400;
			$salida[] = date(self::FECHA, $inicio);
		}
		return $salida;
	}

	public static function getUltimoDiaMes($mes, $ano) {
		$fecha = sprintf("01/%02d/%04d", $mes, $ano);
		$fecha = new FechaHora($fecha);
		return date("t", $fecha->_timestamp);
	}

	public static function getMes($mes) {
		return self::$MESES[$mes - 1];
	}


	public function hora24() {
		return (NULL === $this->_timestamp ? "" : date(self::HORA_24, $this->_timestamp));
	}

	public function hora12() {
		return (NULL === $this->_timestamp ? "" : date(self::HORA_12, $this->_timestamp));
	}

	public function format($formato = null) {
		return (NULL === $this->_timestamp ? "" : self::aplicarFormato($formato, $this->_timestamp));
	}

	public function diferencia(FechaHora $fechaMayor) {
		if (empty($fechaMayor) || NULL === $this->_timestamp)
			return false;
		/* Calculo la diferencia en tiempo */
		$h1 = date(self::HORA_24_SEG, $this->_timestamp);
		$h2 = date(self::HORA_24_SEG, $fechaMayor->_timestamp);
		$p = explode(":", $h1);
		$t1 = $p[2] + $p[1] * 60 + $p[0] * 3600;
		$p = explode(":", $h2);
		$t2 = $p[2] + $p[1] * 60 + $p[0] * 3600;
		$dif_t = $t2 - $t1;
		/* Calculo la diferencia en días */
		$dias_i = intval($this->_timestamp / 86400);
		$dias_f = intval($fechaMayor->_timestamp / 86400);
		$dif_f = $dias_f - $dias_i;
		$dias = abs($dif_f);
		if ($dif_t < 0 && $dias > 0) { /* Ajusto la cant. dias dependiendo de si la diferencia en tiempo fue negativa */
			$dias--;
			$dif_t += 86400;
		}
		/* Hago el recorrido por las fechas para hacer calculo exacto de años y meses en el intervalo */
		$inicio = min($dias_i, $dias_f) * 86400;
		$fin = max($dias_i, $dias_f) * 86400;
		$pd = date("j", $inicio);
		$pm = date("n", $inicio);
		$y = 0; $m = 0; $d = 0;
		for ($i=0; $i < $dias; $i++) {
			$d++;
			$inicio += 86400;
			$j = date("j", $inicio);
			$n = date("n", $inicio);
			if ($pd == $j) {
				$d = 0;
				if ($pm == $n) {
					$y++;
					$m = 0;
				} else {
					$m++;
				}
			} else {
				$ud = date("t", $inicio);
				if($j == $ud && $pd > $ud) {
					$d = 0;
					if ($pm == $n) {
						$y++;
						$m = 0;
					} else {
						$m++;
					}
				}
			}
		}

		$obj = new IntervaloFechas("P{$y}Y{$m}M{$d}DT{$dif_t}S");
		$obj->dias = $dias;
		if ($dif_f < 0 || ($dias == 0 && $dif_t < 0)) $obj->negativo = 1;
		return $obj;
	}

	public function sumar(IntervaloFechas $intervalo) {
		if (NULL === $this->_timestamp) return false;
		if ($intervalo->negativo == 1)
			return $this->restar($intervalo);
		$datos = date("Y,n,j,G,i,s", $this->_timestamp);
		list($y, $m, $d, $h, $i, $s) = explode(",", $datos);
		$t = mktime($h + $intervalo->h, $i + $intervalo->i, $s + $intervalo->s, $m + $intervalo->m, $d + $intervalo->d, $y + $intervalo->y);
		$this->_timestamp = $t;
		return $this;
	}

	public function restar(IntervaloFechas $intervalo) {
		if (NULL === $this->_timestamp) return false;
		if ($intervalo->negativo == 1)
			return $this->sumar($intervalo);
		$datos = date("Y,n,j,G,i,s", $this->_timestamp);
		list($y, $m, $d, $h, $i, $s) = explode(",", $datos);
		$t = mktime($h - $intervalo->h, $i - $intervalo->i, $s - $intervalo->s, $m - $intervalo->m, $d - $intervalo->d, $y - $intervalo->y);
		$this->_timestamp = $t;
		return $this;
	}

	public function intervaloSemana() {
		if (NULL === $this->_timestamp) return false;
		$numdia = date("w", $this->_timestamp);
		$inicio = new FechaHora($this->_timestamp);
		if ($numdia > 0) {
			$inicio->restar(new IntervaloFechas("P{$numdia}D"));
		}
		$fin = new FechaHora($this->_timestamp);
		if ($numdia < 6) {
			$numdia = 6 - $numdia;
			$fin->sumar(new IntervaloFechas("P{$numdia}D"));
		}
		return array("i" => $inicio, "f" => $fin);
	}

	public function __get($name) {
		if ($name === "formatoSQLE") {
			return (NULL === $this->_timestamp ? "NULL" : ("'" . self::aplicarFormato(self::FECHA_SQL, $this->_timestamp) . "'"));
		} elseif ($name === "formatoSQLHoraE") {
			return (NULL === $this->_timestamp ? "NULL" : ("'" . self::aplicarFormato(self::FECHAHORA_SQL, $this->_timestamp) . "'"));
		} elseif (NULL === $this->_timestamp) {
			return "";
		}
		switch ($name) {
			case 'timestamp': return $this->_timestamp;
			case 'formatoSQL': return self::aplicarFormato(self::FECHA_SQL, $this->_timestamp);
			case 'formatoSQLHora': return self::aplicarFormato(self::FECHAHORA_SQL, $this->_timestamp);
			case 'normal': return self::aplicarFormato(self::FECHA, $this->_timestamp);
			case 'normalHora': return self::aplicarFormato(self::FECHAHORA, $this->_timestamp);
			case 'dia': return self::aplicarFormato('j', $this->_timestamp);
			case 'mes': return self::aplicarFormato('n', $this->_timestamp);
			case 'ano': return self::aplicarFormato('Y', $this->_timestamp);
		}
	}
}

function formatea_hora_agenda($hora) {
	$a = explode(".", $hora);
	if(intval(@$a[1]) > 0) {
		$tm = number_format( intval($hora), 0 ) . ":30";
	} else {
		$tm = number_format( intval($hora), 0 ) . ":00";
	}
	$e = explode(":", $tm);
	if(intval($e[0]) >= 12) {
		$t = $e[0] - 12;
		if($t == 0) { $t = 12; }
		$tm = $t . ":" . $e[1] . " pm";
	} else {
		$t = $e[0];
		if($t == 0) { $t = 12; }
		$tm = $t . ":" . $e[1] . " am";
	}
	return $tm;
}

function formatea_hora_agenda24($hora) {
	$a = explode(".", $hora);
	if(intval(@$a[1]) > 0) {
		$tm = number_format( intval($hora), 0 ) . ":30";
	} else {
		$tm = number_format( intval($hora), 0 ) . ":00";
	}
	$e = explode(":", $tm);
	if(intval($e[0]) >= 12) {
		$t = $e[0];
		if($t == 0) { $t = 12; }
		$tm = $t . ":" . $e[1] . ":00";
	} else {
		$t = $e[0];
		if($t == 0) { $t = "00"; } elseif($t <= 9) { $t = "0" . $t; }
		$tm = $t . ":" . $e[1] . ":00";
	}
	return $tm;
}

function combo_mes($id_combo, $seleccion="", $teventos="") {
	$mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	echo "<select name='".$id_combo."' id='".$id_combo."' class='form-control' style='border:1px solid #CCCCCC;' ".$teventos.">";
	echo "<option value=''>Seleccione</option>";
	for ($i=1; $i<=12; $i++) {
		if ($seleccion==$i) { $sel = " selected "; } else { $sel = ""; }
		$nro_mes = substr("0".$i,-2);
		echo "<option value='".$i."' ".$sel.">".$nro_mes." - ".$mes[$i]."</option>";
	}
	echo "</select>";
}

function retornaAntiguedad($fecha_ingreso){
	if($fecha_ingreso == ""){
		return "0";
	}else if(count(split("/",$fecha_ingreso)) < 3){
		return "0";
	}else{
		$ano = 0;
		$fecha_in = explode("/",$fecha_ingreso);
		if($fecha_in[0] == ""){
			$ano = 0;
		}else if($fecha_in[1] == ""){
			$ano = 0;
		}else if($fecha_in[2] == ""){
			$ano = 0;
		}else{
			$dia_in = $fecha_in[0];
			$mes_in = $fecha_in[1];
			$ano_in = $fecha_in[2];
			$fecha_ac = explode("/",date("d/m/Y"));
			$dia_ac = $fecha_ac[0];
			$mes_ac = $fecha_ac[1];
			$ano_ac = $fecha_ac[2];
			$ano = $ano_ac - $ano_in;
			if($mes_ac < $mes_in) {
				$ano = $ano - 1;
			}
			if($mes_ac == $mes_in && $dia_ac < $dia_in) {
				$ano = $ano - 1;
			}
			if($ano < 0) {
				$ano = 0;
			}
		}
		return $ano;
	}
}

function UltimaFechaMes() {
	$mes = date('m');
	$ano = date('Y');
	$fecha = "01-".$mes."-".$ano;
	$fecha = date('d/m/Y', strtotime($fecha));
	$dia  = "";
	if ($mes=="01") {
		$dia = "31";
	}else if($mes=="02"){
		if (($ano % 4 == 0) && (($ano % 100 != 0) || ($ano % 400 == 0))) {
			$dia = "29";
		}else{
			$dia = "28";
		}
	}else if ($mes=="03") {
		$dia = "31";
	}else if ($mes=="04") {
		$dia = "30";
	}else if ($mes=="05") {
		$dia = "31";
	}else if ($mes=="06") {
		$dia = "30";
	}else if ($mes=="07") {
		$dia = "31";
	}else if ($mes=="08") {
		$dia = "31";
	}else if ($mes=="09") {
		$dia = "30";
	}else if ($mes=="10") {
		$dia = "31";
	}else if ($mes=="11") {
		$dia = "30";
	}else if ($mes=="12") {
		$dia = "31";
	}
	$fecha2 = $dia."-".$mes."-".$ano;
	$fecha2 = date('d/m/Y', strtotime($fecha2));
	return $fecha2;
}
/******************************************************************************/
/*                             Manejo de Montos                               */
/******************************************************************************/
function desFormateaMonto($valor) {
	$valor = str_replace(".","",$valor);
	$valor = str_replace(",",".",$valor);
	return $valor;
}

function FormateaMonto($valor, $decimales = 2) {
	return number_format($valor, $decimales, ",", ".");
}

function solo_numeros($cadena, $default="") {
	$m_cadena = preg_replace('/[^\d]/', '', $cadena);
	$m_cadena = empty($m_cadena) ? $default : $m_cadena;
	return $m_cadena;
}

/******************************************************************************/
/*                          Manejo de textos HTML                             */
/******************************************************************************/
function es_utf8($string) {
	if (function_exists("mb_check_encoding") && is_callable("mb_check_encoding")) {
		$u = mb_check_encoding($string, 'UTF8');
		$i = mb_check_encoding($string, 'ISO-8859-1');
		if ($i === true) return false;
		else return $u;
	}

	return preg_match('%^(?:
			[\x09\x0A\x0D\x20-\x7E]            # ASCII
		| [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
		|  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
		| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
		|  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
		|  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
		| [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
		|  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
	)*$%xs', $string);
}

/* Usado para mandar el json en el params en el mostrar datos, para que en el tomar valor se tomen los acentos */
function textconvert($cadena) {

	$cadena = str_replace("&oacute;","ó",$cadena);
	$cadena = str_replace("&Oacute;","Ó",$cadena);
	$cadena = str_replace("&aacute;","á",$cadena);
	$cadena = str_replace("&Aacute;","Á",$cadena);
	$cadena = str_replace("&eacute;","é",$cadena);
	$cadena = str_replace("&Eacute;","É",$cadena);
	$cadena = str_replace("&iacute;","í",$cadena);
	$cadena = str_replace("&Iacute;","Í",$cadena);
	$cadena = str_replace("&uacute;","ú",$cadena);
	$cadena = str_replace("&Uacute;","Ú",$cadena);
	$cadena = str_replace("&ntilde;","ñ",$cadena);
	$cadena = str_replace("&Ntilde;","Ñ",$cadena);
	$cadena = str_replace('"',"&quot;",$cadena);
	$cadena = str_replace('´',"&acute;",$cadena);
	$cadena = str_replace("'","&apos;",$cadena);
	
	return $cadena;
}

function ConvertTextMostrar( $value )
	{
		return stripcslashes(html_entity_decode($value,ENT_QUOTES));
	}

function html_encode($texto, $charset = 'UTF-8') {
	if (empty($charset)) {
		$salida = htmlentities($texto, ENT_QUOTES);
	} else {
		$salida = htmlentities($texto, ENT_QUOTES, $charset);
	}
	return $salida;
}

function html_decode($texto, $charset = 'UTF-8') {
	if (empty($charset)) {
		$salida = html_entity_decode($texto, ENT_QUOTES);
	} else {
		$salida = html_entity_decode($texto, ENT_QUOTES, $charset);
	}
	return $salida;
}

function limpiaacentos($cadena) {
	$trad = array ("&aacute;" => "a", "&eacute;" => "e", "&iacute;" => "i", "&oacute;" => "o", "&uacute;" => "u", "&ntilde;" => "n", "&Aacute;" => "A", "&Eacute;" => "E", "&Iacute;" => "I", "&Oacute;" => "O", "&Uacute;" => "U", "&Ntilde;" => "N", "á" => "a", "é" => "e", "í" => "i", "ó" => "o", "ú" => "u" );
	$trans_tbl = strtr($cadena, $trad) ;
	return $trans_tbl;
}
function limpiaURL($cadena) {
	$trad = array ("https://" => "", "http://" => "");
	$trans_tbl = strtr($cadena, $trad) ;
	return $trans_tbl;
}
function htmlconvert($cadena) {
	$cadena = str_replace("Ã±","&ntilde;",$cadena);
	$cadena = str_replace("Ã³","&oacute;",$cadena);
	$cadena = str_replace("Ãº","&uacute;",$cadena);
	$cadena = str_replace("Ã¡","&aacute;",$cadena);
	$cadena = str_replace("Ã©","&eacute;",$cadena);
	$cadena = str_replace("Ã","&iacute;",$cadena);
	$cadena = str_replace("­Â­","",$cadena);
	$cadena = str_replace("á","&aacute;",$cadena);
	$cadena = str_replace("Á","&Aacute;",$cadena);
	$cadena = str_replace("é","&eacute;",$cadena);
	$cadena = str_replace("É","&Eacute;",$cadena);
	$cadena = str_replace("í","&iacute;",$cadena);
	$cadena = str_replace("Í","&Iacute;",$cadena);
	$cadena = str_replace("ó","&oacute;",$cadena);
	$cadena = str_replace("Ó","&Oacute;",$cadena);
	$cadena = str_replace("ú","&uacute;",$cadena);
	$cadena = str_replace("ü","&uuml;",$cadena);
	$cadena = str_replace("Ú","&Uacute;",$cadena);
	$cadena = str_replace("ñ","&ntilde;",$cadena);
	$cadena = str_replace("Ñ","&Ntilde;",$cadena);
	$cadena = str_replace('"',"&quot;",$cadena);
	$cadena = str_replace('´',"&acute;",$cadena);
	$cadena = str_replace(chr(193),'&Aacute;',$cadena);
	$cadena = str_replace(chr(201),'&Eacute;',$cadena);
	$cadena = str_replace(chr(205),'&Iacute;',$cadena);
	$cadena = str_replace(chr(211),"&Oacute;",$cadena);
	$cadena = str_replace(chr(218),'&Uacute;',$cadena);
	$cadena = str_replace(chr(225),'&aacute;',$cadena);
	$cadena = str_replace(chr(233),'&eacute;',$cadena);
	$cadena = str_replace(chr(237),'&iacute;',$cadena);
	$cadena = str_replace(chr(243),"&oacute;",$cadena);
	$cadena = str_replace(chr(250),'&uacute;',$cadena);
	$cadena = str_replace(chr(194).chr(173),"",$cadena);
	$cadena = str_replace(chr(195).chr(129),"&Aacute;",$cadena);
	$cadena = str_replace(chr(195).chr(137),"&Eacute;",$cadena);
	$cadena = str_replace(chr(195).chr(141),"&Iacute;",$cadena);
	$cadena = str_replace(chr(195).chr(145),"&Ntilde;",$cadena);
	$cadena = str_replace(chr(195).chr(147),"&Oacute;",$cadena);
	$cadena = str_replace(chr(195).chr(154),"&Uacute;",$cadena);
	$cadena = str_replace(chr(195).chr(173),"&iacute;",$cadena);
	$cadena = str_replace("&AACUTE;",'&Aacute;',$cadena);
	$cadena = str_replace("&EACUTE;",'&Eacute;',$cadena);
	$cadena = str_replace("&IACUTE;",'&Iacute;',$cadena);
	$cadena = str_replace("&OACUTE;",'&Oacute;',$cadena);
	$cadena = str_replace("&UACUTE;",'&Uacute;',$cadena);
	$cadena = str_replace("&QUOT;",'&quot;',$cadena);
	$cadena = str_replace("&NTILDE;",'&Ntilde;',$cadena);
	$cadena = str_replace("&DEG;","&deg;",$cadena);
	$cadena = str_replace("&AMP;DEG;","&deg;",$cadena);
	$cadena = str_replace(trim("\ "),"",$cadena);
	$cadena = str_replace("¿","&#191;",$cadena);
	$cadena = str_replace("?","&#63;",$cadena);
	return $cadena;
}	 


/******************************************************************************/
/*                       Elementos de formulario HTML                         */
/******************************************************************************/
function input_boton($id, $nombre, $funcion, $opciones="") {
	$btn = "<a href=\"#\" class=\"btn btn-info\" name=\"$id\" id=\"$id\"  onClick=\"minutos_transcurridos=0; $funcion\" $opciones>$nombre</a>";
	echo $btn;
}

function input_textarea($id, $valor="", $atributos="", $requerido="", $mayus="", $col="", $row="", $logn="") {
	$attr = array($atributos);
	if ($requerido != "") { $attr[] = crear_requerido(); }
	if ($mayus == "1")    { $attr[] = "onBlur=\"this.value=this.value.toUpperCase();\""; }
	if ($logn != "")      { $attr[] = "onKeyPress=\"longitudTexto(this, $logn);\""; }
	if ($col != "")       { $attr[] = "cols=\"$col\""; }
	if ($row != "")       { $attr[] = "rows=\"$row\""; }
	$attr = implode(" ", $attr);
	$str = "<textarea name=\"$id\" id=\"$id\" $attr onKeyDown=\"minutos_transcurridos=0;return esString(this.value, this);\">$valor</textarea>";
	
	echo $str;
}

function input_email($id, $valor = "", $atributos = "", $requerido = "") {
	if ($requerido!="") { $requerido=crear_requerido(); }
	$str = "<input type=\"email\" name=\"$id\" id=\"$id\" class=\"form-control\" tittle=\"Este campo solo acepta direcciones de correo v&aacute;lidas\" value=\"$valor\" $atributos{$requerido} onChange=\"esEmail(this.value,this);\"/>";
	
	echo $str;
}

function input_fecha($id, $fecha = "", $atributos = "", $requerido = "") {
	if ($requerido!="") { $requerido=crear_requerido(); }
	$str = "<input type=\"text\" name=\"$id\" id=\"$id\" value=\"$fecha\" class=\"form-control\" $atributos{$requerido} onKeyUp=\"minutos_transcurridos=0;this.value=formateafecha(this.value);\" maxlength=\"10\" />";
	$str .= "<script>$('#".$id."').datepicker({changeMonth: true,changeYear: true});</script>";
	
	echo $str;
}

function input_numero($id, $valor = "", $atributos = "", $requerido = "") {
	if ($requerido!="") { $requerido=crear_requerido(); }
	$str= "<input type='number' name='{$id}' id='{$id}' value='{$valor}' class='form-control' title='Este campo solo acepta valores n&uacute;mericos' {$atributos} {$requerido} onKeyPress='minutos_transcurridos=0;return AceptarNro(event);' onKeyDown='tecla_control(event);' />";
	
	echo $str;
}

function input_numero_sep($id, $valor = "", $sep = "", $num = "", $atributos = "", $requerido = "") {
	if ($requerido!="") { $requerido=crear_requerido(); }
	$str= "<input type=\"text\" name=\"$id\" id=\"$id\" value=\"$valor\" class=\"form-control\" title=\"Este campo solo acepta valores n&uacute;mericos\" $atributos{$requerido} onKeyUp=\"minutos_transcurridos=0;this.value=formateaString(this.value, '$sep', $num);\" onKeyDown=\"tecla_control(event);\"/>";
	
	echo $str;
}

function input_monto($id, $valor = "", $atributos = "", $requerido = "") {
	if ($requerido != "") { $requerido = " required"; }
	$str= "<input type=\"text\" name=\"$id\" id=\"$id\" value=\"$valor\" class=\"txt_monto\" title=\"Este campo solo acepta montos v&aacute;lidos\" $atributos{$requerido} onKeyPress=\"minutos_transcurridos=0;this.value=ValidaNumero(event,this);\"/>";
	if ($requerido != "") { $str .= '&nbsp;<span class="glyphicon glyphicon-asterisk rojo" title="Campo obligatorio"></span>'; }
	echo $str;
}

function input_monto_sencillo($id, $valor="", $atributos="", $requerido="") {
	if ($requerido != "") { $requerido = " required"; }
	$str = "<input type=\"text\" name=\"$id\" id=\"$id\" value=\"$valor\" class=\"form-control\" title=\"Este campo solo acepta montos v&aacute;lidos\"  onKeyUp=\"minutos_transcurridos=0;this.value=ValidaNumero(event,this);\" $atributos{$requerido}  style=\"text-align:right;\" />";
	if ($requerido != "") { $str .= '&nbsp;<span class="glyphicon glyphicon-asterisk rojo" title="Campo obligatorio"></span>'; }
	echo $str;
}

function input_text($id, $valor = "", $atributos = "", $requerido = "", $mayus = "") {
	$attr = array($atributos);
	if ($requerido != "") { $attr[] = crear_requerido(); }
	if ($mayus != "")     { $attr[] = "onBlur=\"this.value=this.value.toUpperCase();\""; }
	$attr = implode(" ", $attr);
	$str = "<input type=\"text\" name=\"$id\" id=\"$id\" value=\"$valor\" class=\"form-control\" title=\"Este campo solo acepta descripciones alfanum&eacute;ricas v&aacute;lidas\" $attr onKeyUp=\"minutos_transcurridos=0;return esString(this.value, this);\"/>";
	
	echo $str;
}

function input_general($id, $valor = "", $atributos = "", $requerido = "", $mayus="") {
	$attr = array($atributos);
	if ($requerido != "") { $attr[] = crear_requerido();}
	if ($mayus != "")     { $attr[] = "onBlur=\"this.value=this.value.toUpperCase();\""; }
	$attr = implode(" ", $attr);
	$str = "<input type=\"text\" name=\"$id\" id=\"$id\" value=\"$valor\" class=\"txt_normal\" title=\"Este campo solo acepta descripciones alfanum&eacute;ricas v&aacute;lidas\" $attr onKeyUp=\"minutos_transcurridos=0;\"/>";
	
	echo $str;
}

function input_text_simb($id, $valor = "", $atributos = "", $requerido = "", $mayus = "") {
	$attr = array($atributos);
	if ($requerido != "") { $attr[] = crear_requerido();}
	if ($mayus != "")     { $attr[] = "onBlur=\"this.value=this.value.toUpperCase();\""; }
	$attr = implode(" ", $attr);
	$str = "<input type=\"text\" name=\"$id\" id=\"$id\" value=\"$valor\" class=\"txt_normal\" title=\"Este campo solo acepta descripciones alfanum&eacute;ricas v&aacute;lidas\" $attr onKeyDown=\"return esSimbolo(this.value, this);\"/>";
	
	echo $str;
}

function input_formula($id, $valor = "", $atributos = "", $requerido = "", $mayus = "1") {
	$attr = array($atributos);
	if ($requerido != "") { $attr[] = crear_requerido();}
	if ($mayus != "")     { $attr[] = "onBlur=\"this.value=this.value.toUpperCase();\""; }
	$attr = implode(" ", $attr);
	$str = "<input type=\"text\" name=\"$id\" id=\"$id\" value=\"$valor\" class=\"txt_formula\" title=\"Este campo solo acepta descripciones alfanum&eacute;ricas\" $attr onKeyDown=\"return esFormula(this.value, this);\"/>";
	
	echo $str;
}

function input_telefono($id, $valor = "", $atributos = "", $requerido = "") {
	if ($requerido!="") { $requerido=crear_requerido(); }
	$str = "<input type=\"tel\" name=\"$id\" id=\"$id\" value=\"$valor\" class=\"form-control\" title=\"Este campo solo acepta valores n&uacute;mericos\" $atributos{$requerido} onKeyPress=\"return AceptarNro(event);\" onKeyUp=\"this.value=formateatelefono(this.value);\" onKeyDown=\"tecla_control(event);\"/>";
	
	echo $str;
}

function crear_requerido() { 
	 return " style=\"
		background: rgb(252,252,252);
		border-bottom-color: red;\"  
		placeholder=\"(Campo Obligatorio..)\" ";
}

function input_hora($id, $valor = "", $atributos = "", $requerido = "") {
	if ($requerido!="") { $requerido=crear_requerido(); }
	$str = "<input type=\"text\" name=\"$id\" id=\"$id\" value=\"$valor\" class=\"txt_fecha\" title=\"Este campo solo acepta valores n&uacute;mericos\" $atributos{$requerido} onKeyPress=\"return AceptarNro(event);\" onKeyUp=\"this.value=formateahora(this.value);\" onKeyDown=\"tecla_control(event);\"/>";
	
	echo $str;
}

function input_checkbox($id, $etiqueta, $valor, $checked = "", $atributos = "") {
	if ($checked != "") { $checked = 'checked="checked"'; }
	echo "<label><input type=\"checkbox\" id=\"$id\" name=\"$id\" $checked $propiedades value=\"$valor\">$etiqueta</label>";
}

function input_hidden($id, $valor = "", $atributos = "") {
	$str = "<input type=\"hidden\" name=\"$id\" id=\"$id\" value=\"$valor\" {$atributos}/>\n";
	echo $str;
}
function input_check_box($id_input,$etiqueta,$checked="",$propiedades="",$func="") {
	if ($checked=="1" or $checked==true) { $checked = 'checked="checked"'; } else { $checked=""; }
	echo '<label><input type="checkbox" id="'.$id_input.'" name="'.$id_input.'" '.$checked.' '.$propiedades.' value="0" onclick="if (this.value==1){this.value=0;} else {this.value=1;}'.$func.'" ><span class="cont_plain">'.$etiqueta.'</span></label>';
}
function combo_bd($id, $sql, $campoguardar, $campomostrar, $seleccionar, $teventos="") {
	echo "<select name=\"$id\" id=\"$id\" class=\"form-control\" $teventos>";
	echo "<option value=''></option>";
	$conn = ConexionBD::crear('default');
	$dat  = $conn->ejecutar($sql);
	while ($rs = $dat->proximo()){
		if (trim($rs[$campoguardar])==$seleccionar) {
			echo "<option value='".$rs[$campoguardar]."' selected='selected'>".htmlentities($rs[$campomostrar])."</option>";
		} else {
			echo "<option value='".$rs[$campoguardar]."'>".htmlentities($rs[$campomostrar])."</option>";
		}
	}
	echo "</select>";
}

function crear_combo_coment($id, $tabla, $campo, $fuction = "") {
	$slt='<select name="'.$id.'" id="'.$id.'" onchange="'.$fuction.'">';
	$slt.='<option value=""></option>';
	$sql = "SELECT pg_attribute.attname, pg_type.typname as type, pg_attribute.attlen, pg_attribute.atttypmod, pg_attribute.attnotnull,
			(SELECT description FROM pg_description WHERE pg_description.objoid = pg_attribute.attrelid limit 1) as comment
			FROM pg_attribute inner join pg_class on pg_attribute.attrelid = pg_class.oid inner join pg_type on pg_attribute.atttypid = pg_type.oid
			WHERE pg_class.relname = '$tabla' AND pg_attribute.attname='$campo'";
	$conn = ConexionBD::crear('default');
	$dat  = $conn->ejecutar($sql);
	$rs   = $dat->proximo();
	if ($rs!="") {
		if (trim($rs["comment"])!="") {
			$pos = strpos($rs["comment"],",");
			if ($pos!== false) {
				$mcampo = explode(",", $rs["comment"]);
				foreach($mcampo as $val){ $slt.='<option value="'.$val.'">'.$val.'</option>'; }
			}
		}
	}
	$slt.='</select>';
	echo $slt;
}

/**
 * Funcion que imprime diferentes tipos de input.
 * Valores posibles para tipo = [text, checkbox, radio, monto, numero, textarea, fecha]
 */
function input_tag($id, $valor = "", $tipo = "text", $etiqueta = "", $requerido = "", $atributos=array()) {
	/* Si no hay id, no muestra nada */
	if ($id == "") return;
	/* Valores por defecto de las variables */
	$attr = array();
	$mayus = "";
	$div_class = "";
	$options = array();
	/* Quitar los 2 puntos al final de la etiqueta */
	$etiqueta = trim($etiqueta);
	$mensaje = preg_replace('/:\s*$/', '', $etiqueta);
	/* Agregar mensaje a la lista de atributos */
	$atributos["mensaje"] = $mensaje;
	/* Si dentro del arreglo de atributos esta la lista de opciones para el select */
	/* entonces lo asigno de la variable y lo elimino del arreglo */
	if (array_key_exists("options", $atributos)) {
		$options = $atributos["options"];
		unset($atributos["options"]);
	}
	if (array_key_exists("div_class", $atributos)) {
		$div_class = $atributos["div_class"];
		unset($atributos["div_class"]);
	}
	/* Construyo un arreglo de atributos en la forma nombre="valor" */
	foreach ($atributos as $key => $value) { $attr[] = "$key=\"$value\""; }
	/* Si el arreglo no contiene el atributo 'name' se usa el valor del id */
	if (!array_key_exists("name", $atributos)) { $attr[] = "name=\"$id\""; }
	/* Si dentro del arreglo de atributos esta la propiedad mayus se asigna a la variable */
	if (array_key_exists("mayus", $atributos)) { $mayus = $atributos["mayus"]; }
	/* Uno los elementos del arreglo anterior en una sola cadena de texto */
	$attr = implode(" ", $attr);
	echo "<div class=\"form-group item-form $div_class\">";
	switch ($tipo) {
		case 'checkbox':
		case 'radio':
			echo "<div class=\"col-sm-offset-3 col-sm-9\"><div class=\"$tipo\"><label><input type=\"$tipo\" id=\"$id\" value=\"$valor\" $attr/> $etiqueta</label></div></div></div>\n";
			return;
	}
	echo "<label for=\"$id\" class=\"col-sm-3 control-label\">$etiqueta</label><div class=\"col-sm-9\">";
	switch ($tipo) {
		case 'text':   input_text($id, $valor, $attr, $requerido, $mayus); break;
		case 'monto':  input_monto($id, $valor, $attr, $requerido); break;
		case 'numero':
			if ($requerido != "") { $attr .= " required"; }
			echo "<input type=\"number\" id=\"$id\" value=\"$valor\" $attr/>";
			break;
		case 'fecha':  input_fecha($id, $valor, $attr, $requerido); break;
		case 'textarea':
			if ($mayus == "1") { $attr .= ' onBlur="javascript:this.value=this.value.toUpperCase();"'; }
			echo "<textarea id=\"$id\" onKeyDown=\"minutos_transcurridos=0; return esString(this.value, this);\" class=\"caja_tex\" $attr>$valor</textarea>";
		break;
		case 'select':
			if ($requerido != "") { $attr .= " required"; }
			echo "<select id=\"$id\" $attr>";
			if ($options['incluir_vacio']) {
				unset($options['incluir_vacio']);
				echo "<option value=\"\"></option>";
			}
			if ($options['agrupado']) {
				unset($options['agrupado']);
				foreach ($options as $key => $value) {
					/* Crear el optgroup */
					echo "<optgroup label=\"$key\">";
					/* Agregar los options */
					foreach ($value as $key2 => $value2) {
						$selected = ($key2 == $valor) ? "selected" : "";
						echo "<option value=\"$key2\" $selected>$value2</option>";
					}
					echo "</optgroup>";
				}
			} else {
				foreach ($options as $key => $value) {
					$selected = ($key == $valor) ? "selected" : "";
					echo "<option value=\"$key\" $selected>$value</option>";
				}
			}
			echo "</select>";
		break;
		case 'combo_entes': crear_combo_entes($id); break;
		case 'combo_organismos': crear_combo_organismo($id, "", $valor ? $valor : 0); break;
	}
	echo "</div></div>\n";
}

/**
 * Función para crear un string con una lista de elementos option a partir de una tabla en la base de
 * datos o una consulta SQL
 */
function generar_options($baseDatos, $tabla_sql, $campo_value, $campo_texto = "", $order_by = "", $campo_group = "", $idcampo_group = "") {
	$salida   = "";
	$tmpGroup = "";
	$idgroup  = "";
	if (empty($tabla_sql)) return $salida;
	$campos = "";
	if (empty($campo_texto)) {
		$campo_texto = $campo_value;
		$campos = $campo_value;
	} else {
		$campos = "$campo_value, $campo_texto";
	}
	if (empty($idcampo_group)) {
		$idcampo_group = $campo_group;
	}
	/* Verifico si es una consulta */
	$es_sql = preg_match("/^select\\s+.+from\\s+.+/ims", $tabla_sql);
	if ($es_sql === 1) { /* Es una consulta */
		$sql = $tabla_sql;
	} else { /* Es una tabla */
		$sql = "SELECT $campos FROM $tabla_sql" . (empty($order_by) ? "" : " ORDER BY $order_by");
	}
	$conn = ConexionBD::crear($baseDatos);
	$res = $conn->ejecutar($sql);
	while ($rs = $res->proximo()) {
		if ($campo_group !="") {
			if ($rs[$campo_group] != $tmpGroup) {
				if ($tmpGroup != "") { $salida .= "</optgroup>"; }
				$salida.="<optgroup label='" . $rs[$campo_group]. "'>";
				$tmpGroup = $rs[$campo_group];
				$idgroup = $rs[$idcampo_group];
			}
		}
		$salida .= sprintf("<option idgroup=\"$idgroup\" value=\"%s\">%s</option>\n", $rs[$campo_value], utf8_encode($rs[$campo_texto]));
	}
	if ($campo_group !="") { 
		$salida .= "</optgroup>";
	}
	return $salida;
}

/******************************************************************************/
/*       Objetos HTML que se complementan con funciones de JavaScript         */
/******************************************************************************/
function crear_combo_organismo($id, $requerido="", $organismo_usuario=0) {
	if ($requerido!="") { $requerido=crear_requerido(); }
	$combo = "<select name=\"$id\" id=\"$id\"{$requerido} class=\"form-control\" ></select>";
	$str = "<input type=\"text\" name=\"fil_cmb_{$id}\" id=\"fil_cmb_{$id}\" size=\"10\" title=\"B&uacute;squeda por organismo/oficina\">
			<input type=\"button\" name=\"BuscarOrg\" value=\" \" class=\"b_b2\" title=\"Buscar\" onClick=\"traer_organismos('$id', 'div_{$id}', 'fil_cmb_{$id}', '$organismo_usuario');\">
			<span id=\"div_{$id}\">$combo</span>";

	echo $str;
}

function buscar_numero_comprobante($idclasificacion,$mescontable) {
	$conn = ConexionBD::crear('default');
	$sql= "SELECT substr(numerocomprobante,5) AS numero
			FROM contabilidad.comprobante 
			WHERE extract(month from fechacontable)='".intval($mescontable)."' AND idclasificacion=$idclasificacion
			ORDER BY substr(numerocomprobante,5) DESC LIMIT 1";
	$res = $conn->ejecutar($sql);
	if ($res->getCantRegistros() > 0) {
		$rs = $res->proximo();
		$numero_entero = $rs["numero"] + 1;
		$n_num = padl($idclasificacion,"0",2).padl($mescontable,"0",2).padl($numero_entero,"0",6);
		return $n_num = padl($idclasificacion,"0",2).padl($mescontable,"0",2).padl($numero_entero,"0",6);
		
	}else{
		return padl($idclasificacion,"0",2).padl($mescontable,"0",2).padl(1,"0",6);
	}
}

function padl($cadena,$caracter,$long) {
	for ($x=strlen($cadena);$x<$long;$x++) {
		$cadena = $caracter.$cadena;
	}
	return $cadena;
}

function select_organismos($id, $idperfilusuario, $idorganismo, $funcion="") {
	$slt = '<select name="'.$id.'" id="'.$id.'" onchange="'.$funcion.'" class="form-control">';
	$fil = "";
	if ($idorganismo == '0') {
		$slt.='<option value=""></option>';
	} else {
		$fil = "AND idorganismo = $idorganismo";
	}
	
	$conn = ConexionBD::crear('default');
	$res  = $conn->ejecutar("SELECT * FROM jcap_organismos where idtipo=20 $fil order by nombreorganismo");
	if ($res->getCantRegistros() == 1) {
		$slt.='<option value=""></option>';
	}
	while($rs = $res->proximo()) {
		$slt.='<option value="'. $rs["idorganismo"] .'">'.$rs["nombreorganismo"].'</option>';
	}
	$slt.='</select>';
	echo $slt;
}

function select_organismos_creados($id, $idperfilusuario, $idusuario, $idorganismo, $fucnion="") {
	$slt='<select name="'.$id.'" id="'.$id.'" onchange="'.$fucnion.'">';
	if ($idorganismo=='0') {
		$slt.='<option value=""></option>';
		$fil="";
	} else {
		$fil=" AND (idusuario_editor=$idusuario OR idorganismo=$idorganismo) ";
	}
	$conn = ConexionBD::crear('default');
	$sql = "SELECT * FROM jcap_organismos  where idtipo=20 $fil order by nombreorganismo";
	$res = $conn->ejecutar($sql);
	while($rs = $res->proximo()) {
		$slt.='<option value="'. $rs["idorganismo"] .'">'.$rs["nombreorganismo"].'</option>';
	}
	$slt.='</select>';
	echo $slt;
}

function select_organismos_departamentos($id, $idorganismo="", $idorganismooficina="",  $idperfil="", $func="") {
	if ($func!="") { $func='onChange="'.$func.'"'; }
	if (trim($idorganismo)!="") { $fil_idorganismo=" and idorganismo=".$idorganismo." "; } else { $fil_idorganismo=""; }
	$slt ='<select class="form-control" name="'.$id.'" id="'.$id.'" '.$func.'>';
	if (trim($idorganismooficina)=="")  { $slt.='<option value=""></option>'; }
	$sql = "SELECT jcap_organismos.idorganismo as idorganismooficina, jcap_organismos.nombreorganismo as nombreoficina, ciudad, idorganismopadre, t.nombreorganismo
			FROM jcap_organismos
			INNER JOIN (SELECT idorganismo, nombreorganismo FROM jcap_organismos WHERE idtipo=20  $fil_idorganismo ) t ON jcap_organismos.idorganismopadre=t.idorganismo
			WHERE idtipo=21 ORDER BY t.nombreorganismo, jcap_organismos.nombreorganismo ";
	$tmp_nombre="";
	$cls="";
	$conn = ConexionBD::crear('default');
	$res = $conn->ejecutar($sql);
	while($rs = $res->proximo()) {
		if ($rs["nombreorganismo"] != $tmp_nombre) {
			if ($tmp_nombre != "") { $slt .= "</optgroup>"; }
			$slt.="<optgroup label='" . substr($rs["nombreorganismo"],0,40) . "'>";
			$tmp_nombre = $rs["nombreorganismo"];
		}
		if ($idperfil==1) {
			if ($idorganismooficina == $rs["idorganismooficina"])  { $sel_opt = " selected='selected' "; } else { $sel_opt = ""; }
			$slt.="<option ".$sel_opt." class='".$cls."' value='".$rs["idorganismooficina"]."'>". htmlentities(cortar_palabras_hasta($rs["nombreoficina"], 45), ENT_QUOTES, 'UTF-8')/*html_encode(cortar_palabras_hasta($rs["nombreoficina"], 45))*/ ."</option>";
		} else {
			if ($idorganismooficina==$rs["idorganismooficina"]){ $sel_opt = "selected"; } else { $sel_opt = ""; }
			$slt.="<option ".$sel_opt." class='".$cls."' value='".$rs["idorganismooficina"]."' >". htmlentities(cortar_palabras_hasta($rs["nombreoficina"], 45), ENT_QUOTES, 'UTF-8')/*html_encode(cortar_palabras_hasta($rs["nombreoficina"], 45))*/ ."</option>";
		}
		$sql2 = "SELECT jcap_organismos.idorganismo as idorganismooficina, jcap_organismos.nombreorganismo as nombreoficina
				 FROM jcap_organismos
				 WHERE jcap_organismos.idorganismopadre=".$rs["idorganismooficina"]." ORDER BY nombreorganismo ";
		$res2 = $conn->ejecutar($sql2);
		while ($rs2 = $res2->proximo()) {
			if ($idorganismooficina==$rs2["idorganismooficina"]) { $sel_opt = " selected='selected' "; } else { $sel_opt = ""; }
			$slt.="<option ".$sel_opt." class='".$cls."' value='".$rs2["idorganismooficina"]."'> ==>" . htmlentities(cortar_palabras_hasta($rs2["nombreoficina"], 45), ENT_QUOTES, 'UTF-8')/*html_encode(cortar_palabras_hasta($rs2["nombreoficina"], 45))*/ . "</option>";
		}
	}
	$slt.='</select>';
	echo $slt;
}

function select_combo_todos_organismos($id,  $campo_dev="", $valorselec="", $idorganismo="", $func="" ) {
	if ($func!="") { $func='onChange="'.$func.'"'; }
	if ($campo_dev=="") { $campo_dev="idorganismooficina"; }
	if (trim($idorganismo)!="") { $fil_idorganismo=" and idorganismo=".$idorganismo." "; } else { $fil_idorganismo=""; }
	$slt ='<select class="cont_plain" name="'.$id.'" id="'.$id.'" '.$func.'>';
	$slt.='<option value=""></option>';

	$sql = "SELECT idorganismo,  nombreorganismo, idorganismopadre, nombreorganismopadre, (CASE WHEN nombreorganismopadre is null THEN nombreorganismo ELSE (nombreorganismopadre ||' - '||nombreorganismo)  END) as grupo
			FROM (
			SELECT '1' as t, idorganismo, null as nombreorganismopadre, nombreorganismo, (CASE WHEN idorganismopadre=0 THEN idorganismo ELSE idorganismopadre END) as idorganismopadre FROM jcap_organismos WHERE idtipo=20
			union
			SELECT '2' as t, idorganismo, (CASE WHEN idorganismopadre=0 THEN null ELSE (SELECT nombreorganismo FROM jcap_organismos o WHERE o.idorganismo=jcap_organismos.idorganismopadre ) END) as nombreorganismopadre, nombreorganismo, idorganismopadre FROM jcap_organismos WHERE idtipo=21
			) t
			order by idorganismopadre, t ";
	$cls="";
	$conn = ConexionBD::crear('default');
	$res = $conn->ejecutar($sql);
	while ($rs = $res->proximo()) {
		$tmp_nombreorganismopadre="";
		if (trim($rs["nombreorganismopadre"])=="") { $cls="combo_org_padre"; }
		if ((trim($valorselec)!="")&& ($rs[$campo_dev]==trim($valorselec))) { $s=" selected "; } else { $s=""; }
		$slt.="<option $s value='{$rs[$campo_dev]}'>{$rs[$campo_dev]}</option>";
	}
	$slt.='</select>';
	echo $slt;
}
$mat = array();
function crear_combo_organismos_estructura($id, $fil_idorganismo="", $funtion="",$requerido="", $idpadre="")  {
	global $mat;
	$mat = array();
	if ($idpadre == "0") { $idpadre=""; }
	if ($idpadre != "")  { busca_mi_organismos($idpadre); }
	busca_organismos_hijos($idpadre);
	if ($requerido!="")	{ $requerido = " required"; }
	$slt="<select name=\"$id\" id=\"$id\" onchange=\"$funtion\"{$requerido}>";
	if ($fil_idorganismo == "") { $slt .= '<option value=""></option>'; }
	foreach($mat as $rs) {
		$vineta="-&nbsp;";
		$class = "combo_org_padre";
		if ($rs["idorganismopadre"]!="") { $vineta="&nbsp;&nbsp;".$vineta; $class = "combo_org_hijo"; }
		if ($rs["idorganismopadre"]!="" && $rs["abuelo"]!="") { $vineta="&nbsp;&nbsp;&nbsp;".$vineta; $class = "combo_org_nieto"; }

		if ($fil_idorganismo!="") {
			if ($fil_idorganismo==$rs["idorganismo"]) {
				$slt.= "<option class = '".$class."' selected='selected' value='".$rs["idorganismo"]."'>".$vineta.html_encode($rs["nombreorganismo"])."</option>";
			}
		} else {
			$slt.= "<option class = '".$class."' value='".$rs["idorganismo"]."'>".$vineta.html_encode($rs["nombreorganismo"])."</option>";
		}

	}
	$slt.="</select>";
	echo $slt;
}

function crear_combo_organismos_estructura_filtro($id, $fil_idorganismo = "", $funtion = "", $requerido = "", $idpadre = "")  {
	global $mat;
	$mat = array();
	if ($idpadre=="0") { $idpadre=""; }
	$mi_ubicacion = "";
	if ($idpadre!="") {
		$vineta="-&nbsp;";
		$class = "combo_org_padre";
		$rs_mi = busca_mi_organismos($idpadre);
		$mi_ubicacion = "<option class = '".$class."' selected='selected' value='".$rs_mi["idorganismo"]."'>".$vineta.$rs_mi["nombreorganismo"]."</option>";
	}
	busca_organismos_hijos($idpadre);
	if ($requerido!="")	{ $requerido = "select_requerido_textarea"; } else {  $requerido ="cont_plain"; }
	$slt="<input type='text' size='14' class='caja_tex' name='busca_".$id."' id='busca_".$id."' value='' onkeyup='buscar_en_combo(\"".$id."\",\"".$idpadre."\");' />&nbsp;";
	$slt.="<select name='".$id."' id='".$id."' onchange='".$funtion."' class='".$requerido."'>";
	if ($fil_idorganismo=="") { $slt.='<option value=""></option>'; }
	$slt.=$mi_ubicacion;
	foreach($mat as $rs) {
		$vineta="-&nbsp;";
		$class = "combo_org_padre";
		if ($rs["idorganismopadre"]!="") { $vineta="&nbsp;&nbsp;&nbsp;*&nbsp;"; $class = "combo_org_hijo"; }
		if ($rs["idorganismopadre"]!="" && $rs["abuelo"]!="") { $vineta="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;=>&nbsp;"; $class = "combo_org_nieto"; }
		if ($fil_idorganismo!=""){
				if ($fil_idorganismo==$rs["idorganismo"]){
					$slt.= "<option class = '".$class."' selected='selected' value='".$rs["idorganismo"]."' title='".$rs["nombreabuelo"]." / ".$rs["nombrepadre"]."'>".$vineta.$rs["nombreorganismo"]."</option>";
				}
		} else {
			$slt.= "<option class = '".$class."' value='".$rs["idorganismo"]."' title='".$rs["nombreabuelo"]." / ".$rs["nombrepadre"]."'>".$vineta.$rs["nombreorganismo"]."</option>";
		}
	}
	$slt.="</select>";
	echo $slt;
}

function busca_mi_organismos($idorganismo){
	$mat2="";
	$sql = "SELECT jcap_organismos.idorganismo, jcap_organismos.idorganismopadre, jcap_organismos.nombreorganismo,
				padre.nombreorganismo as nombrepadre, padre.idorganismopadre as abuelo,
				abuelo.nombreorganismo as nombreabuelo
			FROM jcap_organismos
				left outer join jcap_organismos padre on jcap_organismos.idorganismopadre=padre.idorganismo
				left outer join jcap_organismos abuelo on padre.idorganismopadre = abuelo.idorganismo
			where jcap_organismos.idorganismo = $idorganismo";
	$conn = ConexionBD::crear('default');
	$res = $conn->ejecutar($sql);
	while($rs = $res->proximo()) {
		$mat2=array("idorganismopadre" => $rs["idorganismopadre"], "idorganismo" => $rs["idorganismo"], "nombreorganismo" => strtoupper($rs["nombreorganismo"]), "abuelo" => $rs["abuelo"], "nombrepadre" => $rs["nombrepadre"], "nombreabuelo" =>  $rs["nombreabuelo"]);
	}
	return $mat2;
}

function busca_organismos_hijos($idorganismopadre = "") {
	global $mat;
	if ($idorganismopadre=="") {
		$where="where jcap_organismos.idorganismopadre is null ";
	} else {
		$where="where jcap_organismos.idorganismopadre = $idorganismopadre";
	}
	$sql = "SELECT jcap_organismos.idorganismo, jcap_organismos.idorganismopadre, jcap_organismos.nombreorganismo,
				padre.nombreorganismo as nombrepadre, padre.idorganismopadre as abuelo,
				abuelo.nombreorganismo as nombreabuelo
			FROM jcap_organismos
				left outer join jcap_organismos padre on jcap_organismos.idorganismopadre=padre.idorganismo
				left outer join jcap_organismos abuelo on padre.idorganismopadre = abuelo.idorganismo
			$where
			order by jcap_organismos.nombreorganismo";
	$conn = ConexionBD::crear('default');
	$res = $conn->ejecutar($sql);
	while($rs = $res->proximo()) {
		$mat[] = array(
			"idorganismopadre" => $rs["idorganismopadre"],
			"idorganismo"      => $rs["idorganismo"],
			"nombreorganismo"  => strtoupper($rs["nombreorganismo"]),
			"abuelo"           => $rs["abuelo"],
			"nombrepadre"      => $rs["nombrepadre"],
			"nombreabuelo"     =>  $rs["nombreabuelo"]
		);
		busca_organismos_hijos($rs["idorganismo"]);
	}
}


function nombre_organismo($idorganismo) {
	$sql = "SELECT * FROM jcap_organismos  where idorganismo=$idorganismo";
	$conn = ConexionBD::crear('default');
	$rs = $conn->ejecutar($sql)->proximo();
	if (!empty($rs)) { $nombreorganismo = $rs["nombreorganismo"]; } else { $nombreorganismo = "NO ASIGNADO"; }
	return $nombreorganismo;
}

function nombre_usuario($idusuario) {
	$sql = "SELECT * FROM jcap_usuarios  where idusuario=$idusuario";
	$conn = ConexionBD::crear('default');
	$rs = $conn->ejecutar($sql)->proximo();
	if (!empty($rs)) { $usuario = $rs["nombrecompleto"]; } else { $nombreorganismo = "NO ASIGNADO"; }
	return $usuario;
}

/******************************************************************************/
/*                         Elementos de diseño HTML                           */
/******************************************************************************/
function crear_tabla($titulo, $ancho = "100%", $function_onclick="") {
	if (trim($function_onclick)!="") {
		$titulo = "<a href=\"javascript:$function_onclick\">$titulo</a>";
	}
	$tbl = "<div class=\"panel panel-default\">
			<div class=\"panel-heading\"><h3 class=\"panel-title\">$titulo</h3></div>
			<div class=\"panel-body\">";
	echo $tbl;
}

function cerrar_tabla() {
	$tbl='</div></div>';
echo $tbl;
}

/**
 * Crea el marco de la tabla
 * @return Object el marco de la tabla
 */
function crear_tabla_marco() {
	$tbl = "<div class=\"panel panel-default\"><div class=\"panel-body\">";
	echo $tbl;
}

function crear_capa_copy($titulo, $capa, $contenido = "", $ancho="", $x=100, $y=100) {
	if (empty($ancho)) $ancho = "max-w-full";
	$str = `<div id="$capa" class="main-container $ancho flex flex-col justify-center w-11/12 my-5 rounded-3xl bg-white md:w-5/6 md:mx-10 md:my-8 low-dpi:h-md md:h-2xl">
				<div class="m-8 space-y-3 overflow-auto scrollbar scrollbar-firefox low-dpi:mx-10 md:mx-28 lg:mx-48">
					<p class="text-2xl text-kulture-color-cuatro">$titulo</p>
					<div>$contenido</div>
					<div class="grid items-end grid-cols-12 grid-rows-1 my-8 lg:mt-8 lg:mb-2">
						<div class="flex flex-col justify-between col-span-10 col-start-2 space-y-6 lg:col-start-1 lg:col-span-12 lg:flex-row h-fit lg:space-y-0">
							<button onclick="continuar2()" class="px-7 py-2.5 rounded-lg bg-kulture-green text-white shadow-md shadow-green-400 hover:bg-green-100 hover:text-kulture-green hover:shadow-none">Continuar <i class="bi bi-arrow-right-short"></i></button>
						</div>
					</div>
				</div>
			</div>`;
	echo $str;
}

function crear_capa($titulo, $capa, $contenido = "", $ancho="", $x=100, $y=100) {
	if (empty($ancho)) $ancho = "modal-lg";
    /* <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
		<button type='button' class='btn btn-naranja' data-dismiss='modal' id='bntFooter'>Cerrar</button></div> */
	$str = "<!-- Modal -->
			<div class=\"modal fade\" id=\"$capa\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"{$capa}Label\" aria-hidden=\"true\">
				<div class=\"modal-dialog $ancho\">
					<div class=\"modal-content\">
						<div class=\"modal-header\">
							<h4 class=\"text-2xl col-start-2\" id=\"{$capa}Label\">$titulo</h4><br>
						</div>
						<div class=\"modal-body\" id=\"inside_{$capa}\">$contenido</div>
						<div class=\"modal-footer\" id=\"footer_{$capa}\">
						<div id=\"footer_space_{$capa}\"></div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->";
	echo $str;
}


function crear_capa2($titulo, $capa, $contenido = "", $ancho="", $x=100, $y=100) {
	if (empty($ancho)) $ancho = "modal-lg";
	$str = "<!-- Modal -->
			<div class=\"modal fade\" id=\"$capa\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"{$capa}Label\" aria-hidden=\"true\">
				<div class=\"modal-dialog $ancho\">
					<div class=\"modal-content\">
						<div class=\"modal-header\">
							<h4 class=\"modal-title\" id=\"{$capa}Label\">$titulo</h4>
						</div>
						<div class=\"modal-body\" id=\"inside_{$capa}\">$contenido</div>
						<div class=\"modal-footer\">
							<button type=\"button\" class=\"btn btn-success\" data-dismiss=\"modal\">Continuar</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->";
	echo $str;
}

/**
* Crea los elementos CSS necesarios para que la TABLA sea totalmente responsiva
* @param string $titulos Cada uno de los titulos de las columnas separados por coma ","
*/
function crear_ccs_columnas($titulos, $css="")	{ 
	global $jcap_config;

	$arch="jcap_tabla.css"; $path="";
	$rutas=array('jcapLib/css/','../jcapLib/css/','../../jcapLib/css/','jcapLib/css/','../jcapLib/css/','../../jcapLib/css/');

	for ($i=0; $i<count($rutas); $i++)	{ 
		if ((file_exists($rutas[$i].$arch)) && ($path=="")) { $path=$rutas[$i].$arch; $i=count($rutas); }
	}

	if ($css==""){
		$css='<link id="tabla_css" rel="stylesheet" type="text/css" href="'.$path.'" />';
	} else {
		$css='<link id="tabla_css" rel="stylesheet" type="text/css" href="'.$css.'" />';
	}
	$str = $css.'<style type="text/css">
			@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {';
	$titulos_array = explode(",", $titulos);

	for ($i=1; $i <= count($titulos_array) ; $i++) { 
		$str.= 'td#columna_'.$i.':nth-of-type('.$i.'):before { content: "'.textconvert($titulos_array[$i-1]).'"; font-weight: bold; }';
	}
	$str .= '}</style>';
	echo $str;
}
	
function crear_tabla_formulario($titulo , $variables, $archivo_datos, $activos = 7, $capas_adicionales="") {
	
	$bM = ($activos & 4) == 4 ? '<a class="btn btn-primary" id="btnShowsRecords" onclick="showRegistros();" title="Mostrar los Registros..."><span class="glyphicon glyphicon-th-list"></span></a>' : '';
	$bF = ($activos & 2) == 2 ? '<a class="btn btn-primary" id="btnShowsFilters" onclick="showFiltros();" title="Filtrar los Registros..."><span class="glyphicon glyphicon-filter"></span></a>' : '';
	$bN = ($activos & 1) == 1 ? '<a class="btn btn-primary" id="btnShowsInputFields" onclick="showNuevoRegistro();" title="Agregar Nuevo Registro..."><span class="glyphicon glyphicon-plus-sign"></span></a>' : '';
	$tbl ='
		<div id="borde-barra-formulario">
			<div id="barra-formulario">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
				<tr style="border:none;">
					<td class="iz22" width="95%">'.$titulo.'</td>
					<td id="btn-forms"  width="5%" style="background-color:white;border:none;"><div class="btn-group pull-right" style="min-width:80px;">'. $bM . $bN . '</div></td>
				</tr>
				</table>
			</div>
		</div>
		<div id="borde-cuerpo-formulario">
			<div  id="cuerpo-formulario" >
				<div class="caja_degradado2 caja_b-redondo">
					<div class="caja_contenido">
						<div align="right" style="position:absolute; " id="msg"></div>
						<input type="hidden" id="accion" value="" name="accion">
						<input type="hidden" name="campo_orden_tabla" id="campo_orden_tabla" value="">
						<input type="hidden" name="campo_orden_tabla_asc" id="campo_orden_tabla_asc" value="desc">
						<input type="hidden" name="capas_adicionales" id="capas_adicionales" value="'.$capas_adicionales.'">
						<input type="hidden" name="archivo_datos" id="archivo_datos" value="'.base64_encode($archivo_datos).'">';
	echo $tbl;
	$obj = new Paginacion(0);
	$obj->crearObjetos("enviar('Paginacion');");
	if (trim($variables)!='') {include_once($variables);}
}
	

function cerrar_tabla_formulario($url = "../") {
	$tbl ='</div></div></div></div>';
	echo $tbl;
}

function crear_botones_formularios($prefijo = "") {
	$prefijo = trim($prefijo);
	$tbl ='<div class="clearfix"></div>
        <div class="area_botones_formularios">
            <button type="button" class="btn btn-danger btn-sm" id="'.$prefijo.'btn_delete_toggle" onclick="Esconde_Muestra_Celda(`'.$prefijo.'btn_delete_toggle`);Esconde_Muestra_Celda(`'.$prefijo.'span_delete`);"  title="Eliminar Registro">
                <span class="glyphicon glyphicon-trash"></span>
                <span class="label_boton">Eliminar</span>
            </button>
            <span id="'.$prefijo.'span_delete" style="display:none;">
                <button type="button"  class="btn btn-danger btn-sm espacio_eliminar" id="'.$prefijo.'btn_action_delete" onclick="enviar(`Eliminar`);showRegistros();">
                    <span class="glyphicon glyphicon-trash"></span>
                    <span class="label_boton">Confirmar</span>
                </button>
                &nbsp;&nbsp;
                <button type="button"  class="btn btn-danger btn-sm espacio_eliminar" onclick="Esconde_Muestra_Celda(`'.$prefijo.'btn_delete_toggle`);Esconde_Muestra_Celda(`'.$prefijo.'span_delete`);">
                    <span class="glyphicon glyphicon-remove"></span>
                    <span class="label_boton">Deshacer</span>
                </button>
            </span>
            <button type="button" class="btn btn-success btn-sm" id="'.$prefijo.'btn_guardar_toggle" onclick="enviar(`Guardar`);"  title="Guardar Registro">
                <span class="glyphicon glyphicon-floppy-disk"></span>
                <span class="label_boton">Guardar</span>
            </button>
            <button type="button" class="btn btn-info btn-sm" id="'.$prefijo.'btn_cancelar_toggle" onclick="LimpiarTodo();showRegistros();">
                <span class="glyphicon glyphicon-floppy-disk"></span>
                <span class="label_boton">Cancelar</span>
            </button>            
        </div>';
	echo $tbl;
}
/**
 * Genera un mensaje definido por el usuario
 * @param string $descripcion, $err = false, $url = "../" Recibe la descripcion del mensaje y la direccion donde se imprime el mismo
 * @return string el mensaje
 */
function crear_msg($descripcion, $err = false, $url = "../") {
	if(!$err) {
		$btn = "<div class=\"alert alert-success\"><span class=\"glyphicon glyphicon-info-sign\"></span> $descripcion</div>";
	} else {
		$btn = "<div class=\"alert alert-danger\"><span class=\"glyphicon glyphicon-warning-sign\"></span> $descripcion</div>";
	}
	echo $btn;
}

/**
* Genera un Combo Desplagable de la Tabla que se le pase como parametro
* @param string $id,$fucnion
* @return Object el Select creado
*/
function crear_combo_tabla($BaseDatos,$tabla, $camp_clav, $camp_muestra, $id, $fucnion="", $orden="", $where="") {	
	$conn = ConexionBD::crear($BaseDatos);
	if (trim($orden)=="") { $orden=$camp_muestra; }
	$slt='<select class="form-control" name="'.$id.'" id="'.$id.'" onChange="'.$fucnion.'">';
	$slt.='<option value=""></option>';
    $sql = " SELECT $camp_clav, $camp_muestra from $tabla $where order by $orden ";
    
	$res = $conn->ejecutar($sql);	
	while($rs = $res->proximo())
	{ 	
		$slt.='<option value="'.$rs[$camp_clav].'">'.$rs[$camp_clav]." - ".strtoupper(desencode($rs[$camp_muestra])).'</option>';
	}
    $slt.='</select>';
	echo $slt;
}

/******************************************************************************/
/*                                   Grid                                     */
/******************************************************************************/
function smgrid($nombregrid,$mat,$ncampos,$tipcampos,$align,$anchocampos,$sololectura,$belimina,$bseleccionar,$evt_elimina="",$edicampos="", $evt_onChange=""){
	$smcampos	=explode(",",$ncampos);
	$smtipos	=explode(",",$tipcampos);
	$align		=explode(",",$align);
	$smancho	=explode(",",$anchocampos);

	if (trim($edicampos)!="") {
		$smeditable	=explode(",",$edicampos);
	} else {
		if ($sololectura!="")
		{ 	$smeditable=array();
			for ($j=0; $j<count($smcampos); $j++)  { $smeditable[$j]="readOnly"; }
		}
	}
	$class_item=' font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #0000CC; background-color: #CCCCCC; border-top-width: thin; border-right-width: thin; border-bottom-width: thin; border-left-width: thin; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: #E2E2E2; border-right-color: #AEAEAE; border-bottom-color: #AEAEAE; border-left-color: #E2E2E2;  height: 20px; width: 5px;';
	$ctabla = '<table class="table" border="0" id="'.$nombregrid.'" name="'.$nombregrid.'"  cellpadding="0" cellspacing="0">';
	$ctabla .= '<tr class="bg-primary"><td>&nbsp;</td>';
 
	for ($i=0;$i<count($smcampos);$i++) {
		if ($smtipos[$i]=="hidden")
		{ $ctabla .= "<td><input type='hidden' name='smf0_c".($i+1)."' id='smf0_c".($i+1)."' value=''></td>"; }
		else
		{ $ctabla .= "<td align='center'>&nbsp;".strtoupper($smcampos[$i])."<input type='hidden' name='smf0_c".($i+1)."' id='smf0_c".($i+1)."' value=''></td>"; }
	}

	if ($belimina!="")	{$ctabla .= "<td>&nbsp;</td>";}
	if ($bseleccionar!="")	{$ctabla .= "<td>&nbsp;</td>";}
	$ctabla .= "</tr>";
	$i = count($smcampos);
	$lng=0;
	for ($x=1; $x<=count($mat); $x++){
		$lng++;
		$ctabla.="<tr id='SMFila".$lng."'>";
		$ctabla .= "<td class='visible-*-inline' id='n".$lng."'>$lng</td>";
		for ($j=0; $j<$i; $j++) {
			$valor=$mat[$x][$j];
			if ($smtipos[$j]=="hidden"){
				$ctabla .= "<td><input type='hidden' name='smf".$lng."_c".($j+1)."' id='smf".$lng."_c".($j+1)."' value='".$valor."'></td>";
			} else {
				$ctabla .= "<td><input type='text'   name='smf".$lng."_c".($j+1)."' id='smf".$lng."_c".($j+1)."' value='".$valor."' size='".$smancho[$j]."' style='text-align:".$align[$j]."'  ".$smeditable[$j]."  onChange='".$evt_onChange."'></td>";
			}
		}
		if ($bseleccionar!="") {
			$ctabla .= "<td><input type='button' class='visible-*-inline' name='BotonS".$lng."' id='BotonS".$lng."' value='S' onClick='seleccionacelda(".$lng.",".($j+1).",".$nombregrid.");'></td>";
		}
		if ($belimina!="") {
			$ctabla .= "<td><input type='button' class='visible-*-inline' name='BotonE".$lng."' id='BotonE".$lng."' value='X' onclick='eliminacelda(".$lng.",".($j+1).",\"".$nombregrid."\",\"$evt_elimina\");'></td>";
		}
		$ctabla.="</tr>";
	}
	$clinea = "<input type='hidden' name='smlineagrid' id='smlineagrid' value='".$lng."'>";
	$clinea .="<input type='hidden' name='smcolumnagrid' id='smcolumnagrid' value='".count($smcampos)."'>";
	$clinea .="<input type='hidden' name='smcamposgrid' id='smcamposgrid' value='".$ncampos."'>";
	$ctabla .= "</table>".$clinea;
	return $ctabla;
}

/******************************************************************************/
/*                    Función para la autocarga de Clases                     */
/******************************************************************************/
spl_autoload_register(function($class) {
	$files = array(
		__DIR__.'/../jcapLib/lib/'.strtr($class, '\\', '/').'.php',
		__DIR__.'/../jcaptemplate/'.strtr($class, '\\', '/').'.php'
	);
	foreach ($files as $file) {
		if (file_exists($file)) {
			require $file;
			return true;
		}
	}
});

/******************************************************************************/
/*                          Función útiles de String                          */
/******************************************************************************/
function cortar_palabras_hasta($texto, $tamano) {
	$limite = strlen($texto);
	if ($limite <= $tamano) return $texto;
	while (strlen($texto) > $tamano) {
		$pos = strripos($texto, " ");
		if (false === $pos) {
			$texto = substr($texto, 0, $tamano);
			break;
		}
		$texto = trim(substr($texto, 0, $pos));
	}
	return $texto;
}

function generar_password($caracteres = 8) {
	$letters = 'abcefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ23456789';
	return substr(str_shuffle($letters), 0, $caracteres);
}

/**
	 * Convierte una fecha en un formato especifico
	 * @param string $accion M => retorna un valor en formato DD/MM/YYYY | G => devuelve la fecha en formato Y-m-d en mktime();
	 * @param string $fecha Fecha a convertir
	 * @return string
	 */
	function ConvierteFecha($accion,$fecha)
	{
		if($fecha==""){ return; }
		switch($accion)
		{
			case 'M':
				$f_arr = explode(" ",$fecha);
				$fecha = $f_arr[0];
				if (strpos($fecha,"/")!==false) { $f=explode("/",$fecha); } else { $f=explode("-",$fecha); }
				return "$f[2]/$f[1]/$f[0]";
			break;

			case 'M2':
				if (strpos($fecha,"/") !== false) { $f = explode("/",$fecha); } else { $f = explode("-",$fecha); }
				return "$f[2]-$f[1]-$f[0]";
			break;

			case 'FH':
				if (strpos($fecha,"/")!==false) { $h=explode(" ",$fecha); $f=explode("/",$h[0]); } else { $h=explode(" ",$fecha); $f=explode("-",$h[0]); }
				return "$f[2]-$f[1]-$f[0] " . $h[1];
			break;

			case 'G':
				if (strpos($fecha,"/")!==false) { $f=explode("/",$fecha); } else { $f=explode("-",$fecha); }
				return date("Y-m-d",mktime(0,0,0,$f[1],$f[0],$f[2]));
			break;

			case 'AFH':
				if (strpos($fecha,"/")!==false) { $f=explode("/",$fecha); } else { $f=explode("-",$fecha); }
				$fecha= "$f[2]-$f[1]-$f[0]";
				$hora = date("h").':'.date("i").':'.date("s").' '.date("a");
				return($fecha.' '.$hora);
			break;

			case 'AAAAIMDD': /*---> Para realizar filtros de fecha en Oracle */
				if (strpos($fecha,"/")!==false) { $f=explode("/",$fecha); } else { $f=explode("-",$fecha); }
				$aMeses= array("JAN", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DEC");
				$nDia = $f[0];
				$nMes = ($f[1]-1);
				$nAno = $f[2];
				return $nAno."-".$aMeses[$nMes]."-".$nDia ;
			break;

			case 'DDIMAAAA': /*---> Para realizar filtros de fecha en Oracle */
				if (strpos($fecha,"/")!==false) { $f=explode("/",$fecha); } else { $f=explode("-",$fecha); }
				$aMeses= array("JAN", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DEC");
				$nDia = $f[0];
				$nMes = ($f[1]-1);
				$nAno = $f[2];
				return $nDia."-".$aMeses[$nMes]."-".$nAno ;
			break;

		}
	}

	function FechaOrdenar($pFecha, $pSeparador, $accion)
	{	$pFecha=trim($pFecha);

		if (empty($pFecha))
		{ return ""; }

		if (strpos($pFecha,"/")!==false) { $pSeparador="/"; } else { $pSeparador="-"; }
		if (trim($pFecha)!="")
		{
			if ($accion=='M')
			{   if (strlen($pFecha)>10)
				{
					$vFecha = explode(" ", $pFecha);
					$f = explode('-', $vFecha[0]);
					return "$f[2]/$f[1]/$f[0]";
				}
				else
				{
					$f = explode('-', $pFecha);
					return "$f[2]/$f[1]/$f[0]";
				}
			}
			else
			{
				$Hora = "";

				if (strlen($pFecha)>10)
				{
					$vFecha = explode(" ", $pFecha);

					$Fecha = $vFecha[0];
					$Hora = " ".$vFecha[1]." ".$vFecha[2];
				}
				else
				{ $Fecha = $pFecha;	}

				$FechaOrd = explode($pSeparador, $Fecha);
				$FechaOrd = "$FechaOrd[2]/$FechaOrd[1]/$FechaOrd[0]";
				return($FechaOrd.$Hora);
			}
		}
	}

	function desencode($cadena, $lugar="")
	{  
		 if  ($lugar=="")
			 { $trad = array ('"' => '', "&amp;amp;" => "&amp;", "&amp;#209;" => "&#209;", "&amp;#241;" => "&#209;", "&amp;aacute;" => "á", "&amp;eacute;" => "é", "&amp;iacute;" => "í", "&amp;oacute;" => "ó", "&amp;uacute;" => "ú"); }
		 if  ($lugar=="COMBO")
			 { $trad = array ("&amp;amp;" => "&amp;", "&amp;#209;" => "&#209;", "&AMP;#209;" => "&#209;", "&amp;#241;" => "&#209;", "&AMP;#241;" => "&#209;", "&amp;aacute;" => "á", "&amp;eacute;" => "é", "&amp;iacute;" => "í", "&amp;oacute;" => "ó", "&amp;uacute;" => "ú"); }
		 if  ($lugar=="OFICIO")
			 { $trad = array ("&amp;nbsp;" => "&nbsp;",  "&quot;" => "", "&amp;amp;" => "&amp;", "&amp;#209;" => "&#209;", "&AMP;#209;" => "&#209;", "&amp;#241;" => "&#241;", "&AMP;#241;" => "&#241;", "&amp;aacute;" => "á", "&amp;eacute;" => "é", "&amp;iacute;" => "í", "&amp;oacute;" => "ó", "&amp;uacute;" => "ú", "&lt;" => "<", "&gt;" => ">"); }
	
		$trans_tbl = strtr($cadena, $trad) ;
		return $trans_tbl;
	}
	


	/* Librerias Agregadas para Generar Reportes*/
	/**
	* Genera un Separador con titulo
	* @param string $descripcion, $fondo, $letra
	* @return Object division
	*/
	function crear_division($descripcion, $fondo="#999", $letra="#FFFFFF",$p_ancho=20){
		$resto = 100 - $p_ancho;
		$tbl = "<div class=\"division\">$descripcion</div>";
		echo $tbl;
	}
?>