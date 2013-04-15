<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$mnuid="";
	if(isset($_GET["mnuid"]))
		$mnuid=$_GET["mnuid"];
	if(!isset($objmenu))
	$objmenu=new CLS_MENU();
	
	$objmenu->ActiveOnce($mnuid);
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
?>