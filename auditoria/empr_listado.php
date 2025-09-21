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
	<td bgcolor="#FFFFFF" width="900" height="100" align="center" ><img border="0" alt="AyC Abogados" src="images/banner_ayc_imagen2.png"/></td>
	<td bgcolor="#FFFFFF" ></td> 
</tr>
<tr>
	<td bgcolor="#FFFFFF" ></td> 
	<td bgcolor="#FFFFFF">
<center>
<BR>
<H1>Menu Principal de <B> Empresas </B> </H1><br>
<BR>

<table width="800" border="1" cellpadding="0" cellspacing="0">

<tr>
 <td>Empresa</td>
 <td>Nombre de la Empresa</td>
 <td colspan="4" align="center" > accion</td>
</tr>
<?php
//nos conectamos a mysql
$cnx = conectar () ;
//consulta.
$sql  = "SELECT E.IdEmpresa, E.Empresa, E.Pais " ;
$sql .= "FROM empresas E " ;
$sql .= "ORDER BY E.IdEmpresa ASC " ;
$res= mysql_query($sql) or die (mysql_error());

if ( mysql_num_rows($res) > 0) {
 //impresion de los datos.
 while (list ($IdEmpresa,$Empresa,$Pais) = mySQL_fetch_array($res)){
   echo "<tr><td>$IdEmpresa</td>\n";
   echo "<td>$Empresa</td>\n";
   echo "<td><a href='empr_ver.php?IdEmpresa=$IdEmpresa'><img border=\"0\" alt=\"ver\" src=\"images/ver.gif\"/></a></td>\n";
   echo "<td><a href='empr_editar.php?IdEmpresa=$IdEmpresa'><img border=\"0\" alt=\"editar\" src=\"images/editar.gif\"/></a></td>\n";
   echo "<td><a href='empr_eliminar.php?IdEmpresa=$IdEmpresa'><img border=\"0\" alt=\"eliminar\" src=\"images/eliminar.gif\"/></a></td>\n";
   echo "<td><a href='empr_reporte$Pais.php?IdEmpresa=$IdEmpresa' target='blank' ><img border=\"0\" alt=\"reporte\" src=\"images/reporte.gif\"/></a></td></tr>\n";
 }
}else{
 echo "<tr><td colspan='5' align='center' >no se obtuvieron resultados</td></tr>\n";
}
mysql_close($cnx);
?>
<tr>
 <td colspan="2" align="center" >ingresar nueva empresa</td>
 <td colspan="4" align="center" ><a href='empr_nuevo.php'><img border="0" alt="nuevo" src="images/nuevo.gif"/></a></td>
</td>
<tr>
 <td colspan="6" align="center" > <a href='menu_admin.php'><img border="0" alt="volver" src="images/volver.gif"/></a></td>
</td>
</table>
<BR>
<BR>
<a href="salir.php"><img border="0" alt="salir" src="images/salir.gif"/></a>
</center>
<td bgcolor="#FFFFFF"></td>
  <td bgcolor="#FFFFFF" ></td>
</tr>
</table>
</body>
</html>
