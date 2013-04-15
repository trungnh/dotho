<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$proid="";
	if(isset($_GET["proid"]))
		$proid=$_GET["proid"];
	$objproduct=new CLS_PRODUCTS();
	$result = $objproduct->Delete($proid);
	if(!$result)
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>";
	else 
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
?>