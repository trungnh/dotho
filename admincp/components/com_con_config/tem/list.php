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
		$strwhere.=" ( `name` like '%$keyword%' OR `desc` like '%$keyword%') AND";
	if($action!="" && $action!="all" )
		$strwhere.=" `isactive` = '$action' AND";
	if($strwhere!="")
		$strwhere=" WHERE ".substr($strwhere,0,strlen($strwhere)-4);
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
    <table width="100%" border="0" cellspacing="0" cellpadding="3" class="list">
      <tr class="header">
        <td width="30" align="center">#</td>
        <td width="30" align="center"><input type="checkbox" name="checkall" id="checkall" value="" onclick="docheckall('checkid',this.checked);" /></td>
        <td align="center">Tiêu đề</td>
        <td align="center">Icon</td>
        <td align="center">Hiện tiêu đề</td>
        <td align="center">Hiện Icon</td>
        <td width="50" align="center"><?php echo CACTIVE;?></td>
        <td width="50" align="center"><?php echo CEDIT;?></td>
        <td width="50" align="center"><?php echo CDELETE;?></td>
      </tr>
      <?php 
	  if(!isset($objmenu))
	  $objmenu=new CLS_CONFIGCONTENT();
	  $objmenu->getList($strwhere);
	  $total_rows=$objmenu->Numrows();
	  $objmenu->listTable($strwhere,$cur_page);
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