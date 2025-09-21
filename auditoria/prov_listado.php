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
	<td bgcolor="#FFFFFF">
<center>
<BR>
<H1>Menu Principal de <B> Proveedores </B> </H1><br>
<BR>

<table width="900" border="1" cellpadding="0" cellspacing="0">

<tr>
 <td>Empresa</td>
 <td>Proveedor</td>
 <td>Nombre del Proveedor</td>
 <td colspan="3" align="center" > accion</td>
</tr>
<?php
//nos conectamos a mysql
$cnx = conectar () ;
//consulta.
$sql  = "SELECT E.Empresa, P.IdProveedor, P.Proveedor " ;
$sql .= "FROM proveedores P " ;
$sql .= "INNER JOIN empresas E ON P.IdEmpresa = E.IdEmpresa " ;
$sql .= "ORDER BY E.Empresa, P.Proveedor ASC " ;
$res= mysql_query($sql) or die (mysql_error());

if ( mysql_num_rows($res) > 0) {
 //impresion de los datos.
 while (list ($Empresa,$IdProveedor,$Proveedor) = mySQL_fetch_array($res)){
   echo "<tr><td>$Empresa</td>\n";
   echo "<td>$IdProveedor</td>\n";
   echo "<td>$Proveedor</td>\n";
   echo "<td><a href='prov_ver.php?IdProveedor=$IdProveedor'><img border=\"0\" alt=\"ver\" src=\"images/ver.gif\"/></a></td>\n";
   echo "<td><a href='prov_editar.php?IdProveedor=$IdProveedor'><img border=\"0\" alt=\"editar\" src=\"images/editar.gif\"/></a></td>\n";
   echo "<td><a href='prov_eliminar.php?IdProveedor=$IdProveedor'><img border=\"0\" alt=\"eliminar\" src=\"images/eliminar.gif\"/></a></td></tr>\n";
 }
}else{
 echo "<tr><td colspan='6' align='center' >no se obtuvieron resultados</td></tr>\n";
}
mysql_close($cnx);
?>
<tr>
 <td colspan="3" align="center" >ingresar nuevo proveedor</td>
 <td colspan="3" align="center" ><a href='prov_nuevo.php'><img border="0" alt="nuevo" src="images/nuevo.gif"/></a></td>
</td>
<tr>
 <td colspan="6" align="center" > <a href='menu_admin.php'><img border="0" alt="volver" src="images/volver.gif"/></a></td>
</td>
</table>
<BR>
<BR>
<a href="salir.php"><img border="0" alt="salir" src="images/salir.gif"/></a>
</center>
<td bgcolor="#FFFFFF"></td>
  <td bgcolor="#FFFFFF" ></td>
</tr>
</table>
</body>
</html>
