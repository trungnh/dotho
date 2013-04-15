<div id="commentid">
<script language="javascript">
	function chechemail()
	{
		var name=document.getElementById("name");
		var title=document.getElementById("title");
		var content=document.getElementById("content");
		if(name.value==""){
            alert("Vui lòng nhập tên của bạn!");
            name.focus();
            return false;
        }
		if(title.value==""){
            alert("Vui lòng nhập tiêu đề!");
            title.focus();
            return false;
        }
		if(content.value==""){
            alert("Vui lòng nhập nội dung góp ý!");
            content.focus();
            return false;
        }
	}
</script>
<div style="z-index: 799999; border: medium none; margin: 0pt; padding: 0pt; width: 100%; height: 100%; top: 0pt; left: 0pt; opacity: 0.6; position: fixed; background-color: rgb(0, 0, 0);" class="blockUI blockOverlay" title="Nhấp chuột để đóng"></div>
<div style="z-index: 800010; position: fixed; padding: 1px; margin: 0px; width: 500px; top: 80px; left: 421.5px; text-align: center; color: rgb(0, 0, 0); border: 3px solid rgb(0, 0, 0); background-color: rgb(255, 255, 255);" class="blockUI blockMsg blockPage">
<form name="frm_comment" method="POST">
<input type="hidden" name="txtconid" value="0" />
		<input type="hidden" name="txtproid" value="0" />
        <div style="background: #333333 ;width:475px; text-align: left;float:left; ">
             <span style="color: #ffffff; line-height:27px; font-weight: bold; margin-left: 20px">Mỗi góp ý của bạn sẽ giúp chúng tôi phục vụ bạn tốt hơn</span>
             
        </div>
        <div style="width:20px; background: #333333; float:left; line-height:22px;height:22px; padding:5px 5px 0 0;cursor: pointer;">
            <a id="closeButton"></a>
        </div>
        <div class="clear"></div>
<!--    <table style="margin:20px; width: 440px; height:327px">-->
    <table style="margin:10px 20px; width: 440px;">
        <tbody>
        <tr>
            <td colspan="2">
                <p style="color:#339933;margin-bottom: 5px;" id="message-success"></p>
            </td>
        </tr>
                <tr>

            <td style=" line-height:27px; width: 150px; font-weight: bold">
                <label for="name">Tên của bạn <em style="color:red;">*</em></label>
            </td>
            <td style=" line-height:31px">
                <input type="text" style="width:343px; height:27px" value="" name="name" id="name">
            </td>
        </tr>
                <tr>
            <td style=" line-height:27px; width: 150px; font-weight: bold">
                <label for="title">Tiêu đề <em style="color:red;">*</em></label>
            </td>
            <td style=" line-height:31px">
                <input type="text" style="width:343px; height:27px" value="" name="title" id="title">
            </td>
        </tr>
        <tr>
            <td style=" line-height:31px;  width: 150px; margin-top: 12px; font-weight: bold">
                <label for="content">Nội dung <em style="color:red;">*</em></label>
            </td>
            <td style="margin-top: 12px;">
                <textarea style="width:343px; height:190px" name="content" id="content"></textarea>
            </td>
        </tr>
         <tr>
            <td style=" line-height:31px;  width: 150px;  font-weight: bold">
               
            </td>
            <td style="padding-top: 12px;">
                <a class="link-send-contact red-button">
                    <span><input type="submit" name="bt_submit" id="bt_submit" value="Gửi góp ý" onclick="return chechemail();" /></span>
                </a>
            </td>
        </tr>
    </tbody></table>
        
</form>
</div>
</div>
<div id="con-detail">
<?php if(!isset($objcom))
	$objcom= new CLS_COMM();
	$objcom->getList(" order by `comm_id` desc limit 0,1 ");
	$rows=$objcom->Fecth_Array();
?>
<div style="z-index: 799999; border: medium none; margin: 0pt; padding: 0pt; width: 100%; height: 100%; top: 0pt; left: 0pt; background-color: rgb(0, 0, 0); opacity: 0.6; position: fixed;" class="blockUI blockOverlay" title="Nhấp chuột để đóng"></div>
<div style="z-index: 800010; position: fixed; padding: 1px; margin: 0px; width: 500px; top: 80px; left: 421.5px; text-align: center; color: rgb(0, 0, 0); border: 3px solid rgb(0, 0, 0); background-color: rgb(255, 255, 255);" class="blockUI blockMsg blockPage"><div style="width: 500px; max-height: 350px;" id="detail-review">
                     <div style="background: #333333 ;width:475px; text-align: left;float:left; ">
                         <span style="color: #ffffff; line-height:27px; font-weight: bold; margin-left: 20px">Sieuthitienich.vn trân trọng cảm ơn góp ý của bạn <?php echo $rows["username"]; ?></span>

                    </div>
                    <div style="width:20px; background: #333333; float:left; line-height:22px; padding:5px 5px 0 0;cursor: pointer;height:22px;">
                        <a id="closeDetailButton"></a>
                        
                    </div>
                    <div class="clear"></div>
                    <div style="padding:20px 10px; text-align: justify; max-height: 283px ; overflow: auto;">
                    <?php echo Substring(($rows["content"]),0,20);  unset($objcom); ?></div>
                </div></div>
</div>
</div>
