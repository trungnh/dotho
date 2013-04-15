<?php
if(!isset($objmember)) $objmember =new CLS_USERS();
if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
{
	$objmember->UserName=randomUser(6);
	$objmember->FirstName=$_POST["txtfirstname"];
	$objmember->LastName=$_POST["txtlastname"];
	
	$txtjoindate = $_POST["txtbirthday"];
	$joindate = mktime(0,0,0,substr($txtjoindate,3,2),substr($txtjoindate,0,2),substr($txtjoindate,6,4));
	$objmember->Birthday=date("Y-m-d",$joindate);
		
	$objmember->Gender=$_POST["optgender"];
	$objmember->Address=$_POST["txtaddress"];
	$objmember->Phone=0;
	$objmember->Mobile=$_POST["txtmobile"];
	$objmember->Email=$_POST["txtusername"];//$_POST["txtemail"];
	$objmember->Gmember=12; //$_POST["cbo_gmember"];
	$objmember->isActive=1;
	if(isset($_POST["txtid"]))
		$objmember->ID=$_POST["txtid"];
	if($objmember->ID=="-1")
	{
		$objmember->Password= trim($_POST["txtpassword"]);
		$result1=$objmember->Add_new();
		if(!$result1)
		{
			echo "<script language=\"javascript\">alert('Đăng ký không thành công vui lòng đăng ký lại')</script>";
			echo "<script language=\"javascript\">window.location='register.html'</script>";
		}
		else	
		{
			echo "<script language=\"javascript\">alert('Chúc mừng bạn đã đăng ký thành công')</script>";
			echo "<script language=\"javascript\">window.location='login.html'</script>";
		}
	}
	else {
		$result3=$objmember->Update();
		if(!$result3)
			echo "<script language=\"javascript\">window.location='index.php?com=users&mess=U02'</script>";
		else
		{	
			echo "<script language=\"javascript\">alert('Chúc mừng bạn sửa đổi thành công')</script>";
		}
	}
}
$viewtype="";
if(isset($_GET["viewtype"])){
	$viewtype=$_GET["viewtype"];
}
	switch($viewtype)
	{
		case "add":	include("tem/add.php"); break;
		case "edit":	include("tem/edit.php"); break;
		case "logout":	include("tem/logout.php"); break;
		case "changepass": include("tem/changepass.php"); break;
		case "login": include("tem/login.php"); break;
	}
unset($objmember);
unset($result1);unset($result2);unset($result3);
?>