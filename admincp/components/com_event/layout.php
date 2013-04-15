<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","event");
	define("THIS_COM_PATH",COM_PATH."com_".COMS."/");
	// Begin Toolbar
	include_once(LAG_PATH."en/lang_products.php");
	$objlag_pro=new LANG_PRODUCTS;
	
	$title_manager=$objlag_pro->PRODUCT_MANAGER;
	if(isset($_GET["task"]) && $_GET["task"]=="add")
		$title_manager = $objlag_pro->PRODUCT_MANAGER_ADD;
	if(isset($_GET["task"]) && $_GET["task"]=="edit")
		$title_manager = $objlag_pro->PRODUCT_MANAGER_EDIT;
		
	require_once("includes/toolbar.php");
	// End toolbar
	$objevent=new CLS_EVENT();
	
	if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
	{
		$objevent->Name=$_POST["txtname"];
		$objevent->Icon=addslashes($_POST["txtthumb"]);
		$objevent->Intro=addslashes($_POST["txtdesc"]);
		if(isset($_POST["ismenu"]))
			$objevent->Ismenu=1;
		else
			$objevent->Ismenu=0;
		$objevent->isActive=(int)$_POST["optactive"];
		if(isset($_POST["txtid"])){
			$objevent->ID=$_POST["txtid"];
		}		
		if($objevent->ID=="-1")
		{
			$result_action = $objevent->Add_new();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A01'</script>";
		}
		else{
			$result_action = $objevent->Update();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A01'</script>";
		}
	}
	if(isset($_POST["txtaction"]) && $_POST["txtaction"]!="")
	{
		$conid=$_POST["txtids"];
		$conid=str_replace(",","','",$conid);
		switch ($_POST["txtaction"])
		{
			case "public": 		$objevent->Publish($conid); 		break;
			case "unpublic": 	$objevent->UnPublish($conid); 	break;
			case "edit": 	
				$id=explode("','",$conid);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&conid=".$id[0]."'</script>";
				exit();
				break;
			case "order_images"	: include(THIS_COM_PATH."tem/order.php"); break;	
			case "delete": 		$objevent->Delete($conid); 		break;
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}
	

	if(isset($_GET["task"]))
		$task=addslashes($_GET["task"]);
	switch($task)
	{
		case "add"	: include(THIS_COM_PATH."tem/add.php"); 	break;
		case "ismenu"	: include(THIS_COM_PATH."tem/ismenu.php"); 	break;
		case "edit"	: include(THIS_COM_PATH."tem/edit.php");	break;
		case "active"	: include(THIS_COM_PATH."tem/active.php");	break;
		case "delete"	: include(THIS_COM_PATH."tem/delete.php");	break;
		default: include(THIS_COM_PATH."tem/list.php");
	}
	// close object
	unset($objevent);
	unset($objlag_pro);
?>