<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$catid="";
	if(isset($_GET["catid"]))
		$catid=$_GET["catid"];
	if(!isset($objcate))
	$objcate=new CLS_CATE();
	$objcate->getCateByID($catid);
?>
<div id="action">
 <script language="javascript">
function checkinput(){
	if($("#txtname").val()=="")
	{
	 	$("#txtname_err").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Vui lòng nhập tên nhóm tin').fadeTo(900,1);
		});
	 	$("#txtname").focus();
	 	return false;
	}
	
	
	return true;
}
$(document).ready(function()
{
	$("#txtname").blur(function() {
		if( $(this).val()=='') {
			$("#txtname_err").fadeTo(200,0.1,function()
			{ 
			  $(this).html('Vui lòng nhập tên nhóm tin').fadeTo(900,1);
			});
		}
		else {
			$("#txtname_err").fadeTo(200,0.1,function()
			{ 
			  $(this).html('').fadeTo(900,1);
			});
		}
	})
})
 </script>
  <form id="frm_action" name="frm_action" method="post" action="">
  Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.
    <table width="100%" border="0" cellspacing="1" cellpadding="3" style="border:#CCC 1px solid;">
      <tr>
        <td width="150" align="right" bgcolor="#EEEEEE"><strong><?php echo CNAME;?> <font color="red">*</font></strong></td>
        <td>
          <input name="txtname" type="text" id="txtname" value="<?php echo $objcate->Name;?>" size="40">
          <label id="txtname_err" class="check_error"></label>
          <input name="txttask" type="hidden" id="txttask" value="1" />
	      <input type="hidden" name="txtid" id="txtid" value="<?php echo $objcate->ID;?>"></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CPAR_ID;?>&nbsp;</strong></td>
        <td>
            <select name="cbo_cate" id="cbo_cate">
              <option value="0" selected="selected"  style="background-color:#eeeeee; font-weight:bold">
              <?php echo "Root";?></option>
               <?php
                if(!isset($objCate))
                $objCate=new CLS_CATE();
				if(!isset($catid) || $catid=="") $catid=0;
				$where=" AND cat_id!='$catid' ";
                $objCate->ListCategory($catid,$objcate->ParID,0,1,$where);
               ?>
            </select><br />
            Các mục <font color="red">màu đỏ</font> là nhóm tin đang không được hiển thị
		</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CPUBLIC;?>&nbsp;</strong></td>
        <td>
        <input name="optactive" type="radio" id="radio" value="1" <?php if($objcate->isActive==1) echo "checked";?>>
			<?php echo CYES;?>
        <input name="optactive" type="radio" id="radio2" value="0" <?php if($objcate->isActive==0) echo "checked";?>>
			<?php echo CNO;?></td>
      </tr>
    </table>
    <fieldset>
    <legend><strong><?php echo CDESC;?>:</strong></legend>
          <?php //Create_textare("txtdesc",'oEdit1');?>
            <textarea name="txtdesc" id="txtdesc" cols="45" rows="5"><?php echo $objcate->Desc;?></textarea>
        	<script language="javascript">
				var oEdit1=new InnovaEditor("oEdit1");
				oEdit1.width="100%";
				oEdit1.height="300";
				oEdit1.cmdAssetManager ="modalDialogShow('<?php echo URLEDITOR;?>/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
				oEdit1.REPLACE("txtdesc");
				document.getElementById("idContentoEdit1").style.height="225px";
			</script>
      <label>
        <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
      </label>
    </fieldset>
  </form>
</div>