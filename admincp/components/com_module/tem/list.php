<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$keyword="Keyword";
	$action="";
	$position="";
	if(isset($_POST["txtkeyword"])){
		$keyword=$_POST["txtkeyword"];
		$action=$_POST["cbo_active"];
		$position=$_POST["cbo_position"];
	}
	$strwhere="";
	if($keyword!="" && $keyword!="Keyword")
		$strwhere.=" AND ( `title` like '%$keyword%' OR `content` like '%$keyword%')";
	if($action!="" && $action!="all" )
		$strwhere.=" AND `isactive` = '$action'";
	if($position!="" && $position!="all" )
		$strwhere.=" AND `position` = '$position'";
	//if($strwhere!="")
	//	$strwhere=" WHERE ".substr($strwhere,0,strlen($strwhere)-4);
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
          <label>
            <select name="cbo_position" id="cbo_position" onchange="document.frm_list.submit();">
              <option value="all">Select position</option>
              <?php 
			  if(!isset($objmodule))
			  $objmodule=new CLS_MODULE();
			  $objmodule->getPosition();
			  ?>
              <script language="javascript">
				cbo_Selected('cbo_position','<?php echo $position;?>');
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
    <table width="100%" border="0" cellspacing="0" cellpadding="3" class="list">
      <tr class="header">
        <td width="30" align="center">#</td>
        <td width="30" align="center"><input type="checkbox" name="checkall" id="checkall" value="" onclick="docheckall('checkid',this.checked);" /></td>
        <td align="center"><?php echo CTITLE;?></td>
        <td width="75" align="center"><?php echo TYPE;?></td>
        <td width="75" align="center"><?php echo CPOSITION;?></td>
        <td width="30" align="center"><?php echo CORDER;?>
            <img onclick="do_order();" src="templates/default/images/save.png" border="0px;" width="13" alt="Save" longdesc="#" />
        </td>
        <td width="50" align="center"><?php echo CACTIVE;?></td>
        <td width="50" align="center"><?php echo CEDIT;?></td>
        <td width="50" align="center"><?php echo CDELETE;?></td>
      </tr>
      <?php
	  if(isset($_POST["txtCurnpage"]))
       $cur_page=$_POST["txtCurnpage"];
	  if(!isset($objmodule))
	  $objmodule=new CLS_MODULE();
	  $objmodule->getAllList($strwhere);
	  $total_rows=$objmodule->Numrows();
	  $objmodule->listTableMod($strwhere,$cur_page);
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