<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$lagid="";
	if(isset($_GET["lagid"]))
		$lagid=(int)$_GET["lagid"];
	$objlang=new CLS_LANGUAGE();
	$objlang->ActiveOnce($lagid);
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
?>