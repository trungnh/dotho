<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$proid="";
	if(isset($_GET["proid"]))
		$proid=$_GET["proid"];
	if(!isset($objproduct))
	$objproduct=new CLS_PRODUCTS();
	$objproduct->ActiveOne($proid);
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
?>