<?PHP
include ("config.php") ;
include ("funciones.php") ;
include ("secure.php") ;
?>
<?php
//si no se recibe el formulario y no hay Empleado  para editar, no puede seguir vuelve a la lista.
if (!isset ($_POST['submit']) && (empty($_GET['Identificacion']))){
	header("Location: empl_listado.php");
	exit;
}
?>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="templatemenor.css" media="screen"/>
<meta http-equiv="Content-Type" content="text/html; charset= iso-8859-1">
</head>

<body>
<table width="100%" height="100%" >
<tr>
	<td bgcolor="#FFFFFF" ></td> 
	<td bgcolor="#666666" width="900" height="100" align="center" ><img border="0" alt="AyC Abogados" src="images/banner_ayc_imagen2.png"/></td>
	<td bgcolor="#FFFFFF" ></td> 
</tr>
<tr>
	<td bgcolor="#FFFFFF" ></td> 
	<td bgcolor="#FFFFFF" width="900" align="center" >
<center>
<BR>
<H1>Menu Principal de <B> Empleados </B> [EDITAR]</H1><br>
<BR>

<?php

function validar(){
	$message = "" ;
	if($_POST ['IdProveedor'] == "" ) {
		$message = "Debe seleccionar un Proveedor";
	}elseif($_POST ['Nombre'] == ""){
		$message = "Debe ingresar Nombre del empleado";
//	}elseif($_POST ['Identificacion'] < 1000000 || $_POST ['Identificacion'] > 99999999 ){
//		$message = "Debe ingresar Identificacion son 7 u 8 dígitos";

	}elseif($_POST ['CUIL'] < 10000000000 || $_POST ['CUIL'] > 99999999999 ){
		$message = "Debe ingresar CUIL/CUIT con 11 dígitos";
	}elseif(($_POST ['Condicion'] == "AU") and 
			(($_POST ['SeguroDeVida'] != "NC") or 
			 ($_POST ['ReciboSueldo'] != "NC") or 
			 ($_POST ['Repeticion'] != "NC"))) {
		$message = "No Corresponde Seguro de Vida ni Recibo de Sueldo ni No Repeticion para Autonomos";
	}elseif(($_POST ['Condicion'] == "EM") and 
			(($_POST ['SeguroDeVida'] == "NC") or 
			 ($_POST ['ReciboSueldo'] == "NC") or 
			 ($_POST ['Repeticion'] == "NC"))) {
		$message = "Debe ingresar Seguro de Vida, Recibo de Sueldo y No Repeticion para Empleados";

//   La fecha de vigencia desde es OPTATIVA
	}elseif(($_POST ['VigenciaDesde'] != "") and (!checkdate (
				substr($_POST ['VigenciaDesde'], 3, 2), 
				substr($_POST ['VigenciaDesde'], 0, 2), 
				substr($_POST ['VigenciaDesde'], 6, 4)))){
		$message = "Debe ingresar Vigencia Desde como DD-MM-AAAA";

//   La fecha de vigencia hasta es OBLIGATORIA
	}elseif( (!checkdate (
				substr($_POST ['VigenciaHasta'], 3, 2), 
				substr($_POST ['VigenciaHasta'], 0, 2), 
				substr($_POST ['VigenciaHasta'], 6, 4)))){
		$message = "Debe ingresar Vigencia Hasta como DD-MM-AAAA";
	}
	return $message;
}

//si el formulario ha sido enviado validamos los datos.
if(isset ($_POST['submit'])) {
	//valida los datos del formulario.
	$message = validar() ;
	//si los datos son validos editamos el registro.
	if($message != "") {
	}else{
		//nos conectamos a mysql
		$cnx = conectar () ;
		$sql  = "UPDATE empleadosAR SET ";
		$sql .= "IdProveedor = '" . $_POST ['IdProveedor'] . "' , ";
//		$sql .= "Nombre = '" . $_POST ['Nombre'] . "' , ";
		$sql .= "Nombre = '" . mysql_real_escape_string ($_POST ['Nombre']) . "' , ";
//		$sql .= "Identificacion = '" . $_POST ['Identificacion'] . "' , ";
		$sql .= "CUIL = '" . $_POST ['CUIL'] . "' , ";
		$sql .= "Condicion = '" . $_POST ['Condicion'] . "' , ";
		$sql .= "F931 = '" . $_POST ['F931'] . "' , ";
		$sql .= "Poliza = '" . $_POST ['Poliza'] . "' , ";
		$sql .= "VigenciaDesde = '" . substr($_POST ['VigenciaDesde'], 6, 4) . "-" ; 
		$sql .=                       substr($_POST ['VigenciaDesde'], 3, 2) . "-" ;  
		$sql .=                       substr($_POST ['VigenciaDesde'], 0, 2) . "' , ";
		$sql .= "VigenciaHasta = '" . substr($_POST ['VigenciaHasta'], 6, 4) . "-" ; 
		$sql .=                       substr($_POST ['VigenciaHasta'], 3, 2) . "-" ;  
		$sql .=                       substr($_POST ['VigenciaHasta'], 0, 2) . "' , ";
		$sql .= "SeguroDeVida = '" . $_POST ['SeguroDeVida'] . "' , ";
		$sql .= "ReciboSueldo = '" . $_POST ['ReciboSueldo'] . "' , ";
		$sql .= "Repeticion = '" . $_POST ['Repeticion'] . "' , ";
		$sql .= "Indemnidad = '" . $_POST ['Indemnidad'] . "' , ";
		$sql .= "Responsable = '" . $_POST ['Responsable'] . "'   ";
		$sql .= " WHERE Identificacion='". $_POST['Identificacion'] . "'";
		$res= mysql_query($sql);// or die (mysql_error() ) ;
		
		if (mysql_errno() !=0 ) {
			$message  = "<BR>Asegurese de no repetir el Identificacion del empleado " ;
			$message .= "\n<BR><!--" ;
			$message .= "\n<BR>mysql_errno " . mysql_errno() ;
			$message .= "\n<BR>mysql_error " . mysql_error() ;
			$message .= "\n<BR>query " . $sql ;
			$message .= "\n<BR>-->" ;
			$message .= "<BR>" ;
		} else {
			echo "El empleado ". $_POST['Identificacion'] ." ha sido editado";
			echo "<br><a href='empl_listado.php'><img border=\"0\" alt=\"volver\" src=\"images/volver.gif\"/></a>" ;
			mysql_close($cnx) ;
			exit;
		}
	}
	$Identificacion = $_POST['Identificacion'] ;
}else{
	$Identificacion = $_GET['Identificacion'] ;
}
?> 
<?php
//Arma los valores por defecto para mostrar en el formulario
//si el formulario ha sido enviado y llega hasta aqui es porque hay errores.
if(isset ($_POST['submit'])) {
	//Arma el combo para seleccionar Proveedor
	$IdEmpresa = $_POST ['IdEmpresa'] ;
	$ComboProveedores = ComboProveedores($IdEmpresa, $_POST ['IdProveedor']) ;
	$Nombre = $_POST ['Nombre'] ;
//	$Identificacion = $_POST ['Identificacion'] ;
	$CUIL = $_POST ['CUIL'] ;
	$Condicion = comboCondicion($_POST ['Condicion'] ) ;
	$F931 = comboSiNo($_POST ['F931'] ) ;
	$Poliza = comboSiNo($_POST ['Poliza'] ) ;
	$VigenciaDesde = $_POST ['VigenciaDesde'] ;
	$VigenciaHasta = $_POST ['VigenciaHasta'] ;
	$SeguroDeVida = comboSiNoNc($_POST ['SeguroDeVida'] ) ;
	$ReciboSueldo = comboSiNoNc($_POST ['ReciboSueldo'] ) ;
	$Repeticion = comboSiNoNc($_POST ['Repeticion'] ) ;
	$Indemnidad = comboSiNo($_POST ['Indemnidad'] ) ;
	$Responsable = $_POST ['Responsable'] ;
}else{
	//nos conectamos a mysql
	$cnx = conectar();
	//consulta para mostrar los datos.
	$sql  = "SELECT L.*, P.IdEmpresa " ;
	$sql .= "FROM empleadosAR L " ;
	$sql .= "INNER JOIN proveedores P ON L.IdProveedor = P.IdProveedor " ;
	$sql .= "WHERE L.Identificacion='". $Identificacion . "'";
	$res= mysql_query($sql) or die (mysql_error());
	if ( mysql_num_rows($res) >0) {
	//si hay resultados hacemos el formulario.
		$fila = mysql_fetch_array($res) ;
		//Arma el combo para seleccionar Proveedor
		$IdEmpresa = $fila ['IdEmpresa'] ;
		$ComboProveedores = ComboProveedores($IdEmpresa, $fila ['IdProveedor']) ;
		$Nombre = $fila['Nombre'] ;
//		$Identificacion = $fila['Identificacion'] ;
		$CUIL = $fila['CUIL'] ;
		$Condicion = comboCondicion($fila['Condicion']) ;
		$F931 = comboSiNo($fila['F931']) ;
		$Poliza = comboSiNo($fila['Poliza']) ;
		$VigenciaDesde  = fecha_dma($fila ['VigenciaDesde']) ;
		$VigenciaHasta  = fecha_dma($fila ['VigenciaHasta']) ;
		$SeguroDeVida = comboSiNoNc($fila['SeguroDeVida']) ;
		$ReciboSueldo = comboSiNoNc($fila['ReciboSueldo']) ;
		$Repeticion = comboSiNoNc($fila['Repeticion']) ;
		$Indemnidad = comboSiNo($fila['Indemnidad']) ;
		$Responsable = $fila['Responsable'] ;
	}
}
?> 
<?php
if(isset ($_POST['submit']) || ( mysql_num_rows($res) >0)) {
//si hay resultados o ha habido errores, hacemos el formulario.
?>

<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table width="500" border="1" cellpadding="0" cellspacing="0">

<tr>
<td height="24" COLSPAN="6" ALIGN="center"> <i><NOBR>
<DIV STYLE="background-color:yellow">
<?PHP
//revisa si hay mensajes de error.
if ($message) {
echo $message;
} ?>
</NOBR></i>
</DIV>
</td>
</tr>

<tr>
<td width="200">*Proveedor</td>
<td width="300"><?php echo $ComboProveedores ; ?></td>
</tr>
<tr>
<td width="200">*Nombre</td>
<td width="300"><input name="Nombre" type="text" id="Nombre" value="<?php echo $Nombre ; ?>"></td>
</tr>
<tr>
<td width="200">Identificacion<input name="Identificacion" type="hidden" id="Identificacion" value="<?php echo $Identificacion ; ?>"></td>
<td width="300"><?php echo $Identificacion ; ?></td>
</tr>
<tr>
<td width="200">*CUIL/CUIT</td>
<td width="300"><input name="CUIL" type="text" id="CUIL" value="<?php echo $CUIL ; ?>"></td>
</tr>
<tr>
<td width="200">Condicion</td>
<td width="300"><select name= "Condicion"><?php echo $Condicion ; ?></select></td>
</tr>
<tr>
<td width="200">F931/AFIP</td>
<td width="300"><select name= "F931"><?php echo $F931 ; ?></select></td>
</tr>
<tr>
<td width="200">ART/ACC. Personales</td>
<td width="300"><select name= "Poliza"><?php echo $Poliza ; ?></select></td>
</tr>
<tr>
<td width="200">Vigencia Desde</td>
<td width="300"><input name="VigenciaDesde" type="text" id="VigenciaDesde" value="<?php echo $VigenciaDesde ; ?>"></td>
</tr>
<tr>
<td width="200">Vigencia Hasta</td>
<td width="300"><input name="VigenciaHasta" type="text" id="VigenciaHasta" value="<?php echo $VigenciaHasta ; ?>"></td>
</tr>
<tr>
<td width="200">Seguro de Vida</td>
<td width="300"><select name= "SeguroDeVida"><?php echo $SeguroDeVida ; ?></select></td>
</tr>
<tr>
<td width="200">Recibo Sueldo</td>
<td width="300"><select name= "ReciboSueldo"><?php echo $ReciboSueldo ; ?></select></td>
</tr>
<tr>
<td width="200">No Repeticion</td>
<td width="300"><select name= "Repeticion"><?php echo $Repeticion ; ?></select></td>
</tr>
<tr>
<td width="200">Indemnidad</td>
<td width="300"><select name= "Indemnidad"><?php echo $Indemnidad ; ?></select></td>
</tr>
<tr>
<td width="200">Responsable</td>
<td width="300"><input name="Responsable" type="text" id="Responsable" value="<?php echo $Responsable ; ?>"></td>
</tr>

<tr>
<td width="200" align='left'><a href='empl_listado.php'><img border="0" alt="volver" src="images/volver.gif"/></a></td>
<td width="300" align="right">
	<input type="hidden" name="IdEmpresa" id="IdEmpresa" value="<?php echo $IdEmpresa ; ?>">
	<input type="hidden" name="submit" value="enviar">
	<input type="image" src="images/enviar.gif" alt="enviar">
</td>
</tr>

</table>
</form>
<?php
}else{
	//no hay resultados, id malo o no existe
	echo "no se obtuvieron resultados";
}
mysql_close ($cnx) ;
?>
<BR>
<BR>
<a href="salir.php"><img border="0" alt="salir" src="images/salir.gif"/></a>
</center>
</td>
  <td bgcolor="#FFFFFF" ></td>
</tr>
</table>
</body>
</html>
