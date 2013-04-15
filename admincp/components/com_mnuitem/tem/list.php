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
	if($mnuid!="" && $mnuid!="all")
		$strwhere.=" `mnu_id` = '$mnuid' AND";
	if($strwhere!="")
		$strwhere=substr($strwhere,0,strlen($strwhere)-4);
	//echo $strwhere;
	if(!isset($_SESSION["CUR_PAGE_MNU"]))
		$_SESSION["CUR_PAGE_MNU"]=1;
	if(isset($_POST["cur_page"])){
		$_SESSION["CUR_PAGE_MNU"]=$_POST["cur_page"];
	}
	$cur_page=$_SESSION["CUR_PAGE_MNU"];
	$parid="";
	$level=0;
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
          <label>
            <select name="cbo_menutype" id="cbo_menutype" onchange="document.frm_list.submit();">
              <option value="all">Select once menu</option>
              <?php 
			  if(!isset($objmenu)) $objmenu=new CLS_MENU();
			  	echo $objmenu->getListmenu("option");
			  ?>
            <script language="javascript">
			cbo_Selected('cbo_menutype','<?php echo $mnuid;?>');
            </script>
            </select>
          </label>
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
	<div style="height: 500px; overflow: auto; padding:4px; border: 1px solid black;" >
    <table width="100%" border="0" cellspacing="0" cellpadding="3" class="list"  >
      <tr class="header">
        <td width="30" align="center">#</td>
        <td width="30" align="center"><input type="checkbox" name="checkall" id="checkall" value="" onclick="docheckall('checkid',this.checked);" /></td>
        <td width="50" align="center"><?php echo CPAR_ID;?></td>
        <td align="center"><?php echo CCODE;?></td>
        <td align="center"><?php echo CNAME;?></td>
        <td width="100" align="center"><?php echo CTYPE;?></td>
        <td width="50" align="center"><?php echo CORDER;?><img src="templates/default/images/save.png" width="13" alt="Save" longdesc="#" /></td>
        <td width="50" align="center"><?php echo CACTIVE;?></td>
        <td width="50" align="center"><?php echo CEDIT;?></td>
        <td width="50" align="center"><?php echo CDELETE;?></td>
      </tr>
      <?php 
	  if(isset($_POST["txtCurnpage"]))
       $cur_page=$_POST["txtCurnpage"];
	  $objmenuitem=new CLS_MENUITEM();
	  $objmenuitem->getAllList($mnuid,$strwhere);
	  $total_rows=$objmenuitem->Numrows();
	  if($strwhere!="")
		$strwhere=" AND ".$strwhere;
	  if($total_rows ==0){
	  	echo "<tr><td colspan=10><center>".NOROW."</center></td></tr>";
	  }else{
	   	$objmenuitem->listTableItemMenuReturn($mnuid,$strwhere,$cur_page,$parid,$level,0);
	   }
		?>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="Footer_list">
      <tr>
        <td align="center">	  
        <?php 
           // echo "<br />Tổng : ".$total_rows." bản ghi<br />";
        ?>
        </td>
      </tr>
  </table>
  </div>
</div>
<?php //----------------------------------------------?>