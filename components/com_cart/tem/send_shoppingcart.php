<?php 
	/*echo 'ids='.$_SESSION["PROIDS"]."<br>";
	echo 'sls='.$_SESSION["PROSLS"];*/
?>
<?php
	if(isset($_POST["txtid"])) {
		$arrsl = $_POST["txtsl"];
		$arrid = $_POST["txtid"];
		
		$_SESSION["PROIDS"]='';
		$_SESSION["PROSLS"]='';
		for($i=0;$i<count($arrid);$i++) {
			$_SESSION["PROIDS"].=$arrid[$i].",";
			$_SESSION["PROSLS"].=$arrsl[$i].",";
		}
	}


  $ids=''; $sls='';
  if(isset($_SESSION["PROIDS"])) $ids = $_SESSION["PROIDS"]; 
  if(isset($_SESSION["PROSLS"])) $sls = $_SESSION["PROSLS"];

if($ids!='') {	
?>
<form name="frmUpdateQuantity" id="frmUpdateQuantity" action="#" method="post">
<table width="750" border="0" align="center" cellpadding="4" cellspacing="1">
  <tr>
    <td colspan="6" style="border-bottom:1px solid #ccc"><h3 class="protitle"><?php echo $lang_igf_yourCart; ?></h3></td>
  </tr>
  <tr class="th_viewcart">
    <th width="314" align="left" nowrap="nowrap"><strong>Tên sản phẩm</strong></th>
    <th width="60" align="center" nowrap="nowrap"><strong>Số lượng</strong></th>
    <th width="118" nowrap="nowrap"><strong>Giá</strong></th>
    <th width="133" nowrap="nowrap"><strong>Tổng tiền</strong></strong></th>
    <th width="50" nowrap="nowrap">Xem</th>
  </tr>
  <?php
  
  if(!isset($objpro)) $objpro = new CLS_PRODUCTS();
  $objpro->viewShoppingCart($ids,$sls); 
  ?>
</table>
</form>
<?php 
}
else 
{ ?>
<br /><br /><h4 align="center">Chưa có sản phẩm nào <a href="index.php">Trở lại gian hàng</a></h4>
<?php } ?>
