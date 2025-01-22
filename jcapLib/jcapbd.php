<?php
/**
 * Clase Abstracta que definen el patrón para las funciones de conexion a las diferentes bases de datos.
 */
abstract class ConexionBD {
	static $CLASES = array("mysql" => "ConexionMySQL", "pgsql" => "ConexionPgSQL");

	protected $_enlace;
	protected $_parametros = array();
	protected $_tempid;

	/**
	 * Función para inicializar los parametros de conexion a la base de datos
	 */
	protected function init($nombre) {
		global $jcap_config;
		if (!empty($nombre) && array_key_exists($nombre, $jcap_config["basedatos"])) {
			$this->_parametros = $jcap_config["basedatos"][$nombre];
			$this->_parametros["raiz"] = $jcap_config["raiz"];
			$this->_enlace = $this->conectar();
		} else {
			throw new Exception("No existen parametros de configuración para la base de datos $nombre", 1);
		}
		$this->_tempid = null;
	}

	/**
	 * Función para el manejo de los errores de base de datos
	 */
	protected function manejarErrorBd($err, $sql_error) {
		global $idusuario, $jcap_config, $nombre_menu_programa;
		//echo $sql_error;
		$nmp = explode("/",trim($_SERVER['PHP_SELF']));
		$nombre_menu_programa = $nmp[count($nmp)-1];
		$men_error = "BD: ".$this->_parametros["db"]." \n";
		$men_error .= "PHP: ".$_SERVER['PHP_SELF']. " \n";
		$men_error .= "IP: ".$_SERVER['REMOTE_ADDR']. " \n";
		$men_error .= "nombre_menu_programa: ". base64_decode(@$_SESSION["nombre_menu_programa"]). " \n";
		$men_error .= "idusuario: ".@$idusuario. " \n";
		$men_error .= "Query: ".$sql_error. " \n";
		$men_error .= "Error: ".$err. " \n";
		crear_msg("Ha ocurrido un error al intentar ejecutar la consulta.", true);
		if ($jcap_config['debug'] === true) {
			echo "<pre>" . $men_error . "</pre>";
		} else {
			mail("soporte@jcap.com.ve", "Error en ".$nombre_menu_programa . " " . date("d/m/Y H:i"), $men_error);
		}
		$nombre = "err_".$nombre_menu_programa."_".date("dmY"). "_". date("Hi").".txt";
		$path = "{$this->_parametros["raiz"]}/_log_sucesos/";
		if (is_writable($path)) {
			escribirtxt("{$path}{$nombre}", $men_error);
		}
	}

	protected function auditoria($sSQL) {
		global $idusuario;
		/*try {
			$this->_tempid = $this->getUltimoId();
		} catch (Exception $e) {
			$this->_tempid = null;
		}*/
		if ($idusuario == "") {  $idusuario = @$_REQUEST["idusuario"];  }
		$aSQL = explode(" ",$sSQL);
		$sAccion="";
		if (strtolower($aSQL[0]) == "insert") {
			$sTabla = $aSQL[2];
			$sAccion = "Agregar";
		} elseif (strtolower($aSQL[0])=="update") {
			$sTabla = $aSQL[1];
			$sAccion = "Modificar";
		} elseif (strtolower($aSQL[0])=="delete") {
			$sTabla = $aSQL[2];
			$sAccion = "Eliminar";
		}
		$sSQL=str_replace("'","",$sSQL);

		if (($sAccion != "") && ($sTabla != "jcap_usuario_ticket")) {
			$num_idusuario = $idusuario;
			if ($num_idusuario == "") { $num_idusuario=1; }
			$sSQL = html_encode($sSQL);
			$StrSQL= "insert into jcap_auditoria (fecha,tabla,ip,accion,idusuario,descripcion)
					values ('". FechaHora::fechaSistema(FechaHora::FECHAHORA_SQL) ."','".$sTabla."','".@$_SERVER['REMOTE_ADDR'] ."','".$sAccion."','". $num_idusuario ."','".$sSQL."')";
			$obj = self::crear("auditoria");
			$resultado = $obj->ejecutarSinAuditoria($StrSQL);
		}
	}

	static function crear($nombre) {
		global $jcap_config;
		if (empty($nombre)) {
			throw new Exception("Debe especificar un el nombre de una conexión de base de datos, ver archivo .conf", 1);
		} elseif (array_key_exists($nombre, $jcap_config["basedatos"])) { 
			$p = $jcap_config["basedatos"][$nombre];
			if (array_key_exists($p['tipo'], self::$CLASES)) { // Crear el objeto
				$rc = new ReflectionClass(self::$CLASES[$p['tipo']]);
				return $rc->newInstance($nombre);
			} else {
				throw new Exception("No existen funciones definidas para este tipo de base de datos: {$p['tipo']}", 1);
			}
		}
	}
	abstract protected function conectar();
	abstract function ejecutar($sql);
	abstract protected function ejecutarSinAuditoria($sql);
	abstract function desconectar();
	abstract function iniciarTransaccion();
	abstract function terminarTransaccion();
	abstract function abortarTransaccion();
	abstract function getUltimoId($secuencia = "");
}

/**
 * Clase abstracta para la obtencion de resultados de una consulta SQL
 */
abstract class Resultados {
	protected $_resource;

	abstract function proximo();
	abstract function get($pos);
	abstract function todos();
	abstract function getTipoDato($pos);
	abstract function getCantColumnas();
	abstract function getCantRegistros();
	abstract function getNombreCampo($pos);
	abstract function limpiar();
}

/**
 * Clase concreta de conexion a base de datos PostgreSQL
 */
class ConexionPgSQL extends ConexionBD {

	function __construct($nombre) {
		if (empty($nombre)) {
			throw new Exception("Debe especificar un el nombre de una conexión de base de datos, ver archivo .conf", 1);
		} else {
			$this->init($nombre);
		}
	}

	protected function conectar() {
		$host = $this->_parametros['host'];
		$port = $this->_parametros['port'];
		$db = $this->_parametros['db'];
		$user = $this->_parametros['user'];
		$pass = $this->_parametros['pass'];
		$con = pg_connect("dbname=$db host=$host port=$port user=$user password=$pass");
		if ($con === false) {
			throw new Exception("Error de conexión a base de datos", 1);
		} else {
			return $con;
		}
	}

	function desconectar() {
		return pg_close($this->_enlace);
	}

	function ejecutar($sql) {
		$resultado =  pg_query($this->_enlace, $sql);
		if ($resultado === false) {
			$error = pg_last_error();
			$this->manejarErrorBd($error, $sql);
			throw new Exception("Error al intentar ejecutar la consulta: $error", 1);
		} else {
			$this->auditoria($sql);
			return new ResultadosPgSQL($resultado);
		}
	}

	protected function ejecutarSinAuditoria($sql) {
		$resultado =  pg_query($this->_enlace, $sql);
		if ($resultado === false) {
			$error = pg_last_error();
			$this->manejarErrorBd($error, $sql);
			throw new Exception("Error al intentar ejecutar la consulta: $error", 1);
		} else {
			return new ResultadosPgSQL($resultado);
		}
	}

	function iniciarTransaccion() {
		$resultado = pg_query($this->_enlace, "BEGIN");
		if ($resultado === false) {
			$error = pg_last_error();
			$this->manejarErrorBd($error, "BEGIN");
			throw new Exception("Error al intentar ejecutar la consulta: $error", 1);
		} else {
			return $resultado;
		}
	}

	function terminarTransaccion() {
		$resultado = pg_query($this->_enlace, "COMMIT");
		if ($resultado === false) {
			$error = pg_last_error();
			$this->manejarErrorBd($error, "COMMIT");
			throw new Exception("Error al intentar ejecutar la consulta: $error", 1);
		} else {
			return $resultado;
		}
	}

	function abortarTransaccion() {
		$resultado = pg_query($this->_enlace, "ROLLBACK");
		if ($resultado === false) {
			$error = pg_last_error();
			$this->manejarErrorBd($error, "ROLLBACK");
			throw new Exception("Error al intentar ejecutar la consulta: $error", 1);
		} else {
			return $resultado;
		}
	}

	function getUltimoId($secuencia = ""){
		if (empty($secuencia)) {
			// Si hay un _tempid guardado por auditoria, entonces devuelve ese resultado
			if (!empty($this->_tempid)) return $this->_tempid;
			$sql = "SELECT lastval() as id;";
		} else {
			$sql = "SELECT currval('$secuencia') as id;";
		}
		$resultado = pg_query($this->_enlace, $sql);
		if ($resultado === false) {
			$error = pg_last_error();
			$this->manejarErrorBd($error, $sql);
			throw new Exception("Error al intentar ejecutar la consulta: $error", 1);
		} else {
			$rs = pg_fetch_array($resultado);
			return $rs === false ? $rs : $rs['id'];
		}
	}
}

/**
 * Clase concreta para los resultados de consultas realizadas a base de datos PostgreSQL
 */
class ResultadosPgSQL extends Resultados {
	function __construct($resource) {
		if (is_resource($resource)) {
			$this->_resource = $resource;
		} else {
			throw new Exception("Este parámetro no es un recurso de base de datos válido", 1);
		}
	}

	function proximo() {
		return pg_fetch_array($this->_resource);
	}

	function get($pos) {
		return pg_fetch_array($this->_resource, $pos);
	}

	function todos() {
		return pg_fetch_all($this->_resource);
	}

	function getTipoDato($pos) {
		return pg_field_type($this->_resource, $pos);
	}

	function getCantColumnas() {
		return pg_num_fields($this->_resource);
	}

	function getCantRegistros() {
		return pg_num_rows($this->_resource);
	}

	function getNombreCampo($pos) {
		return pg_field_name($this->_resource, $pos);
	}

	function limpiar() {
		return pg_free_result($this->_resource);
	}
}

/**
 * Clase concreta para conexión a bases de datos MySQL
 */
class ConexionMySQL extends ConexionBD {
	function __construct($nombre) {
		if (empty($nombre)) {
			throw new Exception("Debe especificar un el nombre de una conexión de base de datos, ver archivo .conf", 1);
		} else {
			$this->init($nombre);
		}
	}

	protected function conectar() {
		$host = $this->_parametros['host'];
		$port = $this->_parametros['port'];
		$db = $this->_parametros['db'];
		$user = $this->_parametros['user'];
		$pass = $this->_parametros['pass'];
		$con = new mysqli($host, $user, $pass, $db);
		if ($con->connect_errno) {
			throw new Exception("Error de conexión a base de datos ({$mysqli->connect_errno}): {$mysqli->connect_error}", 1);
		} else {
			return $con;
		}
	}

	function desconectar() {}

	function ejecutar($sql) {
		$resultado = $this->_enlace->query($sql);
		if ($resultado === false) {
			$error = $this->_enlace->error;
			$this->manejarErrorBd($error, $sql);
			throw new Exception("Error al intentar ejecutar la consulta: $error", 1);
		} else {
			$this->auditoria($sql);
			return $resultado === true ? $resultado : new ResultadosMySQL($resultado);
		}
	}

	protected function ejecutarSinAuditoria($sql) {
		$resultado = $this->_enlace->query($sql);
		if ($resultado === false) {
			$error = $this->_enlace->error;
			$this->manejarErrorBd($error, $sql);
			throw new Exception("Error al intentar ejecutar la consulta: $error", 1);
		} else {
			return $resultado === true ? $resultado : new ResultadosMySQL($resultado);
		}
	}

	function iniciarTransaccion() {
		$resultado = $this->_enlace->query('START TRANSACTION;');
		if ($resultado === false) {
			$error = $this->_enlace->error;
			$this->manejarErrorBd($error, 'START TRANSACTION;');
			throw new Exception("Error al intentar ejecutar la consulta: $error", 1);
		} else {
			return $resultado;
		}
	}

	function terminarTransaccion() {
		$resultado = $this->_enlace->query('COMMIT');
		if ($resultado === false) {
			$error = $this->_enlace->error;
			$this->manejarErrorBd($error, 'COMMIT');
			throw new Exception("Error al intentar ejecutar la consulta: $error", 1);
		} else {
			return $resultado;
		}
	}

	function abortarTransaccion() {
		$resultado = $this->_enlace->query('ROLLBACK');
		if ($resultado === false) {
			$error = $this->_enlace->error;
			$this->manejarErrorBd($error, 'ROLLBACK');
			throw new Exception("Error al intentar ejecutar la consulta: $error", 1);
		} else {
			return $resultado;
		}
	}

	function getUltimoId($secuencia = "") {
		$id = empty($this->_tempid) ? $this->_enlace->insert_id : $this->_tempid;
		return $id;
	}
}

/**
 * Clase concreta para los resultados de consultas realizadas a base de datos MySQL
 */
class ResultadosMySQL extends Resultados {
	function __construct($resource) {
		if ($resource instanceof mysqli_result) {
			$this->_resource = $resource;
		} else {
			throw new Exception("Este parámetro no es un objeto de resultados mysqli válido", 1);
		}
	}

	function proximo() {
		return $this->_resource->fetch_assoc();
	}

	function get($pos) {
		$this->_resource->data_seek($pos);
		return $this->_resource->fetch_assoc();
	}

	function todos() {
		$todos = array();
		while ($rs = $this->_resource->fetch_assoc()) $todos[] = $rs;
		return $todos;
	}

	function getTipoDato($pos) {
		$obj = $this->_resource->fetch_field_direct($pos);
		return $obj->type;
	}

	function getCantColumnas() {
		return $this->_resource->field_count;
	}

	function getCantRegistros() {
		return $this->_resource->num_rows;
	}

	function getNombreCampo($pos) {
		$obj = $this->_resource->fetch_field_direct($pos);
		return $obj->name;
	}

	function limpiar() {
		return $this->_resource->free();
	}
}
//echo "bien";
?>