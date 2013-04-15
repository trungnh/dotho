<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$imgid="";
	if(isset($_GET["imgid"]))
		$imgid=$_GET["imgid"];
	$objproduct=new CLS_IMAGES();
	$result = $objproduct->Delete($imgid);
	echo "<script language=\"javascript\">window.location='index.php?com=products&task=edit&proid=".$_SESSION["PROIMAGES"]."'</script>";
?>