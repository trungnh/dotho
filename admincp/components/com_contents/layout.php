<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","contents");
	define("THIS_COM_PATH",COM_PATH."com_".COMS."/");
	// Begin Toolbar
	include_once(LAG_PATH."en/lang_contents.php");
	$objlag_con=new LANG_CONTENTS;
	
	$title_manager=$objlag_con->CONTENT_MANAGER;
	if(isset($_GET["task"]) && $_GET["task"]=="add")
		$title_manager = $objlag_con->CONTENT_MANAGER_ADD;
	if(isset($_GET["task"]) && $_GET["task"]=="edit")
		$title_manager = $objlag_con->CONTENT_MANAGER_EDIT;
		
	require_once("includes/toolbar.php");
	// End toolbar
	$objcontent=new CLS_CONTENTS();
	
	if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
	{
		$objcontent->Title=addslashes($_POST["txttitle"]);
		$objcontent->Code=addslashes($_POST["txtcode"]);
		$objcontent->CatID=addslashes($_POST["cbo_cate"]);
		$objcontent->Intro=addslashes($_POST["txtintro"]);
		
		$txtjoindate=trim($_POST["txtcreadate"]);//dd-mm-yyyy
		$joindate = mktime(0,0,0,substr($txtjoindate,3,2),substr($txtjoindate,0,2),substr($txtjoindate,6,4));
		$objcontent->CreateDate = date("Y-m-d",$joindate);
		
		if(isset($_POST["txtmodify"])) {
			$txtjoindate2=trim($_POST["txtmodify"]);//dd-mm-yyyy
			$joindate2 = mktime(0,0,0,substr($txtjoindate2,3,2),substr($txtjoindate2,0,2),substr($txtjoindate2,6,4));
			$objcontent->ModifyDate = date("Y-m-d",$joindate2);
		}
		if(isset($_POST["txtauthor"]))  $objcontent->Author=addslashes($_POST["txtauthor"]);
		$objcontent->MetaKey=addslashes($_POST["txtmetakey"]);
		$objcontent->MetaDesc=addslashes($_POST["textmetadesc"]);
		$objcontent->GmID=addslashes($_POST["cbo_groupmem"]);
		$sContent=addslashes($_POST['txtdesc']);
		$objcontent->Fulltext=$sContent;
		$objcontent->IsActive=(int)$_POST["optactive"];
		if(isset($_POST["txtid"])){
			$objcontent->ID=$_POST["txtid"];
		}
		//
		
		if($objcontent->ID=="-1")
		{
			$result_action = $objcontent->Add_new();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A01'</script>";
		}
		else{
			$result_action = $objcontent->Update();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U01'</script>";
		}
	}
	if(isset($_POST["txtaction"]) && $_POST["txtaction"]!="")
	{
		$conid=$_POST["txtids"];
		$conid=str_replace(",","','",$conid);
		switch ($_POST["txtaction"])
		{
			case "public": 		$objcontent->Publish($conid); 		break;
			case "unpublic": 	$objcontent->UnPublish($conid); 	break;
			case "edit": 	
				$id=explode("','",$conid);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&conid=".$id[0]."'</script>";
				exit();
				break;
			case "order"	: include(THIS_COM_PATH."tem/order.php"); break;	
			case "delete": 		$objcontent->Delete($conid); 		break;
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}
	

	if(isset($_GET["task"]))
		$task=addslashes($_GET["task"]);
	switch($task)
	{
		case "add"	: include(THIS_COM_PATH."tem/add.php"); 	break;
		case "edit"	: include(THIS_COM_PATH."tem/edit.php");	break;
		case "active"	: include(THIS_COM_PATH."tem/active.php");	break;
		case "delete"	: include(THIS_COM_PATH."tem/delete.php");	break;
		default: include(THIS_COM_PATH."tem/list.php");
	}
	// close object
	unset($objcontent);
	unset($objlag_con);
?>