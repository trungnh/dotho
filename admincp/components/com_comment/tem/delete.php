<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$comm_id="";
	if(isset($_GET["comm_id"]))
		$comm_id=$_GET["comm_id"];
	$objcomment=new CLS_COMM();
	$result=$objcomment->Delete($comm_id);
	if(!$result)
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>";
	else 
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
?>