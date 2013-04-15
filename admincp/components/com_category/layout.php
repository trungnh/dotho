<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","category");

	// Begin Toolbar
	require_once(LAG_PATH."vi/lang_category.php");
	require_once(libs_path."cls.category.php");
	
	if(!isset($objlag_com)) $objlag_com = new LANG_CATEGORY;
	
	$title_manager = $objlag_com->CATE_MANAGER;
	if(isset($_GET["task"]) && $_GET["task"]=="add")
		$title_manager = $objlag_com->CATE_MANAGER_ADD;
	if(isset($_GET["task"]) && $_GET["task"]=="edit")
		$title_manager = $objlag_com->CATE_MANAGER_EDIT;
		
	require_once("includes/toolbar.php");
	// End toolbar
?>
<?php
	$objcate=new CLS_CATE();
	if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
	{
		$objcate->ParID=$_POST["cbo_cate"];
		$objcate->Name=$_POST["txtname"];
		
		$sContent=stripslashes($_POST['txtdesc']);
		$objcate->Desc=encodeHTML($sContent);
		
		$objcate->isActive=$_POST["optactive"];
		if(isset($_POST["txtid"]))
		$objcate->ID=$_POST["txtid"];
		if($objcate->ID=="-1")
		{
			$result_action=$objcate->Add_new();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A01'</script>";
		}
		else {
			$result_action=$objcate->Update();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U01'</script>";
		}
	}
	if(isset($_POST["txtaction"]) && $_POST["txtaction"]!="")
	{
		$catid=trim($_POST["txtids"]);
		if($catid!='')
			$catid = substr($catid,0,strlen($catid)-1);
		$catid=str_replace(",","','",$catid);
		switch ($_POST["txtaction"])
		{
			case "public": 		$objcate->Publish($catid); 		break;
			case "unpublic": 	$objcate->UnPublish($catid); 	break;
			case "edit": 	
				$id=explode("','",$catid);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&catid=".$id[0]."'</script>";
				exit();
				break;
			case "delete": 		$objcate->Delete($catid); 			break;
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}
	// close object
	unset($objcate);
	
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