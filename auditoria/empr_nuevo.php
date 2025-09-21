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
	<td bgcolor="#FFFFFF" width="900" align="center" >
<center>
<BR>
<H1>Menu Principal de <B> Empresas </B> [NUEVO]</H1><br>
<BR>

<?php

function validar(){
	$message = "" ;
	if($_POST ['Empresa'] == "") {
		$message = "Debe ingresar el nombre de la empresa";
	}elseif($_POST ['Identificacion'] < 10000000000 || $_POST ['Identificacion'] > 99999999999 ){
		$message = "Debe ingresar Identificacion con mas de 10 dígitos";
	}elseif($_POST ['Usuario'] == "" ) {
		$message = "Debe ingresar un usuario";
	}elseif($_POST ['Clave'] == "" ) {
		$message = "Debe ingresar una clave";
	}elseif($_FILES["Logo"]["error"] > 0 && $_FILES["Logo"]["name"] != "") {
			$message = "Error con el archivo del Logo " . $_FILES["Logo"]["name"] . " Error: " . $_FILES["Logo"]["error"] ;
	}
	return $message;
}

//si el formulario ha sido enviado validamos los datos.
if(isset ($_POST['submit'])) {
	//valida los datos del formulario.
	$message = validar() ;
	//si los datos son validos editamos el registro.
	if($message != "") {
	}else{
		if($_FILES["Logo"]["name"] != "") { 
		// sube el archivo con el logo
			if (file_exists($CFG_SUBCARPETA . "/" . $_FILES["Logo"]["name"])) {
				echo "<BR>El Archivo: " . $_FILES["Logo"]["name"] . " se ha reemplazado. ";
			} else {
				echo "<BR>El Archivo: " . $_FILES["Logo"]["name"] . " se ha cargado. ";
			}
			echo "<BR>" ;
			move_uploaded_file($_FILES["Logo"]["tmp_name"], $CFG_SUBCARPETA . "/" . $_FILES["Logo"]["name"]);
		}
		//nos conectamos a mysql
		$cnx = conectar ();
		$campos = "Empresa, Pais, Identificacion, Usuario, Clave, Logo";
		$valores  = "";
		$valores .= "'" . $_POST ['Empresa'] . "' , ";
		$valores .= "'" . $_POST ['Pais'] . "' , ";
		$valores .= "'" . $_POST ['Identificacion'] . "' , ";
		$valores .= "'" . $_POST ['Usuario'] . "' , ";
		$valores .= "'" . $_POST ['Clave'] . "' , ";
		$valores .= "'" . $_FILES["Logo"]["name"] . "' ";
		$sql = "INSERT INTO empresas (" . $campos . ") VALUES (" . $valores . ") ";
		$res = mysql_query ($sql);// or die (mysql_error() ) ;
		
		if (mysql_errno() !=0 ) {
			$message  = "<BR>Asegurese de no repetir el nombre de la empresa ni el usuario " ;
			$message .= "\n<BR><!--" ;
			$message .= "\n<BR>mysql_errno " . mysql_errno() ;
			$message .= "\n<BR>mysql_error " . mysql_error() ;
			$message .= "\n<BR>query " . $sql ;
			$message .= "\n<BR>-->" ;
			$message .= "<BR>" ;
		} else {
			echo "La empresa ". $_POST['Empresa'] ." ha sido agregada";
			echo "<br><a href='empr_listado.php'><img border=\"0\" alt=\"volver\" src=\"images/volver.gif\"/></a>" ;
			mysql_close($cnx) ;
			exit;
		}
	}
}
?>
<?php
//Arma los valores por defecto para mostrar en el formulario
//si el formulario ha sido enviado y llega hasta aqui es porque hay errores.
if(isset ($_POST['submit'])) {
	$Empresa = $_POST ['Empresa'] ;
	$Pais = $_POST ['Pais'] ;
	$Identificacion = $_POST ['Identificacion'] ;
	$Usuario = $_POST ['Usuario'] ;
	$Clave = $_POST ['Clave'] ;
	$Logo = $_POST ['Logo'] ;
}else{
	$Empresa = '' ;
	$Pais = '' ;
	$Identificacion = '' ;
	$Usuario = '' ;
	$Clave = '' ;
	$Logo = '' ;
}
?> 

<form name="form1" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] ; ?> ">
<table width="500" border="1" cellpadding="0" cellspacing="0">

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
<td width="200">*Empresa</td>
<td width="300"><input name="Empresa" type="text" id="Empresa" value="<?php echo $Empresa ; ?>"></td>
</tr>
<tr>
<td width="200">*Pais</td>
<td width="300">
	<select name= "Pais">
		<option <?php if($Pais == "AR") {echo 'SELECTED';} ?> value= "AR">Argentina</option>
		<option <?php if($Pais == "UY") {echo 'SELECTED';} ?> value= "UY">Uruguay</option>
		<option <?php if($Pais == "CS") {echo 'SELECTED';} ?> value= "CS">TGLT</option>
	</select>
</td>
</tr>
<tr>
<td width="200">*Identificacion</td>
<td width="300"><input name="Identificacion" type="text" id="Identificacion" value="<?php echo $Identificacion ; ?>"></td>
</tr>
<tr>
<td width="200">*Usuario</td>
<td width="300"><input name="Usuario" type="text" id="Usuario" value="<?php echo $Usuario ; ?>"></td>
</tr>
<tr>
<td width="200">*Clave</td>
<td width="300"><input name="Clave" type="text" id="Clave" value="<?php echo $Clave ; ?>"></td>
</tr>
<tr>
<td width="200">Logo</td>
<td width="300"><input name="Logo" type="file" id="Logo" value="<?php echo $Logo ; ?>"></td>
</tr>

<tr>
<td width="200" align='left'><a href='empr_listado.php'><img border="0" alt="volver" src="images/volver.gif"/></a></td>
<td width="300" align="right">
	<input type="hidden" name="submit" value="enviar">
	<input type="image" src="images/enviar.gif" alt="enviar">
</td>

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
