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
	 if(pass.value=='') {
	 	//alert("Mời bạn nhập mật khẩu đăng nhập hệ thống");
    	$("#msgbox_pass").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Mời bạn nhập mật khẩu đăng nhập hệ thống').addClass('messagebox').fadeTo(900,1);	
		});
		pass.focus();
		return false;
	 }
	 if(repass.value=='') {
 	    $("#msgbox_repass").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Mời bạn nhập lại mật khẩu 1 lần nữa').addClass('messagebox').fadeTo(900,1);	
		});
		repass.focus();
		return false;
	 }
	 if(pass.value!=repass.value) {
        $("#msgbox_repass").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Mật khẩu nhập 2 lần không khớp nhau. Vui lòng nhập lại đúng.').addClass('messagebox').fadeTo(900,1);	
		});
		pass.focus();
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
            $("#txtcapchar").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		$("#checkcapchar").removeClass().addClass('messagebox').text('Kiểm tra dữ liệu...').fadeIn("slow");
		//check the username exists or not from ajax
		$.post("<?php echo WEBSITE; ?>capchar/checkcapchar.php",{ check_validate:$(this).val() } ,function(data)
        {
		  if($.trim(data)=='nodata' || $.trim(data)=='') {
		  	$("#capchar").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Vui lòng nhập mã bảo vệ').addClass('messageboxerror').fadeTo(900,1);
			});
		  }
		  else if($.trim(data)=='no') //if username not avaiable
		  {
		  	$("#checkcapchar").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Vui lòng nhập mã bảo vệ đúng').addClass('messageboxerror').fadeTo(900,1);
			});		
			document.getElementById("checkvalidate").value="false";
          }
		  else 
		  {
			$("#checkcapchar").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Nhập mã bảo vệ đúng').addClass('messageboxok').fadeTo(900,1);	
			});
			document.getElementById("checkvalidate").value="true";
		  }
				
        });
		if( $(this).val()=='') {
			$("#capchar").fadeTo(200,0.1,function()
			{ 
			  $(this).html('Vui lòng nhập mã bảo vệ').fadeTo(900,1);
			});
		}
		else {
				$("#capchar").fadeTo(200,0.1,function()
				{ 
				  $(this).html('').fadeTo(900,1);
				});
			}
	});
		});
    });
})(jQuery);	
 </script>
 <div id="action">
    <h2 class="header">ĐĂNG KÝ TÀI KHOẢN MỚI</h2>
  <form id="frm_action" class="frm-user" name="frm_action" method="post" action="" class="mod-pro mod-support box-module">
	
   <div id="loginlayou" class="content box-module">
<p><strong style="text-align: left; display: block;">Thông tin tài khoản người dùng</strong></p>
    <table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr><td colspan="2">Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</td></tr>
      <tr>
        <td width="170" align="right"><strong>Địa chỉ email<font color="red"> *</font></strong></td>
        <td width="246">
          <input name="txtusername" type="text" id="txtusername" size="35" class="required" minlength="3"/>
          <span id="msgbox_user" style="display:none"></span>
          <span id="msgbox" style="display:none"></span>
          <input type="hidden" name="checkuser" id="checkuser" value="" />
          <input name="txttask" type="hidden" id="txttask" value="1" />
        </td>
      </tr>
      <tr>
        <td width="170" align="right"><strong>Mật khẩu<font color="red"> *</font></strong></td>
        <td width="246">
          <input name="txtpassword" type="password" id="txtpassword" size="35" class="required"/>
          <span id="msgbox_pass" style="display:none"></span>
        </td>
      </tr>
      <tr>
        <td width="170" align="right"><strong>Nhập lại mật khẩu <font color="red">*</font></strong></td>
        <td width="246"><input name="txtrepass" type="password" id="txtrepass" size="35" class="required" />
        <span id="msgbox_repass" style="display:none"></span>
        </td>
      </tr>
    </table>
<p><strong style="text-align: left; display: block;">Thông tin người dùng</strong></p>
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="170" align="right"><strong>Họ & đệm<font color="red"> *</font></strong></td>
        <td width="246">
        <input name="txtfirstname" type="text" id="txtfirstname" size="35" class="required"/>
          <span id="msgbox_name" style="display:none"></span>
          </td>
        
      </tr>
	  <tr>
        <td  width="170" align="right"><strong>Tên <font color="red">*</font></strong></td>
        <td  width="246"> <input name="txtlastname" type="text" id="txtlastname" size="35" class="required"/>
        <span id="msgbox_lastname" style="display:none"></span>
        </td>
       
      </tr>
	  <tr>
		<td width="170" align="right"><strong>Ngày sinh&nbsp;</strong></td>
        <td  width="246"><input type="text" name="txtbirthday" id="txtbirthday" size="35"  /></td>
	  </tr>
      
	  <tr>
		 <td  width="170" align="right"><strong>Giới tính&nbsp;</strong></td>
        <td  width="246">
          <input name="optgender" type="radio" value="0" checked="checked" />
          Nam
          <input type="radio" name="optgender" value="1" />
        Nữ</td>
	  </tr>
      <tr>
        <td  width="170" align="right"><strong>Địa chỉ &nbsp;</strong></td>
        <td  width="246"><label>
          <input name="txtaddress" type="text" id="txtaddress" size="35" />
        </label></td>
        
      </tr>
	  <tr style="display: none;">
		<td  width="170" align="right"><strong>Điện thoại bàn&nbsp;</strong></td>
        <td  width="246"><input type="text" name="txtphone" id="txtphone" size="35" value="0463294036" /></td>
	  </tr>
      <tr>
        <td align="left"><strong>Mã bảo mật:<font color="red"> *</font></strong></td>
        <td>
            <img id="siimage" align="left" style="padding-right: 5px; border: 0" src="<?php echo WEBSITE; ?>capchar/securimage_show.php?sid=<?php echo md5(time()) ?>" />
            <a tabindex="-1" style="border-style: none" href="#" title="Refresh Image" onClick="document.getElementById('siimage').src = '<?php echo WEBSITE; ?>capchar/securimage_show.php?sid=' + Math.random(); return false"><img src="<?php echo WEBSITE.THIS_TEM_PATH; ?>images/capchar1.gif" alt="Reload Image" border="0" onClick="this.blur()" align="bottom" /></a>
        </td>
      </tr>
      <tr>
        <td align="left"><strong>Nhập mã bảo mật:<font color="red">*</font></strong></td>
        <td><input name="txtcapchar" value="" type="text" id="txtcapchar" size="30" class="required" />
        <span id="checkcapchar" style="display:none"></span>
        <span id="capchar" style="display:none"></span>
          <input type="hidden" name="checkvalidate" id="checkvalidate" value="" /></td>
      </tr>
	  <tr>
		<td  width="170" align="right"><strong>Điện thoại di động&nbsp;<font color="red"> *</font></strong></td>
        <td  width="246">
            <input type="text" name="txtmobile" id="txtmobile" size="35" class="required"/>
            <span id="msgbox_phone" style="display:none"></span>
        </td>
	  </tr>
      <tr>
          <td  width="170">&nbsp;</td>
          <td  width="246"> <label>
            <input type="submit" name="cmdsave" id="cmdsave" class="cmdnew" value="Đăng ký" onclick="return checkinput();">
          </label></td>
      </tr>
    </table>
    </div>
  </form>
    <div class="divfieldset infor-wrapper">
		<div class="information">
			<div class="content">
				<p>Bằng cách tạo một tài khoản với cửa hàng của chúng tôi, bạn sẽ có thể thực hiện quy trình thanh toán nhanh hơn, địa chỉ vận chuyển, xem và theo dõi đơn hàng của bạn trong tài khoản của bạn và nhiều hơn nữa.</p>
			</div>
		</div>                                                                        
	</div>
</div>