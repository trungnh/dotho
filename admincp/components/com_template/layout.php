<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","template");
	
	// Begin Toolbar
	require_once(LAG_PATH."vi/lang_tem.php");
	require_once(libs_path."cls.tem.php");
	
	if(!isset($objlag_tem)) $objlag_tem=new LANG_TEM;
	
	$title_manager = $objlag_tem->TEM_MANAGER;
	if(isset($_GET["task"]) && $_GET["task"]=="add")
		$title_manager = $objlag_tem->TEM_MANAGER_ADD;
	if(isset($_GET["task"]) && $_GET["task"]=="edit")
		$title_manager = $objlag_tem->TEM_MANAGER_EDIT;
		
	require_once("includes/toolbar.php");
	// End toolbar
	
	$objtem=new CLS_TEM();
	if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
	{
		$objtem->Name=addslashes($_POST["txtname"]);
		$sContent=addslashes($_POST['txtdesc']);
		$objtem->Desc=encodeHTML($sContent);
		$objtem->isDefault=(int)$_POST["optactive"];
		if(isset($_POST["txtid"]))
			$objtem->ID=(int)$_POST["txtid"];
		if($objtem->ID=="-1"){
			$objtem->Add_new();
		}
		else{
			$objtem->Update();
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}
	if(isset($_POST["txtaction"]) && $_POST["txtaction"]!="")
	{
		$temids=$_POST["txtids"];
		$temids=str_replace(",","','",$temids);
		switch ($_POST["txtaction"])
		{
			case "public": 		$objtem->Publish($temids); 		break;
			case "unpublic": 	$objtem->UnPublish($temids); 	break;
			case "edit":	
				$id=explode("','",$temids);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&temid=".$id[0]."'</script>";
				exit();
				break;
			case "delete": 		$objtem->Delete($temids); 		break;
		}
		header("location:index.php?com=".COMS);
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
	unset($objtem);
	unset($objlag_tem);
?>