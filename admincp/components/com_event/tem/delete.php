<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$eventid="";
	if(isset($_GET["eventid"]))
		$eventid=$_GET["eventid"];
	$objevent=new CLS_EVENT();
	$result = $objevent->Delete($eventid);
	if(!$result)
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>";
	else 
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
?>