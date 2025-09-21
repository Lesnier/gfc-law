<?PHP
include ("config.php") ;
include ("funciones.php") ;
include ("secure.php") ;
?>
<?PHP
//Sipresiono el boton Submit, entonces accede a la base
//if (isset($_POST['SubmitIdentif'])){
//Si se recibio Identificacion por GET o por POST, lo pasa a POST para asemejar a la pagina inicial
if (isset($_GET['Identif_digitado'])){
	$_POST['Identif_digitado'] = $_GET['Identif_digitado'] ;
}
//Si se recibio Identificacion (asi funciona tabmien con Enter)
if (isset($_POST['Identif_digitado'])){
	//nos conectamos a la bd
	$cnx = conectar();
	//buscamos al empleado
	$sql  = "SELECT " ;
	$sql .= "P.Proveedor , " ;
	$sql .= "P.Identificacion AS IdentifProveedor , " ;
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
	$sql .= "P.DenunciaCC , " ;
	$sql .= "P.RiesgoFin , " ;
	$sql .= "L.Indemnidad , " ;
	$sql .= "L.Responsable " ;
	$sql .= "FROM empleados" . $_SESSION['Pais'] . " L " ;
	$sql .= "INNER JOIN proveedores P ON L.IdProveedor = P.IdProveedor " ;
	$sql .= "WHERE L.Identificacion = '" . $_POST['Identif_digitado'] . "' " ;
	$sql .= "  AND P.IdEmpresa = '" . $_SESSION['IdEmpresa'] . "' " ;
	$userQuery = mysql_query($sql) or die (mysql_error () ) ;
	$userArray = mysql_fetch_array($userQuery) ;

	//revisamos el empleado
	if (mysql_num_rows ($userQuery) > 0) {
		//empleado existe, seguimos
		if ((date("Y-m-d") < $userArray ['VigenciaDesde'] && $userArray ['VigenciaDesde'] != "0000-00-00") 
		 or (date("Y-m-d") > $userArray ['VigenciaHasta'] && $userArray ['VigenciaHasta'] != "0000-00-00")) {
			//valida vigencia
			$AptoIngreso = "NO";
		}
	} else {
		// Si no se encontraron userArrays
		$message = "<DIV STYLE=\"background-color:yellow\">El Identificacion <B>" . $_POST['Identif_digitado'] . "</B> no está ingresada en la base</DIV>";
	}
}
//Termina de validar los datos de la base
?>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="templatemenor.css" media="screen"/>
<meta http-equiv="Content-Type" content="text/html; charset= iso-8859-1">
</head>

<body onLoad="document.form1.Identif_digitado.focus()">
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

<P align="center" >
<img border="0" alt="<?php echo $_SESSION['Logo'];?>" src="<?php echo $CFG_SUBCARPETA . "/" . $_SESSION['Logo'];?>"/>
</P>

<BR>Bienvenido al Sistema<BR>

<form name = "form1" action='<?php echo $_SERVER['PHP_SELF'];?>' METHOD="post" >

<table width="500" cellpadding="0" cellspacing="0" 1>
    <tr>
    <td heiqht="3O" COLSPAN="2" ALIGN="center"><H1>Ingreso de Empleados</H1></td>
    </tr>
    
    <tr>
    <td height="24" COLSPAN="2" ALIGN="center"> <i><NOBR>
    <?PHP
    //revisa si hay mensajes de error.
    if ($message) {
    echo $message;
    } ?>
    </NOBR></i>
    </td>
    </tr>
<?PHP
		if ($AptoIngreso == "NO" 
		 or $message) {
			//cuando el empleado no puede ingresar colorea la fila con toda la subtabla
?>
			<tr bgcolor=red> <!-- rojo -->
<?PHP
} else {
?>
			<tr bgcolor=#66ff66> <!-- verde -->
<?PHP
		}
?>
    <td ALIGN="right" valign="bottom">
    <table width="500" cellpadding="4" cellspacing="1" border="1" >
        <tr>
        <td width="250" align="right" >Identificacion: </td>
        <td width="250"> <input type="text" name="Identif_digitado" ></td>
        </tr>
        <tr>
        <td width="250" align="right">Identificacion consultada: </td>
        <td width="250"><?php echo $userArray['Identificacion'];?>&nbsp;</td>
        </tr>
        <tr>
        <td width="250" align="right">Nombre empleado: </td>
        <td width="250"><?php echo $userArray['Nombre'];?>&nbsp;</td>
        </tr>

        <tr>
        <td width="250" align="right">Nombre del Proveedor: </td>
        <td width="250"><?php echo $userArray['Proveedor'];?>&nbsp;</td>
        </tr>
		<tr>
		<td width="250" align="right">Identificacion del Proveedor:</td>
		<td width="250"><?php echo $userArray['IdentifProveedor'];?>&nbsp;</td>
		</tr>
		<tr>
		<td width="250" align="right">Denuncia Cuenta Corriente:</td>
		<td width="250"><?php echo $userArray['DenunciaCC'];?>&nbsp;</td>
		</tr>
		<tr>
		<td width="250" align="right">Riesgo Financiero:</td>
		<td width="250"><?php echo $userArray['RiesgoFin'];?>&nbsp;</td>
		</tr>
		
        <tr>
        <td width="250" align="right">CUIL/CUIT: </td>
        <td width="250"><?php echo $userArray['CUIL'];?>&nbsp;</td>
        </tr>
        <tr>
        <td width="250" align="right">Condicion: </td>
        <td width="250"><?php echo $userArray['Condicion'];?>&nbsp;</td>
        </tr>
        <tr>
        <td width="250" align="right">F931/AFIP: </td>
        <td width="250"><?php echo $userArray['F931'];?>&nbsp;</td>
        </tr>
        <tr>
        <td width="250" align="right">ART/ACC. Personales: </td>
        <td width="250"><?php echo $userArray['Poliza'];?>&nbsp;</td>
        </tr>
        <tr>
        <td width="250" align="right">Vigencia Desde: </td>
        <td width="250"><?php echo fecha_dma($userArray['VigenciaDesde']);?>&nbsp;</td>
        </tr>
        <tr>
        <td width="250" align="right">Vigencia Hasta: </td>
        <td width="250"><?php echo fecha_dma($userArray['VigenciaHasta']);?>&nbsp;</td>
        </tr>
        <tr>
        <td width="250" align="right">Seguro de Vida: </td>
        <td width="250"><?php echo $userArray['SeguroDeVida'];?>&nbsp;</td>
        </tr>
        <tr>
        <td width="250" align="right">Recibo Sueldo: </td>
        <td width="250"><?php echo $userArray['ReciboSueldo'];?>&nbsp;</td>
        </tr>
        <tr>
        <td width="250" align="right">No Repeticion: </td>
        <td width="250"><?php echo $userArray['Repeticion'];?>&nbsp;</td>
        </tr>
        <tr>
        <td width="250" align="right">Indemnidad: </td>
        <td width="250"><?php echo $userArray['Indemnidad'];?>&nbsp;</td>
        </tr>
        <tr>
        <td width="250" align="right">Responsable: </td>
        <td width="250"><?php echo $userArray['Responsable'];?>&nbsp;</td>
        </tr>
		
        <tr>
        <td>&nbsp;  </td>
		<td align="right">
			<input type="hidden" name="SubmitIdentif" value="Submit">
			<input type="image" src="images/enviar.gif" alt="enviar">
		</td>
         </tr>
    </table>
    </td>
    </tr>
</table>
</form>
<BR>
<a href="menu_empresa.php?Identif_digitado=<?php echo $_POST['Identif_digitado'];?>" ><img border="0" alt="resumen" src="images/resumen.gif"/></a>
<BR>
<a href="menu_empresa_list.php" target="blank" ><img border="0" alt="listados" src="images/listados.gif"/></a>
<BR>
<a href="salir.php"><img border="0" alt="salir" src="images/salir.gif"/></a>
</center>
</td>
  <td bgcolor="#FFFFFF" ></td>
</tr>
</table>
</body>
</html>
