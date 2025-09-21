<?php
//login o logout?
if ( isset ($logout) || isset ($_GET['logout'] ) || isset ($_POST ['logout'])) {
	//logout
	include("logout.php") ;
}else{
	//login
	include("checklogin.php") ;
}
?>