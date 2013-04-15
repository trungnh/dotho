<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$comid="";
	if(isset($_GET["comid"]))
		$comid=$_GET["comid"];
	if(!isset($objcoms))
		$objcoms=new CLS_COMS();
	$objcoms->ActiveOnce($comid);
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
?>