<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$cataid="";
	if(isset($_GET["cataid"]))
		$cataid=$_GET["cataid"];
	if(!isset($objcata))
		$objcata=new CLS_CATALOG();
	$objcata->IsmenuOnce($cataid);
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
?>