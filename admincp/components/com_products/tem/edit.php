<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$proid="";
	if(isset($_GET["proid"]))
		$proid=(int)$_GET["proid"];
	$objproduct=new CLS_PRODUCTS();
	$objproduct->getProByID($proid);
	if(!isset($_SESSION["CUR_PAGE_MNU"]))
		$_SESSION["CUR_PAGE_MNU"]=1;
	if(isset($_POST["cur_page"])){
		$_SESSION["CUR_PAGE_MNU"]=$_POST["cur_page"];
	}
	$cur_page=$_SESSION["CUR_PAGE_MNU"];
	$_SESSION["PROIMAGES"]=""; 
	if(isset($_GET["proid"]))
	$_SESSION["PROIMAGES"]=$_GET["proid"];
?>
<div id="action">
 <script language="javascript">
 function checkinput(){
	if($("#txtname").val()=="")
	{
	 	$("#txtname_err").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Vui lòng nhập tên sản phẩm').fadeTo(900,1);
		});
	 	$("#txtname").focus();
	 	return false;
	}
	return true;
 }
$(document).ready(function() {
	$("#txtname").blur(function(){
		if ($("#txtname").val()=="") {
			$("#txtname_err").fadeTo(200,0.1,function()
			{ 
			  $(this).html('Vui lòng nhập tên sản phẩm').fadeTo(900,1);
			});
		}
	});
});
 </script>
  <form id="frm_action" name="frm_action" method="post" action="">
  Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.
  <fieldset>
   <legend><strong><?php echo CDETAIL;?>&nbsp;</strong></legend>
    <table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="127" align="right" bgcolor="#EEEEEE"><strong><?php echo CCATALOG;?><font color="red">*</font></strong></td>
        <td width="308">
          <select name="cbo_cata" id="cbo_cata">
          	<option value="0">Chọn một loại sản phẩm</option>
            <?php 
			  if(!isset($objcatalog)) $objcatalog=new CLS_CATALOG();
			  	echo $objcatalog->getListCatalog(0,0);
			  ?>
            <script language="javascript">
			  cbo_Selected('cbo_cata',<?php echo $objproduct->CataID;?>);
			  </script>
          </select></td>
        <td width="134" align="right" bgcolor="#EEEEEE"><strong><?php echo CAUTHOR;?>&nbsp;</strong></td>
        <td width="351"><input name="txtauthor" type="text" id="txtauthor" value="<?php echo $_SESSION["IGFUSERNAME"];?>" readonly="readonly" /></td>
        </tr>
      <tr>
         <td align="right" bgcolor="#EEEEEE"><strong><?php echo CNAME;?> <font color="red">*</font></strong></td>
        <td>
          <input name="txtname" type="text" id="txtname" size="45" value="<?php echo $objproduct->Name;?>" />
          <label id="txtname_err" class="check_error"></label>
          <input name="txttask" type="hidden" id="txttask" value="1" />
          <input name="txtid" type="hidden" id="txtid" value="<?php echo $objproduct->ID;?>" />
          </td>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CCREATDATE;?>&nbsp;</strong></td>
        <td><input id="date1" type="text" name="txtcreadate" value="<?php echo $objproduct->Joindate;?>"  readonly="readonly"  /></td>
        </tr>
       <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo QUANTITY;?> <font color="red">*</font></strong></td>
        <td><input name="txtquantity" type="text" id="txtquantity" size="45" value="<?php echo $objproduct->Quantity;?>" />
        <label id="txtcode_err" class="check_error"></label></td>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo UNIT;?> </strong></td>
        <td><input name="txtunit" type="text" id="txtunit" value="<?php echo $objproduct->Unit;?>" /></td>
        </tr>
        <tr>
        	<td align="right" bgcolor="#EEEEEE"><strong><?php echo OLDPRICE;?> </strong></td>
            <td><input name="txtoldprice" type="text" id="txtoldprice" value="<?php echo $objproduct->Old_price;?>" /></td>
            <td align="right" bgcolor="#EEEEEE"><strong><?php echo CURPRICE;?> </strong></td>
            <td><input name="txtcurprice" type="text" id="txtcurprice" value="<?php echo $objproduct->Cur_price;?>" /></td>
        </tr>
       <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CPUBLIC;?>&nbsp;</strong></td>
        <td><input name="optactive" type="radio" id="radio" value="1" <?php if($objproduct->IsActive==1) echo 'checked';?>/>
          <?php echo CYES;?>
          <input name="optactive" type="radio" id="radio2" value="0" <?php if($objproduct->IsActive==0) echo 'checked';?>/>
          <?php echo CNO;?></td>
        <td align="right" bgcolor="#EEEEEE"><strong>&nbsp;<?php echo "Video";?>&nbsp;</strong></td>
        <td><input name="txtthumb" type="text" id="txtthumb" size="30" value="<?php echo $objproduct->Video;?>" />
          <a style="display:none" href="#" onclick="OpenPopup('extens/upload_image.php?item=product');"><?php echo CHOICE;?></a>
          </td>
        </tr>
		<tr>
         <td align="right">Có thế bạn quan tâm</td>
		 <td colspan="3" align="left"><input type="checkbox" value="1" name="cbocheck_iscan" id="cbocheck_iscan" <?php if($objproduct->Iscan==1) echo "checked"  ?> /><td> 
        </tr>
       <tr>
         <td colspan="4" align="left"><hr size="1" color="#EEEEEE" width="100%" /></td>
        </tr>
      </table>
      </fieldset>
	 <br style="clear:both" />
    <strong><?php echo "Mô tả ngắn";?></strong>
    <textarea name="txtdesc" id="txtdesc" cols="45" rows="5"><?php echo $objproduct->Fulltext;?></textarea>
     <script language="javascript">
            var oEdit1=new InnovaEditor("oEdit1");
            oEdit1.width="100%";
            oEdit1.height="100";
            oEdit1.cmdAssetManager ="modalDialogShow('<?php echo URLEDITOR;?>/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
            oEdit1.REPLACE("txtdesc");
			document.getElementById("idContentoEdit1").style.height="100px";
      </script>
    <br style="clear:both" />
    <strong><?php echo "Chi tiết sản phẩm";?></strong>
    <textarea name="txtintro" id="txtintro" cols="45" rows="5"><?php echo $objproduct->Intro;?></textarea>
     <script language="javascript">
            var oEdit2=new InnovaEditor("oEdit2");
            oEdit2.width="100%";
            oEdit2.height="100";
            oEdit2.cmdAssetManager ="modalDialogShow('<?php echo URLEDITOR;?>/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
            oEdit2.REPLACE("txtintro");
			document.getElementById("idContentoEdit2").style.height="300px";
      </script>
    <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
  </form>
  	<fieldset>
		<legend><strong>Gán sự kiện</strong></legend>
		<?php 
			$strwhere = " and `pro_id` = $proid ";
			if(!isset($objeventdetail)) $objeventdetail = new CLS_EVENT_DETAIL();
			$objeventdetail->getAllList($strwhere);
			$total_rows=$objeventdetail->Numrows();
			if($total_rows>0)
			{
				$objeventdetail->getProByCataID($proid);
		?>
		<a href="index.php?com=event_detail&task=edit&id=<?php echo $objeventdetail->ID; ?>" >Cập nhật</a><br />
		<a href="index.php?com=event_detail&task=delete&id=<?php echo $objeventdetail->ID; ?>" >Xóa</a>
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
		  <tr>
			<td width="127" align="right" bgcolor="#EEEEEE"><strong><?php echo CCATALOG;?><font color="red">*</font></strong></td>
			<td width="308">
				<?php echo $objeventdetail->getEventName($objeventdetail->EventID); ?>
			  </td>
		   <td align="right" bgcolor="#EEEEEE"><strong>Số lượng</strong></td>
			<td colspan="3"><?php echo $objeventdetail->Quantity; ?>
			</tr>
		  <tr>		  
		   <td width="191" align="right" bgcolor="#EEEEEE"><strong>Ngày bắt đầu</strong></td>
			<td width="297"><?php echo date("d-m-Y",strtotime($objeventdetail->Start_date));  ?></td>
			<td width="191" align="right" bgcolor="#EEEEEE"><strong>Ngày kết thúc</strong></td>
			<td width="297"><?php echo date("d-m-Y",strtotime($objeventdetail->End_date));  ?></td>
			</tr>
		   <tr>
		   
		   <td align="right" bgcolor="#EEEEEE"><strong>Giá cũ </strong></td>
			<td><?php echo $objeventdetail->Old_price;?></td>
			<td align="right" bgcolor="#EEEEEE"><strong>Giá mới</strong></td>
			<td><?php echo $objeventdetail->Cur_price;?></td>
			</tr>
		</table>

		<?php }
		else
		echo '<a href="index.php?com=event_detail&task=add&proid='.$proid.'">Gán sự kiện</a>';
		?>
	</fieldset>
  <br />
	<fieldset>
		<legend><strong>Ảnh sản phẩm</strong></legend>
			<a href="index.php?com=images&task=add&proid=<?php echo $proid; ?>">Thêm ảnh sản phẩm</a>
		<table width="100%" border="0" cellspacing="0" cellpadding="3" class="list">
			<tr class="header">
				<td>STT</td>
				<td>Ảnh</td>
				<td>Hiển thị</td>
				<td>Sửa</td>
				<td>Xóa</td>
			</tr>
			<?php 
			$strwhere = " `pro_id` = $proid ";
			if(!isset($objimages)) $objimages = new CLS_IMAGES();
			$objimages->getAllList($strwhere);
			$total_rows=$objimages->Numrows();
			$objimages->listTablePro($strwhere);
			?>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Footer_list">
			  <tr>
				<td align="center">
				<?php 
					//paging($total_rows,MAX_ROWS,$cur_page);
				?>
				</td>
			  </tr>
		</table>
	</fieldset>
	<br />
	<fieldset>
		<legend><strong>Thông số kĩ thuật</strong></legend>
			<a href="index.php?com=property&task=add&proid=<?php echo $proid; ?>">Thêm thông số kĩ thuật sản phẩm</a>
		<table width="100%" border="0" cellspacing="0" cellpadding="3" class="list">
			<tr class="header">
				<td>STT</td>
				<td>Tên</td>
				<td>Mô tả</td>
				<td>Hiển thị</td>
				<td>Sửa</td>
				<td>Xóa</td>
			</tr>
			<?php 
			$strwhere = " `product_id` = $proid ";
			if(!isset($objproperty)) $objproperty = new CLS_PROPERTY();
			$objproperty->getAllList($strwhere);
			$total_rows=$objproperty->Numrows();
			$objproperty->listTablePro($strwhere);
			?>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Footer_list">
			  <tr>
				<td align="center">
				<?php 
					//paging($total_rows,MAX_ROWS,$cur_page);
				?>
				</td>
			  </tr>
		</table>
	</fieldset>
</div>