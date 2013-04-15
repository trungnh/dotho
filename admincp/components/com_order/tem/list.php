<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$keyword="Keyword";
	$action="";
	if(isset($_POST["txtkeyword"])){
		$keyword=$_POST["txtkeyword"];
		$action=$_POST["cbo_active"];
	}
	$strwhere="";
	if($keyword!="" && $keyword!="Keyword")
		$strwhere.=" (  `location_buyer` like '%$keyword%') AND";
	if($action!="" && $action!="all" )
		$strwhere.=" `status` = '$action' AND";
	if($strwhere!="")
		$strwhere=" WHERE ".substr($strwhere,0,strlen($strwhere)-4);
	if(!isset($_SESSION["CUR_PAGE_MNU"]))
		$_SESSION["CUR_PAGE_MNU"]=1;
	if(isset($_POST["cur_page"])){
		$_SESSION["CUR_PAGE_MNU"]=$_POST["cur_page"];
	}
	$cur_page=$_SESSION["CUR_PAGE_MNU"];
?>
<div id="list">
  <script language="javascript">
  function checkinput()
  {
	  var strids=document.getElementById("txtids");
	  if(strids.value=="")
	  {
		  alert('You are select once record to action');
		  return false;
	  }
	  return true;
  }
  </script>
  <form id="frm_list" name="frm_list" method="post" action="">
  <div class="messagebox"><?php include(THIS_COM_PATH."tem/message.php");?></div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="Header_list">
      <tr>
        <td><?php echo SEARCH;?>:
            <input type="text" name="txtkeyword" id="txtkeyword" value="<?php echo $keyword;?>" onfocus="onsearch(this,1);" onblur="onsearch(this,0)" />
            <input type="submit" name="button" id="button" value="<?php echo SEARCH;?>" class="button" />
        </td>
        <td align="right">
          <select name="cbo_active" id="cbo_active" onchange="document.frm_list.submit();">
            <option value="all"><?php echo MALL;?></option>
            <option value="0">Chưa duyệt</option>
            <option value="1">Đang xử lý</option>
			<option value="2">Duyệt</option>
			<option value="3"><?php echo DESTROY;?></option>
            <script language="javascript">
			cbo_Selected('cbo_active','<?php echo $action;?>');
            </script>
          </select>
        </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="3" class="list">
      <tr class="header">
        <td width="30" align="center">#</td>
        <td width="30" align="center"><input type="checkbox" name="checkall" id="checkall" value="" onclick="docheckall('checkid',this.checked);" /></td>
        <td width="150" align="center">Mã hóa đơn</td>
        <td align="center" width="120"><?php echo CITY;?></td>
        <td width="120" align="center"><?php echo STATUS;?></td>
		<td align="center"><?php echo CREATEDATE;?></td>
		<td align="center" width="70"> <?php echo DETAIL;?></td>
      </tr>
      <?php 
		if(isset($_POST["txtCurnpage"]))
		$cur_page=$_POST["txtCurnpage"];
		if(!isset($objorder))
			$objorder=new CLS_ORDER();
		$objorder->getList($strwhere);
		$total_rows=$objorder->Numrows(); 
		$objorder->listTableOrder($strwhere,$cur_page);
	  ?>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="Footer_list">
      <tr>
        <td align="center">	  
        <?php 
            paging($total_rows,MAX_ROWS,$cur_page);
        ?>
        </td>
      </tr>
  </table>
</div>