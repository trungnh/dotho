<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","module");
	define("THIS_COM_PATH",COM_PATH."com_".COMS."/");
	// Begin Toolbar
	include_once(LAG_PATH."vi/lang_module.php");
	
	$objlag_mod=new LANG_MODULE;
	
	$title_manager = $objlag_mod->MODULE_MANAGER;
	if(isset($_GET["task"]) && $_GET["task"]=="add")
		$title_manager = $objlag_mod->MODULE_MANAGER_ADD;
	if(isset($_GET["task"]) && $_GET["task"]=="edit")
		$title_manager = $objlag_mod->MODULE_MANAGER_EDIT;
		
	require_once("includes/toolbar.php");
	// End toolbar
	
	//print_r($_POST);die;
	$objmodule=new CLS_MODULE();
	if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
	{		
		$objmodule->Title=addslashes($_POST["txttitle"]);
		$objmodule->Type=addslashes($_POST["cbo_type"]);
		$objmodule->ViewTitle=(int)$_POST["optviewtitle"];
		if(isset($_POST["cbo_menutype"]))
			$objmodule->MnuID=(int)$_POST["cbo_menutype"];
		if(isset($_POST["cbo_theme"]))
		$objmodule->Theme=addslashes($_POST["cbo_theme"]);
		if(isset($_POST["cbo_cate"]))
			$objmodule->CatID=(int)$_POST["cbo_cate"];
		if(isset($_POST["txtcontent"])){
			$sContent=addslashes($_POST['txtcontent']);
			$objmodule->HTML=$sContent;
		}
		$objmodule->Position=addslashes($_POST["cbo_position"]);
		$objmodule->Mnuids=addslashes($_POST["txtmenus"]);
		$objmodule->Class=addslashes($_POST["txtclass"]);
		$objmodule->isActive=(int)$_POST["optactive"];
		
		if(isset($_POST["txtid"]))
			$objmodule->ID=(int)$_POST["txtid"];
		
		if($objmodule->ID=="-1")
		{
			$result_action=$objmodule->Add_new();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A01'</script>";
		}
		else {
			$result_action=$objmodule->Update();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U01'</script>";
		}
	}
	if(isset($_POST["txtaction"]) && $_POST["txtaction"]!="")
	{
		$modids=$_POST["txtids"];
		$modids=str_replace(",","','",$modids);
		switch ($_POST["txtaction"])
		{
			case "public": 		$objmodule->Publish($modids); 		break;
			case "unpublic": 	$objmodule->UnPublish($modids); 		break;
			case "edit": 	
				$id=explode("','",$modids);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&modid=".$id[0]."'</script>";
				exit();
				break;
            case "order"	: include(THIS_COM_PATH."tem/order.php"); break;
			case "delete": 		$objmodule->Delete($modids); 			break;
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}
	// close object
	unset($objmodule);
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
?>