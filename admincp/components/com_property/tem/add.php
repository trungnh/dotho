<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
?>
<div id="action">
 <script language="javascript">
  function checkinput(){
	if($("#txtname").val()=="")
	{
	 	$("#txtname_err").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Bạn phải nhập tên thuộc tính sản phẩm').fadeTo(900,1);
		});
	 	$("#txtname").focus();
	 	return false;
	}
	if($("#txtthumb").val()=="")
	{
	 	$("#txtthumb_err").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Bạn phải nhập mô tả thuộc tính sản phẩm').fadeTo(900,1);
		});
	 	$("#txtthumb").focus();
	 	return false;
	}
	return true;
 }
$(document).ready(function() {
	$("#txtname").blur(function(){
		if ($("#txtname").val()=="") {
			$("#txtname_err").fadeTo(200,0.1,function()
			{ 
			  $(this).html('Bạn phải nhập tên thuộc tính sản phẩm').fadeTo(900,1);
			});
		}
	});
	$("#txtthumb").blur(function(){
		if ($("#txtthumb").val()=="") {
			$("#txtthumb_err").fadeTo(200,0.1,function()
			{ 
			  $(this).html('Bạn phải nhập mô tả thuộc tính sản phẩm').fadeTo(900,1);
			});
		}
	});
});
 </script>

  <form id="frm_action" name="frm_action" method="post" action="">
  <input name="txtproid" type="hidden" id="txtproid" value="<?php echo $_GET["proid"]; ?>" />
  Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.
  <fieldset>
   <legend><strong><?php echo CDETAIL;?>&nbsp;</strong></legend>
    <table width="100%" border="0" cellspacing="1" cellpadding="3">
		<tr>
			<td align="right" bgcolor="#EEEEEE"><strong><?php echo "Tên thuộc tính";?> <font color="red">*</font></strong></td>
			<td>
				<input name="txtname" type="text" id="txtname" size="50" value="" />
				<label id="txtname_err" class="check_error"></label>
				<input name="txttask" type="hidden" id="txttask" value="1" />
			 </td>
		</tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo "Mô tả thuộc tính";?> <font color="red">*</font></strong></td>
        <td>
			<textarea name="txtthumb" id="txtthumb" cols="45" rows="5"></textarea>
			<label id="txtthumb_err" class="check_error"></label>
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