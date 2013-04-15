<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
/*------------------------------------------------------------------*/
function paging($total_rows,$max_rows,$cur_page){
	if($total_rows<=$max_rows)
		return;
		
	$max_pages=ceil($total_rows/$max_rows);
	$start=$cur_page-5; if($start<1)$start=1;
	$end=$cur_page+5;	if($end>$max_pages)$end=$max_pages;
	
	$paging='
	<form action="" method="post" name="frmpaging" id="frmpaging">
	<input type="hidden" name="txtCurnpage" id="txtCurnpage" value="1" />';
	$paging.='<p align="center" class="paging">';
	if($cur_page >1)
	$paging.='<a href="javascript:gotopage('.($cur_page-1).')"> << </a>';
	
	for($i=$start;$i<=$end;$i++)
	{
		if($i!=$cur_page)
		$paging.="<a href=\"javascript:gotopage($i)\"> $i </a>";
		else
		$paging.="<a href=\"#\" class=\"cur_page\"> $i </a>";
	}
	if($cur_page <$max_pages)
	$paging.='<a href="javascript:gotopage('.($cur_page+1).')"> >> </a>';
	$paging.='</p></form>';
	echo $paging;
}
function Create_textare($name)
{
	echo '<textarea name="'.$name.'" id="'.$name.'" cols="45" rows="5"></textarea>';
}
function upload_file ($dir,$name) {
	if($name!='') {
	   $file= $dir. basename($_FILES["$name"]["name"]);
	   @move_uploaded_file($_FILES['$name']['tmp_name'],$file);
	}
}
function isEmpty($id) {
	include("dbconnect.php");
	$sql ="select mnu_id FROM gf_menus WHERE type_id=".$id;
	$rs = mysql_query($sql,$dbconn);
	if(mysql_num_rows($rs)>0) {
		return true;
	}
	else return false;
}
function numMenuShow($id) {
	include("dbconnect.php");
	$sql ="select count(mnu_id) AS num FROM gf_menus WHERE type_id=".$id." AND isactive=1";
	$rs = mysql_query($sql,$dbconn);
	if(mysql_num_rows($rs)>0) {
		$r = mysql_fetch_array($rs);
		echo '('.$r["num"].')';
	}
	else echo '(0)';
}
function numMenuHiden($id) {
	include("dbconnect.php");
	$sql ="select count(mnu_id) AS num FROM gf_menus WHERE type_id=".$id." AND isactive=0";
	$rs = mysql_query($sql,$dbconn);
	if(mysql_num_rows($rs)>0) {
		$r = mysql_fetch_array($rs);
		echo '('.$r["num"].')';
	}
	else echo '(0)';
}

function maxOrderModule($position) {
	include("dbconnect.php");
	$qry = "SELECT `order` FROM gf_modules WHERE position ='$position' ORDER BY `order` DESC LIMIT 0,1";
	@$res = mysql_query($qry,$dbconn);
	
	if(mysql_num_rows($res)>0) {
		$r = mysql_fetch_array($res); 
		return $r[0]; 
	}else
		return 0;
}
function maxOrderCategory($par_id) {
	include("dbconnect.php");
	$qry = "SELECT `order` FROM tbl_categories WHERE par_id =$par_id ORDER BY `order` DESC LIMIT 0,1";
	@$res = mysql_query($qry,$dbconn);
	
	if(mysql_num_rows($res)>0) {
		$r = mysql_fetch_array($res); 
		return $r[0]; 
	}else
		return 0;
}

function maxOrderContent($par_id) {
	include("dbconnect.php");
	$qry = "SELECT `order` FROM tbl_contents WHERE cate_id =$par_id ORDER BY `order` DESC LIMIT 0,1";
	@$res = mysql_query($qry,$dbconn);
	
	if(@mysql_num_rows($res)>0) {
		$r = mysql_fetch_array($res); 
		return $r[0]; 
	}else
		return 0;
}

function maxOrderMenus($type_id,$par_id) {
	include("dbconnect.php");
	$qry = "SELECT `order` FROM gf_menus WHERE type_id =$type_id AND par_id=$par_id ORDER BY `order` DESC LIMIT 0,1";
	@$res = mysql_query($qry,$dbconn);
	
	if(@mysql_num_rows($res)>0) {
		$r = mysql_fetch_array($res); 
		return $r[0]; 
	}else
		return 0;
}

function cbo_OrderCategory($par_id,$current){
	include("dbconnect.php");
	$qry = "SELECT * FROM tbl_categories WHERE isactive=1 AND par_id =$par_id ORDER BY `order` ASC";
	$res = mysql_query($qry,$dbconn);
	$i=0;
	echo '<option value="'.$i.'">'.$i.'.Đầu</option>';
	while ($rows = mysql_fetch_array($res)) {
		$i++;
		echo '<option value="'.$i.'"';
		if($current==$rows["order"]) echo ' selected="selected"';
		echo ' >'.$i.'.'.$rows["name"].'</option>';
	}
	echo '<option value="'.($i+1).'">'.($i+1).'.Cuối</option>';
}

function cbo_Categories($space,$par_id,$current_id) {
	if($par_id==0) $space ='';
	else $space.="-- ";
	include("dbconnect.php");
	$qry = "SELECT cate_id,name FROM tbl_categories WHERE isactive=1 AND par_id =$par_id ORDER BY `order` ASC";
	@$res = mysql_query($qry,$dbconn);
	
	if(@mysql_num_rows($res)>0) {
		while (@$rows = mysql_fetch_array($res)) {
			echo '<option value="'.$rows["cate_id"].'"';
			if($par_id==0) echo ' class="option_level0" ';
			if($current_id>0 && $current_id ==$rows["cate_id"]) echo ' selected="selected" ';
			echo '>'.$space.$rows["name"].'</option>';

			cbo_Categories($space,$rows["cate_id"],$current_id);
		}
	}
}

function listMenus($space,$type_id,$par_id,$option,$url) {
	if($par_id==0) $space='';
		else $space.="--";
	
	if(!isset($stt))	$stt=0;
	
	global $stt; global $dbconn;
	
	$sql = "SELECT * FROM gf_menus  WHERE type_id=$type_id AND par_id = $par_id ORDER BY `order` ASC, mnu_id ASC"; //echo $sql;die;
  	@$result = mysql_query($sql,$dbconn);    
	
	if(@mysql_num_rows($result)>0) {
		while (@$rows = mysql_fetch_array($result)) 
		{
			$stt++;
			if($rows["par_id"]==0) $space ='';
			$str='';
			$id = $rows["mnu_id"];
			
			$str.= "<tr class=\"gf_tr\">
				<td align=\"center\">".$stt."</td>
				<td align=\"center\" valign=\"middle\"><input type=\"checkbox\" name=\"chkid\" id=\"chkid\" value=\"".$id."\"/></td>
				<td>$space<a href=\"?option=".$option."&amp;do=editchild&id=".$rows["mnu_id"]."\">".$rows["name"]."</a></td>
				<td align=\"center\"><input name=\"order\" type=\"text\" id=\"".$rows["mnu_id"]."\" value=\"".$rows["order"]."\" size=\"4\" style=\"text-align:center;\"/></td>
				<td align=\"center\"><a href=\"".$url."/process_activeChild.php?type=".$rows["type_id"]."&amp;id=".$rows["mnu_id"]."&amp;isactive=".$rows["isactive"]."\">";
				
			if($rows["isactive"]==1) {
			  $str.= "<img src=\"images/icon_active.png\" />";
			} 
			else { 
			  $str.= "<img src=\"images/icon_deactive.png\" />";
			}
			
			$str.="</a></td>
			<td align=\"center\">
			<a href=\"javascript:if(confirm('Bạn chắc chắn muốn xóa bản ghi này không ?')) window.location='".$url."/process_deleteChild.php?type=".$rows["type_id"]."&amp;id=".$rows["mnu_id"]."';\"><img src=\"images/icon_delete.png\" /></a>    </td>
		  </tr>";
			
			
			echo $str;
			listMenus($space,$type_id,$rows["mnu_id"],$option,$url);		
		}
	}
}

function listCategories($space,$par_id,$option,$url) {
	if($par_id==0) $space='';
		else $space.="--";
	if(!isset($rowcount))
		$rowcount=0;
	global $rowcount;
	global $dbconn;
	
	$sql = "SELECT * FROM tbl_categories  WHERE par_id = $par_id ORDER BY `order` ASC, cate_id ASC";
  	@$result = mysql_query($sql,$dbconn);   
	
	if(@mysql_num_rows($result)>0) { 
		while (@$rows = mysql_fetch_array($result)) 
		{
			$rowcount++;
			if($rows["par_id"]==0) $space ='';
			$str='';
			$id = $rows["cate_id"];
			$str.= "<tr class=\"gf_tr\">
				<td align=\"center\">".$rowcount."</td>
				<td align=\"center\" valign=\"middle\"><input type=\"checkbox\" name=\"chkid\" id=\"chkid\" value=\"".$id."\"/></td>
				<td>$space<a href=\"?option=".$option."&amp;do=edit&id=".$rows["cate_id"]."\">".$rows["name"]."</a></td>
				<td align=\"right\" style=\"padding-right:30px;\">";
			
			if($rows["order"]==1 && HaveChild($rows["par_id"])!=0)
				$str.= "<img align=\"absmiddle\" src=\"images/downarrow.png\"  onclick=\"getID_Order('".$rows["cate_id"]."','down')\"/>";
			elseif($rows["order"]==HaveChild($rows["par_id"]))
				$str.="<img align=\"absmiddle\" src=\"images/uparrow.png\" onclick=\"getID_Order('".$rows["cate_id"]."','up')\"/>";
			else {
				$str.="<img align=\"absmiddle\" src=\"images/uparrow.png\" onclick=\"getID_Order('".$rows["cate_id"]."','up')\"/>";
				$str.= "<img align=\"absmiddle\" src=\"images/downarrow.png\"  onclick=\"getID_Order('".$rows["cate_id"]."','down')\"/>";
			}
			
			$str .= "<input type=\"textbox\" name=\"order\" id=\"".$rows["cate_id"]."\" value=\"".$rows["order"]."\" size=\"3\"  class=\"order\" style=\"text-align:center;\"/>
				</td>
				<td align=\"center\">0</td>
				<td align=\"center\"><a href=\"".$url."/process_active.php?id=".$rows["cate_id"]."&amp;isactive=".$rows["isactive"]."\">";
			
			if($rows["isactive"]==1) { 
				 $str.= "<img src=\"images/icon_active.png\" width=\"22\" height=\"25\" />";
			} else {
				$str.= "<img src=\"images/icon_deactive.png\" width=\"22\" height=\"25\" />";
			} 
			
			$str.="</a></td>
				<td align=\"center\">
				<a href=\"javascript:if(confirm('Bạn chắc chắn muốn xóa bản ghi này không ?')) window.location='".$url."/process_delete.php?id=".$rows["cate_id"]."'".";\"><img src=\"images/icon_delete.png\" width=\"20\" height=\"22\" /></a>
				</td>
			  </tr>";
			
			echo $str;
			listCategories($space,$rows["cate_id"],$option,$url);	
			
		}
	}
}

function getListId($catId)
{
	global $dbconn;
	$sql="SELECT * FROM tbl_contents WHERE cate_id='$catId'";
	@$result=mysql_query($sql,$dbconn);
	$str="";
	if(@mysql_num_rows($result)>0)
	{
		while(@$rows=mysql_fetch_array($result))
		{
			$str.=$rows["con_id"].",";
		}
	}
	$sql_cate="SELECT * FROM tbl_categories WHERE par_id='$catId'";
	$result_cate=mysql_query($sql_cate,$dbconn);
	while($rows_cate=mysql_fetch_array($result_cate))
	{
		$str.=getListId($rows_cate["cat_id"]);
	}
	return $str;
}

function showCatName($cate_id) {
	global $dbconn;
	if($cate_id == 0)
		echo '';
	else {
		$sql = "SELECT name from tbl_categories WHERE cate_id =".$cate_id; //echo $sql; die;
		$res = mysql_query($sql,$dbconn);
		$r   = mysql_fetch_array($res);
		echo $r["name"];
	}
}
function showicon($fun,$value)
{
	$image="";
	switch($fun)
	{
		case "delete": $image="icon_delete.png"; break;
		case "edit": $image="icon_edit.png"; break;
		case "active": 
			if($value==1) $image="icon_active.png"; 
			else $image="icon_deactive.png";
			break;
		case "isfronpage":
			if($value==1) $image="icon_isfront.png"; 
			else $image="icon_nofront.png";
		case "isdefault":
			if($value==1) $image="icon_default.png"; 
			else $image="icon_nodefault.png";
	}
	echo "<img src=\"images/$image\" width=\"20\" title=\"$fun\" />";
	
}

function cbo_MenuType($cur_id) {
	global $dbconn;
	$sql="SELECT * FROM gf_menutype WHERE isactive=1";
	@$res = mysql_query($sql,$dbconn);
	
	while (@$rows = mysql_fetch_array($res)) {
		echo '<option value="'.$rows["type_id"].'" ';
		if($cur_id!=0 && $rows["type_id"]==$cur_id) 
			echo ' selected="selected"';
		echo '>'.$rows["name"].'</option>';
	}
}
function cbo_Menus($space,$par_id,$current_id,$type_id) {
	if($par_id==0) $space='';
		else $space.="--";
	
	include("dbconnect.php");
	$qry = "SELECT * FROM gf_menus WHERE isactive=1";
	if($type_id!=0)
		$qry .= " AND type_id=$type_id ";
	$qry .= " AND par_id =$par_id ORDER BY `order` ASC"; //echo $qry;die;
	@$res = mysql_query($qry,$dbconn);
	
	if(@mysql_num_rows($res)>0) {
		while (@$rows = mysql_fetch_array($res)) {
			echo '<option value="'.$rows["mnu_id"].'"';
			if($par_id==0) echo ' class="option_level0" ';
			if($current_id>0 && $current_id ==$rows["mnu_id"]) echo ' selected="selected" ';
			echo '>'.$space.$rows["name"].'</option>';
			
			cbo_Menus($space,$rows["mnu_id"],$current_id,$type_id);
		}
	}
}
function cbo_Menus_Showon() {
	global $dbconn;
	$qry = "SELECT type_id,name FROM gf_menutype WHERE isactive=1";
	$res = mysql_query($qry,$dbconn);
	
	while (@$rows = mysql_fetch_array($res)) {
		$type_id = $rows["type_id"];
		echo '<optgroup label="'.$rows["name"].'">';
		$space ='';
		// Liệt kê các danh mục trong menu này
		cbo_Menus($space,0,0,$type_id);
		echo '</optgroup>';
	}
}

function cbo_OrderMenu($par_id,$current){
	include("dbconnect.php");
	$qry = "SELECT mnu_id,name FROM tbl_menus WHERE isactive=1 AND mnu_id =$par_id ORDER BY `order` ASC";
	$res = mysql_query($qry,$dbconn);
	$i=0;
	echo '<option value="'.$i.'">'.$i.'.Đầu</option>';
	while (@$rows = mysql_fetch_array($res)) {
		$i++;
		echo '<option value="'.$i.'"';
		if($current==$rows["order"]) echo ' selected="selected"';
		echo ' >'.$i.'.'.$rows["name"].'</option>';
	}
	if(@mysql_num_rows($res)>0)
		echo '<option value="'.($i+1).'">'.($i+1).'.Cuối</option>';
}

function getTitle($con_id) {
	global $dbconn;
	$sql ="SELECT title FROM tbl_contents WHERE con_id=$con_id"; //echo $sql;
	@$result = mysql_query($sql,$dbconn);
	@$row = mysql_fetch_array($result);
	echo $row["title"];
}

function cbo_position () {
	global $dbconn;
	$sql = "select name from gf_position where isactive =1";
	@$rs = mysql_query($sql,$dbconn);
	while (@$row = mysql_fetch_array($rs)) {
		echo '<option value="'.$row["name"].'">'.$row["name"].'</option>';
	}
}
function HaveChild($par_id) {
	include("dbconnect.php");
	$sql = "SELECT count(cate_id) as num FROM tbl_categories WHERE isactive=1 AND par_id =$par_id ORDER BY `order` ASC";
	$rs = mysql_query($sql,$dbconn);
	if(@mysql_num_rows($rs)>0) {
		@$r = mysql_fetch_array($rs);
		return $r["num"];
	}else 
		return 0;
}
function HaveChild_Catalog($par_id) {
	include("dbconnect.php");
	$sql = "SELECT count(cat_id) as num FROM tbl_catalog WHERE par_id =$par_id ORDER BY `order` ASC";
	$rs = mysql_query($sql,$dbconn);
	if(@mysql_num_rows($rs)>0) {
		@$r = mysql_fetch_array($rs);
		return $r["num"];
	}else 
		return 0;
}

function list_Catalog($space,$par_id,$URL_manager) {
	global $dbconn;
	$sql = "SELECT * FROM tbl_catalog WHERE par_id=$par_id"; //echo $sql;
  	@$result = mysql_query($sql,$dbconn);
  	$i =1;
	$strlist="";
	if($par_id==0) $space='';
		else $space.="--";
			
	if(@mysql_num_rows($result)>0)
	{
	
		while ($rows = mysql_fetch_array($result)) 
		{	
			$id = $rows["cat_id"];
			$desc = '&nbsp;';
			if($rows["description"]!='') $desc = $rows["description"];
			$strlist.='<tr class="gf_tr">
			  <td align="center">'.$i.'</td>
			  <td align="center"><input type="checkbox" name="checkid" id="checkid" value="'.$rows["cat_id"].'" onClick="docheckonce(this)"/></td>
			  <td><a href="index.php?option=com_catalog&do=edit&id='.$rows["cat_id"].'">'.$space.$rows["name"].'</a></td>
			  <td>'.$desc.'</td>
			 
			  <td><div align="center"><a href="index.php?option=com_catalog&do=edit&id='.$rows["cat_id"].'"><img src="images/icon_edit.png" border="0" width="20" height="22" /></a></div></td>';
			  
			 $strlist.= "<td align=\"center\"><div align=\"center\"><a href=\"javascript:if(confirm('Bạn chắc chắn muốn xóa bản ghi này không ?')) window.location='".$URL_manager."/process_delete.php?id=".$rows["cat_id"]."';\"><img src=\"images/icon_delete.png\" border=\"0\" width=\"20\" height=\"22\" /></a> </div></td>";
			  $strlist.= '<td align="center"><div align="center"><a href="'.$URL_manager.'/process_active.php?id='.$rows["cat_id"].'>&amp;isactive='.$rows["isactive"].'">';
			  
			  if($rows["isactive"]==1) {
				 $strlist.= '<img src="images/icon_active.png" border="0" width="22" height="25" />';
			  } else { 
				 $strlist.= '<img src="images/icon_deactive.png" border="0" width="22" height="25" />';
			  }
			  $strlist.= '</a> </div></td></tr>';
			  
			  
			// Kiểm tra cat_id này có danh mục con không ?
			$strlist.=list_Catalog($space,$id,$URL_manager);
				
		}// End while*/
	}// end if num
	return $strlist;
}

function cbo_ListCatalogs($space,$par_id,$cur_id){
	global $dbconn;
	if($par_id==0) $space=''; 
	else $space .="-- ";
	
	$sql="select * from tbl_catalog where par_id=$par_id";
	$result=mysql_query($sql);
	if(@mysql_num_rows($result)>0) {
		while(@$row=mysql_fetch_array($result)) {
			echo'<option value="'.$row["cat_id"].'"';
			if($row["cat_id"]==$cur_id) echo ' selected="selected"';
			echo '>'.$space.$row["name"].'</option>';
			cbo_ListCatalogs($space,$row["cat_id"],$cur_id);
		}
	}
}
function catalogName($id) {
	global $dbconn;
	$sql = "select name from tbl_catalog where cat_id=$id";
	$result=mysql_query($sql);
	if(@mysql_num_rows($result)>0){
		@$row=mysql_fetch_array($result);
		echo $row[0];
	}
	else echo '';
}
?>
