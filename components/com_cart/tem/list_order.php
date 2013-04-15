<?php
	$id="";
	if(isset($_GET["id"]))
		$id=(int)($_GET["id"]);
	$objOrder=new CLS_ORDER();
	$objOrder->getOrderByID($id);
?>
    <h3 style="color:#950500; font-weight: bold; text-align: left; margin: 0px 0 10px 0;">Thông tin đơn hàng</h3>
    <table width="500" class="tbl_history tbl_listorder" border="0" cellspacing="1" cellpadding="3" style="border:#CCC 1px solid;">
      <tr>
        <td width="150" align="right" bgcolor="#EEEEEE"><strong>Tên người mua hàng</strong></td>
        <td>
          <?php echo $objOrder->getNameUser($objOrder->user_id); ?>
        </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Ngày lập&nbsp;</strong></td>
        <td>
			<?php echo 	date("d/m/Y",strtotime($objOrder->create_date));?>
        </td>
      </tr>
	  <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Ghi chú thêm&nbsp;</strong></td>
        <td>
			<?php echo 	$objOrder->note;?>
        </td>
      </tr>
	  <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Địa chỉ</strong>&nbsp;</strong></td>
        <td>
			<?php echo 	$objOrder->location_buyer;?>
        </td>
      </tr>
	   <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Số điện thoại&nbsp;</strong></td>
        <td>
			<?php echo 	$objOrder->phone_buyer;?>
        </td>
      </tr>
	   <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Email&nbsp;</strong></td>
        <td>
			<?php echo 	$objOrder->email_buyer;?>
        </td>
      </tr>	
	  <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Thanh toán&nbsp;</strong></td>
        <td>
			<?php
				$status = $objOrder->status;
				if($status == 0) echo "Chưa thanh toán";
				if($status == 1) echo "Ðang thanh toán";
				if($status == 2) echo "Ðã thanh toán";
				if($status == 3) echo "Hủy thanh toán";
			?>
        </td>
      </tr>
    </table>
	<fieldset>
		<legend>Chi tiết đơn hàng</legend>
		<div id="note"><i>Lưu ý: các giá trị tiền tệ được tính theo đơn vị nghìn Việt Nam Đồng.</i></div>
		<table  width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl_history tbl_listorder">
			<tr class="header">
				<td align="center">#</td>
				<td><strong>Tên sản phẩm</strong></td>
				<td align="center"><strong>Giá</strong></td>
				<td align="center"><strong>Số lượng</strong></td>
				<td align="center"><strong>Thành tiền</strong></td>
			</tr>
			<?php 
				$objdata = new CLS_MYSQL;
				$objdata =  $objOrder->getOrderDetail($id);
				$i=1;
				$total=0;
				if($objdata->Numrows()<=0){
				?>
			<tr><td><?php  echo NOROW;?></td></tr>	
				<?php
				}else{
					while($rows = $objdata->FetchArray()){
						$proName = $objOrder->getProductName($rows['pro_id']);
			?>
			<tr>
				<td align="center"><?php echo $i;?></td>
				<td><a href="index.php?com=products&task=edit&proid=<?php echo $rows['pro_id']; ?>" title="<?php echo $proName; ?>"><?php echo $proName;?></a></td>
				<td align="center"><?php echo $rows['price'];?></td>
				<td align="center"><?php echo $rows["count"];?></td>
				<td align="center"><?php echo number_format($rows["total"]);?></td>
			</tr>
			<?php 
						$i++;
						$total = $total + $rows['total'];
					}
				}
			?>
			<tr>
				<td colspan="4" align="right"><strong>Tổng thành tiền : &nbsp;</strong></td>
				<td><strong><?php echo number_format($total+$objOrder->carriage);?></strong></td>
			</tr>
		</table>	
	</fieldset>