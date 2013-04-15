<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","order");
	
	// Begin Toolbar
	require_once(LAG_PATH."vi/lang_order.php");
	require_once(libs_path."cls.order.php");
	
	if(!isset($objlag_mnu)) $objlag_mnu=new LANG_ORDER;
	//
	$title_manager = $objlag_mnu->ORDER_MANAGER;
	if(isset($_GET["task"]) && $_GET["task"]=="add")
		$title_manager = $objlag_mnu->ORDER_MANAGER_ADD;
	if(isset($_GET["task"]) && $_GET["task"]=="edit")
		$title_manager = $objlag_mnu->ORDER_MANAGER_EDIT;
	
	require_once("includes/toolbar.php");
	// End toolbar
	
	
	$objorder=new CLS_ORDER();
	if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
	{
		$objORDER->Code=$_POST["txtcode"];
		$objORDER->Name=$_POST["txtname"];
		$sContent=stripslashes($_POST['txtdesc']);
		$objORDER->Desc=encodeHTML($sContent);
		$objORDER->isActive=$_POST["optactive"];
		if(isset($_POST["txtid"]))
		$objORDER->ID=$_POST["txtid"];
		if($objORDER->ID=="-1")
		{
			$result_action=$objORDER->Add_new();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A01'</script>";
		}
		else {
			$result_action=$objORDER->Update();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U01'</script>";
		}
	}
	if(isset($_POST["txtaction"]) && $_POST["txtaction"]!="")
	{
		$id=$_POST["txtids"];
		$id=str_replace(",","','",$id);
		switch ($_POST["txtaction"])
		{
			case "review": 		$objorder->review($id);		break;
			case "unreview": 	$objorder->unreview($id); 		break;
			case "paind": 	$objorder->paind($id); 		break;
			case "unpaind": 	$objorder->unpaind($id); 		break;
			case "destroy": 	$objorder->destroy($id); 		break;
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}

	
	if(isset($_GET["task"]))
		$task=$_GET["task"];
	define("THIS_COM_PATH",COM_PATH."com_".COMS."/");
	if(isset($_GET["task"]))
		$task=$_GET["task"];
	switch($task)
	{
		case "add"	: include(THIS_COM_PATH."tem/add.php"); 	break;
		case "edit"	: include(THIS_COM_PATH."tem/edit.php");	break;
		case "active"	: include(THIS_COM_PATH."tem/active.php");	break;
		case "delete"	: include(THIS_COM_PATH."tem/delete.php");	break;
		default: include(THIS_COM_PATH."tem/list.php");
	}	
	// close object
	unset($objORDER);
	unset($objlag_mnu);
?>