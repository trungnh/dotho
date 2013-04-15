<script language="javascript">
function formSubmit()
{
document.getElementById("frm_login_user").submit();
}
</script>
<?php
	$user="";
	$pass="";
	$err ="";
	if(isset($_POST["txtuser"]))
	{
		$user=$_POST["txtuser"];
		$pass=trim($_POST["txtpass"]);
		global $UserLogin;
		if($UserLogin->LOGIN($user,$pass)==true)
			echo "<script language=\"javascript\">window.location='".WEBSITE."checkout.html'</script>";
		else
			//$err='<font color="red">Đăng nhập không thành công.</font>';
            echo "<script language=\"javascript\">window.location='".WEBSITE."'</script>";
	}
?>
<div class="login">
<?php 
if(isset($_SESSION["IGFISLOGIN_USER"]))
{
?>
<strong id="member">
	Chào <?php echo $_SESSION["IGFEMAIL_USER"]; ?>
	<div class="update_login">
		<div class="block block-layered-nav">
			<div class="block-content">
				<dl id="narrow-by-list2">
					<dd class="last odd">
						<ol>
							<li><a href="edit.html">Đổi thông tin cá nhân</a></li>
							<li><a href="changepass.html">Đổi mật khẩu</a></li>
                            <li><a href="logout.html">Thoát</a></li>	
						</ol>
					</dd>
				 </dl>
			 </div>
		 </div>
	</div>
</strong>
<?php
}
else
{
?>
<form name="frm_login" method="post" id="frm_login_user">
<p>
    <input id="email_login" type="text" onfocus="if(this.value='Email đăng nhập') this.value=''" onblur="if(!this.value) this.value='Email đăng nhập'" value="Email đăng nhập" name="txtuser" class="input_name" />
    <input id="pass_login" type="password" value="Mật khẩu"  onfocus="if(this.value='Mật khẩu') this.value=''" onblur="if(!this.value) this.value='Mật khẩu'" class="input_pass" name="txtpass" />
    <button><span onclick="return formSubmit();">OK</span></button>
</p>
<p><input type="checkbox" class="check" /><label>Ghi nhớ</label><a href="<?php echo WEBSITE; ?>register.html">Đăng ký</a><a href="#">Quên mật khẩu </a>
</p>
</form>
<?php } ?>
</div>