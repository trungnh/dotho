<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$mode="";
	$id= "";
	if(isset($_GET["comm_id"])){
		$comm_id=$_GET["comm_id"];
		if(!isset($objcomm))
			$objcomm=new CLS_COMM();
		$objcomm->getCommentByID($comm_id);
		if($objcomm->procomm['isactive']=='1'){
			$objcomm->UnPublish($comm_id);
		}else{
			$objcomm->Publish($comm_id);
		}
		 echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}