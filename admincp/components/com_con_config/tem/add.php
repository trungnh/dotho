<?php
	defined("ISHOME") or die("Can't acess this page, please come back!")
?>
<div id="action">
<script language="javascript">
function checkinput(){	
	if($("#txtname").val()=="")
	{
	 	$("#txtname_err").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Yêu cầu nhập tên').fadeTo(900,1);
		});
	 	$("#txtname").focus();
	 	return false;
	}
	return true;
}

$(document).ready(function()
{
	$("#txtname").blur(function() {
		if( $(this).val()=='') {
			$("#txtname_err").fadeTo(200,0.1,function()
			{ 
			  $(this).html('Yêu cầu nhập tên').fadeTo(900,1);
			});
		}
		else {
			$("#txtname_err").fadeTo(200,0.1,function()
			{ 
			  $(this).html('').fadeTo(900,1);
			});
		}
	})
})
 </script>
  <form id="frm_action" name="frm_action" method="post" action="">
  Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.
    <table width="100%" border="0" cellspacing="1" cellpadding="3" style="border:#CCC 1px solid;">
      <tr>
        <td width="234" align="right" bgcolor="#EEEEEE"><strong>Tiêu đề <font color="red">*</font></strong></td>
        <td width="734">
          <input type="text" name="txtname" id="txtname">
          <label id="txtname_err" class="check_error"></label>
          <input name="txttask" type="hidden" id="txttask" value="1" />
		</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Biểu tượng (Icon)<font color="red"> </font></strong></td>
        <td><input type="text" name="txtthumb" id="txtthumb" />
        <a href="#" onclick="OpenPopup('extensions/upload_image.php');">Chọn ảnh</a></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Hiện tên </strong></td>
        <td><input name="optname" type="radio" id="radio3" value="1" checked="checked" />
          <?php echo CYES;?>
          <input name="optname" type="radio" id="radio4" value="0" />
        <?php echo CNO;?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Hiện Icon</strong></td>
        <td>
        
          <input name="opticon" type="radio" id="radio5" value="1" checked="checked" />
          <?php echo CYES;?>
          <input name="opticon" type="radio" id="radio6" value="0" />
        <?php echo CNO;?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Cho phép hiển thị ?&nbsp;</strong></td>
        <td>
        <input name="optactive" type="radio" id="radio" value="1" checked> 
        <?php echo CYES;?>
        <input name="optactive" type="radio" id="radio2" value="0"> 
        <?php echo CNO;?></td>
      </tr>
    </table>
    <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
  </form>
</div>