<?php
	$objlog=new CLS_LOGIN();
	$objuser=new CLS_USERS();
	//check all logout
	$objlog->updateTimeLogout();
	//if already login
			
	if(isset($_SESSION['IDLOG'])){
		$username = $_SESSION["IGFUSERNAME"];
		// session comparison with database
		//da ton tai session --> phai chay qua ham save ip roi chu?<br />

		if($_SESSION['IDLOG'] == $objlog->getCurrentLogID($_SESSION["IGFUSERID"])){
			//check expired
			if($objlog->checkTimeExpired($_SESSION["IGFUSERID"])){
				
				//echo "expired :";
				echo $_SESSION['IDLOG'];
				global $UserLogin;
				$UserLogin->LOGOUT();
				unset($_SESSION['IDLOG']); 
				
				echo "<script language=\"javascript\">window.location='index.php'</script>";
			}else
				//update timelogin
                //echo "update";
				$objlog->updateTimeLogin($_SESSION['IDLOG']);
		}else{
			//logout
			//header("Location: components/com_logout/logout.php");
			//echo "logout :".$_SESSION['IDLOG']."<br />";		
			global $UserLogin;
			$UserLogin->LOGOUT();
			unset($_SESSION['IDLOG']); 
			//if(isset($_SESSION['log_ip'])) echo "logout :".$_SESSION['log_ip'];
			/*echo "<script language=\"javascript\">window.location='index.php'</script>";
			echo '<script type="text/javascript">location.replace("components/com_logout/logout.php");</script>';*/
		}
	}else{		
		/*function curPageURL() {
			 $pageURL = 'http';
			 if(isset($_SERVER["HTTPS"])){
				if($_SERVER["HTTPS"] == "on") 
					{$pageURL .= "s";}
			 }
			 $pageURL .= "://";
			 if ($_SERVER["SERVER_PORT"] != "80") {
			  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			 } else {
			  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			  //echo $_SERVER["REQUEST_URI"];
			 }
			 return $pageURL;
		}
		if(curPageURL()!='http://2606.a.hostable.me/tuan/index.php'){
			//echo curPageURL();
			//echo '<script type="text/javascript">location.replace("index.php");</script>';
		}*/
		echo "not set session<br />";
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>