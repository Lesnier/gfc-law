<?php
/***
funci�n conectar
que = se conecta a MySQL y devuelve el identificador de conexi�n
***/
function conectar(){
  global $HOSTNAME,$USERNAME,$PASSWORD,$DATABASE;
  $idcnx = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, 'mydb') or
    DIE (mysql_error());
  mysql_select_db($DATABASE, $idcnx);
  return $idcnx;
}

function fecha_dma($fecha){
	if ($fecha == "" || $fecha == "0000-00-00"){ 
	  return "" ; 
	}else{
	  return substr($fecha, 8, 2) . "-" . substr($fecha, 5, 2) . "-" . substr($fecha, 0, 4) ; 
	}
}

function ComboEmpresas($sel){
//Arma el combo para seleccionar Empresa
//nos conectamos a mysql
$CmbEmpr = conectar () ;
//consulta.
$sql  = "SELECT IdEmpresa, Empresa ";
$sql .= "FROM empresas " ;
$sql .= "WHERE Empresa <> 'AyC Abogados' " ;
$sql .= "ORDER BY Empresa ASC " ;
$res= mysqli_query($sql) or die (mysql_error());
//Se llena una variable con todo el texto del combo
if ($row = mysqli_fetch_array($res)){ 
	$rtn  = '<select name= "IdEmpresa">' ;
	do { 
		if ($sel == $row["IdEmpresa"]){ 
			$rtn .= '<option SELECTED value= "'.$row["IdEmpresa"].'">'.$row["Empresa"].'</option>' ;
		}else{
			$rtn .= '<option value= "'.$row["IdEmpresa"].'">'.$row["Empresa"].'</option>' ;
		}
	} while ($row = mysqli_fetch_array($res)) ; 
	$rtn .= '</select>' ;
}else{
	$rtn  = '<select name= "IdEmpresa"></select>' ;
}
mysql_close($CmbEmpr) ;
return $rtn ;
}

function ComboProveedores($IdEmpresa, $sel){
//Arma el combo para seleccionar Empresa
//nos conectamos a mysql
$CmbProv = conectar () ;
//consulta.
$sql  = "SELECT P.IdProveedor, CONCAT( P.Proveedor,  ' (', E.Empresa,  ')' ) AS Descrip " ;
$sql .= "FROM proveedores P " ;
$sql .= "INNER JOIN empresas E ON P.IdEmpresa = E.IdEmpresa " ;
$sql .= "WHERE E.IdEmpresa = '" . $IdEmpresa . "' " ;
$sql .= "ORDER BY E.Empresa ASC, P.Proveedor ASC " ;
$res= mysqli_query($sql) or die (mysql_error());
//Se llena una variable con todo el texto del combo
if ($row = mysqli_fetch_array($res)){ 
	$rtn  = '<select name= "IdProveedor">' ;
	do { 
		if ($sel == $row["IdProveedor"]){ 
			$rtn .= '<option SELECTED value= "'.$row["IdProveedor"].'">'.$row["Descrip"].'</option>' ;
		}else{
			$rtn .= '<option value= "'.$row["IdProveedor"].'">'.$row["Descrip"].'</option>' ;
		}
	} while ($row = mysqli_fetch_array($res)) ; 
	$rtn .= '</select>' ;
}else{
	$rtn  = '<select name= "IdProveedor"></select>' ;
}
mysql_close($CmbProv) ;
return $rtn ;
}

//Arma las opciones de los combos de EMPLEADO/AUTONOMO con el parametro seleccionado
function comboCondicion($sel){
	if ($sel == "AU"){ 
		$rtn  = '<option SELECTED value= "AU">AUTONOMO</option>' ;
		$rtn .= '<option value= "EM">EMPLEADO</option>' ;
	}else{
		$rtn  = '<option value= "AU">AUTONOMO</option>' ;
		$rtn .= '<option SELECTED value= "EM">EMPLEADO</option>' ;
	}
	return $rtn ;
}

//Arma las opciones de los combos de EMPLEADO/UNIPERSONAL con el parametro seleccionado
function comboCondicionUY($sel){
	if ($sel == "UN"){ 
		$rtn  = '<option SELECTED value= "UN">UNIPERSONAL</option>' ;
		$rtn .= '<option value= "EM">EMPLEADO</option>' ;
	}else{
		$rtn  = '<option value= "UN">UNIPERSONAL</option>' ;
		$rtn .= '<option SELECTED value= "EM">EMPLEADO</option>' ;
	}
	return $rtn ;
}

//Arma las opciones de los combos de SI/NO con el parametro seleccionado
function comboSiNo($sel){
	if ($sel == "SI"){ 
		$rtn  = '<option SELECTED value= "SI">SI</option>' ;
		$rtn .= '<option value= "NO">NO</option>' ;
	}else{
		$rtn  = '<option value= "SI">SI</option>' ;
		$rtn .= '<option SELECTED value= "NO">NO</option>' ;
	}
	return $rtn ;
}

//Arma las opciones de los combos de SI/NO/NC con el parametro seleccionado
function comboSiNoNc($sel){

	if($sel == "SI") {$selSI  = 'SELECTED';}else{$selSI  = '';} ;
	if($sel == "NO") {$selNO  = 'SELECTED';}else{$selNO  = '';} ;
	if($sel == "NC") {$selNC  = 'SELECTED';}else{$selNC  = '';} ;

	$rtn .= '<option '.$selSI .' value= "SI">SI </option>' ;
	$rtn .= '<option '.$selNO .' value= "NO">NO </option>' ;
	$rtn .= '<option '.$selNC .' value= "NC">NO CORRESPONDE </option>' ;

	return $rtn ;
}

//Arma las opciones de los combos de SI/NO/NA con el parametro seleccionado
function comboSiNoNa($sel){

	if($sel == "SI") {$selSI  = 'SELECTED';}else{$selSI  = '';} ;
	if($sel == "NO") {$selNO  = 'SELECTED';}else{$selNO  = '';} ;
	if($sel == "NA") {$selNA  = 'SELECTED';}else{$selNA  = '';} ;

	$rtn .= '<option '.$selSI .' value= "SI">SI </option>' ;
	$rtn .= '<option '.$selNO .' value= "NO">NO </option>' ;
	$rtn .= '<option '.$selNA .' value= "NA">No Aplica </option>' ;

	return $rtn ;
}

//Arma las opciones de los combos de SI / NO con SI seleccionado
function comboRiesgoFin($sel){

	if($sel == "STD"){$selSTD = 'SELECTED';}else{$selSTD = '';} ;
	if($sel == "S1") {$selS1  = 'SELECTED';}else{$selS1  = '';} ;
	if($sel == "S2") {$selS2  = 'SELECTED';}else{$selS2  = '';} ;
	if($sel == "S3") {$selS3  = 'SELECTED';}else{$selS3  = '';} ;
	if($sel == "S4") {$selS4  = 'SELECTED';}else{$selS4  = '';} ;
	if($sel == "S5") {$selS5  = 'SELECTED';}else{$selS5  = '';} ;
	if($sel == "S6") {$selS6  = 'SELECTED';}else{$selS6  = '';} ;
	if($sel == "NA") {$selNA  = 'SELECTED';}else{$selNA  = '';} ;

	$rtn  = '<option '.$selSTD.' value= "STD">STD</option>' ;
	$rtn .= '<option '.$selS1 .' value= "S1">S1 </option>' ;
	$rtn .= '<option '.$selS2 .' value= "S2">S2 </option>' ;
	$rtn .= '<option '.$selS3 .' value= "S3">S3 </option>' ;
	$rtn .= '<option '.$selS4 .' value= "S4">S4 </option>' ;
	$rtn .= '<option '.$selS5 .' value= "S5">S5 </option>' ;
	$rtn .= '<option '.$selS6 .' value= "S6">S6 </option>' ;
	$rtn .= '<option '.$selNA .' value= "NA">No Aplica </option>' ;

	return $rtn ;
}


?>