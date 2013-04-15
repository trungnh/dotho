<?php
$memid="";
if(isset($_SESSION["IGFUSERID_USER"]))
	$memid=$_SESSION["IGFUSERID_USER"];
	
if(!isset($objmember))
	$objmember=new CLS_USERS();
		$memid=$_SESSION["IGFUSERID_USER"];
	
	$objmember->getMemberByID($memid); //echo $objmember->UserName;
?>
<div id="catdown">
<?php $this->loadModule("top"); ?>
</div>
<link rel="stylesheet" href="<?php echo WEBSITE.THIS_TEM_PATH; ?>css/jquery-ui.css" type="text/css" media="all" /> 
<link href="<?php echo WEBSITE.THIS_TEM_PATH; ?>css/ui.theme.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo WEBSITE; ?>js/jquery.min.js"></script>
<script src="<?php echo WEBSITE; ?>js/jquery-ui.min.js"></script>
<script language="javascript" src="<?php echo WEBSITE; ?>js/calendar_vi.js"></script>
<script language="javascript">
 function checkinput(){
	 var user = document.getElementById("txtusername");
	 var checkuser	= document.getElementById("checkuser");
	 var pass = document.getElementById("txtpassword");
	 var repass = document.getElementById("txtrepass");
	 var firstname = document.getElementById("txtfirstname");
	 var lastname  = document.getElementById("txtlastname"); 
	 var phone = document.getElementById("txtmobile");
	 if(user.value=='') {
	 	$("#msgbox_user").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Mời bạn nhập địa chỉ email đúng định dạng').addClass('messagebox').fadeTo(900,1);	
		});
		user.focus();
		return false;
	 }
	 if(checkuser.value=="false") {
	 	alert("Email này đã tồn tại. Vui lòng nhập email khác");
		 user.focus();
		 return false;
	 }
	 if(firstname.value=='') {
        $("#msgbox_name").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Mời bạn nhập Họ & đệm của người dùng').addClass('messagebox').fadeTo(900,1);	
		});
		firstname.focus();
		return false;
	 } 
	 if(lastname.value=='') {
        $("#msgbox_lastname").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Mời bạn nhập Tên người dùng').addClass('messagebox').fadeTo(900,1);	
		});
		lastname.focus();
		return false;
	 } 
	if(isNaN(phone.value) || phone.value==""){
        $("#msgbox_phone").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Số điện thoại chưa chính xác!').addClass('messagebox').fadeTo(900,1);	
		});
		phone.focus();
		return false;
	} 
    if($("#txtcapchar").val()=="" )
	{
	 	$("#capchar").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Vui lòng nhập mã bảo vệ').addClass('messagebox').fadeTo(900,1);
		});
	 	$("#txtcapchar").focus();
	 	return false;
	}
	 return true;
 }
jQuery.noConflict();
(function($) { 
  $(function() {
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
				$.post("<?php echo WEBSITE; ?>user_availabity.php",{ user_name:$(this).val() } ,function(data)
				{
				  if($.trim(data)=='nodata' || $.trim(data)=='' || $.trim(data)=='notype') {
					$("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
					{ 
					  //add message and change the class of the box and start fading
					  $(this).html('Mời bạn nhập địa chỉ email đúng định dạng').addClass('messageboxerror').fadeTo(900,1);
					});
				  }
				  else if($.trim(data)=='no') //if username not avaiable
				  {
					$("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
					{ 
					  //add message and change the class of the box and start fading
					  $(this).html('Email này đã tồn tại. Vui lòng nhập email khác').addClass('messageboxerror').fadeTo(900,1);
					});		
					document.getElementById("checkuser").value="false";
				  }
				  else 
				  {
					$("#msgbox").fadeTo(200,0.1,function()  //start fading the messagebox
					{ 
					  //add message and change the class of the box and start fading
					  $(this).html('Email có thể sử dụng').addClass('messageboxok').fadeTo(900,1);	
					});
					document.getElementById("checkuser").value="true";
				  }
						
				});		 
			});
    });
})(jQuery);	
 </script>
<div id="action">
<div class="update">
	 <h2 class="header">THÔNG TIN TÀI KHOẢN NGƯỜI DÙNG</h2>
  <form id="frm_action"  class="frm-user" name="frm_action" method="post" action="">
    <fieldset>
    <table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr><td colspan="2">Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</td></tr>
      <tr>
        <td width="600" align="right" bgcolor="#EEEEEE"><strong>Địa chỉ email <font color="red"> *</font></strong></td>
        <td width="744" align="left">
          <input name="txtusername" type="text" class="required" id="txtusername" value="<?php echo $objmember->Email;?>" minlength="3"<?php if($objmember->isAdmin()==false) echo '  readonly="readonly"';?>/>
          <span id="msgbox" style="display:none"></span>
          <input type="hidden" name="checkuser" id="checkuser" value="" />
         <input type="hidden" name="txtuser" value="<?php echo $objmember->Email;?>" id="txtuser" />  
        </td>
      </tr>
    </table>
    </fieldset>
    <fieldset>
	<legend><strong>Thông tin chi tiết người dùng</strong></legend>
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="171" align="right"><strong>Họ &amp; đệm<font color="red"> *</font></strong></td>
        <td width="236"><input type="text" name="txtfirstname" id="txtfirstname" value="<?php echo $objmember->FirstName;?>" class="required" />
          <input name="txttask" type="hidden" id="txttask" value="1" />
          <input name="txtid" type="hidden" id="txtid" value="<?php echo $objmember->ID;?>" />
		</td>
        <td width="156" align="right"><strong>Ngày sinh&nbsp;</strong></td>
        <td width="339" align="left"><input type="text" name="txtbirthday" id="txtbirthday" value="<?php echo date("d-m-Y",strtotime($objmember->Birthday));?>" /></td>
      </tr>
      <tr>
        <td width="171" align="right"><strong>Tên <font color="red">*</font></strong></td>
        <td width="236"><strong>
          <input type="text" name="txtlastname" id="txtlastname" value="<?php echo $objmember->LastName;?>" class="required"/>
          </strong></td>
        <td width="156" align="right"><strong>Giới tính&nbsp;</strong></td>
        <td align="left">
          <input name="optgender" type="radio" value="0" <?php if($objmember->Gender==0) echo ' checked="checked"';?> /> Nam
          <input type="radio" name="optgender" value="1" <?php if($objmember->Gender==1) echo ' checked="checked"';?>/> N&#7919;</td>
      </tr>
      <tr>
        <td align="right"><strong>Địa chỉ&nbsp;</strong></td>
        <td><label>
          <input type="text" name="txtaddress" id="txtaddress" value="<?php echo $objmember->Address;?>" />
        </label></td>
        <td align="right"><strong>Điện thoại di động &nbsp;</strong></td>
        <td align="left"><input type="text" name="txtmobile" id="txtmobile" value="<?php echo $objmember->Mobile;?>" class="required"/></td>
      </tr>
	  <tr align="center">
	  	<td colspan="4" align="center">
        <input type="submit" name="cmdsave" id="cmdsave" style="float: none;" class="cmdnew" value="Sửa đổi"  onclick="return checkinput(); "></td>
	  </tr>
    </table>
    </fieldset>
  </form>
</div>
</div>
<?php 
unset($objmember);
?>