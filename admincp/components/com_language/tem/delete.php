<?php
    defined("ISHOME") or die("Can't acess this page, please come back!");
	$lagid="";
	if(isset($_GET["lagid"])) $lagid=$_GET["lagid"];
	if(!isset($objlang)) $objlang=new CLS_LANGUAGE();
	$objlang->ID = $lagid;
	$result = $objlang->Delete();
	if(!$result)
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>";
	else 
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
?>