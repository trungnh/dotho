<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$lagid="";
	if(isset($_GET["lagid"]))
		$lagid=(int)$_GET["lagid"];
	$objlang=new CLS_LANGUAGE();
	$objlang->getLagByID($lagid);
?>
<div id="action">
<script language="javascript">
function checkinput(){
	var codeReg = /^[a-z0-9]{2,50}$/i;
	
	if($("#txtname").val()=="")
	{
	 	$("#txtname_err").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Yêu cầu nhập tên ngôn ngữ').fadeTo(900,1);
		});
	 	$("#txtname").focus();
	 	return false;
	}
	if($("#txtcode").val()=="")
	{
		$("#txtcode_err").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Yêu cầu nhập mã ngôn ngữ').fadeTo(900,1);
		});
	 	$("#txtcode").focus();
	    return false;
	}
	else if (($("#txtcode").val().trim()).indexOf(' ') > -1) {
	 	$("#txtcode_err").fadeTo(200,0.1,function()
		 {
		 	$("#txtcode_err").html("Mã có chứa dấu cách(space). Vui lòng nhập mã không có dấu cách.").fadeTo(900,1);
		 });
		 return false;
	}
	else if (($("#txtcode").val().trim()).length<2) {
		$("#txtcode_err").fadeTo(200,0.1,function()
		 {
		 	$("#txtcode_err").html("Mã gồm ít nhất 2 ký tự").fadeTo(900,1);
		 });
		 return false;
	}
	else if (!codeReg.test($("#txtcode").val().trim())) {
		$("#txtcode_err").fadeTo(200,0.1,function()
		 {
		 	$("#txtcode_err").html("Mã gồm các chữ cái a->z, số 0->9, không bao gồm dấu cách(space").fadeTo(900,1);
		 });
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
			  $(this).html('Yêu cầu nhập tên ngôn ngữ').fadeTo(900,1);
			});
		}
		else {
			$("#txtname_err").fadeTo(200,0.1,function()
			{ 
			  $(this).html('').fadeTo(900,1);
			});
		}
	})
	
	$("#txtcode").blur(function() {
		if( $(this).val()=='') {
			$("#txtcode_err").fadeTo(200,0.1,function()
			{ 
			  $(this).html('Yêu cầu nhập mã ngôn ngữ').fadeTo(900,1);
			});
		}
		else {
			$("#txtcode_err").fadeTo(200,0.1,function()
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
        <td width="150" align="right" bgcolor="#EEEEEE">
        	<strong><?php echo $obj_laglang->LANG_NAME;?> <font color="red">*</font></strong>
        </td>
        <td>
          <input type="text" name="txtname" id="txtname" value="<?php echo $objlang->_Name;?>">
          <label id="txtname_err" class="check_error"></label>
          <input name="txttask" type="hidden" id="txttask" value="1" />
          <input type="hidden" name="txtid" id="txtid" value="<?php echo $objlang->ID;?>">
		</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo $obj_laglang->LANG_CODE;?> <font color="red">*</font></strong>
        </td>
        <td><input type="text" name="txtcode" id="txtcode" value="<?php echo $objlang->_Code;?>" />
            <label id="txtcode_err" class="check_error"></label>
        </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo $obj_laglang->LANG_FLAG;?> <font color="red">*</font></strong></td>
        <td><input name="txtflag" type="text" id="txtflag" maxlength="50" value="<?php echo $objlang->_Flag;?>" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE">
        	<strong><?php echo $obj_laglang->LANG_SITE;?> <font color="red">*</font></strong>
        </td>
        <td>
        <input name="optsite" type="radio" value="front_end" <?php if($objlang->_Site=="front_end") echo ' checked="checked"';?>/>
          <?php echo $obj_laglang->TAB_SITE;?>
          <input type="radio" name="optsite" value="back_end" <?php if($objlang->_Site=="back_end") echo ' checked="checked"';?>/>
          <?php echo $obj_laglang->TAB_ADMIN;?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CPUBLIC;?> <font color="red">*</font></strong></td>
        <td><input name="optactive" type="radio"  value="1" <?php if($objlang->isActive==1) echo ' checked="checked"';?> />
          <?php echo CYES;?>
          <input type="radio" name="optactive" value="0" <?php if($objlang->isActive==0) echo ' checked="checked"';?>/>
          <?php echo CNO;?></td>
      </tr>
    </table>
    <label>
        <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
      </label>
  </form>
</div>