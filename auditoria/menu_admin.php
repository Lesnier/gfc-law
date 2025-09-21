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
	<td bgcolor="#ffffff" width="900" height="100" align="center" ><img border="0" alt="AyC Abogados" src="images/banner_ayc_imagen2.png"/></td>
	<td bgcolor="#FFFFFF" ></td> 
</tr>
<tr>
	<td bgcolor="#FFFFFF" ></td> 
	<td bgcolor="#FFFFFF" width="900" align="center" >
<center>
Bienvenido al Sistema<BR>
<BR>
<H1>Menu principal del <B> administrador </B> </H1><br>
<BR>
<BR>
<table width="500" border="1" cellpadding="0" cellspacing="0">

<tr>
 <td>Mantenimiento de Empresas</td>
 <td><a href="empr_listado.php"><img border="0" alt="empresas" src="images/empresas.gif"/></a></td>
</tr>
<tr>
 <td>Mantenimiento de Proveedores</td>
 <td><a href="prov_listado.php"><img border="0" alt="proveedores" src="images/proveedores.gif"/></a></td>
</tr>
<tr>
 <td>Mantenimiento de Empleados</td>
 <td><a href="empl_listado.php"><img border="0" alt="empleados" src="images/empleados.gif"/></a></td>
</tr>
<BR>
</table>
<BR>
<a href="salir.php"><img border="0" alt="salir" src="images/salir.gif"/></a>
</center>
</td>
  <td bgcolor="#FFFFFF" ></td>
</tr>
</table>
</body>
</html>