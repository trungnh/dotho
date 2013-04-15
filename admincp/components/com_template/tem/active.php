<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$temid="";
	if(isset($_GET["temid"]))
		$temid=$_GET["temid"];
	if(!isset($objtem))
	$objtem=new CLS_TEM();
	$objtem->ActiveOnce($temid);
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
?>