<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$id="";
	if(isset($_GET["id"]))
		$id=$_GET["id"];
	if(!isset($objmenu))
	$objmenu=new CLS_CONFIGCONTENT();
	
	$objmenu->ActiveOnce($id);
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
?>