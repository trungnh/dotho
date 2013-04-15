<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$item="";
	if(isset($_GET["item"]))
		$item=$_GET["item"];
	if(!isset($objitem))
	$objitem=new CLS_MENUITEM();
	
	$rerult = $objitem->Delete($item);
	if( $rerult==1)
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
	else 
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>";
?>