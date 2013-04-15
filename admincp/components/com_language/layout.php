<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","language");
	include_once(LAG_PATH."vi/lang_language.php");
	require_once(libs_path."cls.language.php");
	
	if(!isset($obj_laglang)) $obj_laglang=new LANG_LANGUAGE;
	// Begin Toolbar
	$title_manager=$obj_laglang->LANGUAGE_MANAGER;
	if(isset($_GET["task"]) && $_GET["task"]=="add")
		$title_manager = $obj_laglang->LANGUAGE_MANAGER_ADD;
	if(isset($_GET["task"]) && $_GET["task"]=="edit")
		$title_manager = $obj_laglang->LANGUAGE_MANAGER_EDIT;
	require_once("includes/toolbar.php");
	// End toolbar
	$objlang=new CLS_LANGUAGE();
	if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
	{
		$result_action;
		//print_r ($_POST);
		$objlang->_Code=addslashes(trim($_POST["txtcode"]));
		$objlang->_Name=addslashes($_POST["txtname"]);
		$objlang->_Flag=addslashes($_POST["txtflag"]);
		$objlang->_Site=addslashes($_POST['optsite']);
		$objlang->isActive=(int)$_POST["optactive"];
		
		if(isset($_POST["txtid"]))
			$objlang->ID=(int)$_POST["txtid"];
		if($objlang->ID==-1){   
			$result_action=$objlang->Add_new();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A01'</script>";
		}
		else {
			$result_action=$objlang->Update();
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
			case "public": 		$objlang->Publish($mnuids); 		break;
			case "unpublic": 	$objlang->UnPublish($mnuids); 		break;
			case "edit": 	
				$id=explode("','",$mnuids);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&lagid=".$id[0]."'</script>";
				exit();
				break;
			case "delete": 		$objlang->Delete($mnuids); 			break;
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}
	
	define("THIS_COM_PATH",COM_PATH."com_".COMS."/");
	if(isset($_GET["task"]))
		$task=$_GET["task"];
	switch($task)
	{
		case "add"	: include(THIS_COM_PATH."tem/add.php"); 	break;
		case "edit"	: include(THIS_COM_PATH."tem/edit.php");	break;
		case "active"	: include(THIS_COM_PATH."tem/active.php");	break;
		case "default"	: include(THIS_COM_PATH."tem/default.php");	break;
		case "delete"	: include(THIS_COM_PATH."tem/delete.php");	break;
		default: include(THIS_COM_PATH."tem/list.php");
	}
	
	unset($objlang);
	unset($obj_laglang);
?>