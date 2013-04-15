<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$memid="";
	if(isset($_GET["comm_id"]))
		$comm_id=$_GET["comm_id"];
		if(!isset($objcomm))
			$objcomm=new CLS_COMM();
		$objcomm->getCommentByID($comm_id);
?>
<table cellpadding="0" cellspacing="0">
  <tr>
    <td width="267" align="right">Họ tên</td>
    <td width="376"><input type="text" value="<?php echo $objcomm->username; ?>" readonly="readonly"  /></td>
  </tr>
  <tr>
    <td align="right">Nội dung</td>
    <td><textarea cols="40" rows="10" readonly="readonly"><?php echo $objcomm->Content; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">Hiển thị</td>
    <td><input name="optactive" type="radio" id="radio" value="1" <?php if($objcomm->isactive==1) echo 'checked';?>/>
          <?php echo CYES;?>
          <input name="optactive" type="radio" id="radio2" value="0" <?php if($objcomm->isactive==0) echo 'checked';?>/>
          <?php echo CNO;?></td>
  </tr>

</table>