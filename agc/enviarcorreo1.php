<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GREMIAL AGC</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {color: #c11c16}
.Estilo3 {font-weight: bold;
	color: #FFFFFF;
}
body {
	background-color: #525252;
}
-->
</style>
</head>
<title>enviarcorreo</title><? //Recepcion de datos 
$apellido=$_POST['apellido']; 
$nombre=$_POST['nombre']; 
$correo=$_POST['correo']; $asunto=$_POST['asunto']; 
$consulta=$_POST['consulta']; 

// Fin de recpcion de datos 

// Accion de envio 

//---------// 

$para='laurapico79@hotmail.com'; 
$mensaje=' 

Mensaje de: 
'.$apellido.', '.$nombre.' 

Correo: 
'.$correo.' 

Asunto: 
'.$asunto.' 

Consulta: 
'.$consulta.' 
'; 
$desde='From: laurapico79@hotmail.com'; 
ini_set(sendmail_from,'laurapico79@hotmail.com'); 
mail($para,$asunto,$mensaje,$desde); 
echo''; 
?>
<body>
<div id="topPan">
	<a href="index.html"></a>
	<ul>
	  <li><a href="index.html">inicio</a></li>
		<li><a href="ACCION SOCIAL.html">a. social </a></li>
		<li><a href="FOTOS.html">fotos</a></li>
		<li><a href="CURSOS.html">cursos</a></li>
		<li><a href="Contacto.html">Contacto</a></li>
	</ul>
	
	<img src="images/logo.jpg" width="250" height="108" /></div>
<div id="bodytopmainPan">
<div id="bodytopPan">
	<h2 class="Estilo1">&nbsp;</h2>
	<p class="Estilo1">&nbsp;</p>
	<p align="center">Mensaje envido con exito, muchas gracias</p>
	<p align="center">&nbsp;</p>
	<p align="center">&nbsp;</p>
	<p>&nbsp;</p>
	<p> <a href="#"></a></p>
</div>
</div>
<div id="bodymainmiddlePan"></div>

<div id="footermainPan">
  <div id="footerPan"><a href="index.html"></a>
<ul>
      <li></li>
      <li></li>
      <li><a href="servicios.html"><span class="Estilo3">&copy; 2012 GREMIAL  AGC</span></a></li>
      <li><a href="productos.html"></a></li>
      <li></li>
    </ul>
    </div>
</div>
</body>
</html>
