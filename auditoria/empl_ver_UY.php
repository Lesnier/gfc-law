<?PHP
include ("config.php") ;
include ("funciones.php") ;
include ("secure.php") ;
?>
<?php
//si no hay Empleado para consultar, no puede seguir vuelve a la lista.
if (empty($_GET['Identificacion'])){
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
	<td bgcolor="#FFFFFF" width="900" height="100" align="center" ><img border="0" alt="AyC Abogados" src="images/banner_ayc_imagen2.png"/></td>
	<td bgcolor="#FFFFFF" ></td> 
</tr>
<tr>
	<td bgcolor="#FFFFFF" ></td> 
	<td bgcolor="#FFFFFF" width="900" align="center" >
<center>
<BR>
<H1>Menu Principal de <B> Empleados </B> [VER]</H1><br>
<BR>

<table width="400" border="1"  cellpadding="0" cellspacing="0">
<?php
//nos conectamos a mysql
$cnx = conectar () ;
//consulta.

$sql  = "SELECT " ;
$sql .= "E.Empresa , " ;
$sql .= "P.Proveedor , " ;
$sql .= "L.Nombre , " ;
$sql .= "L.Identificacion , " ;
$sql .= "CASE L.Condicion " ;
$sql .= "  WHEN 'EM' THEN 'EMPLEADO' " ;
$sql .= "  WHEN 'UN' THEN 'UNIPERSONAL' " ;
$sql .= "  ELSE L.Condicion  " ;
$sql .= "END AS Condicion , " ;
$sql .= "L.BPS , " ;
$sql .= "L.BPS_Ultimo_Pago , " ;
$sql .= "L.BSE_certificado , " ;
$sql .= "L.BSE_pago_periodo , " ;
$sql .= "L.DGI , " ;
$sql .= "L.DGI_Ultimo_Pago , " ;
$sql .= "CASE L.MTSS " ;
$sql .= "  WHEN 'NC' THEN 'NO CORRESPONDE' " ;
$sql .= "  ELSE L.MTSS  " ;
$sql .= "END AS MTSS , " ;
$sql .= "CASE L.ReciboSueldo " ;
$sql .= "  WHEN 'NC' THEN 'NO CORRESPONDE' " ;
$sql .= "  ELSE L.ReciboSueldo  " ;
$sql .= "END AS ReciboSueldo , " ;
$sql .= "L.VigenciaDesde , " ;
$sql .= "L.VigenciaHasta , " ;
$sql .= "L.Indemnidad , " ;
$sql .= "L.Responsable " ;
$sql .= "FROM empleadosUY L " ;
$sql .= "INNER JOIN proveedores P ON L.IdProveedor = P.IdProveedor " ;
$sql .= "INNER JOIN empresas E ON P.IdEmpresa = E.IdEmpresa " ;
$sql .= "WHERE L.Identificacion='". $_GET['Identificacion'] . "' ";
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
 <td>Proveedor</td>
 <td><?php echo $fila['Proveedor'];?></td>
</tr>
<tr>
 <td>Nombre</td>
 <td><?php echo $fila['Nombre'];?></td>
</tr>
<tr>
 <td>Identificacion</td>
 <td><?php echo $fila['Identificacion'];?></td>
</tr>
<tr>
 <td>Condicion</td>
 <td><?php echo $fila['Condicion'];?></td>
</tr>
<tr>
 <td>Certificado Unico BPS</td>
 <td><?php echo $fila['BPS'];?></td>
</tr>
<tr>
 <td>Ultimo pago BPS</td>
 <td><?php echo $fila['BPS_Ultimo_Pago'];?></td>
</tr>
<tr>
 <td>BSE Certificado</td>
 <td><?php echo $fila['BSE_certificado'];?></td>
</tr>
<tr>
 <td>BSE Pago Periodo</td>
 <td><?php echo $fila['BSE_pago_periodo'];?></td>
</tr>
<tr>
 <td>Certificado Unico DGI</td>
 <td><?php echo $fila['DGI'];?></td>
</tr>
<tr>
 <td>Ultimo Pago DGI</td>
 <td><?php echo $fila['DGI_Ultimo_Pago'];?></td>
</tr>
<tr>
 <td>Planilla MTSS</td>
 <td><?php echo $fila['MTSS'];?></td>
</tr>
<tr>
 <td>Recibo Sueldo</td>
 <td><?php echo $fila['ReciboSueldo'];?></td>
</tr>
<tr>
 <td>Vigencia Desde</td>
 <td><?php echo fecha_dma($fila['VigenciaDesde']);?></td>
</tr>
<tr>
 <td>Vigencia Hasta</td>
 <td><?php echo fecha_dma($fila['VigenciaHasta']);?></td>
</tr>
<tr>
 <td>Carta de Indemnidad</td>
 <td><?php echo $fila['Indemnidad'];?></td>
</tr>
<tr>
 <td>Responsable</td>
 <td><?php echo $fila['Responsable'];?></td>
</tr>

<?php
  }
}else{
  echo "<tr><td colspan='2' align='center'>no se obtuvieron resultados</td></tr>";
}

echo "<tr><td colspan='2' align='center'><a href='empl_listado.php'><img border=\"0\" alt=\"volver\" src=\"images/volver.gif\"/></a></td></tr>"; 

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
