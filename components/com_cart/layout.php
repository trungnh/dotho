<div id="catdown">
<?php $this->loadModule("top"); ?>
</div>
<?php	
$do='';
if(isset($_GET["do"]))	$do=$_GET["do"];
	
switch($do){
	case "add2cart": include("tem/add2cart.php"); break;
	case "viewcart": include("tem/view-cart.php"); break;
	case "remove": include("tem/remove.php"); break;
	case "removeall": include ("tem/removeall.php"); break;
	case "checkout": include("tem/checkout.php"); break;
    case "list_order": include("tem/list_order.php"); break;
	//default: include("tem/article.php"); break;
}
?>