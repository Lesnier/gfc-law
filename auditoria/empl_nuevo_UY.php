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

	}elseif(($_POST ['Condicion'] == "UN") and 
			 ($_POST ['ReciboSueldo'] != "NC")) {
		$message = "No Corresponde Recibo de Sueldo para Unipersonales";
	}elseif(($_POST ['Condicion'] == "EM") and 
			 ($_POST ['ReciboSueldo'] == "NC")) { 
		$message = "Debe ingresar Recibo de Sueldo para Empleados";

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
		$campos   = "IdProveedor, Nombre, Identificacion, Condicion, " ;
		$campos  .= "BPS, BPS_Ultimo_Pago, BSE_certificado, BSE_pago_periodo, DGI, DGI_Ultimo_Pago, MTSS, ";
		$campos  .= "VigenciaDesde, VigenciaHasta, " ;
		$campos  .= "ReciboSueldo, Indemnidad, Responsable " ;
		$valores  = "";
		$valores .= "'" . $_POST ['IdProveedor'] . "' , ";
		$valores .= "'" . mysql_real_escape_string ($_POST ['Nombre']) . "' , ";
		$valores .= "'" . $_POST ['Identificacion'] . "' , ";
		$valores .= "'" . $_POST ['Condicion'] . "' , ";
		$valores .= "'" . $_POST ['BPS'] . "' , ";
		$valores .= "'" . $_POST ['BPS_Ultimo_Pago'] . "' , ";
		$valores .= "'" . $_POST ['BSE_certificado'] . "' , ";
		$valores .= "'" . $_POST ['BSE_pago_periodo'] . "' , ";
		$valores .= "'" . $_POST ['DGI'] . "' , ";
		$valores .= "'" . $_POST ['DGI_Ultimo_Pago'] . "' , ";
		$valores .= "'" . $_POST ['MTSS'] . "' , ";
		$valores .= "'" . substr($_POST ['VigenciaDesde'], 6, 4) . "-" ; 
		$valores .=       substr($_POST ['VigenciaDesde'], 3, 2) . "-" ;  
		$valores .=       substr($_POST ['VigenciaDesde'], 0, 2) . "' , ";
		$valores .= "'" . substr($_POST ['VigenciaHasta'], 6, 4) . "-" ; 
		$valores .=       substr($_POST ['VigenciaHasta'], 3, 2) . "-" ;  
		$valores .=       substr($_POST ['VigenciaHasta'], 0, 2) . "' , ";
		$valores .= "'" . $_POST ['ReciboSueldo'] . "' , ";
		$valores .= "'" . $_POST ['Indemnidad'] . "' , ";
		$valores .= "'" . $_POST ['Responsable'] . "'   ";
		$sql = "INSERT INTO empleadosUY (" . $campos . ") VALUES (" . $valores . ") ";
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
	$Condicion = comboCondicionUY($_POST ['Condicion']) ;
	$BPS = comboSiNo($_POST ['BPS']) ;
	$BPS_Ultimo_Pago = comboSiNo($_POST ['BPS_Ultimo_Pago']) ;
	$BSE_certificado = comboSiNo($_POST ['BSE_certificado']) ;
	$BSE_pago_periodo = comboSiNo($_POST ['BSE_pago_periodo']) ;
	$DGI = comboSiNo($_POST ['DGI']) ;
	$DGI_Ultimo_Pago = comboSiNo($_POST ['DGI_Ultimo_Pago']) ;
	$MTSS = comboSiNoNc($_POST ['MTSS']) ;
	$VigenciaDesde = $_POST ['VigenciaDesde'] ;
	$VigenciaHasta = $_POST ['VigenciaHasta'] ;
	$ReciboSueldo = comboSiNoNc($_POST ['ReciboSueldo'] ) ;
	$Indemnidad = comboSiNo($_POST ['DGI']) ;
	$Responsable = $_POST ['Responsable'] ;
}else{
	//Arma el combo para seleccionar Proveedor
	$ComboProveedores = ComboProveedores($IdEmpresa, '') ;
	$Nombre = '' ;
	$Identificacion = '' ;
	$Condicion = comboCondicionUY("EMPLEADO") ;
	$BPS = comboSiNo("SI") ;
	$BPS_Ultimo_Pago = comboSiNo("SI") ;
	$BSE_certificado = comboSiNo("SI") ;
	$BSE_pago_periodo = comboSiNo("SI") ;
	$DGI = comboSiNo("SI") ;
	$DGI_Ultimo_Pago = comboSiNo("SI") ;
	$MTSS = comboSiNoNc("SI") ;
	$VigenciaDesde = '' ;
	$VigenciaHasta = '' ;
	$ReciboSueldo = comboSiNoNc("SI") ;
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
<td width="200">Condicion</td>
<td width="300"><select name= "Condicion"><?php echo $Condicion ; ?></select></td>
</tr>
<tr>
<td width="200">Certificado Unico BPS</td>
<td width="300"><select name= "BPS"><?php echo $BPS ; ?></select></td>
</tr>
<tr>
<td width="200">Ultimo Pago BPS</td>
<td width="300"><select name= "BPS_Ultimo_Pago"><?php echo $BPS_Ultimo_Pago ; ?></select></td>
</tr>
<tr>
<td width="200">BSE Certificado</td>
<td width="300"><select name= "BSE_certificado"><?php echo $BSE_certificado ; ?></select></td>
</tr>
<tr>
<td width="200">BSE Pago Periodo</td>
<td width="300"><select name= "BSE_pago_periodo"><?php echo $BSE_pago_periodo ; ?></select></td>
</tr>
<tr>
<td width="200">Certificado Unico DGI</td>
<td width="300"><select name= "DGI"><?php echo $DGI ; ?></select></td>
</tr>
<tr>
<td width="200">Ultimo Pago DGI</td>
<td width="300"><select name= "DGI_Ultimo_Pago"><?php echo $DGI_Ultimo_Pago ; ?></select></td>
</tr>
<tr>
<td width="200">Planilla MTSS</td>
<td width="300"><select name= "MTSS"><?php echo $MTSS ; ?></select></td>
</tr>
<tr>
<td width="200">Recibo Sueldo</td>
<td width="300"><select name= "ReciboSueldo"><?php echo $ReciboSueldo ; ?></select></td>
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
<td width="200">Carta de Indemnidad</td>
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
