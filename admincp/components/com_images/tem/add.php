<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
?>
<div id="action">
 <script language="javascript">
 function checkinput(){
	if($("#txtthumb").val()=="")
	{
	 	$("#txtthumb_err").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Vui lòng chọn ảnh sản phẩm').fadeTo(900,1);
		});
	 	$("#txtname").focus();
	 	return false;
	}
	return true;
 }
$(document).ready(function() {
	$("#txtthumb").blur(function(){
		if ($("#txtthumb").val()=="") {
			$("#txtthumb_err").fadeTo(200,0.1,function()
			{ 
			  $(this).html('Vui lòng chọn ảnh sản phẩm').fadeTo(900,1);
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
         <td align="right" bgcolor="#EEEEEE"><strong><?php echo "Ảnh sản phẩm";?> <font color="red">*</font></strong></td>
        <td>
		<input name="txtthumb" type="text" id="txtthumb" size="50" />
          <a href="#" onclick="OpenPopup('extens/upload_image.php');"><?php echo CHOICE;?></a><br>
          
          <label id="txtthumb_err" class="check_error"></label>
          <input name="txttask" type="hidden" id="txttask" value="1" />
          </td>
        </tr>
       <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CPUBLIC;?>&nbsp;</strong></td>
        <td><input name="optactive" type="radio" id="radio" value="1" checked />
          <?php echo CYES;?>
          <input name="optactive" type="radio" id="radio2" value="0"/>
          <?php echo CNO;?></td>
       </tr>
       <tr>
        <td colspan="2" align="left"><hr size="1" color="#EEEEEE" width="100%" /></td>
       </tr>
      </table>
    </fieldset>
    <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
  </form>
</div>