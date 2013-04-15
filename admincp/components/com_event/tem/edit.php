<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$eventid="";
	if(isset($_GET["eventid"]))
		$eventid=(int)$_GET["eventid"];
	$objevent=new CLS_EVENT();
	$objevent->getProByID($eventid);
	$_SESSION["PROIMAGES"]=$objevent->Proid;
	if(!isset($_SESSION["CUR_PAGE_MNU"]))
		$_SESSION["CUR_PAGE_MNU"]=1;
	if(isset($_POST["cur_page"])){
		$_SESSION["CUR_PAGE_MNU"]=$_POST["cur_page"];
	}
	$cur_page=$_SESSION["CUR_PAGE_MNU"];
?>
<div id="action">
 <script language="javascript">
 function checkinput(){
 	if($("#txtname").val()=="")
	{
	 	$("#txtname_err").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Vui lòng nhập tên sự kiện').fadeTo(900,1);
		});
	 	$("#txtname").focus();
	 	return false;
	}
	return true;
 }
$(document).ready(function() {
	$("#txtname").blur(function(){
		if ($("#txtname").val()=="") {
			$("#txtname_err").fadeTo(200,0.1,function()
			{ 
			  $(this).html('Vui lòng nhập tên sự kiện').fadeTo(900,1);
			});
		}
	});
});
 </script>
  <form id="frm_action" name="frm_action" method="post" action="">
  Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.
  <fieldset>
   <legend><strong><?php echo CDETAIL;?>&nbsp;</strong></legend>
    <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
			<td align="right" bgcolor="#EEEEEE"><strong>Tên sự kiện<font color="red">*</font></strong></td>
			<td>
				<input name="txtname" type="text" id="txtname" size="50" value="<?php echo $objevent->Name;?>" />
				<label id="txtname_err" class="check_error"></label>
				<input name="txttask" type="hidden" id="txttask" value="1" />
				<input name="txtid" type="hidden" id="txtid" value="<?php echo $objevent->ID;?>" />
			 </td>
	    </tr>
		<tr>
			<td align="right" bgcolor="#EEEEEE"><strong>Biểu tượng</strong></td>
			<td>
				<input name="txtthumb" type="text" id="txtthumb" size="50" value="<?php echo $objevent->Icon;?>" />
				<a href="#" onclick="OpenPopup('extens/upload_image.php');"><?php echo CHOICE;?></a>
				<label id="txtthumb_err" class="check_error"></label>
			 </td>
        </tr>
		<tr>
			<td align="right" bgcolor="#EEEEEE"><strong>Hiển trị trên menu</strong></td>
			<td><input type="checkbox" value="1" name="ismenu" id="ismenu" <?php if($objevent->Ismenu==1) echo "checked" ?> />
			 </td>
        </tr>
        <tr>
			<td align="right" bgcolor="#EEEEEE"><strong><?php echo CPUBLIC;?>&nbsp;</strong></td>
			<td><input name="optactive" type="radio" id="radio" value="1" <?php if($objevent->isActive==1) echo 'checked';?>/>
			  <?php echo CYES;?>
			  <input name="optactive" type="radio" id="radio2" value="0" <?php if($objevent->isActive==0) echo 'checked';?>/>
			  <?php echo CNO;?></td>
        </tr>
        <tr>
			<td colspan="2" align="left"><hr size="1" color="#EEEEEE" width="100%" /></td>
        </tr>
    </table>
   </fieldset>
   <br>
   <fieldset>
<legend><strong><?php echo CDESC;?>:</strong></legend>
          <?php //Create_textare("txtdesc",'oEdit1');?>
            <textarea name="txtdesc" id="txtdesc" cols="45" rows="5"><?php echo $objevent->Intro;?></textarea>
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
    <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
  </form>
</div>