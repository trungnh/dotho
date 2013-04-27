<div class="comment">
<?php $this->loadModule("top");?>
</div>
<div id="comment"  class="mod-pro box-module">
<div id="form_comment">
<?php if(isset($_SESSION["IGFUSERNAME_USER"])) 
{?>
    <form name="frm_comment" id="frm_comment" method="POST">
		<input type="hidden" name="txtconid" value="0" />
		<input type="hidden" name="txtproid" value="0" />
    	<h2>Viết góp ý</h2>
       	<p><textarea  cols="70" rows="5" name="content" id="content_com" onblur="if (this.value=='') this.value = this.defaultValue" onfocus="if (this.value==this.defaultValue) this.value = '';">Nội dung</textarea>
         </p>
            <p>
        <input type="submit" name="bt_submit" id="bt_submit" value="Gửi góp ý" class="button1"/> 
        <input style="margin-left: 10px;" type="reset" name="bt_cancel" id="bt_cancel" class="button1" value="Nhập lại"/> 
             </p>
    </form>  
<?php }
else
{
?>
<div class="register_com"><a href="index.php?com=users&viewtype=login"> Đăng nhập </a> Hoặc <a href="index.php?com=users&viewtype=add">Đăng ký </a> Để gửi góp ý </div>
<?php
}
?>
</div>
<?php //require_once (MOD_PATH."mod_comment/helper.php");
$strwhere=""; $i=0;
		$objcom->getAllListdisplay($strwhere);
		$total_rows=$objcom->Numrows();
		$objcom->getList($strwhere);
		//echo $total_rows; 
		if($total_rows>0)
		{
?>
	<h2>Góp ý kiến <span>(<?php echo $total_rows; ?>) </span></h2>
    <div class="display_com">
    	<ul>
       	<?php
			while($rows=$objcom->Fecth_Array())
			{
				$i++;
				echo "<li><p class=\"listcom\">".$rows["username"]."<span> ( ".$rows["joindate"].")</span></p><p>".$rows["content"]."</p></li>";	
			}
		?>
        </ul>
    </div>
<?php } ?>
</div>