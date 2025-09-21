<?PHP
include ("config.php") ;
include ("funciones.php") ;
include ("secure.php") ;
?>
<?php
//si no se recibe el formulario y no hay Proveedor para editar, no puede seguir vuelve a la lista.
if (!isset ($_POST['submit']) && (empty($_GET['IdProveedor']))){
	header("Location: prov_listado.php");
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
	<td bgcolor="#FFFFFF" width="900" height="100" align="center" ><img border="0" alt="AyC Abogados" src="images/banner_ayc_imagen2.png"/></td>
	<td bgcolor="#FFFFFF" ></td> 
</tr>
<tr>
	<td bgcolor="#FFFFFF" ></td> 
	<td bgcolor="#FFFFFF" width="900" align="center" >
<center>
<BR>
<H1>Menu Principal de <B> Proveedores </B> [EDITAR]</H1><br>
<BR>

<?php
function validar(){
	$message = "" ;
	if($_POST ['Proveedor'] == "" ) {
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
		$cnx = conectar () ;
		$sql  = "UPDATE proveedores SET ";
		$sql .= "Proveedor = '" . $_POST ['Proveedor'] . "' , ";
		$sql .= "Identificacion = '" . $_POST ['Identificacion'] . "' , ";
		$sql .= "DenunciaCC = '" . $_POST ['DenunciaCC'] . "' , ";
		$sql .= "RiesgoFin = '" . $_POST ['RiesgoFin'] . "'  ";
		$sql .= " WHERE IdProveedor='". $_POST['IdProveedor'] . "'";
		$res= mysql_query($sql);// or die (mysql_error() ) ;
		
		if (mysql_errno() !=0 ) {
			$message  = "<BR>Asegurese de no repetir el nombre del proveedor para la misma empresa " ;
			$message .= "\n<BR><!--" ;
			$message .= "\n<BR>mysql_errno " . mysql_errno() ;
			$message .= "\n<BR>mysql_error " . mysql_error() ;
			$message .= "\n<BR>query " . $sql ;
			$message .= "\n<BR>-->" ;
			$message .= "<BR>" ;
		} else {
			echo "El proveedor ". $_POST['IdProveedor'] ." ha sido editado";
			echo "<br><a href='prov_listado.php'><img border=\"0\" alt=\"volver\" src=\"images/volver.gif\"/></a>" ;
			mysql_close($cnx) ;
			exit;
		}
	}
	$IdProveedor = $_POST['IdProveedor'] ;
}else{
	$IdProveedor = $_GET['IdProveedor'] ;
}
?> 
<?php
//Arma los valores por defecto para mostrar en el formulario
//si el formulario ha sido enviado y llega hasta aqui es porque hay errores.
if(isset ($_POST['submit'])) {
	$IdEmpresa = $_POST ['IdEmpresa'] ;
	$Empresa = $_POST ['Empresa'] ;
	$Proveedor = $_POST ['Proveedor'] ;
	$Identificacion = $_POST ['Identificacion'] ;
	$DenunciaCC = comboSiNoNa($_POST ['DenunciaCC'] ) ;
	$RiesgoFin = comboRiesgoFin($_POST ['RiesgoFin'] ) ;
}else{
	//nos conectamos a mysql
	$cnx = conectar();
	//consulta para mostrar los datos.
	$sql  = "SELECT E.IdEmpresa, E.Empresa, P.IdProveedor, P.Proveedor, P.Identificacion, P.DenunciaCC, P.RiesgoFin " ;
	$sql .= "FROM proveedores P ";
	$sql .= "INNER JOIN empresas E ON P.IdEmpresa = E.IdEmpresa " ;
	$sql .= "WHERE IdProveedor=". $_GET['IdProveedor'] ;
	$res= mysql_query($sql) or die (mysql_error());
	if ( mysql_num_rows($res) >0) {
	//si hay resultados hacemos el formulario.
		$fila = mysql_fetch_array($res) ;
		$IdEmpresa = $fila['IdEmpresa'] ;
		$Empresa = $fila['Empresa'] ;
		$Proveedor = $fila['Proveedor'] ;
		$Identificacion = $fila['Identificacion'] ;
		$DenunciaCC = comboSiNoNa($fila['DenunciaCC']) ;
		$RiesgoFin = comboRiesgoFin($fila['RiesgoFin']) ;
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
<td width="200">Empresa
	<input name="IdEmpresa" type="hidden" id="IdEmpresa" value="<?php echo $IdEmpresa;?>">
	<input name="Empresa" type="hidden" id="Empresa" value="<?php echo $Empresa;?>">
</td>
<td width="300"><?php echo $Empresa;?></td>
</tr>

<tr>
<td width="200">*Proveedor<input name="IdProveedor" type="hidden" id="IdProveedor" value="<?php echo $IdProveedor;?>"></td>
<td width="300"><input name="Proveedor" type="text" id="Proveedor" value="<?php echo $Proveedor; ?>"></td>
</tr>

<tr>
<td width="200">*Identificacion</td>
<td width="300"><input name="Identificacion" type="text" id="Identificacion" value="<?php echo $Identificacion;?>"></td>
</tr>

<tr>
<td width="200">Denuncia Cuenta Corriente</td>
<td width="300"><select name= "DenunciaCC"><?php echo $DenunciaCC; ?></select></td>
</tr>

<tr>
<td width="200">Riesgo Financiero</td>
<td width="300"><select name= "RiesgoFin"><?php echo $RiesgoFin; ?></select></td>
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

