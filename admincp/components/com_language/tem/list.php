<?php
	$_SESSION["ACTION_SITE"]="front_end";
	if(isset($_POST["tab_site"]) && $_POST["tab_site"]!='')
		$_SESSION["ACTION_SITE"] = $_POST["tab_site"];
	
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$keyword="Keyword";
	$action="";
	if(isset($_POST["txtkeyword"])){
		$keyword=addslashes($_POST["txtkeyword"]);
		$action=$_POST["cbo_active"];
	}
	$strwhere=" `site`='".$_SESSION["ACTION_SITE"]."' AND";
	if($keyword!="" && $keyword!="Keyword")
		$strwhere.=" ( `name` like '%$keyword%') AND";
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
<div class="tab">
    <a href="javascript:document.getElementById('tab_site').value='front_end'; document.frm_list.submit();" class="<?php if($_SESSION["ACTION_SITE"]=="front_end") echo 'activetab';?>"><?php echo $obj_laglang->TAB_SITE;?></a>
    <a href="javascript:document.getElementById('tab_site').value='back_end'; document.frm_list.submit();" class="<?php if($_SESSION["ACTION_SITE"]=="back_end") echo 'activetab';?>"><?php echo $obj_laglang->TAB_ADMIN;?></a>
</div>
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
  <form id="frm_list" name="frm_list" method="post" action="" onsubmit="document.getElementById('tab_site').value= '<?php echo $_SESSION["ACTION_SITE"];?>';">
  	<input type="hidden" name="tab_site" id="tab_site" value="" />
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
          </select>
        </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="3" class="list">
      <tr class="header">
        <td width="30" align="center">STT</td>
        <td width="30" align="center"><input type="checkbox" name="checkall" id="checkall" value="" onclick="docheckall('checkid',this.checked);" /></td>
        <td width="75" align="center"><?php echo $obj_laglang->LANG_NAME;?></td>
        <td align="center"><?php echo $obj_laglang->LANG_CODE;?></td>
        <td align="center"><?php echo $obj_laglang->LANG_FLAG;?></td>
        <td width="50" align="center"><?php echo IS_DEFAULT;?></td>
        <td width="50" align="center"><?php echo ACTIVE;?></td>
        <td width="50" align="center"><?php echo EDIT;?></td>
        <td width="50" align="center"><?php echo DELETE;?></td>
      </tr>
      <?php 
	  $objlang=new CLS_LANGUAGE();
	  $objlang->getList($strwhere);
	  $total_rows=$objlang->Numrows();
	  $start=($cur_page-1)*MAX_ROWS;
	  $leng=MAX_ROWS;
	  $objlang->getList($strwhere." LIMIT $start,$leng");
	  $i=1;
	  while($rows=$objlang->FetchArray()){
	  ?>
      <tr name="trow" class="list">
        <td width="30" align="center"><?php echo $i;?></td>
        <?php //begin change -----------------------------------------------------------?>
        <td width="30" align="center"><input type="checkbox" name="checkid" id="checkid" value=""  /></td>
       <?php //end change -----------------------------------------------------------?>
        <td width="75"><?php echo $rows["name"];?></td>
        <td><?php echo $rows["code"];?></td>
        <td><?php echo '<img src="../images/flags/'.$rows["flag"].'" width="22" align="absmiddle" /> '.$rows["flag"];?></td>
        <td width="50" align="center">
        	<a href="index.php?com=<?php echo COMS;?>&amp;task=default&amp;lagid=<?php echo $rows["lag_id"];?>">
			<?php showIconFun('isdefault',$rows["isdefault"]);?>
            </a>
        </td>
        <td width="50" align="center">
        	<a href="index.php?com=<?php echo COMS;?>&amp;task=active&amp;lagid=<?php echo $rows["lag_id"];?>">
			<?php showIconFun('publish',$rows["isactive"]);?>
            </a>
        </td>
        <td width="50" align="center">
        	<a href="index.php?com=<?php echo COMS;?>&amp;task=edit&amp;lagid=<?php echo $rows["lag_id"];?>">
			<?php showIconFun('edit','');?>
            </a>
            </td>
        <td width="50" align="center">
        	<a href="javascript:detele_field('index.php?com=<?php echo COMS;?>&task=delete&lagid=<?php echo $rows["lag_id"];?>');">
			<?php showIconFun('delete','');?>
            </a>
         </td>
      </tr>
      <?php 
	  $i++;
	  }?>
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