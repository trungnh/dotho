<?php
  $ids=''; $sls='';
	if(isset($_GET["ItemID"]))
	$item=$_GET["ItemID"];
	if(!isset($objorder))
	$objorder=new CLS_ORDER();
	$objorder->getOrderByID($item);


   $ids = $objorder->Product; 
  $sls = $objorder->Amout;

if($ids!='') {	
?>
<h2 align="center">Thông tin người đặt hàng</h2>
<table width="730" border="0" align="center" cellpadding="3" cellspacing="1">
	<tr>
		<td width="150" bgcolor="#EEEEEE" align="right">Họ Tên</td>
		<td align="left"><?php echo $objorder->Name; ?></td>
	</tr>
	<tr>
		<td width="150" bgcolor="#EEEEEE" align="right">Email</td>
		<td align="left"><?php echo $objorder->Email; ?></td>
	</tr>
	<tr>
		<td width="150" bgcolor="#EEEEEE" align="right">Điện Thoại</td>
		<td align="left"><?php echo $objorder->Phone; ?></td>
	</tr>
	<tr>
		<td width="150" bgcolor="#EEEEEE" align="right">Địa chỉ</td>
		<td align="left"><?php echo $objorder->Address; ?></td>
	</tr>
	<tr>
		<td width="150" bgcolor="#EEEEEE" align="right">Thông tin khác</td>
		<td align="left"><?php echo $objorder->Text; ?></td>
	</tr>
	</table>
<form name="frmUpdateQuantity" id="frmUpdateQuantity" action="#" method="post">
<table width="730" border="0" align="center" cellpadding="2" cellspacing="1">
  <tr>
    <td colspan="6" style="border-bottom:1px solid #ccc;color:#950500;" align="center"><h3 class="protitle"><?php echo "Thồng tin đơn hàng"; ?></h3></td>
  </tr>
  <tr class="th_viewcart">
  	<th width="80" align="center" nowrap="nowrap"><strong><?php echo "Mã SP";?></strong></th>
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
<br /><br /><h4 align="center"><?php echo "Chưa có Sản phẩm nào trong giỏ hàng của bạn";?> <a href="index.php?com=mart"><?php echo "Gian Hàng";?></a></h4>
<?php } ?>