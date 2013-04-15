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
<form name="frmUpdateQuantity" id="frmUpdateQuantity" action="#" method="post">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
  <tr>
    <td colspan="4" style="border-bottom: 1px solid #CCCCCC; color:#950500;" align="center"><h3 class="protitle" style="border: none;"><?php echo "Giỏ Hàng của bạn"; ?></h3></td>
    <td colspan="2"  style="border-bottom: 1px solid #CCCCCC;" align="right"><span class="updatecart"><a href="<?php echo WEBSITE; ?>viewcart.html" class="regis">Sửa đơn hàng</a></span></td>
  </tr>
  <tr class="th_viewcart">
    <th width="150" align="center" nowrap="nowrap"><strong><?php echo "Tên Sản Phẩm";?></strong></th>
    <th width="150" align="center" nowrap="nowrap"><strong><?php echo "Hình ảnh";?></strong></th>
    <th width="60" align="center" nowrap="nowrap"><strong><?php echo "Số lượng";?></strong></th>
    <th width="100" nowrap="nowrap"><strong><?php echo "Giá VNĐ";?></strong></th>
    <th width="100" nowrap="nowrap"><strong><?php echo "Thành Tiền";?></strong></th>
    <th width="50" nowrap="nowrap"><?php "Xoa";?></th>
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
<br /><br /><h4 align="center"><?php echo "Chưa có Sản phẩm nào trong giỏ hàng của bạn";?> <a href="<?php echo WEBSITE; ?>index.php"><?php echo "Gian Hàng";?></a></h4>
<?php } ?>

