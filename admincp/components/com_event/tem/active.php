<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$eventid="";
	if(isset($_GET["eventid"]))
		$eventid=$_GET["eventid"];
	if(!isset($objevent))
	$objevent=new CLS_EVENT();
	$objevent->ActiveOne($eventid);
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
?>