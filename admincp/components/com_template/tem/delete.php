<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$mnuid="";
	if(isset($_GET["mnuid"]))
		$mnuid=$_GET["mnuid"];
	$objmenu=new CLS_MENU();
	$objmenu->Delete($mnuid);
	echo "<script language=\"javascript\">window.location='index.php?com=menus'</script>";
?>