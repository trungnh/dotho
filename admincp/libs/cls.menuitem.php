<?php
class CLS_MENUITEM extends CLS_MYSQL{
	var $pro_menu=array(
					  "ID"=>"-1",
					  "Par_ID"=>"0",
					  "Code"=>"",
					  "Name"=>"default",
					  "Desc"=>"",
					  "Mnu_ID"=>"0",
					  "Viewtype"=>"block", // block, link, list, detail
					  "Cat_ID"=>"0",
					  "Con_ID"=>"0",
					  "Link"=>"",
					  "Class"=>"",
					  "Order"=>"",
					  "LangID"=>"0",
					  "isActive"=>1
					  );
	var $result;
	function CLS_MENUITEM()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_menu[$proname]))
		{
			echo ("Can't found $proname member");
			return;
		}
		$this->pro_menu[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_menu[$proname]))
		{
			echo ("Can't found $proname member");
			return;
		}
		return $this->pro_menu[$proname];// phai tra ve gia tri
	}
	function getMenuItemByID($mnuid){
		$sql="SELECT * FROM `view_mnuitem` WHERE `mnuitem_id`='$mnuid' ";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->pro_menu["ID"]=$rows["mnuitem_id"];
			$this->pro_menu["Par_ID"]=$rows["par_id"];
			$this->pro_menu["Code"]=$rows["code"];
			$this->pro_menu["Name"]=$rows["name"];
			$this->pro_menu["Desc"]=$rows["desc"];
			$this->pro_menu["Mnu_ID"]=$rows["mnu_id"];
			$this->pro_menu["Viewtype"]=$rows["viewtype"];
			$this->pro_menu["Cat_ID"]=$rows["cat_id"];
			$this->pro_menu["Con_ID"]=$rows["con_id"];
			$this->pro_menu["Link"]=$rows["link"];
			$this->pro_menu["Class"]=$rows["class"];
			$this->pro_menu["isActive"]=$rows["isactive"];
			unset($rows);
		}
	}
	function getAllList($mnuid,$where=""){
		if($where!="")
			$where=" WHERE `mnu_id`='$mnuid' AND ".$where;
		$sql="SELECT * FROM `view_mnuitem` ".$where;
		//echo $sql."<br />"; 
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
	}
	function getListMenuItem($mnuid,$par_id,$level)
	{
		$sql="SELECT * FROM `view_mnuitem` WHERE `par_id`='$par_id' AND `mnu_id`='$mnuid' AND`isactive`='1'";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()<=0)
			return;
		$strspace="";
		if($level!=0){
			for($i=0;$i<$level;$i++)
				$strspace.="&nbsp;&nbsp;";
			$strspace.="|->";
		}
		$str="";
		while($rows=$objdata->FetchArray())
		{
			$str.="<option value=\"".$rows["mnuitem_id"]."\" >".$strspace.$rows["name"]."</option>";
			$str.=$this->getListMenuItem($mnuid,$rows["mnuitem_id"],++$level);
		}
		return $str;
	}
	function getListMenu($mnuid,$par_id,$level)
	{
		$sql="SELECT * FROM `view_mnuitem` WHERE `par_id`='$par_id' AND `mnu_id`='$mnuid' AND`isactive`='1'";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()<=0)
			return;
		$strspace="";
		if($level!=0){
			for($i=0;$i<$level;$i++)
				$strspace.="&nbsp;&nbsp;";
			$strspace.="|->";
		}
		$str="";
		while($rows=$objdata->FetchArray())
		{
			$str.="<option value=\"".$rows["mnuitem_id"]."\" onclick=\"getIDs();\">".$strspace.$rows["name"]."</option>";
			$str.=$this->getListMenu($mnuid,$rows["mnuitem_id"],++$level);
		}
		return $str;
	}
	function listTableItemMenu($mnuids,$strwhere="",$page,$par_id,$level,$rowcount){
		global $rowcount;
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM `view_mnuitem` WHERE `par_id`=\"$par_id\" ".$strwhere ." LIMIT $star,$leng";
		//echo $sql."<br />";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$str_space="";
		if($level!=0)
		{
			for($i=1;$i<$level;$i++)
				$str_space.="&nbsp;&nbsp;&nbsp;";
			$str_space.="|--";
		}
		$i=0;
		while($rows=$objdata->FetchArray())
		{	
			$rowcount++;
			$mnuids=$rows["mnuitem_id"];
			$par_id=$rows["par_id"];
			$code=$rows["code"];
			$name=Substring($rows["name"],0,10);
			$type=$rows["viewtype"];
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$rowcount</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" onclick=\"docheckonce('checkid');\" value=\"$mnuids\" />";
			echo "</label></td>";
			echo "<td width=\"50\" align=\"center\">$par_id</td>";
			echo "<td align=\"left\">$code</td>";
			echo "<td>$str_space $name</td>";
			echo "<td width=\"100\" align=\"center\">$type &nbsp;</td>";
			echo "<td width=\"50\" align=\"center\"><input type=\"text\" name=\"txtorder\" id=\"txtorder\" value=\"0\" size=\"4\" class=\"order\"></td>";
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;item=$mnuids\">";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;item=$mnuids\">";
			showIconFun('edit','');
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			
			$sql2 = "SELECT * FROM `tbl_mnuitem` WHERE `par_id` = '$mnuids'";
			$objdata2=new CLS_MYSQL;
			$objdata2->query($sql2);
			if($objdata2->Numrows()<=0)
				echo "<a href=\"index.php?com=".COMS."&amp;task=delete&amp;item=$mnuids\" onclick=\"return confirm('".CF_DELETE01."');\">";
			else
				echo "<a href=\"index.php?com=".COMS."&amp;task=delete&amp;item=$mnuids\" onclick=\"return confirm('".CF_MN_DELETE01."');\">";
			showIconFun('delete','');
			echo "</a>";
			
			echo "</td>";
		  	echo "</tr>";
			
			$this->listTableItemMenu($mnuids,$strwhere,$page,$mnuids,++$level,$rowcount);
		}
	}
 
	function Numrows() { 
		return mysql_num_rows($this->result);
	}
	function FetchArray(){	
		return @mysql_fetch_array($this->result);
	}
	
	function getChildID($parid) {
		$sql = "SELECT mnuitem_id FROM tbl_mnuitem WHERE par_id IN ('$parid')"; 
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		
		$ids='';
		if($objdata->Numrows()>0) {
			while($r = $objdata->FetchArray()) {
				$ids.=$r[0]."','";
				$ids.=$this->getChildID($r[0]);
			}
		}
		return $ids;
	}
	function isActiveID($id) {
		$sql = "SELECT isactive FROM tbl_mnuitem WHERE mnuitem_id =$id";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		if($objdata->Numrows()>0) {
			$r = $objdata->FetchArray();
			return $r[0];
		}
		return '';
	}
	
	function Add_new(){
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		$sql="INSERT INTO 	`tbl_mnuitem`(`par_id`,`code`,`desc`,`mnu_id`,`viewtype`,`cat_id`,`con_id`,`link`,`class`,`isactive`) VALUES ";
		$sql.=" ('".$this->pro_menu["Par_ID"]."','".$this->pro_menu["Code"]."','".$this->pro_menu["Desc"]."','".$this->pro_menu["Mnu_ID"]."','".$this->pro_menu["Viewtype"]."','".$this->pro_menu["Cat_ID"]."','".$this->pro_menu["Con_ID"]."','".$this->pro_menu["Link"]."','".$this->pro_menu["Class"]."','".$this->pro_menu["isActive"]."') ";
		
		$result = $objdata->Query($sql);
		$mnuitemid=$objdata->LastInsertID();
		$sql="INSERT INTO 	`tbl_mnuitem_text`(`mnuitem_id`,`name`,`lag_id`) VALUES ";
		$sql.=" ('$mnuitemid','".$this->pro_menu["Name"]."','".$this->pro_menu["LangID"]."')";
		//echo $sql; exit();
		$result1=$objdata->Query($sql);
		
		if($result && $result1){
			$objdata->Query('COMMIT');
			$this->result =true;
		}else{
			$objdata->Query('ROLLBACK');
			$this->result =false;
		}
		return $this->result;
	}
	function Update(){
		$objdata=new CLS_MYSQL();
		$objdata->Query("BEGIN");
		$sql="UPDATE `tbl_mnuitem` SET  `par_id`='".$this->pro_menu["Par_ID"]."',
										`code`='".$this->pro_menu["Code"]."',
										`desc`='".$this->pro_menu["Desc"]."',
										`mnu_id`='".$this->pro_menu["Mnu_ID"]."',
									    `viewtype`='".$this->pro_menu["Viewtype"]."',
										`cat_id`='".$this->pro_menu["Cat_ID"]."',
										`con_id`='".$this->pro_menu["Con_ID"]."',
										`link`='".$this->pro_menu["Link"]."',
										`class`='".$this->pro_menu["Class"]."',
										`isactive`='".$this->pro_menu["isActive"]."'";
		$sql.=" WHERE `mnuitem_id`='".$this->pro_menu["ID"]."'";
		$result=$objdata->Query($sql);
		$sql="UPDATE `tbl_mnuitem_text` SET  
										`name`='".$this->pro_menu["Name"]."'";
		$sql.=" WHERE `mnuitem_id`='".$this->pro_menu["ID"]."'";
		$result1=$objdata->Query($sql);
		
		if($result && $result1)
		{
			$objdata->Query('COMMIT');
			$this->result =true;
		}else{
			$objdata->Query('ROLLBACK');
			$this->result =false;
		}
		return $this->result;
	}
	function ActiveOnce($mnuids){
		if($this->isActiveID($mnuids)==1) {
			$child = $this->getChildID($mnuids);
			if($child!='')
				$mnuids.="','".$child;
			$sql="UPDATE `tbl_mnuitem` SET `isactive` = 0 WHERE `mnuitem_id` in ('$mnuids')";
		}
		else 
			$sql="UPDATE `tbl_mnuitem` SET `isactive` = IF(isactive=1,0,1) WHERE `mnuitem_id` in ('$mnuids')";
		//echo $sql;
		$objdata=new CLS_MYSQL;
		return $objdata->Query($sql);
	}
	function Publish($mnuids){
		$sql="UPDATE `tbl_mnuitem` SET `isactive` = '1' WHERE `mnuitem_id` in ('$mnuids')";
		$objdata=new CLS_MYSQL;
		return $objdata->Query($sql);
	}
	function UnPublish($mnuids){
		$sql="UPDATE `tbl_mnuitem` SET `isactive` = '0' WHERE `mnuitem_id` in ('$mnuids')";
		$objdata=new CLS_MYSQL;
		return $objdata->Query($sql);
	}
	//Old code ------------------------------------------------------
/*	function Delete($mnuids){
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		$sql="DELETE FROM `tbl_mnuitem` WHERE `mnuitem_id` in ('$mnuids')";
		$result=$objdata->Query($sql);	
		//echo $sql; die();
		$sql="DELETE FROM `tbl_mnuitem_text` WHERE `mnuitem_id` in ('$mnuids')";
		$result1=$objdata->Query($sql);
		
		if($result && $result1 ){
			$objdata->Query('COMMIT');
			return $result;
		}else{
			$objdata->Query('ROLLBACK');
		}
	}
*/
	
	function Delete($mnuitem_id)
	{
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		$sql = "select * from tbl_mnuitem where par_id = $mnuitem_id";
		$objdata->Query($sql);	
		while($rows=$objdata->FetchArray())
		{
			$id = $rows["mnuitem_id"];	
			$this->Delete($id);
		}
		$sql="DELETE FROM `tbl_mnuitem` WHERE `mnuitem_id` in ('$mnuitem_id')";
		$result=$objdata->Query($sql);	
		//echo $sql; die();
		$sql="DELETE FROM `tbl_mnuitem_text` WHERE `mnuitem_id` in ('$mnuitem_id')";
		$result1=$objdata->Query($sql);
		
		if($result && $result1 ){
			$objdata->Query('COMMIT');
			return $result;
		}else{
			$objdata->Query('ROLLBACK');
		}
	}
	
	function listTableItemMenuReturn($mnuids,$strwhere="",$page,$par_id,$level,$rowcount){
		global $rowcount;
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM `view_mnuitem` WHERE `par_id`=\"$par_id\"  ".$strwhere ;
		//echo $sql."<br />";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$str_space="";
		if($level!=0)
		{
			for($i=1;$i<$level;$i++)
				$str_space.="&nbsp;&nbsp;&nbsp;";
			$str_space.="|--";
		}
		$i=0;
		while($rows=$objdata->FetchArray())
		{	
			$rowcount++;
			$mnuids=$rows["mnuitem_id"];
			$par_id=$rows["par_id"];
			$code=$rows["code"];
			$name=Substring($rows["name"],0,10);
			$type=$rows["viewtype"];
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$rowcount</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" onclick=\"docheckonce('checkid');\" value=\"$mnuids\" />";
			echo "</label></td>";
			echo "<td width=\"50\" align=\"center\">$par_id</td>";
			echo "<td align=\"left\">$code</td>";
			echo "<td>$str_space $name</td>";
			echo "<td width=\"100\" align=\"center\">$type &nbsp;</td>";
			echo "<td width=\"50\" align=\"center\"><input type=\"text\" name=\"txtorder\" id=\"txtorder\" value=\"0\" size=\"4\" class=\"order\"></td>";
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;item=$mnuids\">";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;item=$mnuids\">";
			showIconFun('edit','');
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			
			$sql2 = "SELECT * FROM `tbl_mnuitem` WHERE `par_id` = '$mnuids'";
			$objdata2=new CLS_MYSQL;
			$objdata2->query($sql2);
			if($objdata2->Numrows()<=0)
				echo "<a href=\"index.php?com=".COMS."&amp;task=delete&amp;item=$mnuids\" onclick=\"return confirm('".CF_DELETE01."');\">";
			else
				echo "<a href=\"index.php?com=".COMS."&amp;task=delete&amp;item=$mnuids\" onclick=\"return confirm('".CF_MN_DELETE01."');\">";
			showIconFun('delete','');
			echo "</a>";
			
			echo "</td>";
		  	echo "</tr>";
			$this->listTableItemMenuReturn($mnuids,$strwhere,$page,$mnuids,++$level,$rowcount);
		}
	}
}
$objmenu=new CLS_MENU();
?>