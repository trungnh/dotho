<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$id="";
	if(isset($_GET["id"]))
		$id=$_GET["id"];
	/*
	$objmenu=new CLS_CONFIGCONTENT();
	$result=$objmenu->Delete($id);
	if(!$result)
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02"); 
	else 
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01");
	*/
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D04'</script>";
?>