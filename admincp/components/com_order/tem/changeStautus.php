<?php
	include("../../../../includes/gfinnit.php");
	include("../../../libs/cls.data.php");
	include("../../../libs/cls.order.php");
	if(isset($_GET["id"]))
		$id=$_GET["id"];
	if(isset($_GET["status"]))
		$status=$_GET["status"];
	if(!isset($objorder))
	$objOrder=new CLS_ORDER();
	$objOrder->changeStatus($id,$status);
?>