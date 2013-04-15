<?php
@session_start();
if(isset($_GET["ItemID"])) {
	$id=$_GET["ItemID"];
	//unset($objpo);
	if(!isset($_SESSION["PROIDS"])) { 
		$_SESSION["PROIDS"]=$id.",";
		$_SESSION["PROSLS"]="1,";
	}
	else {
		$arr = explode(",",$_SESSION["PROIDS"]);
		$arr_sl = explode(",",$_SESSION["PROSLS"]);
		
		$flag=0;
		//kiem tra ma SP co ton tai trong chuoi khong? neu co, thi SL+1, neu khong thi them ma SP và SL
		for($i=0;$i<count($arr);$i++) {
			if($arr[$i]==$id) {
				$flag =1;
				$arr_sl[$i]++;
			}
		}
		if($flag==0) {
			$_SESSION["PROIDS"].=$id.",";
			$_SESSION["PROSLS"].="1,";
		}
		else {
			$_SESSION["PROSLS"]="";
			for($i=0;$i<count($arr);$i++) 
				$_SESSION["PROSLS"].=$arr_sl[$i].",";
		}
	}
	$cart_num=0;
	if(isset($_SESSION["PROIDS"]))	{
		$arr = explode(",",$_SESSION["PROIDS"]);
		$cart_num= count($arr)-1;
	}
echo "<a href=\"".WEBSITE."viewcart.html\" class=\"btn btn-cart\" title=\"giỏ hàng\"><i class=\"nicon-cart\"></i>Giỏ hàng (<span class=\"amount-cart\">".$cart_num."</span>)</a>";
}
?>