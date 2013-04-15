<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$catid="";
	if(isset($_GET["catid"]))
		$catid=$_GET["catid"];
	if(!isset($objcon))
		$objcon= new CLS_CONTENTS();
/*	if($objcon->getConByCateID($catid)==true)
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D04'</script>";
	else
	{*/
		$objcate=new CLS_CATE();
		$ids=$objcate->getChildID($catid);
		//echo $ids;  die();
		if($objcon->getConByCateID(substr($ids,0,strlen($ids)-1))==true)
			echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D05'</script>";
		else
		{
		$iddelete= $catid.",".substr($ids,0,strlen($ids)-1);
		$result = $objcate->Delete($iddelete);
		if(!$result)
			 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>";
		else
			 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
		}
	//}
?>