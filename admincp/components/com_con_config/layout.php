<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","con_config");
	
	// Begin Toolbar
	require_once(LAG_PATH."vi/lang_default.php");
	require_once(libs_path."cls.configcontent.php");
	
	if(!isset($objlag_mnu)) $objlag_mnu=new LANG_DEFAULT;
	
	$title_manager = $objlag_mnu->DEFAULT_MANAGER;
	if(isset($_GET["task"]) && $_GET["task"]=="add")
		$title_manager = $objlag_mnu->DEFAULT_MANAGER_ADD." Config Article";
	if(isset($_GET["task"]) && $_GET["task"]=="edit")
		$title_manager = $objlag_mnu->DEFAULT_MANAGER_EDIT." Config Article";
		
	require_once("includes/toolbar.php");
	// End toolbar
	
	$objmenu=new CLS_CONFIGCONTENT();
	if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
	{
		$objmenu->Icon=$_POST["txtthumb"];
		$objmenu->Name=$_POST["txtname"];
		$objmenu->ShowName=$_POST["optname"];
		$objmenu->ShowIcon=$_POST["opticon"];
		$objmenu->isActive=$_POST["optactive"];
		if(isset($_POST["txtid"]))
		$objmenu->ID=$_POST["txtid"];
		if($objmenu->ID=="-1")
		{
			$result_action=$objmenu->Add_new();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A01'</script>";
		}
		else {
			$result_action=$objmenu->Update();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U01'</script>";
		}
	}
	if(isset($_POST["txtaction"]) && $_POST["txtaction"]!="")
	{
		$mnuids=$_POST["txtids"];
		$mnuids=str_replace(",","','",$mnuids);
		switch ($_POST["txtaction"])
		{
			case "public": 		$objmenu->Publish($mnuids); 		break;
			case "unpublic": 	$objmenu->UnPublish($mnuids); 		break;
			case "edit": 	
				$id=explode("','",$mnuids);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&mnuid=".$id[0]."'</script>";
				exit();
				break;
			case "delete": 		//$objmenu->Delete($mnuids); 			break;
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
		case "showname"	: include(THIS_COM_PATH."tem/show.php");	break;
		case "showicon"	: include(THIS_COM_PATH."tem/show.php");	break;
		case "delete"	: include(THIS_COM_PATH."tem/delete.php");	break;
		default: include(THIS_COM_PATH."tem/list.php");
	}	
	// close object
	unset($objmenu);
	unset($objlag_mnu);
?>