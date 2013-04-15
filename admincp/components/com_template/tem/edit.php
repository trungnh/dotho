<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$temid="";
	if(isset($_GET["temid"]))
		$temid=(int)$_GET["temid"];
	$objtem=new CLS_TEM();
	$objtem->getTemById($temid);
?>
<div id="action">
 <script language="javascript">
 function checkinput(){
	 return true;
 }
 </script>
  <form id="frm_action" name="frm_action" method="post" action="">
  	<fieldset>
    <legend><strong>Template infomation:</strong></legend>
    <table width="100%" border="0" cellspacing="1" cellpadding="3" style="border:#CCC 1px solid;">
      <tr>
        <td width="150" align="right" bgcolor="#EEEEEE"><strong><?php echo CNAME;?>:</strong></td>
        <td>
          <input type="text" name="txtname" id="txtname" value="<?php echo $objtem->Name;?>">
          <input name="txttask" type="hidden" id="txttask" value="1" />
		</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong><?php echo CAUTHOR;?>:</strong></td>
        <td>
          <input type="text" name="txtauthor" id="txtauthor" value="<?php echo $objtem->Author;?>">
        </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Email:</strong></td>
        <td><input type="text" name="txtemail" id="txtemail" value="<?php echo $objtem->Email;?>" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Website:</strong></td>
        <td><input type="text" name="txtwebsite" id="txtwebsite" value="<?php echo $objtem->ASite;?>" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>isDefault:</strong></td>
        <td>
          <input name="optactive" type="radio" id="radio" value="1" <?php if($objtem->isDefault==1) echo "checked";?>><?php echo CYES;?>
          <input name="optactive" type="radio" id="radio2" value="0" <?php if($objtem->isDefault==0) echo "checked";?>><?php echo CNO;?></td>
      </tr>
    </table>
    </fieldset>
    <fieldset>
    <legend><strong><?php echo CDESC;?>:</strong></legend>
          <?php //Create_textare("txtdesc",'oEdit1');?>
            <textarea name="txtdesc" id="txtdesc" cols="45" rows="5"><?php echo $objtem->Desc;?></textarea>
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