<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","components");

	// Begin Toolbar
	require_once(LAG_PATH."vi/lang_component.php");
	require_once(libs_path."cls.component.php");
	
	if(!isset($objlag_com)) $objlag_com=new LANG_COMPONENT;
	
	$title_manager = $objlag_com->COMPONENT_MANAGER;
	if(isset($_GET["task"]) && $_GET["task"]=="add")
		$title_manager = $objlag_com->COMPONENT_MANAGER_ADD;
	if(isset($_GET["task"]) && $_GET["task"]=="edit")
		$title_manager = $objlag_com->COMPONENT_MANAGER_EDIT;
		
	require_once("includes/toolbar.php");
	// End toolbar
	
	$objcoms=new CLS_COMS();
	if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
	{
		$objcoms->Code=$_POST["txtcode"];
		$objcoms->Name=$_POST["txtname"];
		$sContent=stripslashes($_POST['txtdesc']);
		$objcoms->Desc=encodeHTML($sContent);
		$objcoms->Site=$_POST["cbo_site"];
		$objcoms->isActive=$_POST["optactive"];
		if(isset($_POST["txtid"]))
		$objcoms->ID=$_POST["txtid"];
		if($objcoms->ID=="-1")
		{
			$result_action=$objcoms->Add_new();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A01'</script>";
		}
		else {
			$result_action=$objcoms->Update();
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
			case "public": 		$objcoms->Publish($mnuids); 		break;
			case "unpublic": 	$objcoms->UnPublish($mnuids); 		break;
			case "edit": 	
				$id=explode("','",$mnuids);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&comid=".$id[0]."'</script>";
				exit();
				break;
			case "delete": 		$objcoms->Delete($mnuids); 			break;
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}
	// close object
	unset($objcoms);
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
?>