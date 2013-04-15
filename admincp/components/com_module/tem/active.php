<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$modid="";
	if(isset($_GET["modid"]))
		$modid=$_GET["modid"];
	if(!isset($objmodule))
	$objmodule=new CLS_MODULE();
	
	$objmodule->ActiveOnce($modid);
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
?>