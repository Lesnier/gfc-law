<?php
include ("config.php") ;
include ("funciones.php") ;
$logout = true;
include ("secure.php") ;

$SaludoFinal = "hasta la proxima" ;
echo "<SCRIPT LANGUAGE=\"JavaScript\"> alert (\"Adios, " . $SaludoFinal . " \") ; </SCRIPT>" ; 

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
<BR>
<BR>
<h1>Gracias por utilizar nuestro sistema.</h1>
<br>
<a href="index.php"><img border="0" alt="salir" src="images/ingresar.gif"/></a>
<BR>
</td>
  <td bgcolor="#FFFFFF" ></td>
</tr>
</table>
</center>
</body>
</html>
