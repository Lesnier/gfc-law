<?PHP
include ("config.php") ;
include ("funciones.php") ;
include ("secure.php") ;
?>
<?php
//si no hay Empresa para consultar, no puede seguir vuelve a la lista.
if (empty($_GET['IdEmpresa'])){
	header("Location: empr_listado.php");
	exit;
}
?>
<?php
//nos conectamos a mysql
$cnx = conectar () ;
//consulta.
$sql  = "SELECT E.IdEmpresa, E.Empresa " ;
$sql .= "FROM   empresas E " ;
$sql .= "WHERE  E.IdEmpresa = '" . $_GET['IdEmpresa'] . "' " ;
$res= mysql_query($sql) or die (mysql_error());

if( mysql_num_rows($res) >0){
	list ($IdEmpresa,$Empresa) = mySQL_fetch_array($res) ;
}else{
	echo "no se obtuvieron resultados" ;
	exit ;
}
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset= iso-8859-1">
</head>

<body>

<table width="3430" border="1" cellpadding="0" cellspacing="0">

<tr>
	<td COLSPAN="17" ALIGN="center">Informe de Auditoria Control de Proveedores Art. 30 LCT</td>
</tr>
<tr>
	<td COLSPAN="17" ALIGN="center">para de la empresa <B> <?PHP echo $Empresa ; ?> </B> al <B><?PHP echo date("d/m/Y") ; ?> </B></td>
</tr>
<tr>
	<td width="500" align="left">PROVEEDOR</td>
	<td width="30" align="left">Fila</td>
	<td width="500" align="left">Empleado</td>
	<td width="250" align="left">CI</td>
	<td width="250" align="left">Condicion</td>
	<td width="50" align="left">Certificado Unico BPS</td>
	<td width="50" align="left">Ultimo Pago BPS</td>
	<td width="50" align="left">BSE Certificado</td>
	<td width="50" align="left">BSE Pago Periodo</td>
	<td width="50" align="left">Certificado Unico DGI</td>
	<td width="50" align="left">Ultimo Pago DGI</td>
	<td width="50" align="left">Planilla MTSS</td>
	<td width="50" align="left">Recibo de sueldo</td>
	<td width="200" align="left">Vigencia Desde</td>
	<td width="200" align="left">Vigencia Hasta</td>
	<td width="50" align="left">Carta de Indemnidad</td>
	<td width="500" align="left">Responsable </td>
</tr>

<?PHP
// //nos conectamos a la bd
// $cnx = conectar();
//buscamos todos los empleados
$sql  = "SELECT " ;
$sql .= "P.Proveedor , " ;
$sql .= "P.Identificacion AS RUT , " ;
$sql .= "L.Nombre , " ;
$sql .= "L.Identificacion AS CI , " ;
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
$sql .= "L.VigenciaDesde , " ;
$sql .= "L.VigenciaHasta , " ;
$sql .= "CASE L.ReciboSueldo " ;
$sql .= "  WHEN 'NC' THEN 'NO CORRESPONDE' " ;
$sql .= "  ELSE L.ReciboSueldo  " ;
$sql .= "END AS ReciboSueldo , " ;
$sql .= "L.Indemnidad , " ;
$sql .= "L.Responsable " ;
$sql .= "FROM empleadosUY L " ;
$sql .= "INNER JOIN proveedores P ON L.IdProveedor = P.IdProveedor " ;
$sql .= "WHERE P.IdEmpresa = '" . $IdEmpresa . "' " ;
$sql .= "ORDER BY P.Proveedor, L.Nombre " ;
$userQuery = mysql_query($sql) or die (mysql_error () ) ;

//revisamos si hubo filas devueltas
if (mysql_num_rows ($userQuery) > 0) {

	//impresion de los datos.
	$fila = 1 ;
	$ProvNum = 1 ;
	$ProvAnt = '' ;
	while ($userArray = mysql_fetch_array($userQuery) ){
		//Si cambio el proveedor imprime una fila naranja
		if ($ProvAnt != $userArray ['Proveedor'] ) {
			$ProvAnt = $userArray ['Proveedor'] ;
?>
<tr bgcolor=orange>
<!--	<td COLSPAN="17" &nbsp; </td> -->
	<td COLSPAN="17"> ( <?php echo $ProvNum;?> ) <?php echo $userArray['Proveedor'];?> - <?php echo $userArray['RUT'];?> </td>
</tr>
<?PHP
			$ProvNum += 1 ;
		}
		//valida fecha de vigencia para el ingreso
		if ((date("Y-m-d") < $userArray ['VigenciaDesde'] && $userArray ['VigenciaDesde'] != "0000-00-00") 
		 or (date("Y-m-d") > $userArray ['VigenciaHasta'] && $userArray ['VigenciaHasta'] != "0000-00-00")) {
			//el permiso de acceso ya no esta vigente
			//cuando el empleado no puede ingresar colorea la fila
			$colorFila='#aaaaaa' ; // gris
		} else {
			$colorFila='white' ;
		}
?>
<tr bgcolor=<?php echo $colorFila;?>>
	<td width="500"><?php echo $userArray['Proveedor'];?></td>
	<td width="30"><?php echo $fila;?></td>
	<td width="500"><?php echo $userArray['Nombre'];?></td>
	<td width="250"><?php echo $userArray['CI'];?></td>
	<td width="250"><?php echo $userArray['Condicion'];?></td>
	<td width="50"><?php echo $userArray['BPS'];?></td>
	<td width="50"><?php echo $userArray['BPS_Ultimo_Pago'];?></td>
	<td width="50"><?php echo $userArray['BSE_certificado'];?></td>
	<td width="50"><?php echo $userArray['BSE_pago_periodo'];?></td>
	<td width="50"><?php echo $userArray['DGI'];?></td>
	<td width="50"><?php echo $userArray['DGI_Ultimo_Pago'];?></td>
	<td width="50"><?php echo $userArray['MTSS'];?></td>
	<td width="50"><?php echo $userArray['ReciboSueldo'];?></td>
	<td width="200"><?php echo fecha_dma($userArray['VigenciaDesde']);?></td>
	<td width="200"><?php echo fecha_dma($userArray['VigenciaHasta']);?></td>
	<td width="50"><?php echo $userArray['Indemnidad'];?></td>
	<td width="500"><?php echo $userArray['Responsable'];?></td>
</tr>
<?PHP
		$fila += 1 ;

	}
} else {
	// Si no se encontraron userArrays
?>
<tr>
		<td COLSPAN="17" ALIGN="center">No hay empleados en la base</td>
</tr>
<?PHP
}
//Termina de validar los datos de la base
?>
<tr>
		<td COLSPAN="17" ALIGN="center">Fin de la Lista</td>
</tr>
</table>
<BR>
</body>
</html>


