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
<H1>Menu Principal de <B> Proveedores </B> [NUEVO]</H1><br>
<BR>

<?php

function validar(){
	$message = "" ;
	if($_POST ['IdEmpresa'] == "" ) {
		$message = "Debe seleccionar una Empresa";
	}elseif($_POST ['Proveedor'] == "" ) {
		$message = "Debe ingresar el nombre del Proveedor";
	}elseif($_POST ['Identificacion'] < 10000000000 || $_POST ['Identificacion'] > 999999999999 ){
		$message = "Debe ingresar Identificacion con 11 o 12 dígitos";
	}
/* Comentado a partir de la versión de 2012-05-09
	if($message == "") {
		$message = validarPorPais() ;
	}
*/
	return $message;
}

function validarPorPais(){
	//nos conectamos a mysql
	$cnx = conectar () ;
	//consulta para averiguar el Pais de la Empresa.
	$sql  = "SELECT Pais FROM empresas ";
	$sql .= " WHERE IdEmpresa=". $_POST['IdEmpresa'] ;

	$res= mysql_query($sql) or die (mysql_error());
	if ( mysql_num_rows($res) >0) {
	//Obtiene el Pais de la Empresa elegida.
		$fila = mysql_fetch_array($res) ;
		$Pais = $fila['Pais'] ;
	}
	if($Pais != "AR" && $_POST ['DenunciaCC'] != "NA") {
		$message = "Para Empresas que NO son de Argentina debe seleccionar <B>Denuncia Cuenta Corriente</B> 'No Aplica'";
	}elseif($Pais == "AR" && $_POST ['DenunciaCC'] == "NA") {
		$message = "Para Empresas que son de Argentina debe seleccionar <B>Denuncia Cuenta Corriente</B> distinto de 'No Aplica'";
	}elseif($Pais != "AR" && $_POST ['RiesgoFin'] != "NA") {
		$message = "Para Empresas que NO son de Argentina debe seleccionar <B>Riesgo Financiero</B> 'No Aplica'";
	}elseif($Pais == "AR" && $_POST ['RiesgoFin'] == "NA") {
		$message = "Para Empresas que son de Argentina debe seleccionar <B>Riesgo Financiero</B> distinto de 'No Aplica'";
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
		$cnx = conectar ();
		$campos = "IdEmpresa, Proveedor, Identificacion, DenunciaCC, RiesgoFin";
		$valores  = "";
		$valores .= "'" . $_POST ['IdEmpresa'] . "' , ";
		$valores .= "'" . $_POST ['Proveedor'] . "' , ";
		$valores .= "'" . $_POST ['Identificacion'] . "' , ";
		$valores .= "'" . $_POST ['DenunciaCC'] . "' , ";
		$valores .= "'" . $_POST ['RiesgoFin'] . "'  ";
		$sql = "INSERT INTO proveedores (" . $campos . ") VALUES (" . $valores . ") ";
		$res = mysql_query ($sql);// or die (user_mysql_error() ) ;
		
		if (mysql_errno() !=0 ) {
			$message  = "<BR>Asegurese de no repetir el nombre del proveedor para la misma empresa " ;
			$message .= "\n<BR><!--" ;
			$message .= "\n<BR>mysql_errno " . mysql_errno() ;
			$message .= "\n<BR>mysql_error " . mysql_error() ;
			$message .= "\n<BR>query " . $sql ;
			$message .= "\n<BR>-->" ;
			$message .= "<BR>" ;
		} else {
			echo "El proveedor ". $_POST['IdProveedor'] ." ha sido agregado";
			echo "<br><a href='prov_listado.php'><img border=\"0\" alt=\"volver\" src=\"images/volver.gif\"/></a>" ;
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
	//Arma el combo para seleccionar Empresa
	$ComboEmpresas = ComboEmpresas($_POST ['IdEmpresa']) ;
	$Proveedor = $_POST ['Proveedor'] ;
	$Identificacion = $_POST ['Identificacion'] ;
	$DenunciaCC = comboSiNoNa($_POST ['DenunciaCC'] ) ;
	$RiesgoFin = comboRiesgoFin($_POST ['RiesgoFin'] ) ;
}else{
	//Arma el combo para seleccionar Empresa
	$ComboEmpresas = ComboEmpresas('') ;
	$Proveedor = '' ;
	$Identificacion = '' ;
	$DenunciaCC = comboSiNoNa("SI") ;
	$RiesgoFin = comboRiesgoFin("STD") ;
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
<td width="200">*Empresa</td>
<td width="300"><?php echo $ComboEmpresas ; ?></td>
</tr>
<tr>
<td width="200">*Proveedor</td>
<td width="300"><input name="Proveedor" type="text" id="Proveedor" value="<?php echo $Proveedor ; ?>"></td>
</tr>
<tr>
<td width="200">*Identificacion</td>
<td width="300"><input name="Identificacion" type="text" id="Identificacion" value="<?php echo $Identificacion ; ?>"></td>
</tr>
<tr>
<td width="200">Denuncia Cuenta Corriente</td>
<td width="300"><select name= "DenunciaCC"><?php echo $DenunciaCC ; ?></select></td>
</tr>
<tr>
<td width="200">Riesgo Financiero</td>
<td width="300"><select name= "RiesgoFin"><?php echo $RiesgoFin ; ?></select></td>
</tr>

<tr>
<td width="200" align='left'><a href='prov_listado.php'><img border="0" alt="volver" src="images/volver.gif"/></a></td>
<td width="300" align="right">
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
