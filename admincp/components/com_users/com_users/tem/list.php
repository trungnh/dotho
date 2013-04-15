<?php
	$id = $_SESSION['IGFUSERID'];
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$keyword="Keyword";
	$action="";
	if(isset($_POST["txtkeyword"])){
		$keyword=$_POST["txtkeyword"];
		$action=$_POST["cbo_active"];
	}
	$strwhere="";
	if($keyword!="" && $keyword!="Keyword")
		$strwhere.=" and (`username` like '%$keyword%' OR `firstname` like '%$keyword%' OR `lastname` like '%$keyword%') ";
	if($action!="" && $action!="all" )
		$strwhere.=" and `isactive` = '$action' ";
	//if($strwhere!="")
		//$strwhere=" WHERE ".substr($strwhere,0,strlen($strwhere)-4);
	//echo $strwhere;
	if(!isset($_SESSION["CUR_PAGE_MNU"]))
		$_SESSION["CUR_PAGE_MNU"]=1;
	if(isset($_POST["cur_page"])){
		$_SESSION["CUR_PAGE_MNU"]=$_POST["cur_page"];
	}
	$cur_page=$_SESSION["CUR_PAGE_MNU"];
	
	if(!isset($objmember)) $objmember=new CLS_USERS();
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
	<?php if($objmember->isAdmin()==true) { ?>
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
          </select>
        </td>
      </tr>
    </table>
    <?php } ?>
    <table width="100%" border="0" cellspacing="1" cellpadding="5" class="list">
      <tr class="header">
        <td width="30" align="center">#</td>
        <td width="30" align="center"><input type="checkbox" name="checkall" id="checkall" value="" onclick="docheckall('checkid',this.checked);" /></td>
        <td align="center">Tên đăng nhập</td>
        <td align="center">Tên</td>
        <td align="center">Email</td>
        <?php 
	    if($objmember->isAdmin()==true) {
		?>
        <td align="center">Đổi mật khẩu</td>
        <td width="75" align="center">Nhóm quyền</td>
        <td width="50" align="center"><?php echo CACTIVE;?></td>
        <td width="50" align="center"><?php echo CEDIT;?></td>
        <td width="50" align="center"><?php echo CDELETE;?></td>
        <?php } ?>
      </tr>
      <?php 
      if(isset($_POST["txtCurnpage"]))
            $cur_page=$_POST["txtCurnpage"];
	  $objmember->getAllList($strwhere,$id);
	  /*--------------update tuan 25/11/2011 --------------*/
	  //if($objmember->Numrows() != 0)
		 // $total_rows=($objmember->Numrows()-1);
	  /*else*/ $total_rows = $objmember->Numrows();
	  
	  
	  //if($strwhere==''){
	  //	$strwhere = "where mem_id not in ('$id')";
	 // }else{
	  	//$strwhere  = $strwhere." and mem_id not in ('$id')";
	  //}
	  
	  $objmember->listTableMember($strwhere,$cur_page,$id);
	  /*---------------end --------------------------------*/
	  ?>
    </table>
  </form>
  <?php if($objmember->isAdmin()==true) { ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="Footer_list">
      <tr>
        <td align="center">	  
       <?php 
            paging($total_rows,MAX_ROWS,$cur_page);
        ?>
        </td>
      </tr>
  </table>
  <?php } ?>
</div>
<?php //----------------------------------------------?>