<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$mnuid="";
	if(isset($_GET["mnuid"]))
		$mnuid=$_GET["mnuid"];
	$objmenu=new CLS_MENU();
	$result=$objmenu->Delete($mnuid);
	if(!$result)
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>";
	else 
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
?>