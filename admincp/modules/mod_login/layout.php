<?php 
if(isset($_SESSION["IGFUSERNAME_USER"]))
{
?>
Chào <strong><?php echo $_SESSION["IGFISLOGIN_USER"]; ?></strong> | <a href="index.php?com=users&viewtype=logout">Thoát</a>
<?php
}
else
{
?><a href="index.php?com=users&viewtype=add">Đăng ký</a> | <a href="index.php?com=users&viewtype=login">Đăng nhập</a>
<?php } ?>