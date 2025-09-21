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
$sql .= "L.CUIL , " ;
$sql .= "CASE L.Condicion " ;
$sql .= "  WHEN 'EM' THEN 'EMPLEADO' " ;
$sql .= "  WHEN 'AU' THEN 'AUTONOMO' " ;
$sql .= "  ELSE L.Condicion  " ;
$sql .= "END AS Condicion , " ;
$sql .= "L.F931 , " ;
$sql .= "L.Poliza , " ;
$sql .= "L.VigenciaDesde , " ;
$sql .= "L.VigenciaHasta , " ;
$sql .= "CASE L.SeguroDeVida " ;
$sql .= "  WHEN 'NC' THEN 'NO CORRESPONDE' " ;
$sql .= "  ELSE L.SeguroDeVida  " ;
$sql .= "END AS SeguroDeVida , " ;
$sql .= "CASE L.ReciboSueldo " ;
$sql .= "  WHEN 'NC' THEN 'NO CORRESPONDE' " ;
$sql .= "  ELSE L.ReciboSueldo  " ;
$sql .= "END AS ReciboSueldo , " ;
$sql .= "CASE L.Repeticion " ;
$sql .= "  WHEN 'NC' THEN 'NO CORRESPONDE' " ;
$sql .= "  ELSE L.Repeticion  " ;
$sql .= "END AS Repeticion , " ;
$sql .= "L.Indemnidad , " ;
$sql .= "L.Responsable , " ;
$sql .= "L.CuotaSindical , " ;
$sql .= "L.SeguroDesempleo , " ;
$sql .= "L.LibretaTrabajo , " ;
$sql .= "L.Obra , " ;
$sql .= "L.CtaCorrienteMarca , " ;
$sql .= "L.CtaCorrienteNro " ;

$sql .= "FROM empleadosCS L " ;
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
 <td>CUIL/CUIT</td>
 <td><?php echo $fila['CUIL'];?></td>
</tr>
<tr>
 <td>Condicion</td>
 <td><?php echo $fila['Condicion'];?></td>
</tr>
<tr>
 <td>F931/AFIP</td>
 <td><?php echo $fila['F931'];?></td>
</tr>
<tr>
 <td>ART/ACC. Personales</td>
 <td><?php echo $fila['Poliza'];?></td>
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
 <td>Seguro de Vida</td>
 <td><?php echo $fila['SeguroDeVida'];?></td>
</tr>
<tr>
 <td>Recibo Sueldo</td>
 <td><?php echo $fila['ReciboSueldo'];?></td>
</tr>
<tr>
 <td>No Repeticion</td>
 <td><?php echo $fila['Repeticion'];?></td>
</tr>
<tr>
 <td>Indemnidad</td>
 <td><?php echo $fila['Indemnidad'];?></td>
</tr>
<tr>
 <td>Responsable</td>
 <td><?php echo $fila['Responsable'];?></td>
</tr>
<tr>
 <td>Cuota Sindical</td>
 <td><?php echo $fila['CuotaSindical'];?></td>
</tr>
<tr>
 <td>Seguro de Desempleo</td>
 <td><?php echo $fila['SeguroDesempleo'];?></td>
</tr>
<tr>
 <td>Libreta de Trabajo</td>
 <td><?php echo $fila['LibretaTrabajo'];?></td>
</tr>
<tr>
 <td>Obra</td>
 <td><?php echo $fila['Obra'];?></td>
</tr>
<tr>
 <td>CtanCorriente(SI/NO)</td>
 <td><?php echo $fila['CtaCorrienteMarca'];?></td>
</tr>
<tr>
 <td>Cta.Corriente(CBU)</td>
 <td><?php echo $fila['CtaCorrienteNro'];?></td>
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
