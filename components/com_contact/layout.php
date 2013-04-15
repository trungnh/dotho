<script language="javascript">
	function chechemail()
	{
		var phone=document.getElementById("phone");
		var subject=document.getElementById("subject");
		var content=document.getElementById("content");
		var email=document.getElementById("email");
		reg1=/^[0-9A-Za-z]+[0-9A-Za-z_]*@[\w\d.]+.\w{2,4}$/;
        testmail=reg1.test(email.value);
		if(!testmail){
            alert("Địa chỉ email không hợp lệ!");
            email.focus();
            return false;
        }
		if(isNaN(phone.value)){
            alert("Số điện thoại chưa chính xác!");
            phone.focus();
            return false;
        }
		if(subject.value==""){
            alert("Vui lòng nhập tiêu đề thư!");
            subject.focus();
            return false;
        }
		if(content.value==""){
            alert("Vui lòng nhập nội dung thư!");
            content.focus();
            return false;
        }
	}
</script>
<?php
require_once 'libs/gfclass/cls.mail.php';
$noidung="<h2>Thông tin người liên hệ:</h2>";
if(isset($_POST["ok"]))
{
    $name=$_POST["name"];
    $email=$_POST["email"];
    $phone=$_POST["phone"];
    $subject=$_POST["subject"];
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
	$noidung.="<hr>".$text."<br />";
    $objMailer=new CLS_MAILER();
    $header='MIME-Version: 1.0' . "\r\n";
	$header.='Content-type: text/html; charset=utf-8' . "\r\n";//Content-type: text/html; charset=iso-8859-1′ . “\r\n
	$header.="FROM: <".$email."> \r\n";

   	$objMailer->FROM="$name<$email>";//WEB_MAIL;
	$objMailer->HEADER=$header;
	$objMailer->TO=$email.", ".EMAILCONTACT; //somebody@example.com, somebodyelse@example.com
	$objMailer->SUBJECT=$subject;
	$objMailer->CONTENT=$noidung;
	$objMailer->SendMail();
	?>
    <script language="javascript"> window.location="index.php?com=contact";</script>
    <?php
    }
?>	
	<fieldset style="border: 1px solid #006289;">
        <legend><strong>Thông tin liên hệ: </strong></legend>
        <div style="line-height: 200%; padding-left: 11px; padding-bottom: 30px; text-align: left !important;">
        	<?php echo CONTACT;?>
        </div>
    </fieldset>
    <fieldset style="border: 1px solid #006289;">
        <legend><strong>Liên hệ: </strong></legend>
        <div>Mục có dấu <font color="#FFFF00">*</font> là thông tin bắt buộc</div>
        <form action="" method="post" style="padding: 0px; margin:0px;" >
        <center><strong><?php //echo $err; ?></strong></center>
        <table style="border: 0px solid #CCC; margin: 0 auto;" width="70%" border="0" cellpadding="5" cellspacing="1">
        <tr>
            <td width="150" align="right"><strong>Họ và Tên:</strong></td>
            <td align="left"><input type="text" name="name" size="50" /></td>
        </tr>
        <tr>
            <td width="150" align="right"><strong>Hòm thư:<font color="#FFFF00">*</font></strong></td>
            <td align="left"><input type="text" name="email" size="50" id="email" /></td>
        </tr>
        <tr>
            <td width="150" align="right"><strong>Điện Thoại:<font color="#FFFF00">*</font></strong></td>
            <td align="left"><input type="text" name="phone" size="50" id="phone" /></td>
        </tr>
        <tr>
            <td width="150" align="right"><strong>Địa chỉ:</strong></td>
            <td align="left"><input type="text" name="address" size="50" /></td>
        </tr>
        <tr>
            <td width="150" align="right"><strong>Tiêu đề:<font color="#FFFF00">*</font></strong></td>
            <td align="left"><input name="subject" type="text" id="subject" size="50"/></td>
        </tr>
        <tr>
            <td width="150" align="right"><strong>Nội dung:<font color="#FFFF00">*</font></strong></td>
            <td align="left"><textarea cols="50" rows="10" name="text" id="content"></textarea></td>
        </tr>
        <tr>
            <td width="150" align="right"></td>
            <td align="left"><input type="submit" name="ok" value="Gửi" class="btninput" onclick="return chechemail();" /><input type="reset" value="Làm lại" class="btninput btnright" /></td>
        </tr>
        </table>
       </form>
        </form>    