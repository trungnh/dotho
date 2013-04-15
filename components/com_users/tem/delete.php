<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$memid="";
	if(isset($_GET["memid"]))
		$memid=$_GET["memid"];
	if(!isset($objmember))
		$objmember=new CLS_USERS();
	if($objmember->isAdmin()==true) {
		$result = $objmember->Delete($memid);
		if(!$result)
			echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>"; 
		else 
			echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
	}
?>