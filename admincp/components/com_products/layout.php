<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","products");
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
	$objproduct=new CLS_PRODUCTS();
	if(isset($_SESSION['CANCELNEWID'])&&$_SESSION['CANCELNEWID']!=""){
            $objproduct->Delete($_SESSION['CANCELNEWID']);
        }
	if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
	{
		$objproduct->Name=addslashes($_POST["txtname"]);
		$objproduct->CataID=addslashes($_POST["cbo_cata"]);
		$objproduct->Unit=addslashes($_POST["txtunit"]);
		$objproduct->Quantity=addslashes($_POST["txtquantity"]);
		$objproduct->Video=addslashes($_POST["txtthumb"]);
        
		$txtjoindate=trim($_POST["txtcreadate"]);//dd-mm-yyyy
		$joindate = mktime(0,0,0,substr($txtjoindate,3,2),substr($txtjoindate,0,2),substr($txtjoindate,6,4));
		$objproduct->Joindate = date("Y-m-d",$joindate);
		$objproduct->Creator=$_SESSION["IGFUSERNAME"];
		$objproduct->Old_price=addslashes($_POST["txtoldprice"]);
		$objproduct->Cur_price=addslashes($_POST["txtcurprice"]);
        
        $objproduct->Sale=round(100-(((int)$_POST["txtcurprice"] / (int)$_POST["txtoldprice"])*100));
        
		$sproduct=addslashes($_POST['txtintro']);
		$objproduct->Intro=$sproduct;
		$objproduct->Fulltext=addslashes($_POST['txtdesc']);
		if(isset($_POST["cbocheck_iscan"]))
			$objproduct->Iscan=1;
		else
			$objproduct->Iscan=0;
		$objproduct->IsActive=(int)$_POST["optactive"];
		if(isset($_POST["txtid"])){
			$objproduct->ID=$_POST["txtid"];
		}
		//
		
		if($objproduct->ID=="-1")
		{
			$result_action = $objproduct->Add_new();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A01'</script>";
		}
		else{
			$result_action = $objproduct->Update();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U02'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U01'</script>";
		}
	}
	if(isset($_POST["txtaction"]) && $_POST["txtaction"]!="")
	{
		$conid=$_POST["txtids"];
		$conid=str_replace(",","','",$conid);
		switch ($_POST["txtaction"])
		{
			case "public": 		$objproduct->Publish($conid); 		break;
			case "unpublic": 	$objproduct->UnPublish($conid); 	break;
			case "edit": 	
				$id=explode("','",$conid);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&conid=".$id[0]."'</script>";
				exit();
				break;
			case "order"	: include(THIS_COM_PATH."tem/order.php"); break;	
			case "order_images"	: include("components/com_property/tem/order.php"); break;
			case "order_property"	: include("components/com_images/tem/order.php"); break;
			case "delete": 		$objproduct->Delete($conid); 		break;
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
	}
	if(isset($_POST["txtaction_images"]) && $_POST["txtaction_images"]!="")
	{
		$conid=$_POST["txtids_images"];
		$conid=str_replace(",","','",$conid);
		switch ($_POST["txtaction_images"])
		{
			case "order_images"	: include("components/com_property/tem/order.php"); break;
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&conid=".$id[0]."'</script>";
	}
	if(isset($_POST["txtaction_property"]) && $_POST["txtaction_property"]!="")
	{
		$conid=$_POST["txtids_property"];
		$conid=str_replace(",","','",$conid);
		switch ($_POST["txtaction_property"])
		{
			case "order_property"	: include("components/com_property/tem/order.php"); break;
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&conid=".$id[0]."'</script>";
	}

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
	// close object
	unset($objproduct);
	unset($objlag_pro);
?>