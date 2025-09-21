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
	<td width="250" align="left">DNI</td>
	<td width="250" align="left">CUIL/CUIT</td>
	<td width="250" align="left">Condicion</td>
	<td width="50" align="left">F931/AFIP</td>
	<td width="50" align="left">ART/ACC. Personales</td>
	<td width="200" align="left">Vigencia Desde</td>
	<td width="200" align="left">Vigencia Hasta</td>
	<td width="50" align="left">Seguro de Vida Obligatorio</td>
	<td width="50" align="left">Recibo de sueldo</td>
	<td width="50" align="left">Cláusula de No Repeticiòn</td>
	<td width="50" align="left">Denuncia Cta.Corriente</td>
	<td width="50" align="left">Riesgo financiero</td>
	<td width="50" align="left">Carta Indemnidad</td>
	<td width="500" align="left">Responsable </td>
	<td width="50" align="left">Cuota Sindical</td>
	<td width="50" align="left">Seguro de Desempleo</td>
	<td width="50" align="left">Libreta de Trabajo</td>
	<td width="500" align="left">Obra</td>
	<td width="50" align="left">Cta.Corriente(SI/NO)</td>
	<td width="500" align="left">Cta.Corriente(CBU)</td>

</tr>

<?PHP
// //nos conectamos a la bd
// $cnx = conectar();
//buscamos todos los empleados
$sql  = "SELECT " ;
$sql .= "P.Proveedor , " ;
$sql .= "P.Identificacion AS CUIT , " ;
$sql .= "L.Nombre , " ;
$sql .= "L.Identificacion AS DNI , " ;
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
$sql .= "P.DenunciaCC , " ;
$sql .= "P.RiesgoFin , " ;
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
	<td COLSPAN="17"> ( <?php echo $ProvNum;?> ) <?php echo $userArray['Proveedor'];?> - <?php echo $userArray['CUIT'];?> </td>
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
	<td width="250"><?php echo $userArray['DNI'];?></td>
	<td width="250"><?php echo $userArray['CUIL'];?></td>
	<td width="250"><?php echo $userArray['Condicion'];?></td>
	<td width="50"><?php echo $userArray['F931'];?></td>
	<td width="50"><?php echo $userArray['Poliza'];?></td>
	<td width="200"><?php echo fecha_dma($userArray['VigenciaDesde']);?></td>
	<td width="200"><?php echo fecha_dma($userArray['VigenciaHasta']);?></td>
	<td width="50"><?php echo $userArray['SeguroDeVida'];?></td>
	<td width="50"><?php echo $userArray['ReciboSueldo'];?></td>
	<td width="50"><?php echo $userArray['Repeticion'];?></td>
	<td width="50"><?php echo $userArray['DenunciaCC'];?></td>
	<td width="50"><?php echo $userArray['RiesgoFin'];?></td>
	<td width="50"><?php echo $userArray['Indemnidad'];?></td>
	<td width="500"><?php echo $userArray['Responsable'];?></td>
	<td width="50"><?php echo $userArray['CuotaSindical'];?></td>
	<td width="50"><?php echo $userArray['SeguroDesempleo'];?></td>
	<td width="50"><?php echo $userArray['LibretaTrabajo'];?></td>
	<td width="500"><?php echo $userArray['Obra'];?></td>
	<td width="50"><?php echo $userArray['CtaCorrienteMarca'];?></td>
	<td width="500"><?php echo $userArray['CtaCorrienteNro'];?></td>
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


