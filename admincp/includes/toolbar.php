<div id="menus" class="toolbars">
  <form id="frm_menu" name="frm_menu" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><h2 style="margin:0px; padding:0px;"><?php echo $title_manager;?></h2></td>
        <td>
        <label>
          <input type="hidden" name="txtorders" id="txtorders" />
          <input type="hidden" name="txtids" id="txtids" />
          <input type="hidden" name="txtaction" id="txtaction" />
        </label>
        </td>
        <td align="right">
        <ul>
        <?php 
            $task="";
			if($_GET["com"]=="statistic"){
			?>
			<li><a class="help"  href="index.php?com=<?php echo COMS;?>&task=help" title="<?php echo MHELP;?>"><?php echo MHELP;?></a></li>
			<?php
			}else{
			if($_GET["com"]!="order"){
            if(!isset($_GET["task"])){
        ?>
            <li><a class="publish" href="#" onclick="dosubmitAction('frm_menu','public');" title="<?php echo MPUBLISH;?>"><?php echo MPUBLISH;?></a> </li>
            <li><a class="unpublish" href="#" onclick="dosubmitAction('frm_menu','unpublic');" title="<?php echo MUNPUBLISH;?>"><?php echo MUNPUBLISH;?></a></li>
            <li><a class="edit" href="#" onclick="dosubmitAction('frm_menu','edit');" title="<?php echo MEDIT;?>"><?php echo MEDIT;?></a></li>
            <li><a class="addnew" href="index.php?com=<?php echo COMS;?>&task=add" title="<?php echo MADDNEW;?>"><?php echo MADDNEW;?></a></li>
            <li><a class="delete" href="#" onclick="javascript:if(confirm('Bạn có chắc chắn muốn xóa thông tin này không?')){dosubmitAction('frm_menu','delete'); }" title="<?php echo MDELETE;?>"><?php echo MDELETE;?></a></li>
            <?php }else{?>
				
            <li><a class="save"  href="#" onclick="dosubmitAction('frm_action','save');" title="<?php echo MSAVE;?>"><?php echo MSAVE;?></a></li>
            <li><a class="close"  href="index.php?com=<?php echo COMS;?>" title="<?php echo MCLOSE;?>"><?php echo MCLOSE;?></a></li>
            <li><a class="help"  href="index.php?com=<?php echo COMS;?>&task=help" title="<?php echo MHELP;?>"><?php echo MHELP;?></a></li>
        <?php }
		}else{ 
			if(!isset($_GET["task"])){
		?>
			<!--<li><a class="publish" href="#" onclick="dosubmitAction('frm_menu','review');" title="<?php echo REVIEW;?>"><?php echo REVIEW;?></a> </li>
			<li><a class="publish" href="#" onclick="dosubmitAction('frm_menu','unreview');" title="<?php echo UNREVIEW;?>"><?php echo UNREVIEW;?></a> </li>
			<li><a class="publish" href="#" onclick="dosubmitAction('frm_menu','paind');" title="<?php echo PAIND;?>"><?php echo PAIND;?></a> </li>
			<li><a class="publish" href="#" onclick="dosubmitAction('frm_menu','unpaind');" title="<?php echo UNPAIND;?>"><?php echo UNPAIND;?></a> </li>-->
			<li><a class="close" href="#" onclick="dosubmitAction('frm_menu','destroy');" title="<?php echo DESTROY;?>"><?php echo DESTROY;?></a> </li>
			<li><a class="help"  href="index.php?com=<?php echo COMS;?>&task=help" title="<?php echo MHELP;?>"><?php echo MHELP;?></a></li>
		<?php 
			}
			else{
			?> 
			<li><a class="close" href="#" onclick="history.back();" title="<?php echo GOBACK;?>"><?php echo GOBACK;?></a> </li>	
			<li><a class="help"  href="index.php?com=<?php echo COMS;?>&task=help" title="<?php echo MHELP;?>"><?php echo MHELP;?></a></li>
			<?php
			}
		}
		}
		?>
        </ul>
        </td>
      </tr>
    </table>
  </form>
</div>