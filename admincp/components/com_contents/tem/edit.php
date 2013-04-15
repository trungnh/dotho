<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$conid="";
	if(isset($_GET["conid"]))
		$conid=(int)$_GET["conid"];
	$objcontent=new CLS_CONTENTS();
	$objcontent->getConByID($conid);
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
	if($("#txttitle").val()=="")
	{
	 	$("#txttitle_err").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Vui lòng nhập tên bài viết').fadeTo(900,1);
		});
	 	$("#txttitle").focus();
	 	return false;
	}
	if($("#txtcode").val()=="")
	{
	 	$("#txtcode_err").fadeTo(200,0.1,function()
		{ 
		  $(this).html('Vui lòng nhập mã cho bài viết').fadeTo(900,1);
		});
	 	$("#txtcode").focus();
	 	return false;
	}
	return true;
 }
$(function() {
	$( "#date1" ).datepicker({ dateFormat: 'dd-mm-yy' });
});
$(function() {
	$( "#date2" ).datepicker({ dateFormat: 'dd-mm-yy' });
});

$(document).ready(function() {
	$("#txttitle").blur(function(){
		if ($("#txttitle").val()=="") {
			$("#txttitle_err").fadeTo(200,0.1,function()
			{ 
			  $(this).html('Vui lòng nhập tên bài viết').fadeTo(900,1);
			});
		}
	});
	$("#txtcode").blur(function(){
		if ($("#txtcode").val()=="") {
			$("#txtcode_err").fadeTo(200,0.1,function()
			{ 
			  $(this).html('Vui lòng nhập mã bài viết').fadeTo(900,1);
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
        <td width="127" align="right" bgcolor="#EEEEEE"><strong><?php echo CCATEGORY;?><font color="red">*</font></strong></td>
        <td width="308">
          <select name="cbo_cate" id="cbo_cate">
            <?php 
			  if(!isset($objmenu)) $objmenu=new CLS_CATE();
			  	echo $objmenu->getListCate("option");
			  ?>
            <script language="javascript">
			  cbo_Selected('cbo_cate',<?php echo $objcontent->CatID;?>);
			  </script>
          </select></td>
        <td width="134" align="right" bgcolor="#EEEEEE"><strong><?php echo CAUTHOR;?>&nbsp;</strong></td>
        <td width="351"><input name="txtauthor" type="text" id="txtauthor" value="<?php echo $_SESSION["IGFUSERNAME"];?>" readonly="readonly" /></td>
        </tr>
      <tr>
         <td align="right" bgcolor="#EEEEEE"><strong><?php echo CTITLE;?> <font color="red">*</font></strong></td>
        <td>
          <input name="txttitle" type="text" id="txttitle" size="45" value="<?php echo $objcontent->Title;?>" />
          <label id="txttitle_err" class="check_error"></label>
          <input name="txttask" type="hidden" id="txttask" value="1" />
          <input name="txtid" type="hidden" id="txtid" value="<?php echo $objcontent->ID;?>" />
          </td>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CCREATDATE;?>&nbsp;</strong></td>
        <td><input id="date1" type="text" name="txtcreadate" value="<?php echo $objcontent->CreateDate;?>"/></td>
        </tr>
       <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CCODE;?> <font color="red">*</font></strong></td>
        <td><input name="txtcode" type="text" id="txtcode" size="45" value="<?php echo $objcontent->Code;?>" />
        <label id="txtcode_err" class="check_error"></label></td>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CMODIFY;?> </strong></td>
        <td><input name="txtmodify" type="text" id="date2" value="<?php echo date("d-m-Y");?>" /></td>
        </tr>
       <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CPUBLIC;?>&nbsp;</strong></td>
        <td><input name="optactive" type="radio" id="radio" value="1" <?php if($objcontent->IsActive==1) echo 'checked';?>/>
          <?php echo CYES;?>
          <input name="optactive" type="radio" id="radio2" value="0" <?php if($objcontent->IsActive==0) echo 'checked';?>/>
          <?php echo CNO;?></td>
        <td align="right" bgcolor="#EEEEEE"><strong>&nbsp;<?php echo CMEM;?>&nbsp;</strong></td>
        <td><select name="cbo_groupmem" id="cbo_groupmem">
          <?php 
		  	$gmemid = $objcontent->GmID;
			if(!isset($objmodule)) $objmodule=new CLS_CONTENTS();
			$objmodule->LoadConType($gmemid,0,'');?>
        </select></td>
        </tr>
       <tr>
         <td colspan="4" align="left"><hr size="1" color="#EEEEEE" width="100%" /></td>
        </tr>
       <tr>
         <td align="right" bgcolor="#EEEEEE"><strong><?php echo CMETAKEY;?>&nbsp;</strong></td>
         <td><textarea name="txtmetakey" cols="28" rows="1" id="txtmetakey"><?php echo $objcontent->MetaKey;?></textarea></td>
         <td align="right" bgcolor="#EEEEEE"><strong><?php echo CMETADESC;?></strong></td>
         <td><textarea name="textmetadesc" cols="28" rows="1" id="textmetadesc"><?php echo $objcontent->MetaDesc;?></textarea></td>
       </tr>
      </table>
      </fieldset>
    <br style="clear:both" />
    <strong><?php echo CINTRO;?></strong>
    <textarea name="txtintro" id="txtintro" cols="45" rows="5"><?php echo $objcontent->Intro;?></textarea>
     <script language="javascript">
            var oEdit2=new InnovaEditor("oEdit2");
            oEdit2.width="100%";
            oEdit2.height="100";
            oEdit2.cmdAssetManager ="modalDialogShow('<?php echo URLEDITOR;?>/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
            oEdit2.REPLACE("txtintro");
			document.getElementById("idContentoEdit2").style.height="100px";
      </script>
    <br style="clear:both" />
    <strong><?php echo CFULLTEXT;?>&nbsp;</strong></legend>
    <textarea name="txtdesc" id="txtdesc" cols="45" rows="5"><?php echo $objcontent->Fulltext;?></textarea>
    <script language="javascript">
            var oEdit1=new InnovaEditor("oEdit1");
            oEdit1.width="100%";
            oEdit1.height="300";
            oEdit1.cmdAssetManager ="modalDialogShow('<?php echo URLEDITOR;?>/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
            oEdit1.REPLACE("txtdesc");
            document.getElementById("idContentoEdit1").style.height="225px";
        </script>
    <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
  </form>
  <br />
	<fieldset>
		<legend>Bình luận</legend>
		<table width="100%" border="0" cellspacing="0" cellpadding="3" class="list">
			<tr class="header">
				<td>STT</td>
				<td>ID</td>
				<td>Người đăng</td>
				<td>Ngày đăng</td>
				<td>Hiện thị</td>
				<td>Xóa</td>
			</tr>
			<?php 
			$strwhere = " where `con_id` = $conid ";
			//echo substr($strwhere,0,15);
			if(!isset($objComm)) $objComm = new CLS_COMM();
			$objComm->getAllList($strwhere);
			$total_rows=$objComm->Numrows();
			$objComm->listTableCommentNews($strwhere,$cur_page,$conid);
			?>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Footer_list">
			  <tr>
				<td align="center">
				<?php 
					paging($total_rows,MAX_ROWS,$cur_page);
				?>
				</td>
			  </tr>
		  </table>
	</fieldset>
</div>