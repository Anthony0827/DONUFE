<?php
include_once('jcap.php');
define("resultado", "");
define("enlace", "");
define("rsdatos","");

if (strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry")!==false) 
	{	$navegador="movil"; 
		$anchocol=28;
	} 
else 
	{ 	$navegador="escritorio"; 
		$anchocol=100;
	}
	
if (empty($_POST["tabla"])) { $tabla=""; } else { $tabla=$_POST["tabla"];}
if (empty($_POST["utf8"])) { $utf8=""; } else { $utf8=$_POST["utf8"];}

if (empty($_POST["sql"])) { $sql=""; } 
else { $sql=$_POST["sql"];

if (strpos(strtoupper($_POST["sql"]),"INCLUDE")!==false)
	{   $include=trim(str_replace("include","",strtolower($_POST["sql"]))); 
		include_once($include);
		$TipoBaseDatos=$jcap_config["basedatos"]["default"]["tipo"];
		$ServBD=$jcap_config["basedatos"]["default"]["host"];
		$BaseDatos=$jcap_config["basedatos"]["default"]["db"];
		$Usuario=$jcap_config["basedatos"]["default"]["user"];
		$clave=$jcap_config["basedatos"]["default"]["pass"];
		$sql="";
	}
}

if (empty($ServBD))
	{
		if (empty($_POST["TipoBaseDatos"])): $TipoBaseDatos=""; else:	$TipoBaseDatos= $_POST["TipoBaseDatos"]; endif;
		if (empty($_POST["ServBD"])): $ServBD=""; else:	$ServBD= $_POST["ServBD"]; endif;
		if (empty($_POST["BaseDatos"])): $BaseDatos=""; else:	$BaseDatos=$_POST["BaseDatos"]; endif;
		if (empty($_POST["Usuario"])): $Usuario=""; else:	$Usuario= $_POST["Usuario"]; endif;
		if (empty($_POST["clave"])): $clave=""; else:	$clave= $_POST["clave"]; endif;
	}

//foreach($_POST as $dessuministro_campo => $valor)	{    $asignacion = "\$" . $dessuministro_campo . "='" . $valor . "';"; eval($asignacion); } 	

function abredatabase($DataBase,$consultaSQL)
{	global $enlace, $TipoBaseDatos, $ServBD, $Usuario, $clave;
    $consultaSQL = str_replace("#","'",$consultaSQL);
    $consultaSQL = str_replace(chr(13)," ",$consultaSQL);
    $consultaSQL = str_replace(chr(9)," ",$consultaSQL);

	//exit();
	if ($TipoBaseDatos=='MySQL'):
		$enlace = mysqli_connect($ServBD, $Usuario, $clave,$DataBase);
		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		} else {
			//echo "Coneccion realizada : ".$DataBase;
		}
		$resultado = mysqli_query($enlace, $consultaSQL);
		return $resultado;
	elseif ($TipoBaseDatos=='MSSQL'):
		$enlace = mssql_connect($ServBD, $Usuario, $clave);
		mssql_select_db($DataBase) ;
		$resultado = mssql_query($consultaSQL) ;
		return $resultado;
	elseif ($TipoBaseDatos=='PG'):
		$enlace = pg_connect('dbname='. $DataBase . ' host=' . $ServBD . ' port=5432 user=' . $Usuario . ' password=' .$clave );
		if (false === $enlace) echo pg_last_error();
		$resultado = pg_query($enlace,$consultaSQL) ;
		return $resultado;
	elseif ($TipoBaseDatos=='ORACLE'):
		$db = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=".$ServBD.")(PORT=1521))(CONNECT_DATA=(SID=".$DataBase.")))";
        $enlace = ocilogon($Usuario,$clave,$db);
		$stmt = ociparse($enlace,$consultaSQL);
		ociexecute($stmt,OCI_DEFAULT);
		return $stmt;
	elseif (empty($TipoBaseDatos)):
		echo "FALTA SELECCIONAR EL TIPO DE BASE DE DATOS";
		exit();
	endif;
}

function dregistro($resu){global $TipoBaseDatos; 
	if ($TipoBaseDatos=='MySQL'): return mysqli_fetch_array($resu); 
	elseif ($TipoBaseDatos=='MSSQL'): return mssql_fetch_array($resu); 
	elseif ($TipoBaseDatos=='PG'): return pg_fetch_array($resu); 
	elseif ($TipoBaseDatos=='ORACLE'): return OCIFetch($resu); 
	endif;
}

function Cant_Registro($cant)
{  
	global $TipoBaseDatos;    
	if ($TipoBaseDatos=='MySQL')
	{return mysqli_num_rows($cant);} 
	elseif ($TipoBaseDatos=='MSSQL')
	{return mssql_num_rows($cant);} 
	elseif ($TipoBaseDatos=='PG')
	{return pg_num_rows($cant);} 
	elseif ($TipoBaseDatos=='ORACLE') 
	{return 1;}
}

function vcampos($conex,$campo)
{
	$pvalor="";
	if (!is_null(ociresult($conex,$campo)))
	{
		$pvalor=ociresult($conex,$campo);
	}
	return $pvalor;
}

function cierradatabase(){   global $enlace, $TipoBaseDatos;    
	global $enlace;
	if ($TipoBaseDatos=='MySQL'): mysqli_close ($enlace); elseif ($TipoBaseDatos=='MSSQL'): mssql_close($enlace); elseif ($TipoBaseDatos=='PG'): 	pg_close($enlace); endif;
}

function encode($cadena){ $trans_tbl = htmlentities($cadena);  return $trans_tbl; }


?> 
<html>
<head>
<title>JCAP- SQL Inserts</title>

</head>
<body>
<form action="" method="post" name="formulario" >
<table width="250px" border="0" class="CelTabla" cellpadding="2" cellspacing="0">
	<tr>
		<td colspan="2" class="tabla_titulo"><strong>Generar SQL Inserts</strong></td>
	</tr>
	<tr class="CelTabla">
		<td nowrap>Servidor BD:</td>
		<td><input type="text" name="ServBD" id="ServBD" class="caja_tex" value="<?php echo $ServBD;?>"></td>
	</tr>
	<tr class="CelTabla">
		<td  nowrap>Tipo BD:</td>
		<td>
			<select name="TipoBaseDatos" id="TipoBaseDatos">
				<option value=""></option>
				<option value="MySQL">MySQL</option>
				<option value="MSSQL">MSSQL</option>
				<option value="PG">PostGres</option>
				<option value="ORACLE">ORACLE</option>
			</select>
		</td>
	</tr>
	<tr>
		<td nowrap>Base Datos:</td>
		<td><input type="text" name="BaseDatos" id="BaseDatos" class="caja_tex" value="<?PHP echo $BaseDatos;?>"></td>
	</tr>
	<tr class="CelTabla">
		<td>Usuario</td>
		<td><input type="text" name="Usuario" id="Usuario" class="caja_tex" value="<?PHP echo $Usuario;?>"></td>
	</tr>
	<tr class="CelTabla">
		<td>clave</td>
		<td><input name="clave" id="clave" class="caja_tex" value="<?PHP echo $clave;?>" type="password"></td>
	</tr>
	<tr class="CelTabla">
		<td>Tabla</td>
		<td><input type="text" name="tabla" class="caja_tex" value="<?PHP echo $tabla;?>"></td>
		<td>utf8_encode</td>
		<td>
			<?php 
			$checked='';
			if ($utf8==1) {
				$checked='checked';
			}
			?>
			<input id="utf8" name="utf8" class="caja_tex" type="checkbox" value="<?PHP echo $utf8;?>" <?PHP echo $checked;?> onChange="if (this.checked==false) {this.value='0'} else {this.value='1'};" ></td>
	</tr>
</table>

<table width="250px" border="0" class="CelTabla" cellpadding="0" cellspacing="0">
	<tr class="CelTabla">
		<td>Cadena SQL</td>
	</tr>
	<tr class="CelTabla">
		<td><textarea Name="sql" class="Caja_tex" cols="<?php echo $anchocol; ?>" rows="10"><?PHP echo $sql; ?></textarea></td>
	</tr>
  <tr>
    <td align="center">
		<input type="submit" name="action" value="Ejecutar" class="BotonesActi">&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="limpiar" value="Reestablecer" onClick="Limpiar()" class="BotonesActi">
	</td>
  </tr>
</table>
</form> 
<?php
$SQLInserts="";
$SQLInsCampos="";
$SQLInsValores="";
if ((!empty($BaseDatos)) && (trim($sql)!=""))
{ 
	$xcant = explode(";", $sql);
	if (count($xcant)>1)
	{$tcant = count($xcant)-1;}
	else
	{$tcant = count($xcant);}
	$contar = 0;
    for ($contar=0; $contar<$tcant; $contar++)
	{
	$i=0; 
	$res=abredatabase($BaseDatos,$xcant[$contar]);
	if ($TipoBaseDatos=='MySQL'){
		if (strpos(strtoupper($xcant[$contar]),'SELECT')!==false) {
			$i = mysqli_num_fields($res);
		}
	} elseif ($TipoBaseDatos=='MSSQL'){ 
		$i = mssql_num_fields($res); 
	} elseif ($TipoBaseDatos=='PG'){
		$i = pg_num_fields($res);
	} elseif ($TipoBaseDatos=='ORACLE'){
		$i = ocinumcols($res); 	
	}
	if ($i>0) { ?>
	<?php if ($contar>0) {?>
	</table>
	<br>
	<?php } 
	if (strpos(strtoupper($xcant[$contar]),'SELECT')!==false) {
			echo "I=$i  -  Cant=".Cant_Registro($res)."<br>";
	}?>
	
	<!--<div style="height:250px; overflow:auto; vertical-align:top;">-->
<table cellpadding="0" cellspacing="0" border="1" width="100%" class="CelTabla">
	<tr class="classSubTitulo" valign="top"><td colspan="<?PHP echo $i; ?>">Tabla Resultante: <?php echo $xcant[$contar] ?></td></tr>
	<tr class="classSubTitulo" valign="top">
	<?PHP 
	$x1 = 0;
	//$Campos[0]="";
	for ($x=0;$x<$i;$x++) { 
		if ($TipoBaseDatos=='MySQL'):
			$info_campo =  mysqli_fetch_field_direct($res, $x);
			$Campos[$x]= $info_campo->name; 
			$SQLInsCampos= $SQLInsCampos . $Campos[$x] . ","; 
			?><td height="19" colspan="1" class="tabla_subt"><div align="Center"><?PHP echo $Campos[$x]; ?></div></td><?PHP 
		elseif ($TipoBaseDatos=='MSSQL'):
			$Campos[$x]= mssql_field_name($res, $x); 
			$SQLInsCampos= $SQLInsCampos . mssql_field_name($res, $x) . ","; 
			?><td height="19" colspan="1" class="tabla_subt"><div align="Center"><?PHP echo mssql_field_name($res, $x); ?></div></td><?PHP 
		elseif ($TipoBaseDatos=='PG'):
			$Campos[$x]= pg_field_name($res, $x); 
			$SQLInsCampos= $SQLInsCampos . pg_field_name($res, $x) . ","; 
			?><td height="19" colspan="1" class="tabla_subt"><div align="Center"><?PHP echo pg_field_name($res, $x); ?></div></td><?PHP 
		elseif ($TipoBaseDatos=='ORACLE'):
			$x1=$x+1;
			$Campos[$x1]= OCIColumnName($res, $x1); 
			$SQLInsCampos= $SQLInsCampos . OCIColumnName($res, $x1) . ","; 
		endif;	
	}
	$x1=$x1+1;
	$SQLInsCampos = substr($SQLInsCampos,0,strlen($SQLInsCampos)-1);
	$SQLInsCampos = "insert into " . $tabla . " (" . $SQLInsCampos . ") values ("; 
	?>
	</tr>
	<?PHP 
	if ($TipoBaseDatos=='ORACLE')
	{ 	
		echo "<tr>";
		for ($x=1;$x<$x1;$x++)
		{
			if ($Campos[$x]!="###")
			{
			echo "<td width='97' class='tabla_subt'><div align='Center'>$Campos[$x]&nbsp;</div></td>";
			}
		}
		echo "</tr>";
		while (dregistro($res))  { ?>
			<tr valign="top" class="CelTabla">
			<?PHP for ($x=1;$x<$x1;$x++) 
			{ 
					if ($Campos[$x]!="###")
					{
				?>
				<td width="97"><?PHP echo vcampos($res,$Campos[$x]); ?>&nbsp;</td>
				<?PHP 
					if ((strtoupper(ocicolumntype($res, $x))=="VARCHAR") or (strtoupper(ocicolumntype($res, $x))=="BPCHAR") or (strtoupper(ocicolumntype($res, $x))=="CHAR") or (strtoupper(ocicolumntype($res, $x))=="DATE"))
						{	$SQLInsValores = $SQLInsValores . "'" . vcampos($res,$Campos[$x]) . "'," ;	}
					else 
						{ $SQLInsValores = $SQLInsValores . encode(vcampos($res,$Campos[$x])) . "," ;	}
					}
			} ?>
			</tr>
			<?PHP
		$SQLInsValores = substr($SQLInsValores,0,strlen($SQLInsValores)-1);
		$SQLInserts=$SQLInserts . $SQLInsCampos . $SQLInsValores . ");" . chr(13) . chr(10);
		$SQLInsValores = "";
		}
		$SQLInserts=$SQLInserts .  chr(13) . chr(10).  chr(13) . chr(10);
		for ($x=1;$x<$x1;$x++)
		{
			$Campos[$x]="###";
		}
	}
	else
	{ 	
		$mysql_data_type_hash = array(
			1=>'tinyint',2=>'smallint',3=>'int',4=>'float',5=>'double',7=>'timestamp',8=>'bigint',
			9=>'mediumint',10=>'date',11=>'time',12=>'datetime',13=>'year',16=>'bit',253=>'varchar',
			254=>'char',246=>'decimal');

		while ($rsdatos=dregistro($res))  { ?>
			<tr valign="top" class="CelTabla">
			<?PHP for ($x=0;$x<count($Campos);$x++) 
			{ 
				//echo $Campos[$x]."<br>";
				if ($Campos[$x]!="###")
				{
			?>
				<td width="97"><?PHP 
					if ($utf8==1){
						echo utf8_encode($rsdatos[$Campos[$x]]); 
					} else {
						echo encode($rsdatos[$Campos[$x]]); 
					}
					?>&nbsp;</td>
				<?PHP 
				if ($TipoBaseDatos=='MySQL'):
					$info_campo = $res->fetch_field_direct($x);
					$tipo=$info_campo->type; 
					if (($tipo==253) or ($tipo==254) or ($tipo==10) or ($tipo==7) or ($tipo==12)){	
						$SQLInsValores = $SQLInsValores . "'" . encode($rsdatos[$Campos[$x]]) . "'," ;	
					} else { 
						$SQLInsValores = $SQLInsValores . encode($rsdatos[$Campos[$x]]) . "," ;	
					}
				elseif ($TipoBaseDatos=='MSSQL'):
					if ((mssql_field_type($res, $x)=="varchar") or (mssql_field_type($res, $x)=="bpchar") or (mssql_field_type($res, $x)=="char") or (mssql_field_type($res, $x)=="date"))
						{	$SQLInsValores = $SQLInsValores . "'" . $rsdatos[$Campos[$x]] . "'," ;	}
					else { $SQLInsValores = $SQLInsValores . encode($rsdatos[$Campos[$x]]) . "," ;	}
				elseif ($TipoBaseDatos=='PG'):
					if ((pg_field_type($res, $x)=="varchar") or (pg_field_type($res, $x)=="bpchar") or (pg_field_type($res, $x)=="char") or (pg_field_type($res, $x)=="date"))
						{	$SQLInsValores = $SQLInsValores . "'" . $rsdatos[$Campos[$x]] . "'," ;	}
					else { if (trim(encode($rsdatos[$Campos[$x]]))=="") { $v_tmp="Null"; } else { $v_tmp=encode($rsdatos[$Campos[$x]]); }
						$SQLInsValores = $SQLInsValores . $v_tmp . "," ;	}
		
				endif; 
				}
			} ?>
		</tr>
		<?PHP
		$SQLInsValores = substr($SQLInsValores,0,strlen($SQLInsValores)-1);
		$SQLInserts=$SQLInserts . $SQLInsCampos . $SQLInsValores . ");" . chr(13) . chr(10);
		$SQLInsValores = "";
		}
		$SQLInserts=$SQLInserts .  chr(13) . chr(10).  chr(13) . chr(10);
		for ($x=0;$x<count($Campos);$x++)
		{
			$Campos[$x]="###";
		}
	}
	cierradatabase();
	}
	}
}

?> 
</table>
<!--</div>-->
<br>
<table class="CelTabla" cellpadding="0" cellspacing="0" border="0">
<tr><td valign="top"><strong>SQL Resultado</strong></td></tr>
<tr><td>
<textarea name="SQLResultante" class="caja_tex" cols="<?php echo $anchocol; ?>" rows="10"><?PHP echo $SQLInserts; ?></textarea>
</td>
</tr>
</table>
</body>
</html>
<script language="javascript">

function RemChrEsp(Text){
	var tText = String(Text.value);
	var Enter = String;
	Enter = Enter.fromCharCode(13) + Enter.fromCharCode(10);
	tText = tText.replace("'","");
	tText = tText.replace('"','');
	tText = tText.replace("`","");
	tText = tText.replace("´","");
	tText = tText.replace(Enter,"");
	tText = tText.replace("^","");
	tText = tText.replace("|","");
	tText = tText.replace("ª","");
	tText = tText.replace("/","");
	Text.value = tText;	
}

var nav4 = window.Event ? true : false;
function acceptNum(evt){
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
var key = nav4 ? evt.which : evt.keyCode;
return (key <= 13 || (key >= 48 && key <= 57));
}
document.getElementById("TipoBaseDatos").value = '<?php echo $TipoBaseDatos ?>';
</script>