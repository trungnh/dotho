<?php
session_start();
define("incl_path","../../includes/");
define("libs_path","../../libs/");
require_once(incl_path."gfconfig.php");
require_once(incl_path."gfinnit.php");
require_once(incl_path."gffunction.php");
// include libs
require_once(libs_path."innit_libs.php");

$objlog=new CLS_LOGIN();
if(isset($_SESSION['userid']) && isset($_SESSION['log_ip'])){
	$log_id_db = $objlog->getCurrentLogID($_SESSION['userid']);
	if($log_id_db!=$_SESSION['log_ip']){
		echo $log_id_db."-->not ok ".$_SESSION['log_ip'];
		//remote session
		unset($_SESSION['log_ip']); 
		unset($_SESSION['userid']); 
	 
		// or this would remove all the variables in the session, but not the session itself 
		session_unset(); 
	 
		// this would destroy the session variables 
		session_destroy();
		
		//go to alert page
		echo '<script type="text/javascript">location.replace("index.php?com=login_ok");</script>';
	}else
		echo $log_id_db."-->ok ".$_SESSION['log_ip'];
}else{
	echo "not set or deleted!";
}
?>
