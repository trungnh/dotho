<?php
if(isset($_SESSION["IGFISLOGIN_USER"]))
{
?>
<script language="javascript">
	function chekinput()
	{
		var email=document.getElementById("email");
		var phone=document.getElementById("phone");
		reg1=/^[0-9A-Za-z]+[0-9A-Za-z_]*@[\w\d.]+.\w{2,4}$/;
        testmail=reg1.test(email.value);
		if(!testmail){
            alert("Địa chỉ email không hợp lệ!");
            email.focus();
            return false;
        }
		if(isNaN(phone.value) || phone.value==""){
            alert("Số điện thoại chưa chính xác!");
            phone.focus();
            return false;
        }
	}
</script>
<?php
require_once 'includes/gfinnit.php';
require_once 'libs/gfclass/cls.mail.php';
require_once 'libs/gfclass/cls.product.php';
mysql_connect(HOSTNAME,DB_USERNAME,DB_PASSWORD) or die ("Không thể kết nối đến máy chủ");
mysql_select_db(DB_DATANAME) or die ("Database không tồn tại");
$err="";
$noidung="";
if(isset($_POST["ok"]))
{
    $name=$_POST["name"];
    $email=$_POST["email"];
    $phone=$_POST["phone"];
    $address=$_POST["address"];
    $text=$_POST["text"];
    if($_POST["name"]!="")
	$noidung.="<strong>Họ tên:</strong> ".$name."<br />";
	if($_POST["email"]!="")
	$noidung.="<strong>Email:</strong> ".$email."<br />";
	if($_POST["phone"]!="")
	$noidung.="<strong>Điện thoại:</strong> ".$phone."<br />";
	if($_POST["address"]!="")
	$noidung.="<strong>Địa chỉ:</strong> ".$address."<br />";
	if($_POST["text"]!="")
	$noidung.="<strong>Thông tin khác:</strong><br> ".$text."<br />";
	$noidung.='
	<table width="" border="0" align="center" cellpadding="4" cellspacing="1">
	  <tr>
		<td colspan="4" style="border-bottom:1px solid #ccc"><h3 class="protitle">Giỏ hàng của bạn</h3></td>
	  </tr>
	  <tr class="th_viewcart">
		<th width="314" align="left" nowrap="nowrap"><strong>Tên sản phẩm</strong></th>
		<th width="60" align="center" nowrap="nowrap"><strong>Số lượng</strong></th>
		<th width="118" nowrap="nowrap"><strong>Giá</strong></th>
		<th width="200" nowrap="nowrap"><strong>Tổng tiền</strong></th>
	  </tr>
	';
	$ids='';$sls='';
  	if(isset($_SESSION["PROIDS"])) $ids = $_SESSION["PROIDS"]; 
  	if(isset($_SESSION["PROSLS"])) $sls = $_SESSION["PROSLS"];
	
	if(!isset($objpro)) $objpro = new CLS_PRODUCTS();
		$noidung.=$objpro->viewEmailCart($ids,$sls); 
	$noidung.="</table>";
	//echo $noidung."</td></tr>"; die();
	$to = $email.", ".EMAILCONTACT;
	$subjecta = "Đặt hàng sản phẩm: ";
	$message = $noidung;
	$headers='MIME-Version: 1.0' . "\r\n";
	$headers.='Content-type: text/html; charset=utf-8' . "\r\n";
	$headers.="FROM: <".$email."> \r\n";
	mail($to,$subjecta,$message,$headers);
	if(!isset($objorder))
	$objorder= new CLS_ORDER();
	$objorder->code="NHH";
	$objorder->user_id=$_SESSION["IGFUSERID_USER"];
	$objorder->pay_id=1;
	$objorder->create_date=date("Y-m-d h:i:s");
	$objorder->carriage="0";
	$objorder->name_buyer=$name;
	$objorder->location_buyer=$address;
	$objorder->email_buyer=$email;
	$objorder->phone_buyer=$phone;
	$objorder->note=$text;
	$objorder->Add_new();
	
if(!isset($objorderdetail))
$objorderdetail= new CLS_ORDER_DETAIL();
$objorderdetail->order_id=$objorderdetail->getOrderIDlast();

	$idss = explode(",",$ids);
	$slss = explode(",",$sls);
	$n = count($idss)-1;
	for ($i=0;$i<$n;$i++){
		$objpro->getProByID($idss[$i],0);
		$objpro->UpdateStatic($idss[$i],$objpro->Static,$slss[$i]);
		$objpro->getProByID($idss[$i],0);
		$objorderdetail->pro_id=$idss[$i];
		$objorderdetail->Count=$slss[$i];
		$objorderdetail->price=$objpro->Cur_price;
		$objorderdetail->total=$objpro->Cur_price * $slss[$i];
		$objorderdetail->Add_new();
	}
	//echo 'Cảm ơn Quý khách. Đơn đặt hàng của Quý khách sẽ được chúng tôi xác nhận.';
	echo "<script language=\"javascript\">alert(\"Cảm ơn Quý khách. Đơn đặt hàng của Quý khách sẽ được chúng tôi xác nhận.\");</script>";
	echo "<script language=\"javascript\">window.location='".WEBSITE."'</script>";
}
if(isset($_SESSION["PROIDS"])) $ids = $_SESSION["PROIDS"];
if($ids!="")
{
?>
        <h3 style="color:#950500; font-weight: bold; text-align: left; margin: 10px 0 10px 0;">Qúy khách vui lòng điền thông tin đặt hàng:</h3>
        <form action="" method="post" class="form_checkout">
        <center><strong><?php echo $err; ?></strong></center>
        <table width="500" border="0" align="center" cellpadding="3" cellspacing="1">
            <tr>
                <td width="150" bgcolor="#EEEEEE" align="right">Họ Tên</td>
                <td width="350"><input type="text" name="name" size="100" readonly="readonly" value="<?php  echo $_SESSION["IGFUSERNAME_NAME"];?>" /></td>
            </tr>
            <tr>
                <td width="150" bgcolor="#EEEEEE" align="right">Email</td>
                <td width="350"><input type="text" name="email" id="email" size="100"  readonly="readonly" value="<?php echo $_SESSION["IGFGROUPUSER_EMAIL"]; ?>" /></td>
            </tr>
            <tr>
                <td width="150" bgcolor="#EEEEEE" align="right">Điện Thoại</td>
                <td align="left"><input type="text" name="phone" size="100" id="phone" readonly="readonly" value="<?php echo $_SESSION["IGFGROUPUSER_PHONE"]; ?>" /></td>
            </tr>
            <tr>
                <td width="150" bgcolor="#EEEEEE" align="right">Địa chỉ</td>
                <td width="350"><input type="text" name="address" size="100"  readonly="readonly" value="<?php echo $_SESSION["IGFGROUPUSER_ADDRESS"]; ?>" /></td>
            </tr>
            <tr>
                <td width="150" bgcolor="#EEEEEE" align="right">Thông tin khác</td>
                <td width="350"><textarea cols="100" rows="10" name="text"></textarea></td>
            </tr>
            <tr>
                <td width="150" bgcolor="#EEEEEE" align="right"></td>
                <td width="350"><input type="submit" name="ok" value="Gửi" onclick="return chekinput();"  /><input type="reset" value="Làm lại" /></td>
            </tr>
        </table>
        </form>
<?php
}
else
echo "Chưa có sản phẩm nào trong giỏ hàng. Vui lòng click <a href=\"".WEBSITE."\">vào đây</a> để chọn mua hàng "; 
?>
<div class="history_cart">
    <h3>Lịch sử mua hàng</h3>
    <?php if(!isset($objorder)) $objorder= new CLS_ORDER();
    $objorder->listTableOrder("",$_SESSION["IGFUSERID_USER"]);
    ?>
</div>
<?php include_once("components/com_cart/tem/order.php");
}
else
echo "<script language=\"javascript\">window.location='".WEBSITE."login.html'</script>";?>
