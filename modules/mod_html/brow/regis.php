<script language="javascript">
	function check_email()
	{
		var email=document.getElementById("txt_reemail");
		reg1=/^[0-9A-Za-z]+[0-9A-Za-z_]*@[\w\d.]+.\w{2,4}$/;
        testmail=reg1.test(email.value);
		if(!testmail){
            alert("Địa chỉ email không hợp lệ!");
            email.focus();
            return false;
        }
	}
</script>
<?php
$str="";
if(!isset($objemail))
$objemail= new CLS_EMAIL();
if(isset($_POST["txt_reemail"]) && $_POST["txt_reemail"]!="")
{
$objemail->Email=str_replace("'","",$_POST["txt_reemail"]);
$str=" where email='".$objemail->Email."'";
$objemail->getAllList($str);
if($objemail->Numrows()<0 || $objemail->Numrows()==0)
$objemail->Add_new();
}
?>
<span class="buttton_close">Ẩn [x]</span>
<span class="buttton_block close">Hiện [x]</span>
<form name="frm_regis_email" class="frm_reemail" method="post">
    <input value="Nhập email của bạn" onfocus="if(this.value='Nhập email của bạn') this.value=''" onblur="if(!this.value) this.value='Nhập email của bạn'" name="txt_reemail" id="txt_reemail" /> 
    <button onclick="return check_email();"><span>Gửi đăng ký</span></button>
</form>