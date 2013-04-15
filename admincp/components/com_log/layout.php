<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
define("COMS","log");

// Begin Toolbar
require_once(LAG_PATH."vi/lang_default.php");
require_once(libs_path."cls.users.php");
require_once(libs_path."cls.log_login.php");
if(!isset($objmember)) $objmember=new CLS_USERS();
if(!isset($objlog)) $objlog=new CLS_LOGIN();
$rows = $objlog->getAllList("");
?>
<center>
	<h1>Quản lý đăng nhập</h1>
</center>
<table width="100%" border="0" cellspacing="1" cellpadding="5" class="list">
	<tr class="header">
        <td width="30" align="center">#</td>
        <td align="center">Tên đăng nhập</td>
        <td align="center">ip_login</td>
        <td align="center">login_time</td>
		<td align="center">	logout_time</td>
        <td  align="center">Log</td>
    </tr>
	<?php 
	$i=0;
	for($i=0;$i< sizeof($rows['id']);$i++){
	?>
	<tr>
		<td width="30" align="center"><?php echo $i+1;?></td>
        <td align="center"><?php 
			echo $objmember->getUserNameById($rows['user_id']);?></td>
        <td align="center"><?php echo $rows['ip_login'];?></td>
        <td align="center"><?php echo date("d/m/Y G:i:s",strtotime($rows["login_time"]));?></td>
		<td align="center">	<?php  if(date("d/m/Y G:i:s",strtotime($rows['logout_time']))== "01/01/1970 1:00:00"){
										echo "Not logout";
									}
								   else 
										echo date("d/m/Y G:i:s",strtotime($rows["login_time"]));	
									?></td>
        <td  align="center"><?php echo $rows['loglogin'];?></td>
	</tr>
	<?php
	}
	?>
</table>