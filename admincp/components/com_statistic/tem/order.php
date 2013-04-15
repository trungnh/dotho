<?php 
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$keyword="Keyword";
	$action="";
	$strwhere="";
	$date ="";
	if(isset($_POST["txtkeyword"])){
		$keyword=$_POST["txtkeyword"];
		$date=$_POST["date"];
		
		$strDate = $date;
		$txtjoindate = $_POST["date"];
		$joindate = mktime(0,0,0,substr($txtjoindate,3,2),substr($txtjoindate,0,2),substr($txtjoindate,6,4));
		$date=date("Y-m-d",$joindate);
	}
	if($date!="1999-11-30"&&$date!=""){
		$strwhere.="   `location_buyer` like '%$keyword%' AND `city` like '%$keyword%' AND `create_date` BETWEEN '$date' AND DATE_ADD( '$date', INTERVAL 1 DAY )    ";
		// AND status in ('1','3')    
	}else{
		$strDate ="Tất cả";
	}
	if($keyword!="" && $keyword!="Keyword" &&$date=="")
	{
		$strwhere.=" (  `location_buyer` like '%$keyword%' AND `city` like '%$keyword%' ) ";
	}
	if($strwhere!="")
		$strwhere=" WHERE ".substr($strwhere,0,strlen($strwhere)-4);
	$objorder->getList($strwhere);
?>
<script language="javascript" >
$(document).ready(function()
{	
	$('#date').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: '1900:<?php echo date("Y");?>'
    });
});
</script>
<div>
	<form id="frm_list" name="frm_list" method="post" action="">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Header_list">
		  <tr>
			<td>Địa điểm :
				<input type="text" name="txtkeyword" id="txtkeyword" onfocus="onsearch(this,1);" onblur="onsearch(this,0)" />
				
			</td>
			<td align="left">
			  Ngày tháng :<input type="text" name="date" id="date" />
			</td>
			<td align="right">
				 <input type="submit" name="button" id="button" value="<?php echo SEARCH;?>" class="button" />
			</td>
		  </tr>
		</table>
	</form>
	<?php 
	if(isset($_POST["txtkeyword"])){
	?>
	<fieldset>
		<legend>Thông tin thống kê</legend>
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
			<tr>
				<td align="right" bgcolor="#EEEEEE" width="200px">Ngày : </td>
				<td><?php echo $strDate;?></td>
			</tr>
			<tr>
				<td align="right" bgcolor="#EEEEEE">Lượt mua : </td>
				<td><?php echo $objorder->Numrows();?></td>
			</tr>
		</table><br />
		
		<center><h1>Hóa đơn</h1></center>
		<center><div id="note"><i><?php echo NOTEORDER; ?></i></div></center>
		<div  <?php if($objorder->Numrows()>=10) {?>  style="height:500px;overflow:scroll" <?php }?>>
		<table width="100%" border="0" cellspacing="0" cellpadding="3" class="list"  >
		  <tr class="header">
			<td width="30" align="center">#</td>
			<td align="center"><?php echo NAMEUSER;?></td>
			<td align="center" ><?php echo CITY;?></td>
			<td width="120" align="center"><?php echo STATUS;?></td>
			<td align="center" width="70"> <?php echo DETAIL;?></td>
		  </tr>
		  <?php 
		 	 $objorder->listTableOrder($strwhere,-1);
			 if($objorder->Numrows()<=0){
			 ?>
			 <td colspan="5" align="center">Không có bản ghi nào.</td>
			 <?php
			 }
		  ?>
	  </table><br />
	  </div>
		<center><h1>Sản phẩm đã bán</h1></center>
		<center><div id="note"><i><?php echo NOTEORDER; ?></i></div></center>
		<div  <?php if($objorder->Numrows()>=4) {?>  style="height:500px;overflow:scroll" <?php }?>>
		<table width="100%" border="0" cellspacing="0" cellpadding="3" class="list">
			<tr class="header">
				<td width="30">#</td>
				<td>Tên sản phẩm</td>
				<td>Số lượng</td>
				<td>Thành tiền</td>
			</tr>
		<?php 
			$count = $objorder->getListProBuy($strwhere);
			if($count == 1){
				?>
					<td colspan="4" align="center">Không có bản ghi nào.</td>
				<?php 
			}
		?>
		</table><br />
		</div>
		<center><h1>Sản phẩm đang giao dịch</h1></center>
		<center><div id="note"><i><?php echo NOTEORDER; ?></i></div></center>
		<table width="100%" border="0" cellspacing="0" cellpadding="3" class="list">
			<tr class="header">
				<td width="30">#</td>
				<td>Tên sản phẩm</td>
				<td>Số lượng</td>
				<td>Thành tiền</td>
			</tr>
			<?php 
			$count = $objorder->getListProNotBuy($strwhere);
			if($count == 1){
				?>
					<td colspan="4" align="center">Không có bản ghi nào.</td>
				<?php 
			}
		?>
		</table>
	</fieldset>
	<?php 
	}
	?>
</div>