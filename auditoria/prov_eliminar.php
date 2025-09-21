<?PHP
include ("config.php") ;
include ("funciones.php") ;
include ("secure.php") ;
?>
<?php
//si no se recibe el formulario y no hay Proveedor para eliminar, no puede seguir vuelve a la lista.
if (!isset ($_POST['submit']) && empty($_GET['IdProveedor'])){
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
<H1>Menu Principal de <B> Proveedores </B> [ELIMINAR]</H1><br>
<BR>

<?php
//si el formulario ha sido enviado se elimina el registro
if (isset ($_POST['submit']) ) {
	//nos conectamos a mysql
	$cnx = conectar () ;
	$sql  = "DELETE FROM proveedores ";
	$sql .= "WHERE IdProveedor=". $_POST['IdProveedor'] ;
	$res = mysql_query ($sql);// or die (mysql_error () ) ;

		if (mysql_errno() !=0 ) {
			$message  = "<BR>Asegurese de eliminar todos los empleados antes de eliminar el proveedor " ;
			$message .= "\n<BR><!--" ;
			$message .= "\n<BR>mysql_errno " . mysql_errno() ;
			$message .= "\n<BR>mysql_error " . mysql_error() ;
			$message .= "\n<BR>query " . $sql ;
			$message .= "\n<BR>-->" ;
			$message .= "<BR>" ;
		} else {
			echo "El proveedor ". $_POST['IdProveedor'] ." ha sido eliminado";
			echo "<br><a href='prov_listado.php'><img border=\"0\" alt=\"volver\" src=\"images/volver.gif\"/></a>" ;
			mysql_close($cnx) ;
			exit;
		}
	$IdProveedor = $_POST['IdProveedor'] ;
}else{
	$IdProveedor = $_GET['IdProveedor'] ;
}
?>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table width="400" border="0" cellpadding="0" cellspacing="0">

<tr>
<td height="24" COLSPAN="6" ALIGN="center"> <i><NOBR>
<DIV STYLE="background-color:yellow">
<?PHP
//revisa si hay mensajes de error.
if ($message) {
echo $message;
} ?>
</NOBR></i>
</DIV>
</td>
</tr>

<tr>
<td><input name="IdProveedor" type="hidden" id="IdProveedor" value="<?php echo $IdProveedor;?>">
<br>
¿Seguro de querer borrar 
El proveedor <?php echo $IdProveedor;?>?</td>
</tr>

<tr>
<td>&nbsp;</td>
<td align="right">
	<input type="hidden" name="submit" value="eliminar">
	<input type="image" src="images/eliminar.gif" alt="eliminar">
</td>
</tr>

<tr>
<td align="center"><a href = "prov_listado.php"><img border="0" alt="volver" src="images/volver.gif"/></a></td>
</tr>

</table>
</form>
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
