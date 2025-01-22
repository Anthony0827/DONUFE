<?php if (empty($boton_generico))		{ $boton_generico=false; } ?>
<table width="100%" border="0" cellpadding="0" cellspacing="1"  align="center">
	<tr>
		<td colspan="9" align="center">
			<input type="hidden" id="accion" value="" name="accion">
			<input type="hidden" name="campo_orden_tabla" id="campo_orden_tabla" value="">
			<input type="hidden" name="campo_orden_tabla_asc" id="campo_orden_tabla_asc" value="desc">			
			<table width="450px" border="0" cellpadding="0" cellspacing="1" align="center">
				<tr>
					<?php if ($boton_generico) {?>
						<td align="center"><?php input_boton("bGenerico", $boton_generico_nombre, "javascript:".$boton_generico_accion."", "disabled"); ?></td>
					<?php } ?>
					<td><a id="bGuardar" onClick="enviar('Grabar');Esconde_Muestra_Celda('tblestructura');Esconde_Muestra_Celda('tbldatos');" data-role="button" data-icon="check"  data-mini="true" data-inline="true" data-iconpos="right" data-theme="b">Guardar</a></td>
					<td><a id="bAnular" onClick="enviar('Eliminar');Esconde_Muestra_Celda('tblestructura');Esconde_Muestra_Celda('tbldatos');" data-role="button" data-icon="delete" disabled  data-mini="true" data-inline="true" data-iconpos="right" data-theme="b">Anular</a></td>
					<td><a id="bRestablecer" onClick="LimpiarTodo();" data-role="button" data-icon="forward" disabled  data-mini="true" data-inline="true" data-iconpos="right" data-theme="b">Limpiar</a></td>
					<td><a id="bVisual" onClick="enviar('MostrarDatos');Esconde_Muestra_Celda('tblestructura');Esconde_Muestra_Celda('tbldatos');" data-role="button" data-icon="grid" disabled  data-mini="true" data-inline="true" data-iconpos="right" data-theme="b">Ver Todos</a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script type="text/javascript" language="javascript" src="../jcapLib/jcap.js"></script>
<script type="text/javascript" language="javascript"> 
function on_off_Boton()
{ 	var acc = document.getElementById("accion");
	var bGuardar = document.getElementById("bGuardar");
	var bAnular = document.getElementById("bAnular");
	if (acc.value!="Grabar") {	
		bAnular.disabled="";			
	} else {	
		bAnular.disabled="disabled";	
	}
}

function off_Boton()
{ 	var acc = document.getElementById("accion");
	var bGuardar = document.getElementById("bGuardar");
	var bAnular = document.getElementById("bAnular");
	bGuardar.disabled="disabled";	
	bAnular.disabled="disabled";	
}
</script>