<?php 
	//echo 'ids='.$_SESSION["PROIDS"]."<br>";
	//echo 'sls='.$_SESSION["PROSLS"];
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
<tr><td>
<form name="frmUpdateQuantity" id="frmUpdateQuantity" action="#" method="post">
<h3 class="protitle" style="color: #950500; border: none;"><?php echo "Giỏ hàng của bạn";?></h3>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr class="th_viewcart">
    <th width="150" align="center" nowrap="nowrap" ><?php echo "Tên Sản Phẩm";?></th>
    <th width="150" align="center" nowrap="nowrap" ><?php echo "Hình ảnh";?></th>
    <th width="50" align="center" nowrap="nowrap" ><?php echo "Số lượng";?></th>
    <th width="100" align="center" nowrap="nowrap" ><?php echo "Giá VNĐ";?></th>
    <th width="100" align="center" nowrap="nowrap" ><?php echo "Thành Tiền";?></th>
    <th width="50" align="center" nowrap="nowrap" ><?php "Xóa";?></th>
  </tr>
  <?php
      if(!isset($objpro)) $objpro = new CLS_PRODUCTS();
      $objpro->viewShoppingCart($ids,$sls); 
  ?>
  <tr>
	<td align="left" colspan="3">
		<span class="updatecart"><a class="regis" href="<?php echo WEBSITE; ?>index.php" title="Mua tiếp"><?php echo "Mua tiếp";?></a></span>
        <span class="updatecart"><a class="regis" href="<?php echo WEBSITE; ?>removeall.html" title="Xóa"><?php echo "Xóa giỏ hàng";?></a></span>
	</td>
    <td colspan="3" align="right">
        <a class="delete_cart" href="#" title="Cập nhật giỏ hàng" onclick="javascript:frmUpdateQuantity.submit()"><span><?php echo "Cập nhật giỏ hàng";?></span></a></span>
        <span class="updatecart"><a class="regis" href="<?php echo WEBSITE; ?>checkout.html" title="thanh toán"><?php echo "Thanh toán";?></a></span>
  </tr>
</table>
</form>
</tr>
<?php 
}
else 
{ ?>
<tr>
<td>
<br />
<h4 align="center"> <?php echo "Chưa có sản phẩm :  ";?> <a href="index.php" style="color:#950500;"><?php echo "chở lại Gian hàng ";?></a></h4> 
</td>
</tr>
<?php } ?>