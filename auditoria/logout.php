<?PHP
session_start() ; 
unset($_SESSION['usuario'] ) ;
unset($_SESSION['clave'] ) ;
unset($_SESSION['IdEmpresa']) ;
unset($_SESSION['Empresa']) ;
unset($_SESSION['Pais']) ;
unset($_SESSION['Logo']) ;
$_SESSION = array();
session_destroy() ;
$sessionPath = session_get_cookie_params() ;
setcookie (session_name(), "", 0, $sessionPath['path'] , $sessionPath["domain"] ) ;
?>