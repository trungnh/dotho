<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","comment");
	
	// Begin Toolbar
	require_once(LAG_PATH."vi/lang_comment.php");
	require_once(libs_path."cls.comment.php");
	
	if(!isset($objlag_mnu)) $objlag_mnu=new LANG_COMM;
	
	$title_manager = $objlag_mnu->COMMS_MANAGER;
	if(isset($_GET["task"]) && $_GET["task"]=="add")
		$title_manager = $objlag_mnu->COMM_MANAGER_ADD;
	if(isset($_GET["task"]) && $_GET["task"]=="edit")
		$title_manager = $objlag_mnu->COMM_MANAGER_EDIT;
		
	require_once("includes/toolbar.php");
	//End toolbar
	
	
	//Processing---------------------------------------------------------------------------------
	$objcomment=new CLS_COMM();
	if(isset($_POST["txtaction"]) && $_POST["txtaction"]!="")
	{
		$comm_id=$_POST["txtids"];
		$comm_ids=str_replace(",","','",$comm_id);
		switch ($_POST["txtaction"])
		{
			case "public": 		$objcomment->Publish($comm_ids); 		break;
			case "unpublic": 	$objcomment->UnPublish($comm_ids); 		break;
			case "delete": 		$objcomment->Delete($comm_ids); 			break;
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}
	//Controller  -------------------------------------------------------------------------------
	if(isset($_GET["task"]))
		$task=$_GET["task"];
	define("THIS_COM_PATH",COM_PATH."com_".COMS."/");
	if(isset($_GET["task"]))
		$task=$_GET["task"];
	switch($task)
	{
		case "active"	: include(THIS_COM_PATH."tem/active.php");	break;
                case "edit"	: include(THIS_COM_PATH."tem/edit.php");	break;
		case "delete"	: include(THIS_COM_PATH."tem/delete.php");	break;
		default: include(THIS_COM_PATH."tem/list.php");
	}	
	// close object
	unset($objcomment);
?>