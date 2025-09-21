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
<?PHP
if (1==2){
   echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\">\n";
   echo "<tr>\n";
   echo "<td>SESSION NombrePatron :".$_SESSION['NombrePatron']."</td>\n";
   echo "</tr>\n";
   echo "<tr>\n";
   echo "<td>SESSION IdentifPatron :".$_SESSION['IdentifPatron']."</td>\n";
   echo "</tr>\n";
   echo "<tr>\n";
   echo "<td>SESSION ProveedPatron :".$_SESSION['ProveedPatron']."</td>\n";
   echo "</tr>\n";
   echo "<tr>\n";
   echo "<td>POST NombrePatron :".$_POST['NombrePatron']."</td>\n";
   echo "</tr>\n";
   echo "<tr>\n";
   echo "<td>POST IdentifPatron :".$_POST['IdentifPatron']."</td>\n";
   echo "</tr>\n";
   echo "<tr>\n";
   echo "<td>POST ProveedPatron :".$_POST['ProveedPatron']."</td>\n";
   echo "</tr>\n";
   echo "</table>\n";
}
// Si vinieron filtros los guardo en la session
if (isset($_POST['NombrePatron']) || isset($_POST['IdentifPatron']) || isset($_POST['ProveedPatron'])) {
	$_SESSION['NombrePatron']  = $_POST['NombrePatron']  ;
	$_SESSION['IdentifPatron'] = $_POST['IdentifPatron'] ;
	$_SESSION['ProveedPatron'] = $_POST['ProveedPatron'] ;
} else {
	$_POST['NombrePatron']  = $_SESSION['NombrePatron']  ;
	$_POST['IdentifPatron'] = $_SESSION['IdentifPatron'] ;
	$_POST['ProveedPatron'] = $_SESSION['ProveedPatron'] ;
}
?>
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
<H1>Menu Principal de <B> Empleados </B> </H1><br>
<BR>

<table width="900" border="1" cellpadding="0" cellspacing="0">

<tr>
 <td colspan="11" align="center" > <a href="salir.php"><img border="0" alt="salir" src="images/salir.gif"/></a></td>
</tr>
<tr>
 <td colspan="11" align="center" > <a href='menu_admin.php'><img border="0" alt="volver" src="images/volver.gif"/></a></td>
</tr>
<tr>
 <td colspan="3" align="center" >ingresar nuevo empleado</td>
 <td colspan="8" align="center" >
	<form name = "form2" action='empl_nuevo_select.php' METHOD="post" >
		<?php $ComboEmpresas = ComboEmpresas('') ; echo $ComboEmpresas ; ?>
		<input type="image" src="images/nuevo.gif" alt="nuevo">
	</form>
 </td>
</tr>
<tr>
 <td colspan="3" align="center" >buscar coincidencias<br>Se permiten * intermedios</td>
 <td colspan="8" align="center" >
	<form name = "form1" action='<?php echo $_SERVER['PHP_SELF'];?>' METHOD="post" >
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		 <td align="right" >por nombre</td>
		 <td><input type="text" name="NombrePatron" value="<?php echo $_SESSION['NombrePatron'] ; ?>"></td>
		 </tr>
		<tr>
		 <td align="right" >por identificacion</td>
		 <td><input type="text" name="IdentifPatron" value="<?php echo $_SESSION['IdentifPatron'] ; ?>"></td>
		</tr>
		<tr>
		 <td align="right" >por proveedor</td>
		 <td><input type="text" name="ProveedPatron" value="<?php echo $_SESSION['ProveedPatron'] ; ?>"></td>
		</tr>
		</table>
		<input type="image" src="images/enviar.gif" alt="enviar">
	</form>
 </td>
</tr>

<tr>
 <td>Empresa</td>
 <td>Pais</td>
 <td>Proveedor</td>
 <td>Nombre del Empleado</td>
 <td>Identificacion</td>
 <td>Vigencia Desde</td>
 <td>Vigencia Hasta</td>
 <td colspan="3" align="center" > accion</td>
</tr>
<?php
//nos conectamos a mysql
$cnx = conectar () ;

$WHERE = "" ;
if ($_POST['NombrePatron'] != ""){
	//arma lista de empleados FILTRANDO con en NombrePatron
	$_POST['NombrePatron'] = str_replace("*","%",$_POST['NombrePatron']);  
	$WHERE .= " WHERE L.Nombre LIKE '%" . $_POST['NombrePatron'] . "%' " ;
}else{
	//arma lista de empleados SIN FILTRAR con en NombrePatron
	$WHERE .= " WHERE 1=1 ";
}
if ($_POST['IdentifPatron'] != ""){
	//arma lista de empleados FILTRANDO con en IdentifPatron
	$_POST['IdentifPatron'] = str_replace("*","%",$_POST['IdentifPatron']);  
	$WHERE .= "   AND L.Identificacion LIKE '%" . $_POST['IdentifPatron'] . "%' " ;
}else{
	//arma lista de empleados SIN FILTRAR con en IdentifPatron
	$WHERE .= "   AND 2=2 ";
}
if ($_POST['ProveedPatron'] != ""){
	//arma lista de empleados FILTRANDO con en ProveedPatron
	$_POST['ProveedPatron'] = str_replace("*","%",$_POST['ProveedPatron']);  
	$WHERE .= "   AND P.Proveedor LIKE '%" . $_POST['ProveedPatron'] . "%' " ;
}else{
	//arma lista de empleados SIN FILTRAR con en ProveedPatron
	$WHERE .= "   AND 3=3 ";
}
//arma el query UNIENDO las tablas de empleados de cada pais
//Argentina
$sql  = "SELECT E.Empresa, E.Pais, P.Proveedor, L.Nombre, L.Identificacion, L.VigenciaDesde, L.VigenciaHasta " ;
$sql .= "FROM empleadosAR L " ;
$sql .= "INNER JOIN proveedores P ON L.IdProveedor = P.IdProveedor " ;
$sql .= "INNER JOIN empresas E ON P.IdEmpresa = E.IdEmpresa " ;
$sql .= $WHERE ;
//Uruguay
$sql .= " UNION " ;
$sql .= "SELECT E.Empresa, E.Pais, P.Proveedor, L.Nombre, L.Identificacion, L.VigenciaDesde, L.VigenciaHasta " ;
$sql .= "FROM empleadosUY L " ;
$sql .= "INNER JOIN proveedores P ON L.IdProveedor = P.IdProveedor " ;
$sql .= "INNER JOIN empresas E ON P.IdEmpresa = E.IdEmpresa " ;
$sql .= $WHERE ;
//ConstructoraSudamericana
$sql .= " UNION " ;
$sql .= "SELECT E.Empresa, E.Pais, P.Proveedor, L.Nombre, L.Identificacion, L.VigenciaDesde, L.VigenciaHasta " ;
$sql .= "FROM empleadosCS L " ;
$sql .= "INNER JOIN proveedores P ON L.IdProveedor = P.IdProveedor " ;
$sql .= "INNER JOIN empresas E ON P.IdEmpresa = E.IdEmpresa " ;
$sql .= $WHERE ;

$sql .= "ORDER BY Empresa ASC, Proveedor ASC, Nombre ASC " ;

$res= mysql_query($sql) or die (mysql_error());

//echo "<tr><td colspan='8' align='center' >$sql</td></tr>\n";

if ( mysql_num_rows($res) > 0) {
 //impresion de los datos.
 while (list ($Empresa,$Pais,$Proveedor,$EmplNombre,$Identificacion,$VigenciaDesde,$VigenciaHasta,$AptoIngreso) = mySQL_fetch_array($res)){
   echo "<tr><td>$Empresa</td>\n";
   echo "<td>$Pais</td>\n";
   echo "<td>$Proveedor</td>\n";
   echo "<td>$EmplNombre</td>\n";
   echo "<td>$Identificacion</td>\n";
   echo "<td>&nbsp;" . fecha_dma($VigenciaDesde) . "</td>\n";
   echo "<td>&nbsp;" . fecha_dma($VigenciaHasta) . "</td>\n";
   echo "<td><a href='empl_ver_$Pais.php?Identificacion=$Identificacion'><img border=\"0\" alt=\"ver\" src=\"images/ver.gif\"/></a></td>\n";
   echo "<td><a href='empl_editar_$Pais.php?Identificacion=$Identificacion'><img border=\"0\" alt=\"editar\" src=\"images/editar.gif\"/></a></td>\n";
   echo "<td><a href='empl_eliminar_$Pais.php?Identificacion=$Identificacion'><img border=\"0\" alt=\"eliminar\" src=\"images/eliminar.gif\"/></a></td></tr>\n";
 }
}else{
 echo "<tr><td colspan='8' align='center' >no se obtuvieron resultados</td></tr>\n";
}
mysql_close($cnx);
?>
</table>
<BR>
<BR>
</center>
</td>
  <td bgcolor="#FFFFFF" ></td>
</tr>
</table>
</body>
</html>
