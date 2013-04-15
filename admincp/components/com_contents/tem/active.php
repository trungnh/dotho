<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$conid="";
	if(isset($_GET["conid"]))
		$conid=$_GET["conid"];
	if(!isset($objcontent))
	$objcontent=new CLS_CONTENTS();
	
	$objcontent->ActiveOne($conid);
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
?>