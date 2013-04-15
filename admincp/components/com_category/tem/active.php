<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$catid="";
	if(isset($_GET["catid"]))
		$catid=$_GET["catid"];
	if(!isset($objcat))
		$objcat=new CLS_CATE();
	$objcat->ActiveOnce($catid);
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
?>