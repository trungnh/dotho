<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$id="";
	if(isset($_GET["id"]))
		$id=$_GET["id"];
	if(!isset($objproduct))
	$objproduct=new CLS_EVENT_DETAIL();
	$objproduct->ActiveOne($id);
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
?>