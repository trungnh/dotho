<div id="catdown">
<?php $this->loadModule("top"); ?>
</div>
<?php
	$user="";
	$pass="";
	$err ="";
	if(isset($_POST["submit"]))
	{
		$user=$_POST["txtuser"];
		$pass=trim($_POST["txtpass"]);
		global $UserLogin;
		if($UserLogin->LOGIN($user,$pass)==true)
			echo "<script language=\"javascript\">window.location='".WEBSITE."checkout.html'</script>";
		else
			$err='<font color="red">Đăng nhập không thành công.</font>';
	}
?>
<div id="action">
    <h2 class="header">THÔNG TIN ĐĂNG NHẬP</h2>
    <div class="col-1 new-users">
        <div class="content">
            <p>Bằng cách tạo một tài khoản với cửa hàng của chúng tôi, bạn sẽ có thể thực hiện quy trình thanh toán nhanh hơn, địa chỉ vận chuyển, xem và theo dõi đơn hàng của bạn trong tài khoản của bạn và nhiều hơn nữa.</p>
            <a class="regis" href="register.html">Đăng lý tài khoản mới</a>
        </div>                
    </div>
    <form id="frm_login" class="frm-user_login" name="frm_login" method="post" action="" class="mod-pro mod-support box-module">
     	<div class="box-login-contain">
    		<div class="box-login">
    			<div class="box-login-content">
    				<table width="80%" style="padding-left: 40px;" border="0" align="center" cellpadding="3" cellspacing="0">
    					<tr><td align="center"><?php echo $err;?></td></tr>
    					<tr>
    					  <td><strong>Tên đăng nhập</strong></td>
    					</tr>
    					<tr><td><label>
    						<input type="text" name="txtuser" id="txtuser" class="text"  size="35" />
    					  </label></td></tr>
    					<tr>
    					  <td><strong>Mật khẩu</strong></td>
    					</tr>
    					<tr>
    						<td><label>
    						<input type="password" name="txtpass" id="txtpass" class="text" size="35"  />
    					  </label></td></tr>
    					<tr>
    					  <td align="right" colspan="2"><input type="submit" name="submit" id="submit" value="Đăng nhập" class="cmdnew" >
    						</td>
    					</tr>
    					<tr><td>&nbsp;</td><td align="center">&nbsp;</td></tr>
    				  </table>
    			</div>
    		</div>
    	</div>
    </form>
</div>