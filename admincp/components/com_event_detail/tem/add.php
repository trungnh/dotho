<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	if(!isset($objpro))
	$objpro=new CLS_PRODUCTS();
	$objpro->getProByID($_SESSION["PROIMAGES"],0);
?>
<div id="action">
 <script language="javascript">
 function checkinput(){
	if($("#cbo_cata").val()=="0")
	{
	 	$("#cbo_cata_err").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Vui lòng chọn sự kiện').fadeTo(900,1);
		});
	 	$("#cbo_cata").focus();
	 	return false;
	}
	return true;
 }
$(document).ready(function() {
	$('#txtstartdate').datepicker({
	changeMonth: true,
	changeYear: true,
	yearRange: '1900:<?php echo date("Y");?>'
	});
	$('#txtenddate').datepicker({
	changeMonth: true,
	changeYear: true,
	yearRange: '1900:<?php echo date("Y");?>'
	});
	$("#cbo_cata").blur(function(){
		if ($("#cbo_cata").val()=="0") {
			$("#cbo_cata_err").fadeTo(200,0.1,function()
			{ 
			  $(this).html('Vui lòng chọn sự kiện').fadeTo(900,1);
			});
		}
	});
});
 </script>
  <form id="frm_action" name="frm_action" method="post" action="">
  Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.
  <fieldset>
  <input name="txttask" type="hidden" id="txttask" value="1" />
   <legend><strong><?php echo CDETAIL;?>&nbsp;</strong></legend>
    <table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="127" align="right" bgcolor="#EEEEEE"><strong>Chọn sự kiện<font color="red">*</font></strong></td>
        <td width="308">
          <select name="cbo_cata" id="cbo_cata">
          	<option value="0">Chọn sự kiện</option>
            <?php 
			  if(!isset($objevent)) $objevent=new CLS_EVENT();
			  $objevent->getEvent();
			  ?>
          </select><label id="cbo_cata_err" class="check_error"></label></td>
          <td align="right" bgcolor="#EEEEEE"><strong>Số lượng </strong></td>
		  <td colspan="3"><input name="txtquantity" type="text" id="txtquantity" size="20" value="" />
		  <label id="txtcode_err" class="check_error"></label></td>
        </tr>
      <tr>		  
       <td width="191" align="right" bgcolor="#EEEEEE"><strong>Ngày bắt đầu</strong></td>
        <td width="297"><input type="text" name="txtstartdate" id="txtstartdate" /><label id="txtstartdate_err" class="check_error"></label></td>
		<td width="191" align="right" bgcolor="#EEEEEE"><strong>Ngày kết thúc</strong></td>
        <td width="297"><input type="text" name="txtenddate" id="txtenddate" /><label id="txtenddate_err" class="check_error"></label></td>
        </tr>
       <tr>
	   <td align="right" bgcolor="#EEEEEE"><strong>Giá cũ</strong></td>
        <td><input name="txtoldprice" type="text" readonly="readonly" id="txtoldprice" value="<?php echo $objpro->Cur_price;?>" /></td>
		<td align="right" bgcolor="#EEEEEE"><strong>Giá mới</strong></td>
        <td><input name="txtcurprice" type="text" id="txtcurprice" value="" /></td>
        </tr>
       <tr>
         <td colspan="4" align="left"><hr size="1" color="#EEEEEE" width="100%" /></td>
        </tr>
      </table>
      </fieldset>
       <strong><?php echo CINTRO;?></strong>
    <textarea name="txtintro" id="txtintro" cols="45" rows="5"></textarea>
     <script language="javascript">
            var oEdit2=new InnovaEditor("oEdit2");
            oEdit2.width="100%";
            oEdit2.height="100";
            oEdit2.cmdAssetManager ="modalDialogShow('<?php echo URLEDITOR;?>/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
            oEdit2.REPLACE("txtintro");
			document.getElementById("idContentoEdit2").style.height="200px";
      </script>
    <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
  </form>
</div>