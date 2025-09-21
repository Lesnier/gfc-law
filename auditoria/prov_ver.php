<?PHP
include ("config.php") ;
include ("funciones.php") ;
include ("secure.php") ;
?>
<?php
//si no hay Proveedor para consultar, no puede seguir vuelve a la lista.
if (empty($_GET['IdProveedor'])){
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
<H1>Menu Principal de <B> Proveedores </B> [VER]</H1><br>
<BR>

<table width="400" border="1"  cellpadding="0" cellspacing="0">
<?php
//nos conectamos a mysql
$cnx = conectar () ;
//consulta.
$sql  = "SELECT E.Empresa, P.IdProveedor, P.Proveedor, P.Identificacion, P.DenunciaCC, P.RiesgoFin " ;
$sql .= "FROM proveedores P ";
$sql .= "INNER JOIN empresas E ON P.IdEmpresa = E.IdEmpresa " ;
$sql .= "WHERE IdProveedor=". $_GET['IdProveedor'] ;
$res = mysql_query ($sql) or die (mysql_error());

if( mysql_num_rows($res) >0){
  //impresión de los datos.
  while ($fila = mysql_fetch_array($res)) {
?>

<tr>
 <td>Empresa</td>
 <td><?php echo $fila['Empresa'];?></td>
</tr>
<tr>
 <td>IdProveedor</td>
 <td><?php echo $fila['IdProveedor'];?></td>
</tr>
<tr>
 <td>Proveedor</td>
 <td><?php echo $fila['Proveedor'];?></td>
</tr>
<tr>
 <td>Identificacion</td>
 <td><?php echo $fila['Identificacion'];?></td>
</tr>
<tr>
 <td>Denuncia Cuenta Corriente</td>
 <td><?php echo $fila['DenunciaCC'];?></td>
</tr>
<tr>
 <td>Riesgo Financiero</td>
 <td><?php echo $fila['RiesgoFin'];?></td>
</tr>

<?php
  }
}else{
  echo "<tr><td colspan='2' align='center'>no se obtuvieron resultados</td></tr>";
}

echo "<tr><td colspan='2' align='center'><a href='prov_listado.php'><img border=\"0\" alt=\"volver\" src=\"images/volver.gif\"/></a></td></tr>"; 

mysql_close ($cnx) ;
?>
</table>
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
