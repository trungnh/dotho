<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","event_detail");
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
	if(!isset($objeventdetail))
	$objeventdetail= new CLS_EVENT_DETAIL();
	
	if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
	{
		$objeventdetail->ProID=$_SESSION["PROIMAGES"];
		$objeventdetail->EventID=addslashes($_POST["cbo_cata"]);
		$startdate=explode("/",$_POST["txtstartdate"]);
		$objeventdetail->Start_date=$startdate[2]."-".$startdate[1]."-".$startdate[0];
		$enddate=explode("/",$_POST["txtenddate"]);
		$objeventdetail->End_date=$enddate[2]."-".$enddate[1]."-".$enddate[0];
		$objeventdetail->Quantity=addslashes($_POST["txtquantity"]);
		$objeventdetail->Old_price=addslashes($_POST["txtoldprice"]);
		$objeventdetail->Cur_price=addslashes($_POST["txtcurprice"]);
        $objeventdetail->Intro=addslashes($_POST["txtintro"]);
		
        $objeventdetail->Sales=round(100-(((int)$_POST["txtcurprice"] / (int)$_POST["txtoldprice"])*100));
        
            $ti=date("Y-m-d")."-".date("h-i-s");
			$time1=explode("-",$ti);
			$time11= mktime($time1[3],$time1[4],$time1[5],$time1[1],$time1[2],$time1[0]);
			$time12= mktime(0,0,0,$enddate[1],$enddate[0],$enddate[2]);
			
			$objeventdetail->Time=$time12 - $time11;
        
        
		if(isset($_POST["txtid"])){
			$objeventdetail->ID=$_POST["txtid"];
		}
		if($objeventdetail->ID=="-1")
		{
			$result_action = $objeventdetail->Add_new();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=products'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=products'</script>";
		}
		else{
			$result_action = $objeventdetail->Update();
			if(!$result_action)
				echo "<script language=\"javascript\">window.location='index.php?com=products'</script>";
			else	
				echo "<script language=\"javascript\">window.location='index.php?com=products'</script>";
		}
	}
	if(isset($_POST["txtaction"]) && $_POST["txtaction"]!="")
	{
		$conid=$_POST["txtids"];
		$conid=str_replace(",","','",$conid);
		switch ($_POST["txtaction"])
		{
			case "public": 		$objeventdetail->Publish($conid); 		break;
			case "unpublic": 	$objeventdetail->UnPublish($conid); 	break;
			case "edit": 	
				$id=explode("','",$conid);
				echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&conid=".$id[0]."'</script>";
				exit();
				break;
			case "order"	: include(THIS_COM_PATH."tem/order.php"); break;	
			case "delete": 		$objeventdetail->Delete($conid); 		break;
		}
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
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
	unset($objeventdetail);
	unset($objlag_pro);
?>