<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$id="";
	if(isset($_GET["id"]))
		$id=$_GET["id"];
	$objproduct=new CLS_EVENT_DETAIL();
	$result = $objproduct->Delete($id);
	if(!$result)
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>";
	else 
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
?>