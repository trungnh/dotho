<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	define("COMS","statistic");
	
	// Begin Toolbar
	require_once(LAG_PATH."vi/lang_order.php");
	require_once(LAG_PATH."vi/lang_products.php");
	require_once(libs_path."cls.order.php");
	require_once(libs_path."cls.product.php");
	
	if(!isset($objlag_order)) $objlag_order=new LANG_ORDER;
	//
	if(isset($_GET['mode'])&&$_GET['mode']=="order")
		$title_manager = $objlag_order->STATISTIC_ORDER;
	else
		$title_manager = $objlag_order->STATISTIC_PRODUCT;
	require_once("includes/toolbar.php");
	// End toolbar
	$objorder=new CLS_ORDER();
	$objpro=new CLS_PRODUCTS();
	
	if(isset($_GET["mode"]))
		$mode=$_GET["mode"];
	define("THIS_COM_PATH",COM_PATH."com_".COMS."/");

	switch($mode)
	{
		case "order"	: include(THIS_COM_PATH."tem/order.php"); 	break;
		case "product"	: include(THIS_COM_PATH."tem/product.php");	break;
		default: include(THIS_COM_PATH."tem/order.php");
	}	
	// close object
	unset($objorder);
	unset($objlag_order);
	unset($objpro);
?>