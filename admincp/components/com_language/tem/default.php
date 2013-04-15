<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$lagid="";
	if(isset($_GET["lagid"]))
		$lagid=(int)$_GET["lagid"];
	$objlang=new CLS_LANGUAGE();
	if(!$objlang->setDefault($lagid,$_SESSION["ACTION_SITE"]))
	{
		echo "Loi"; 
	}else
	header("location:index.php?com=".COMS);
?>