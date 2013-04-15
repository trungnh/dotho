<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$cataid="";
	if(isset($_GET["cataid"]))
		$cataid=$_GET["cataid"];
	$objcata=new CLS_CATALOG();
	$result = $objcata->Delete($cataid);
	if(!$result)
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>";
	else 
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
?>