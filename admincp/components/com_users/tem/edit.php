<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$memid="";
if(isset($_GET["memid"]))
	$memid=$_GET["memid"];
	
if(!isset($objmember))
	$objmember=new CLS_USERS();
		
if($objmember->isAdmin()==false &&  $memid!=$_SESSION["IGFUSERID"]){
	echo ('<div id="action" style="background-color:#fff"><h3 align="center">Bạn không có quyền truy cập. <a href="index.php">Vui lòng quay lại trang chính</a></h3></div>');
}
else {
	if(isset($_GET["personal"]) && $_GET["personal"]==true)
		$memid=$_SESSION["IGFUSERID"];
	
	$objmember->getMemberByID($memid); //echo $objmember->UserName;
?>
<script language="javascript">

  function checkinput(){
	 var user = document.getElementById("txtusername");
	 var checkuser	= document.getElementById("checkuser");
	 
	 var firstname = document.getElementById("txtfirstname");
	 var lastname  = document.getElementById("txtlastname");
	 var mobile  = document.getElementById("txtmobile");
	 var email  = document.getElementById("txtemail");
	 var gmember  = document.getElementById("cbo_gmember");
	 
	 if(user.value=='') {
	 	alert("Mời bạn nhập tên đăng nhập hệ thống");
		user.focus();
		return false;
	 }
	 if(checkuser.value=="false") {
	 	alert("Tên đăng nhập này đã tồn tại. Vui lòng nhập tên đăng nhập khác");
		 user.focus();
		 return false;
	 }
	 if(firstname.value=='') {
	 	alert("Mời bạn nhập Tên người dùng");
		firstname.focus();
		return false;
	 }
	 if(lastname.value=='') {
	 	alert("Mời bạn nhập Họ & đệm của người dùng");
		lastname.focus();
		return false;
	 }
	 if(email.value!='' && !checkEmail(email.value)){email.focus();return false;}
	 if(gmember.value==0) {
	 	alert("Mời bạn chọn nhóm quyền người dùng");
		gmember.focus();
		return false;
	 }
	 if(mobile.value=='') {
	 	/*alert("Mời bạn nhập số điện thoại di động");
		mobile.focus();
		return false;*/
	 }
	 else if(!checkPhone(mobile.value)){
   	   mobile.focus();
	   return false;
	 }
	 
	 return true;
 }

$(document).ready(function()
{	
	$('#txtbirthday').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: '1900:<?php echo date("Y");?>'
    });
	
	$("#txtusername").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		$("#msgbox").removeClass().addClass('messagebox').text('Kiểm tra dữ liệu...').fadeIn("slow");
		//check the username exists or not from ajax
		$.post("user_availabity.php",{ user_name:$(this).val() } ,function(data)
        {
		  if($.trim(data)=='nodata' || $.trim(data)=='') {
		  	$("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Vui lòng nhập tên đăng nhập').addClass('messageboxerror').fadeTo(900,1);
			});
		  }
		  else if($.trim(data)=='no') //if username not avaiable
		  {
		  	$("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Tên đăng nhập này đã tồn tại. Vui lòng nhập tên đăng nhập khác').addClass('messageboxerror').fadeTo(900,1);
			});		
			document.getElementById("checkuser").value="false";
          }
		  else 
		  {
			$("#msgbox").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Tên đăng nhập có thể sử dụng').addClass('messageboxok').fadeTo(900,1);	
			});
			document.getElementById("checkuser").value="true";
		  }
				
        });
 
	});
});
 </script>
<div id="action">
  <form id="frm_action" name="frm_action" method="post" action="">
    <fieldset>
	<legend><strong>Thông tin tài khoản người dùng</strong></legend>
    <table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr><td colspan="2">Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</td></tr>
      <tr>
        <td width="172" align="right" bgcolor="#EEEEEE"><strong>Tên đăng nhập<font color="red"> *</font></strong></td>
        <td width="744">
          <input name="txtusername" type="text" class="required" id="txtusername" value="<?php echo $objmember->UserName;?>" minlength="3"<?php if($objmember->isAdmin()==false) echo '  readonly="readonly"';?>/>
          <span id="msgbox" style="display:none"></span>
          <input type="hidden" name="checkuser" id="checkuser" value="" />
         <input type="hidden" name="txtuser" value="<?php echo $objtea->UserName;?>" id="txtuser" />  
        </td>
      </tr>
    </table>
    </fieldset>
    <fieldset>
	<legend><strong>Thông tin chi tiết người dùng</strong></legend>
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="171" align="right" bgcolor="#EEEEEE"><strong>Họ &amp; đệm<font color="red"> *</font></strong></td>
        <td width="236"><input type="text" name="txtfirstname" id="txtfirstname" value="<?php echo $objmember->FirstName;?>" class="required" />
          <input name="txttask" type="hidden" id="txttask" value="1" />
          <input name="txtid" type="hidden" id="txtid" value="<?php echo $objmember->ID;?>" />
		</td>
        <td width="156" align="right" bgcolor="#EEEEEE"><strong>Ngày sinh&nbsp;</strong></td>
        <td width="339"><input type="text" name="txtbirthday" id="txtbirthday" value="<?php echo date("d-m-Y",strtotime($objmember->Birthday));?>" /></td>
      </tr>
      <tr>
        <td width="171" align="right" bgcolor="#EEEEEE"><strong>Tên <font color="red">*</font></strong></td>
        <td><strong>
          <input type="text" name="txtlastname" id="txtlastname" value="<?php echo $objmember->LastName;?>" class="required"/>
          </strong></td>
        <td width="156" align="right" bgcolor="#EEEEEE"><strong>Giới tính&nbsp;</strong></td>
        <td><label>
          <input name="optgender" type="radio" value="0" <?php if($objmember->Gender==0) echo ' checked="checked"';?> /> Nam
          <input type="radio" name="optgender" value="1" <?php if($objmember->Gender==1) echo ' checked="checked"';?>/> N&#7919;</label></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Địa chỉ&nbsp;</strong></td>
        <td><label>
          <input type="text" name="txtaddress" id="txtaddress" value="<?php echo $objmember->Address;?>" />
        </label></td>
        <td align="right" bgcolor="#EEEEEE"><strong>Điện thoại bàn &nbsp;</strong></td>
        <td><input type="text" name="txtphone" id="txtphone" value="<?php echo $objmember->Phone;?>" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Email&nbsp;</strong></td>
        <td><input type="text" name="txtemail" id="txtemail" value="<?php echo $objmember->Email;?>" class="required email"/></td>
        <td align="right" bgcolor="#EEEEEE"><strong>Điện thoại di động &nbsp;</strong></td>
        <td><input type="text" name="txtmobile" id="txtmobile" value="<?php echo $objmember->Mobile;?>" class="required"/></td>
      </tr>
      <?php
	  //begin update tuan 25/11/2011-----------------------------------------------------------------
	 // if($objmember->isAdmin()==true) {
	 if(false){
	 //end update tuan 25/11/2011-----------------------------------------------------------------
	  ?>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Nhóm quyền <font color="red">*</font></strong></td>
        <td>
        <select name="cbo_gmember" id="cbo_gmember">
         <?php 
			if(!isset($objgmem)) $objgmem = new CLS_GUSER();
			$objgmem->getName_ID(0,$objmember->Gmember,0,'');
			unset($objgmem);
			?>
        </select>
        </td>
        <td align="right" bgcolor="#EEEEEE"><strong>Tình trạng người dùng</strong></td>
        <td><input name="optactive" type="radio" id="radio" value="1" <?php if($objmember->isActive==1) echo ' checked="checked"';?> /> Đang hoạt động
          <input name="optactive" type="radio" id="radio2" value="0" <?php if($objmember->isActive==0) echo ' checked="checked"';?> />Đang bị Khóa</td>
      </tr>
      <?php } 
	  else {
	  ?>
      <input type="hidden" id="cbo_gmember" name="cbo_gmember" value="<?php echo $objmember->Gmember;?>" />
      <input type="hidden" name="optactive" value="<?php echo $objmember->isActive;?>" />
      <?php } ?>
    </table>
      <label>
        <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
      </label>
    </fieldset>
  </form>
</div>
<?php } 
unset($objmember);
?>