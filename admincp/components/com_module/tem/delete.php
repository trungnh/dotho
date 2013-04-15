<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$modid="";
	if(isset($_GET["modid"]))
		$modid=$_GET["modid"];
	$objmodule=new CLS_MODULE();
	$result = $objmodule->Delete($modid);
	if(!$result)
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>"; 
	else 
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
?>