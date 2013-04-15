<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$memid="";
	if(isset($_GET["ItemID"]))
		$memid=$_GET["ItemID"];
	if(!isset($objmember))
		$objmember=new CLS_ORDER();
		$objmember->ActiveOnce($memid);
		//header("location:index.php?com=".COMS);
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
				if(!$result)
			echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>"; 
		else 
			echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
?>