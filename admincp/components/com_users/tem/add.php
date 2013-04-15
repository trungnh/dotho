<?php
	defined("ISHOME") or die("Can't acess this page, please come back!")
?>
<div id="action">
<script language="javascript">

 function checkinput(){
	 var user = document.getElementById("txtusername");
	 var checkuser	= document.getElementById("checkuser");
	 var pass = document.getElementById("txtpassword");
	 var repass = document.getElementById("txtrepass");
	 
	 var firstname = document.getElementById("txtfirstname");
	 var lastname  = document.getElementById("txtlastname");
	 var mobile  = document.getElementById("txtmobile");
	 var email  = document.getElementById("txtemail");
	 var gmember = document.getElementById("cbo_gmember");
	 
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
	 if(pass.value=='') {
	 	alert("Mời bạn nhập mật khẩu đăng nhập hệ thống");
		pass.focus();
		return false;
	 }
	 if(repass.value=='') {
	 	alert("Mời bạn nhập lại mật khẩu 1 lần nữa");
		repass.focus();
		return false;
	 }
	 if(pass.value!=repass.value) {
	 	alert("Mật khẩu nhập 2 lần không khớp nhau. Vui lòng nhập lại thật chính xác.");
		pass.focus();
		return false;
	 }
	 if(firstname.value=='') {
	 	alert("Mời bạn nhập Họ & đệm của người dùng");
		firstname.focus();
		return false;
	 } 
	 if(lastname.value=='') {
	 	alert("Mời bạn nhập Tên người dùng");
		lastname.focus();
		return false;
	 }
	 
	 if(email.value=='') {
	 	/*alert("Mời bạn nhập địa chỉ Email");
		email.focus();
		return false;*/
	 } 
	 if(email.value!='' && !checkEmail(email.value))
	 {
		 email.focus();return false;
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
	 if(gmember.value==0) {
	 	alert("Mời bạn chọn nhóm quyền người dùng");
		gmember.focus();
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
  <form id="frm_action" name="frm_action" method="post" action="">
    <fieldset>
<legend><strong>Thông tin tài khoản người dùng</strong></legend>
    <table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr><td colspan="2">Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</td></tr>
      <tr>
        <td width="160" align="right" bgcolor="#EEEEEE"><strong>Tên đăng nhập<font color="red"> *</font></strong></td>
        <td width="788">
          <input name="txtusername" type="text" id="txtusername" size="30" class="required" minlength="3"/>
          <span id="msgbox" style="display:none"></span>
          <input type="hidden" name="checkuser" id="checkuser" value="" />
          <input name="txttask" type="hidden" id="txttask" value="1" />
          </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Mật khẩu<font color="red"> *</font></strong></td>
        <td>
          <input name="txtpassword" type="password" id="txtpassword" size="30" class="required"/>
        </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Nhập lại mật khẩu <font color="red">*</font></strong></td>
        <td><input name="txtrepass" type="password" id="txtrepass" size="30" class="required" /></td>
      </tr>
    </table>
    </fieldset>
    <fieldset>
	<legend><strong>Thông tin người dùng</strong></legend>
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="170" align="right" bgcolor="#EEEEEE"><strong>Họ & đệm</strong><font color="red"> *</font></strong></td>
        <td width="246"><strong><input name="txtfirstname" type="text" id="txtfirstname" size="30" class="required"/>
         
          </strong></td>
        <td width="191" align="right" bgcolor="#EEEEEE"><strong>Ngày sinh&nbsp;</strong></td>
        <td width="297"><input type="text" name="txtbirthday" id="txtbirthday" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Tên <font color="red">*</font></strong></td>
        <td> <input name="txtlastname" type="text" id="txtlastname" size="30" class="required"/></td>
        <td align="right" bgcolor="#EEEEEE"><strong>Giới tính&nbsp;</strong></td>
        <td><label>
          <input name="optgender" type="radio" value="0" checked="checked" />
          Nam
          <input type="radio" name="optgender" value="1" />
        N&#7919;</label></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Địa chỉ &nbsp;</strong></td>
        <td><label>
          <input name="txtaddress" type="text" id="txtaddress" size="30" />
        </label></td>
        <td align="right" bgcolor="#EEEEEE"><strong>Điện thoại bàn&nbsp;</strong></td>
        <td><input type="text" name="txtphone" id="txtphone" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Email&nbsp;</strong></td>
        <td><input name="txtemail" type="text" id="txtemail" size="30" class="required email"/></td>
        <td align="right" bgcolor="#EEEEEE"><strong>Điện thoại di động&nbsp;</strong></td>
        <td><input type="text" name="txtmobile" id="txtmobile" class="required"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Nhóm quyền <font color="red">*</font></strong></td>
        <td>
        <select name="cbo_gmember" id="cbo_gmember">
        	<option value="0" style="font-weight:bold; background-color:#cccccc">Chọn nhóm quyền</option>
			<?php 
			if(!isset($objgmem)) $objgmem = new CLS_GUSER();
			$objgmem->getName_ID();
			unset($objgmem);
			?>
        </select>
        </td>
        <td align="right" bgcolor="#EEEEEE"><strong>Tình trạng &nbsp;</strong></td>
        <td><input name="optactive" type="radio" id="radio" value="1" checked /> Đang hoạt động
          <input name="optactive" type="radio" id="radio2" value="0" />Đang bị Khóa</td>
      </tr>
    </table>
      <label>
        <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
      </label>
    </fieldset>
  </form>
</div>