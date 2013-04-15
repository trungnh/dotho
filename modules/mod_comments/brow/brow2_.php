<script type="text/javascript">
    function imgsecuri_click(){
        var obj=document.getElementById("myimg");
        obj.style.display = "block";
    }
    function getIDclick(name){
    	document.getElementById("par_id").value=name;
    }
    $(document).ready(function() {
        $("#bt_hidden").click(function () {
            $("#display").toggle("slow");
            setTimeout("text()",200);
            });  
    });
     function loadcomment(id){
        var str = ".frm_comment_" + id;
         $(str).html($('#form_comment').html());
    }
function text() {
    if(document.getElementById("bt_hidden").innerHTML=="Ẩn lời bình")
    {
        document.getElementById("bt_hidden").innerHTML="Hiện lời bình";
    }
    else
    {
        document.getElementById("bt_hidden").innerHTML="Ẩn lời bình";
    }
    
}
</script>
<?php //require_once (MOD_PATH."mod_comment/helper.php");
    if(isset($_GET["ItemID"]))
        $proid = (int)$_GET["ItemID"];
		$strwhere = " where `pro_id` = $proid ";
		$objcom->getAllList($strwhere);
		$total_rows=$objcom->Numrows();
		//$objcom->listTableCommentNews($strwhere,$cur_page,$conid);
		echo $total_rows;
?>
<div id="comment">
	<h2>Bình luận <span>(<?php echo $total_rows; ?>) </span></h2>
<div id="display">
<?php
    unset($objcom);
 ?>
</div><!-- End #display -->
</div><!-- End #list_comment -->
<?php
//-----------Add comment -----------
    //if(!isset($objcom))
       //$objcom = new MOD_COMMENT();
     
    if(isset($_POST["bt_submit"]))
    {
        if( $_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] ) ) 
        {
            $userid = 0;
            $objcom->username = $_SESSION["IGFUSERNAME"];
            $objcom->Content = $_POST["content"];
            $objcom->par_id=0;
            $isactive = 0;
            if($userid!=0)
                $isactive=1;
            $objcom->isactive = $isactive;
            $objcom->pro_id=$proid;
            $objcom->Add_new();
        }           
    }
    unset($objcom);
?>
<div id="form_comment">
    <form name="frm_comment" id="frm_comment" method="POST">
    	<h2>Viết bình luận</h2>
        <input type="hidden" name="par_id" id="par_id" value="0"/>
        <p><input type="text" name="name" onblur="if (this.value=='') this.value = this.defaultValue" onfocus="if (this.value==this.defaultValue) this.value = '';" value="Họ tên" id="name" onblur="" />
              <input type="text" name="email" id="email" onblur="if (this.value=='') this.value = this.defaultValue" onfocus="if (this.value==this.defaultValue) this.value = '';" value="Email"  style="width: 190px;"/>
            </p>
            <p>
                <p>(Bấm vào đây để nhận mã)</p><img id="imgcheck" class="imgcheck" src="captcha/refress_comment.jpg" onclick="imgsecuri_click()"/>
                <img id="myimg" class="imgcheck" src="captcha/CaptchaSecurityImages.php?width=88&height=18&characters=4" />
                <input type="text" id="security_code" name="security_code" style="width: 77px;" onblur="if (this.value=='') this.value = this.defaultValue" onfocus="if (this.value==this.defaultValue) this.value = '';" value="Mã xác nhận"/>
               </p>
           <p>
                    <textarea  cols="20" rows="5" name="content" id="content_com" onblur="if (this.value=='') this.value = this.defaultValue" onfocus="if (this.value==this.defaultValue) this.value = '';">Nội dung</textarea>
               </p>
            <p>
             
                <input type="submit" name="bt_submit" id="bt_submit" value="Gửi bình luận" class="button1"/> 
                <input style="margin-left: 10px;" type="reset" name="bt_cancel" id="bt_cancel" class="button1" value="Nhập lại"/> 
             </p>
    </form>  
</div>