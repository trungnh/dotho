<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$comid="";
	if(isset($_GET["comid"]))
		$comid=$_GET["comid"];
	$objmenu=new CLS_COMS();
	$result = $objmenu->Delete($comid);
	if(!$result)
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>";
	else 
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
?>