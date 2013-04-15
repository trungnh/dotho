<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","mnuitem");
	
	// Begin Toolbar
	require_once(LAG_PATH."vi/lang_mnuitem.php");
	require_once(libs_path."cls.menuitem.php");
	
	if(!isset($objlag_mnu)) $objlag_mnu=new LANG_MENU;
	
	$title_manager = $objlag_mnu->MENUS_MANAGER;
	if(isset($_GET["task"]) && $_GET["task"]=="add")
		$title_manager = $objlag_mnu->MENU_MANAGER_ADD;
	if(isset($_GET["task"]) && $_GET["task"]=="edit")
		$title_manager = $objlag_mnu->MENU_MANAGER_EDIT;
		
	require_once("includes/toolbar.php");
	// End toolbar
	
	$objmenu= new CLS_MENU;
	$mnuid="";
	if(isset($_GET["mnuid"]) && $_GET["mnuid"]!="") 
	{
		$mnuid=$_GET["mnuid"];
		$_SESSION["MNUID"]=$mnuid;
		//echo "<script language=\"javascript\">window.location='index.php?com=".COMS);
	}
	if(isset($_POST["cbo_menutype"])){
		$mnuid=$_POST["cbo_menutype"];
		$_SESSION["MNUID"]=$mnuid;
	}
	$mnuid=$_SESSION["MNUID"];
	if(!isset($objmenu)) 
		$objmenu=new CLS_MENU();
		$objmenu->getMenuByID($mnuid);


	$objmnuitem=new CLS_MENUITEM();
	if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
	{
		$objmnuitem->Par_ID=addslashes($_POST["cbo_parid"]);
		$objmnuitem->Code=$_POST["txtcode"];
		$objmnuitem->Name=$_POST["txtname"];
		$sContent=stripslashes($_POST["txtdesc"]);
		$objmnuitem->Desc=encodeHTML($sContent);
		$objmnuitem->Mnu_ID=$mnuid; //
		$objmnuitem->Viewtype=addslashes($_POST["cbo_viewtype"]);
		if($objmnuitem->Viewtype=="block" || $objmnuitem->Viewtype=="list"){
			$objmnuitem->Cat_ID=addslashes($_POST["cbo_cate"]);
		}
		else if($objmnuitem->Viewtype=="article"){		
			$objmnuitem->Con_ID=addslashes($_POST["cbo_article"]);
		}
		else{
			$objmnuitem->Link=addslashes($_POST["txtlink"]);
		}
		$objmnuitem->Class=$_POST["txtclass"];
		//$objmnuitem->Link=addslashes($_POST["txtlink"]);
		$objmnuitem->isActive=$_POST["optactive"];
		if(isset($_POST["txtid"]))
		$objmnuitem->ID=$_POST["txtid"];
		if($objmnuitem->ID=="-1")
		{
			$result_action=$objmnuitem->Add_new();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A01'</script>";
				
		}
		else {
			$result_action=$objmnuitem->Update();
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
			case "public": 		$objmnuitem->Publish($mnuids); 		break;
			case "unpublic": 	$objmnuitem->UnPublish($mnuids); 		break;
			case "edit": 	
				$id=explode("','",$mnuids);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&item=".$id[0]."'</script>";
				exit();
				break;
			case "delete": 		$objmnuitem->Delete($mnuids); 			break;
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
		case "delete"	: include(THIS_COM_PATH."tem/delete.php");	break;
		default: include(THIS_COM_PATH."tem/list.php");
	}
	
	// close object
	unset($objmnuitem);
	unset($objlag_mnu);
	unset($objmenu);
?>