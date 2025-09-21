<?PHP
include ("config.php") ;
include ("funciones.php") ;
include ("secure.php") ;
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
	<td bgcolor="#FFFFFF" width="900" height="100" align="center" ><img border="0" alt="AyC Abogados" src="images/banner_ayc_imagen2.png"/></td>
	<td bgcolor="#FFFFFF" ></td> 
</tr>
<tr>
	<td bgcolor="#FFFFFF" ></td> 
	<td bgcolor="#FFFFFF" width="900" align="center" >
<center>
<BR>
<H1>Menu Principal de <B> Empleados </B> [NUEVO]</H1><br>
<BR>

<?php
// Se guarda la empresa recibida desde la pagina anterior para filtrar los proveedores
if(isset ($_GET['IdEmpresa'])) {
	$IdEmpresa = $_GET['IdEmpresa'] ;
}
// Se guarda la empresa recibida desde el envio anterior del formulario para filtrar los proveedores
if(isset ($_POST['IdEmpresa'])) {
	$IdEmpresa = $_POST['IdEmpresa'] ;
}

function validar(){
	$message = "" ;
	if($_POST ['IdProveedor'] == "" ) {
		$message = "Debe seleccionar un Proveedor";
	}elseif($_POST ['Nombre'] == ""){
		$message = "Debe ingresar Nombre del empleado";
	}elseif($_POST ['Identificacion'] < 1000000 || $_POST ['Identificacion'] > 99999999 ){
		$message = "Debe ingresar Identificacion son 7 u 8 dígitos";
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
		//nos cnnectamos a mysql
		$cnx = conectar ();
		$campos   = "IdProveedor, Nombre, Identificacion, CUIL, Condicion, F931, Poliza, " ;
		$campos  .= "VigenciaDesde, VigenciaHasta, " ;
		$campos  .= "SeguroDeVida, ReciboSueldo, Repeticion, Indemnidad, Responsable " ;
		$valores  = "";
		$valores .= "'" . $_POST ['IdProveedor'] . "' , ";
		$valores .= "'" . mysql_real_escape_string ($_POST ['Nombre']) . "' , ";
		$valores .= "'" . $_POST ['Identificacion'] . "' , ";
		$valores .= "'" . $_POST ['CUIL'] . "' , ";
		$valores .= "'" . $_POST ['Condicion'] . "' , ";
		$valores .= "'" . $_POST ['F931'] . "' , ";
		$valores .= "'" . $_POST ['Poliza'] . "' , ";
		$valores .= "'" . substr($_POST ['VigenciaDesde'], 6, 4) . "-" ; 
		$valores .=       substr($_POST ['VigenciaDesde'], 3, 2) . "-" ;  
		$valores .=       substr($_POST ['VigenciaDesde'], 0, 2) . "' , ";
		$valores .= "'" . substr($_POST ['VigenciaHasta'], 6, 4) . "-" ; 
		$valores .=       substr($_POST ['VigenciaHasta'], 3, 2) . "-" ;  
		$valores .=       substr($_POST ['VigenciaHasta'], 0, 2) . "' , ";
		$valores .= "'" . $_POST ['SeguroDeVida'] . "' , ";
		$valores .= "'" . $_POST ['ReciboSueldo'] . "' , ";
		$valores .= "'" . $_POST ['Repeticion'] . "' , ";
		$valores .= "'" . $_POST ['Indemnidad'] . "' , ";
		$valores .= "'" . $_POST ['Responsable'] . "'   ";
		$sql = "INSERT INTO empleadosAR (" . $campos . ") VALUES (" . $valores . ") ";
//		$sql = mysql_real_escape_string ($sql);
		$res = mysql_query ($sql);// or die (mysql_error() ) ;
		
		if (mysql_errno() !=0 ) {
			$message  = "<BR>Asegurese de no repetir el Identificacion del emleado " ;
			$message .= "\n<BR><!--" ;
			$message .= "\n<BR>mysql_errno " . mysql_errno() ;
			$message .= "\n<BR>mysql_error " . mysql_error() ;
			$message .= "\n<BR>query " . $sql ;
			$message .= "\n<BR>-->" ;
			$message .= "<BR>" ;
		} else {
			echo "El empleado con Identificacion ". $_POST['Identificacion'] ." ha sido agregado";
			echo "<br><a href='empl_listado.php'><img border=\"0\" alt=\"volver\" src=\"images/volver.gif\"/></a>" ;
			mysql_close($cnx) ;
			exit;
		}
	}
}
?>
<?php
//Arma los valores por defecto para mostrar en el formulario
//si el formulario ha sido enviado y llega hasta aqui es porque hay errores.
if(isset ($_POST['submit'])) {
	//Arma el combo para seleccionar Proveedor
	$ComboProveedores = ComboProveedores($IdEmpresa, $_POST ['IdProveedor']) ;
	$Nombre = $_POST ['Nombre'] ;
	$Identificacion = $_POST ['Identificacion'] ;
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
	//Arma el combo para seleccionar Proveedor
	$ComboProveedores = ComboProveedores($IdEmpresa, '') ;
	$Nombre = '' ;
	$Identificacion = '' ;
	$CUIL = '' ;
	$Condicion = comboCondicion("EMPLEADO") ;
	$F931 = comboSiNo("SI") ;
	$Poliza = comboSiNo("NO") ;
	$VigenciaDesde = '' ;
	$VigenciaHasta = '' ;
	$SeguroDeVida = comboSiNoNc("SI") ;
	$ReciboSueldo = comboSiNoNc("SI") ;
	$Repeticion = comboSiNoNc("SI") ;
	$Indemnidad = comboSiNo("SI") ;
	$Responsable = '' ;
}
?> 

<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ; ?> ">
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
<td width="200">*Identificacion</td>
<td width="300"><input name="Identificacion" type="text" id="Identificacion" value="<?php echo $Identificacion ; ?>"></td>
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
