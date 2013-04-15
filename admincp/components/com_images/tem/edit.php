<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$imgid="";
	if(isset($_GET["imgid"]))
		$imgid=(int)$_GET["imgid"];
	$objproduct=new CLS_IMAGES();
	$objproduct->getProByID($imgid);
	$_SESSION["PROIMAGES"]=$objproduct->Proid;
	if(!isset($_SESSION["CUR_PAGE_MNU"]))
		$_SESSION["CUR_PAGE_MNU"]=1;
	if(isset($_POST["cur_page"])){
		$_SESSION["CUR_PAGE_MNU"]=$_POST["cur_page"];
	}
	$cur_page=$_SESSION["CUR_PAGE_MNU"];
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
			<input name="txtthumb" type="text" id="txtthumb" size="50" value="<?php echo $objproduct->Link;?>" />
			<a href="#" onclick="OpenPopup('extens/upload_image.php');"><?php echo CHOICE;?></a>
			<label id="txtthumb_err" class="check_error"></label>
			<input name="txttask" type="hidden" id="txttask" value="1" />
			<input name="txtid" type="hidden" id="txtid" value="<?php echo $objproduct->ID;?>" />
         </td>
       </tr>
       <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CPUBLIC;?>&nbsp;</strong></td>
        <td><input name="optactive" type="radio" id="radio" value="1" <?php if($objproduct->isActive==1) echo 'checked';?>/>
          <?php echo CYES;?>
          <input name="optactive" type="radio" id="radio2" value="0" <?php if($objproduct->isActive==0) echo 'checked';?>/>
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