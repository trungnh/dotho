<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$keyword="Keyword";
	$action="";
	$catid="";
	if(isset($_POST["txtkeyword"])){
		$keyword=$_POST["txtkeyword"];
		$action=$_POST["cbo_active"];
		$catid=$_POST["cbo_cont"];
	}
	if(!isset($objcata))
		$objcata= new CLS_EVENT();
	
	$strwhere="";
	if($keyword!="" && $keyword!="Keyword")
		$strwhere.="AND ( `name` like '%$keyword%')";
	if($catid!="" && $catid!="all")
		$strwhere.="AND `cata_id` = '$catid' ";
	if($action!="" && $action!="all" )
		$strwhere.="AND `isactive` = '$action'";
	//echo $strwhere;
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
          <option value="1"><?php echo MPUBLISH;?></option>
          <option value="0"><?php echo MUNPUBLISH;?></option>
          <script language="javascript">
			cbo_Selected('cbo_active','<?php echo $action;?>');
            </script>
        </select></td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="3" class="list">
      <tr class="header">
        <td width="30" align="center">#</td>
        <td width="30" align="center"><input type="checkbox" name="checkall" id="checkall" value="" onclick="docheckall('checkid',this.checked);" /></td>
        <td width="100" align="center"><?php echo CNAME;?></td>
        <td width="100">Icon</td>
        <td width="30">Hiển thị menu</td>
        <td width="30" align="center"><?php echo CACTIVE;?></td>
        <td width="30" align="center"><?php echo CEDIT;?></td>
        <td width="30" align="center"><?php echo CDELETE;?></td>
      </tr>
      <?php 
	   if(isset($_POST["txtCurnpage"]))
       $cur_page=$_POST["txtCurnpage"];
	  $objcont=new CLS_EVENT();
	  $objcont->getAllList($strwhere);
	  $total_rows=$objcont->Numrows();
	  
	  $objcont->listTablePro($strwhere,$cur_page,0);
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
<?php //----------------------------------------------?>