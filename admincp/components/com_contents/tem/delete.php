<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$conid="";
	if(isset($_GET["conid"]))
		$conid=$_GET["conid"];
	$objcontent=new CLS_CONTENTS();
	$result = $objcontent->Delete($conid);
	if(!$result)
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>";
	else 
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
?>