<?PHP
include ("config.php") ;
include ("funciones.php") ;
include ("secure.php") ;
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset= iso-8859-1">
</head>

<body>
<table width="100%" height="100%">
<tr>
  <td bgcolor="#FFFFFF"; width="40"></td>
  <td bgcolor="#FFFFFF">
<P align="right" >
<img border="0" alt="<?php echo $_SESSION['Logo'];?>" src="<?php echo $CFG_SUBCARPETA . "/" . $_SESSION['Logo'];?>"/>
</P>

<table width="1000" border="1" cellpadding="0" cellspacing="0">

<tr>
		<td COLSPAN="6" ALIGN="center">Lista de emplados de la empresa <B> <?PHP echo $_SESSION['Empresa'] ; ?> </B> </td>
</tr>
<tr>
        <td width="030" align="left">Fila </td>
        <td width="250" align="left">Identificacion empleado </td>
        <td width="500" align="left">Nombre empleado </td>
        <td width="500" align="left">Nombre del Proveedor </td>
        <td width="300" align="left">Vigencia Desde</td>
        <td width="300" align="left">Vigencia Hasta</td>
</tr>

<?PHP
//nos conectamos a la bd
$cnx = conectar();
//buscamos todos los empleados
$sql  = "SELECT L.Identificacion, L.Nombre AS Empl_Nombre, P.Proveedor AS Prov_Nombre, " ;
$sql .= "       L.VigenciaDesde, L.VigenciaHasta " ;
$sql .= "FROM empleados" . $_SESSION['Pais'] . " L " ;
$sql .= "INNER JOIN proveedores P ON L.IdProveedor = P.IdProveedor " ;
$sql .= "WHERE P.IdEmpresa = '" . $_SESSION['IdEmpresa'] . "' " ;
$sql .= "ORDER BY Prov_Nombre, L.Identificacion " ;
$userQuery = mysql_query($sql) or die (mysql_error () ) ;

//revisamos si hubo filas devueltas
if (mysql_num_rows ($userQuery) > 0) {

	//impresion de los datos.
	$fila = 1 ;
	while ($userArray = mysql_fetch_array($userQuery) ){
		//valida fecha de vigencia para el ingreso
		if ((date("Y-m-d") < $userArray ['VigenciaDesde'] && $userArray ['VigenciaDesde'] != "0000-00-00") 
		 or (date("Y-m-d") > $userArray ['VigenciaHasta'] && $userArray ['VigenciaHasta'] != "0000-00-00")) {
			//el permiso de acceso ya no esta vigente
			$userArray ['AptoIngreso'] = "NO";
		}
		
		if ($userArray ['AptoIngreso'] == "NO") {
			//cuando el empleado no puede ingresar colorea la fila
?>
			<tr bgcolor=#aaaaaa>
<?PHP
} else {
?>
			<tr bgcolor=white>
<?PHP
		}
?>
        <td width="030"><?php echo $fila;?></td>
        <td width="250"><?php echo $userArray['Identificacion'];?></td>
        <td width="500"><?php echo $userArray['Empl_Nombre'];?></td>
        <td width="500"><?php echo $userArray['Prov_Nombre'];?></td>
        <td width="250"><?php echo $userArray['VigenciaDesde'];?></td>
        <td width="250"><?php echo $userArray['VigenciaHasta'];?></td>
        </tr>
<?PHP
		$fila += 1 ;

	}
} else {
	// Si no se encontraron userArrays
?>
<tr>
		<td COLSPAN="6" ALIGN="center">No hay empleados en la base</td>
</tr>
<?PHP
}
//Termina de validar los datos de la base
?>
<tr>
		<td COLSPAN="6" ALIGN="center">Fin de la Lista</td>
</tr>
</table>
<BR>
<td bgcolor="#FFFFFF"></td>
  <td bgcolor="#FFFFFF"; width="40"></td>
</tr>
</table>
</body>
</html>


