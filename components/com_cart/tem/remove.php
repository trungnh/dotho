<?php
@session_start();
if(isset($_GET["cartID"])) {
	$id=$_GET["cartID"];	
	if(isset($_SESSION["PROIDS"])) { 
		$arrids = explode(",",$_SESSION["PROIDS"]);
		$arrsls = explode(",",$_SESSION["PROSLS"]);
		$n=count($arrids)-1;
		
		for($i=0;$i<$n;$i++) {
			if($arrids[$i]==$id) {
				$n--;
				for($j=$i;$j<$n;$j++) {
					$arrids[$j]=$arrids[$j+1];
					$arrsls[$j]=$arrsls[$j+1];
				}
				
			}
		}
		$_SESSION["PROIDS"]='';
		$_SESSION["PROSLS"]='';
		for($i=0;$i<$n;$i++) {
			if($arrids[$i]!='') $_SESSION["PROIDS"].=$arrids[$i].",";
			if($arrsls[$i]!='') $_SESSION["PROSLS"].=$arrsls[$i].",";
		}
	}
}
?>
<script>window.location="<?php echo WEBSITE; ?>viewcart.html"</script>