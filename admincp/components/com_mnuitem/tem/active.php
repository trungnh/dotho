<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$item="";
	if(isset($_GET["item"]))
		$item=$_GET["item"];
	if(!isset($objitem))
	$objitem=new CLS_MENUITEM();
	
	$mnuid=$_SESSION["MNUID"];
	$objitem->ActiveOnce($item);
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
?>