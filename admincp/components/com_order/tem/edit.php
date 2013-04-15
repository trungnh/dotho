<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$id="";
	if(isset($_GET["id"]))
		$id=$_GET["id"];
	$objOrder=new CLS_ORDER();
	$objOrder->getOrderByID($id);
?>
<script language="javascript" type="text/javascript">
	function changeStatusOrder(id){
		var xmlhttp;
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var status ="";
		status = document.getElementById("cbo_active").value;
		if(status == ""){
			for( i = 0; i < document.statusOrder.cbo_active.length; i++ )
			{
				if(  document.statusOrder.cbo_active[i].checked == true )
				status = document.statusOrder.cbo_active[i].value;
			}
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				//alert(xmlhttp.responseText);
				window.location.reload();
			}
		}
		var url = "components/com_order/tem/changeStautus.php?id="+id+"&status="+status;
		//alert (url);
		xmlhttp.open("GET",url,true);
		xmlhttp.send();
		
	}
</script>
<div id="action">
  <form id="frm_action" name="frm_action" method="post" action="">
    <table width="100%" border="0" cellspacing="1" cellpadding="3" style="border:#CCC 1px solid;">
      <tr>
        <td width="150" align="right" bgcolor="#EEEEEE"><strong><?php echo NAMEUSER;?> </strong></td>
        <td>
          
          <?php echo $objOrder->getNameUser($objOrder->user_id); ?>
	      <input type="hidden" name="txtid"  size="50" id="txtid" value="<?php echo $objOrder->id;?>"></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo PAYMENT;?></strong></td>
        <td>
          <?php echo $objOrder->getPaymentName($objOrder->pay_id); ?>
        </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CREATEDATE;?>&nbsp;</strong></td>
        <td>
			<?php echo 	date("d/m/Y s:i:G",strtotime($objOrder->create_date));?>
        </td>
      </tr>
	  <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo NOTE;?>&nbsp;</strong></td>
        <td>
			<?php echo 	$objOrder->note;?>
        </td>
      </tr>
	  <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CITY;?>&nbsp;</strong></td>
        <td>
			<?php echo 	$objOrder->city;?>
        </td>
      </tr>
	   <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo NAMEBUYER;?>&nbsp;</strong></td>
        <td>
			<?php echo 	$objOrder->name_buyer;?>
        </td>
      </tr>
	   <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo PHONEBUYER;?>&nbsp;</strong></td>
        <td>
			<?php echo 	$objOrder->phone_buyer;?>
        </td>
      </tr>
	   <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo EMAILBUYER;?>&nbsp;</strong></td>
        <td>
			<?php echo 	$objOrder->email_buyer;?>
        </td>
      </tr>	  <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo LOCATIONBUYER;?>&nbsp;</strong></td>
        <td>
			<?php echo 	$objOrder->location_buyer;?>
        </td>
      </tr>
	  <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CARRIAGE;?>&nbsp;</strong></td>
        <td>
			<?php echo 	$objOrder->carriage;?>
        </td>
      </tr>
	  <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo STATUS;?>&nbsp;</strong></td>
        <td>
			<?php
				$status = $objOrder->status;
				if($status == 0) echo UNREVIEW;
				if($status == 1) echo "Đang xử lý";
				if($status == 2) echo REVIEW;
				if($status == 3) echo DESTROY;
			?>
			<!--<select name="cbo_active" id="cbo_active"   onchange="changeStatusOrder(<?php// echo $objOrder->id;?>);">
				<option value="0">Chọn </option>
				<option value="all"><?php //echo MALL;?></option>
				<option value="0">Chưa duyệt</option>
				<option value="1">Đang xử lý</option>
				<option value="2">Duyệt</option>
				<option value="3"><?php //echo DESTROY;?></option>
	        </select>-->
        </td>
      </tr>
    </table>
  </form>
	<fieldset>
		<legend><?php echo DETAIL; ?></legend>
		<div id="note"><i><?php echo NOTEORDER; ?></i></div>
		<table  width="100%" border="0" cellspacing="1" cellpadding="3" class="list">
			<tr class="header">
				<td>#</td>
				<td><?php echo PRONAME;?></td>
				<td><?php echo PRICE;?></td>
				<td><?php echo COUNT;?></td>
				<td><?php echo TOTAL;?></td>
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
				<td><?php echo $i;?></td>
				<td><a href="index.php?com=products&task=edit&proid=<?php echo $rows['pro_id']; ?>"><?php echo $proName;?></a></td>
				<td><?php echo $rows['price'];?></td>
				<td><?php echo $rows["count"];?></td>
				<td><?php echo number_format($rows["total"]);?></td>
			</tr>
			<?php 
						$i++;
						$total = $total + $rows['total'];
					}
				}
			?>
			<tr>
				<td colspan="4" align="right"><?php echo ATOTAL;?> : &nbsp;</td>
				<td><?php echo number_format($total+$objOrder->carriage);?></td>
			</tr>
			<tr>
				<td colspan="5" align="center">
				<form name="statusOrder" method="get" action="">
				<?php 
					if($objOrder->status=="0"){
				?>
					<?php /*?><input type="radio" value="3" name="cbo_active" id="cbo_active" />Hủy &nbsp;<?php */?>
					<input type="radio" value="2" name="cbo_active" id="cbo_active" checked="checked"  />Xử lý &nbsp;
					<input type="button" value="Thay đổi trạng thái" style="height:30px; width:160px;"  onclick="changeStatusOrder(<?php echo $objOrder->id;?>);"/>
				<?php 
					}
					if($objOrder->status=="1"){
				?>
					<?php /*?><input type="radio" value="2" name="cbo_active" id="cbo_active" checked="checked" />Hủy &nbsp;<?php */?>
					<input type="radio" value="2" name="cbo_active" id="cbo_active"  checked="checked" />Duyệt &nbsp;
					<input type="button" value="Thay đổi trạng thái" style="height:30px; width:160px;"  onclick="changeStatusOrder(<?php echo $objOrder->id;?>);"/>
				<?php 
					}
					if($objOrder->status=="2"){
				?>
					<input type="hidden" id="cbo_active" value="3" name="cbo_active" />
					<input type="button" value="Hủy hóa đơn" style="height:30px; width:160px;"  onclick="changeStatusOrder(<?php echo $objOrder->id;?>);"/>
				<?php 
					}
					?>
				</form>
				</td>
			</tr>
		</table>	
	</fieldset>
</div>