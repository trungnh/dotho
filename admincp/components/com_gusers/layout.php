<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","gusers");

	// Begin Toolbar
	require_once(LAG_PATH."vi/lang_default.php");
	require_once(libs_path."cls.guser.php");
	
	if(!isset($obj_lagdefault)) $obj_lagdefault=new LANG_DEFAULT;
	
	$title_manager = "Phân quyền nhóm người dùng";
	if(isset($_GET["task"]) && $_GET["task"]=="add")
		$title_manager = "Thêm nhóm người dùng";
	if(isset($_GET["task"]) && $_GET["task"]=="edit")
		$title_manager = "Sửa nhóm người dùng";
		
	require_once("includes/toolbar.php");
	// End toolbar
	
	$obj=new CLS_GUSER();
	if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
	{
		$obj->ParID=$_POST["cbo_cate"];
		$obj->Name=addslashes($_POST["txtname"]);
		
		$sContent=addslashes($_POST['txtdesc']);
		$obj->Intro=encodeHTML($sContent);
		
		$obj->isActive=$_POST["optactive"];
		if(isset($_POST["txtid"]))
		$obj->ID=$_POST["txtid"];
		if($obj->ID=="-1")
		{
			$result1=$obj->Add_new();
			if(!$result1)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A01'</script>";
		}
		else {
			$result2=$obj->Update();
			if(!$result2)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U01'</script>";
		}
		//header("location:index.php?com=".COMS);
	}
	if(isset($_POST["txtaction"]) && $_POST["txtaction"]!="")
	{
		$catid=$_POST["txtids"];
		$catid=str_replace(",","','",$catid);
		switch ($_POST["txtaction"])
		{
			case "public": 		$obj->Publish($catid); 		break;
			case "unpublic": 	$obj->UnPublish($catid); 	break;
			case "edit": 	
				$id=explode("','",$catid);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&catid=".$id[0]."'</script>";
				exit();
				break;
			case "delete": 		$obj->Delete($catid); break;
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
	
unset($obj_lagdefault);
unset($obj); 
unset($result1);unset($result2);
?>