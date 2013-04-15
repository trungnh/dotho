<?php
session_start();
define("incl_path","../../includes/");
define("libs_path","../../libs/");
require_once(incl_path."gfconfig.php");
require_once(incl_path."gfinnit.php");
require_once(incl_path."gffunction.php");
// include libs
require_once(libs_path."innit_libs.php");
$objuser=new CLS_USER;
$objlog =  new CLS_LOGIN;
if(isset($_POST['username'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	if($objuser->login($username,$password)){
		//check log exists
		echo $objlog->getCurrentLogID($objuser->getIDUser($username));
		if($objlog->getCurrentLogID($objuser->getIDUser($username))!=0){
			//delete log
			$objlog->deleteLog($objlog->getCurrentLogID($objuser->getIDUser($username)));
		}
		//save log in table login
		$objlog->saveIp($objlog->getRealIpAddr(),$objuser->getIDUser($username));
		//echo "Đăng nhập thành công <br /> new log_ip:".$objlog->getCurrentLogID($objuser->getIDUser($username));
		//save session
		$_SESSION['log_ip'] = $objlog->getCurrentLogID($objuser->getIDUser($username));
		$_SESSION['userid'] = $objuser->getIDUser($username);
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		echo '<script type="text/javascript">location.replace("../../index.php?com=login_ok");</script>';
	}else{
		echo '<script type="text/javascript">location.replace("../../index.php?com=login_error");</script>';
	}
}
?>