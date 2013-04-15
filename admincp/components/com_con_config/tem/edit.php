<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$id="";
	if(isset($_GET["id"]))
		$id=$_GET["id"];
	$editmenu=new CLS_CONFIGCONTENT();
	$editmenu->getMenuByID($id);
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
          <input type="text" name="txtname" id="txtname" value="<?php echo $editmenu->Name;?>">
          <label id="txtname_err" class="check_error"></label>
          <input name="txtid" type="hidden" id="txtid" value="<?php echo $editmenu->ID;?>" />
          <input name="txttask" type="hidden" id="txttask" value="1" />
		</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Biểu tượng (Icon)<font color="red"> </font></strong></td>
        <td><input type="text" name="txtthumb" id="txtthumb"  value="<?php echo $editmenu->Icon;?>"/>
        <a href="#" onclick="OpenPopup('extensions/upload_image.php');">Chọn ảnh</a></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Hiện tên </strong></td>
        <td><input name="optname" type="radio" id="radio3" value="1" <?php if($editmenu->ShowName==1) echo 'checked="checked"';?>/>
          <?php echo CYES;?>
          <input name="optname" type="radio" id="radio4" value="0" <?php if($editmenu->ShowName==0) echo 'checked="checked"';?>/>
        <?php echo CNO;?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Hiện Icon</strong></td>
        <td>
        
          <input name="opticon" type="radio" id="radio5" value="1" <?php if($editmenu->ShowIcon==1) echo 'checked="checked"';?>/>
          <?php echo CYES;?>
          <input name="opticon" type="radio" id="radio6" value="0" <?php if($editmenu->ShowIcon==0) echo 'checked="checked"';?>/>
        <?php echo CNO;?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Cho phép hiển thị ?&nbsp;</strong></td>
        <td>
        <input name="optactive" type="radio" id="radio" value="1" <?php if($editmenu->isActive==1) echo 'checked="checked"';?>> 
        <?php echo CYES;?>
        <input name="optactive" type="radio" id="radio2" value="0" <?php if($editmenu->isActive==0) echo 'checked="checked"';?>> 
        <?php echo CNO;?></td>
      </tr>
    </table>
    <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
  </form>
</div>