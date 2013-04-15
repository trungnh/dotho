<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","catalogs");
	define("THIS_COM_PATH",COM_PATH."com_".COMS."/");
	// Begin Toolbar
	require_once(LAG_PATH."vi/lang_catalogs.php");
	require_once(libs_path."cls.catalogs.php");
	
	if(!isset($objlag_com)) $objlag_com = new LANG_CATALOGS;
	
	$title_manager = $objlag_com->CATA_MANAGER;
	if(isset($_GET["task"]) && $_GET["task"]=="add")
		$title_manager = $objlag_com->CATA_MANAGER_ADD;
	if(isset($_GET["task"]) && $_GET["task"]=="edit")
		$title_manager = $objlag_com->CATA_MANAGER_EDIT;
		
	require_once("includes/toolbar.php");
	// End toolbar
?>
<?php
	$objcata=new CLS_CATALOG();
	if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
	{
		$objcata->ParID=$_POST["cbo_cata"];
		$objcata->Name=$_POST["txtname"];
		
		$sContent=addslashes($_POST["txtintro"]);
		$objcata->Intro=$sContent;
		$objcata->isActive=$_POST["optactive"];
		if(isset($_POST["txtid"]))
		$objcata->ID=$_POST["txtid"];
		if($objcata->ID=="-1")
		{
			$result_action=$objcata->Add_new();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A01'</script>";
		}
		else {
			$result_action=$objcata->Update();
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
			case "public": 		$objcata->Publish($catid); 		break;
			case "unpublic": 	$objcata->UnPublish($catid); 	break;
			case "edit": 	
				$id=explode("','",$catid);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&catid=".$id[0]."'</script>";
				exit();
				break;
			case "order"	: include(THIS_COM_PATH."tem/order.php"); break;
			case "delete": 		$objcata->Delete($catid); 			break;
		}
		/*echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";*/
	}
	// close object
	unset($objcata);
	if(isset($_GET["task"]))
		$task=$_GET["task"];
	switch($task)
	{
		case "add"	: include(THIS_COM_PATH."tem/add.php"); 	break;
		case "edit"	: include(THIS_COM_PATH."tem/edit.php");	break;
		case "active"	: include(THIS_COM_PATH."tem/active.php");	break;
		case "ismenu"	: include(THIS_COM_PATH."tem/ismenu.php");	break;
		case "delete"	: include(THIS_COM_PATH."tem/delete.php");	break;
		default: include(THIS_COM_PATH."tem/list.php");
	}
?>