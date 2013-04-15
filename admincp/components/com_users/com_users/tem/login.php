<div style="text-align: center">
<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$user="";
	$pass="";
	$err ="";
	if(isset($_POST["submit"]))
	{
		$user=$_POST["txtuser"];
		$pass=trim($_POST["txtpass"]);
		global $UserLogin;
		if($UserLogin->LOGIN($user,$pass)==true)
			//header("location:index.php");
			echo "<script language=\"javascript\">window.location='index.php'</script>";
		else
			$err='<font color="red">Đăng nhập không thành công.</font>';
	}
?>
<form id="frm_login" name="frm_login" method="post" action="">
	
    <h3 class="header">ĐĂNG NHẬP </h3>
   <div id="loginlayou">
  
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr><td>&nbsp;</td><td align="center"><?php echo $err;?></td></tr>
    <tr>
      <td align="right">Tên đăng nhập</td>
      <td width="50%"><label>
        <input type="text" name="txtuser" id="txtuser" class="text"  />
      </label></td>
    </tr>
    <tr>
      <td align="right">Mật khẩu</td>
      <td><label>
        <input type="password" name="txtpass" id="txtpass" class="text"  />
      </label></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>
        <input type="submit" name="submit" id="submit" value="Đăng nhập" class="button">
        <input type="reset" name="reset" id="reset" value="Hủy bỏ" class="button">
        </td>
    </tr>
  </table>
  </div>
</form>
</div>