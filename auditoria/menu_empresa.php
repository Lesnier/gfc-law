<?PHP
include ("config.php") ;
include ("funciones.php") ;
include ("secure.php") ;
?>
<?PHP
//Sipresiono el boton Submit, entonces accede a la base
//if (isset($_POST['SubmitIdentif'])){
//Si se recibio Identificacion (asi funciona tabmien con Enter)
if (isset($_POST['Identif_digitado'])){
	//nos conectamos a la bd
	$cnx = conectar();
	//buscamos al empleado
	$sql  = "SELECT L.Identificacion, L.Nombre AS Empl_Nombre, P.Proveedor AS Prov_Nombre, " ;
	$sql .= "       L.VigenciaDesde, L.VigenciaHasta " ;
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
		 or (date("Y-m-d") > $userArray ['VigenciaHasta'] && $userArray ['VigenciaHasta'] != "0000-00-00")){ 
			//valida vigencia
			$AptoIngreso = "NO";
		}
	} else {
		// Si no se encontraron userArrays
		$message = "<DIV STYLE=\"background-color:yellow\">El DNI <B>" . $_POST['DNI_digitado'] . "</B> no está ingresada en la base</DIV>";
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
			if (isset($_POST['Identif_digitado'])){
?>
			<tr bgcolor=#66ff66> <!-- verde -->
<?PHP
			} else {
			//por primera vez la colorea de gris
?>
			<tr bgcolor=#CCCCCC> <!-- gris -->
<?PHP
			}
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
        <td width="250"><?php echo $userArray['Empl_Nombre'];?>&nbsp;</td>
        </tr>
        <tr>
        <td width="250" align="right">Nombre del Proveedor: </td>
        <td width="250"><?php echo $userArray['Prov_Nombre'];?>&nbsp;</td>
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
<a href="menu_empresa_detalle<?php echo $_SESSION['Pais'];?>.php?Identif_digitado=<?php echo $_POST['Identif_digitado'];?>" ><img border="0" alt="detalle" src="images/detalle.gif"/></a>
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
