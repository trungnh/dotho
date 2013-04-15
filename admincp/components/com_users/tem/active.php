<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$memid="";
	if(isset($_GET["memid"]))
		$memid=$_GET["memid"];
	if(!isset($objmember))
		$objmember=new CLS_USERS();
	if($objmember->isAdmin()==true) {
		$objmember->ActiveOnce($memid);
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}
?>