<?php
class CLS_MENU{
	var $pro_menu=array(
					  "ID"=>"-1",
					  "Code"=>"default",
					  "Name"=>"default",
					  "Desc"=>"",
					  "LangID"=>"0",
					  "isActive"=>1
					  );
	var $result;
	var $result1;
	function CLS_MENU()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_menu[$proname]))
		{
			echo "Error";
			return;
		}
		$this->pro_menu[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_menu[$proname]))
		{
			$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->pro_menu[$proname];
	}
	function getMenuByID($mnuid){
		$sql="SELECT * FROM `view_menu` WHERE `mnu_id`='$mnuid' ";
		$objdata=new CLS_MYSQL;
		$objdata->query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->pro_menu["ID"]=$rows["mnu_id"];
			$this->pro_menu["Code"]=$rows["code"];
			$this->pro_menu["Name"]=$rows["name"];
			$this->pro_menu["Desc"]=$rows["desc"];
			$this->pro_menu["isActive"]=$rows["isactive"];
		}
	}
	function getList($where=""){
		$sql="SELECT * FROM `view_menu` ".$where;
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->query($sql);
	}
	
	function getListmenu($type)
	{
		$sql="SELECT * FROM `view_menu` WHERE `isactive`=1";
		$objdata=new CLS_MYSQL;
		$objdata->query($sql);
		if($objdata->Numrows()<=0)
			return;
		$str="";
		while($rows=$objdata->FetchArray())
		{
			if($type=="list")
				$str.="<li><a href=\"index.php?com=mnuitem&mnuid=".$rows["mnu_id"]."\">".$rows["name"]."</a></li>";
			else if($type=="option")
				$str.="<option value=\"".$rows["mnu_id"]."\">".$rows["name"]."</option>";
			else 
				$str.=$rows["name"];
		}
		return $str;
	}
	function listTableMenu($strwhere="",$page){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM `view_menu` ".$strwhere ." LIMIT $star,$leng";
		$objdata=new CLS_MYSQL;
		$objdata2 =  new CLS_MYSQL;
		$objdata->query($sql);
		$i=0;
		while($rows=$objdata->FetchArray())
		{	$i++;
			$mnuid=$rows["mnu_id"];$code=$rows["code"];$name=Substring($rows["name"],0,10);$desc=$rows["desc"];
			$desc = stripslashes($rows["desc"]);
			$desc = str_get_html($desc)->plaintext;
			$desc = Substring($desc,0,15);
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" onclick=\"docheckonce('checkid');\" value=\"$mnuid\" />";
			echo "</label></td>";
			echo "<td width=\"75\">$code</td>";
			echo "<td>$name</td>";
			echo "<td>$desc &nbsp;</td>";
			
			echo "<td align=\"center\">";
			echo "<a href=\"index.php?com=mnuitem&mnuid=$mnuid\">";
			showIconFun('menuitem',0);
			echo "</a>";
			echo "</td>";
			
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;mnuid=$mnuid\">";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			echo "</td>";
			
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;mnuid=$mnuid\">";
			showIconFun('edit','');
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			
			//echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;mnuid=$mnuid')\">";
			$sql2 = "SELECT * FROM `tbl_mnuitem` WHERE `mnu_id` = '$mnuid'";
			$objdata2->query($sql2);
			if($objdata2->Numrows()<=0)
				echo "<a href=\"index.php?com=".COMS."&amp;task=delete&amp;mnuid=$mnuid\" onclick=\"return confirm('".CF_DELETE01."');\">";
			else 
				echo "<a href=\"index.php?com=".COMS."&amp;task=delete&amp;mnuid=$mnuid\" onclick=\"return confirm('".CF_MN_DELETE01."');\">";
			showIconFun('delete','');
			echo "</a>";
			
			echo "</td>";
		  	echo "</tr>";
		}
	}
	function Numrows(){
		if(@mysql_num_rows($this->result)>0)
			return @mysql_num_rows($this->result);
		else 
			return 0;
	}
	function Add_new(){
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		$sql="INSERT INTO `tbl_menus`(`code`,`desc`,`isactive`) VALUES ";
		$sql.=" ('".$this->pro_menu["Code"]."','".$this->pro_menu["Desc"]."','".$this->pro_menu["isActive"]."') ";
		$result=$objdata->Query($sql);
		$mnuid=$objdata->LastInsertID();
		
		$sql="INSERT INTO `tbl_menus_text`(`mnu_id`,`name`,`lag_id`) VALUES";
		$sql.="('$mnuid','".$this->pro_menu["Name"]."','".$this->pro_menu["LangID"]."')";
		$result1=$objdata->Query($sql);
		
		if($result && $result1 ){
			$objdata->Query('COMMIT');
			$this->result = $result;
		}
		else {
			$objdata->Query('ROLLBACK');
		}
		return $this->result;
	}
	function Update(){
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		$sql="UPDATE `tbl_menus` SET `code`='".$this->pro_menu["Code"]."',
									 `desc`='".$this->pro_menu["Desc"]."',
									 `isactive`='".$this->pro_menu["isActive"]."' ";
		$sql.=" WHERE `mnu_id`='".$this->pro_menu["ID"]."'";
		$result=$objdata->Query($sql);
		
		$sql="UPDATE `tbl_menus_text` SET `name`='".$this->pro_menu["Name"]."'";
		$sql.=" WHERE `mnu_id`='".$this->pro_menu["ID"]."'";
		$result1=$objdata->Query($sql);
		
		if($result && $result1 ){
			$objdata->Query('COMMIT');
			$this->result = $result;
		}
		else {
			$objdata->Query('ROLLBACK');
		}
		return $this->result;
	}
	function ActiveOnce($mnuids){
		$sql="UPDATE `tbl_menus` SET `isactive` = IF(isactive=1,0,1) WHERE `mnu_id` in ('$mnuids')";
		$objdata=new CLS_MYSQL;
		$result=$objdata->query($sql);
	}
	function Publish($mnuids){
		$sql="UPDATE `tbl_menus` SET `isactive` = '1' WHERE `mnu_id` in ('$mnuids')";
		$objdata=new CLS_MYSQL;
		$result=$objdata->query($sql);
	}
	function UnPublish($mnuids){
		$sql="UPDATE `tbl_menus` SET `isactive` = '0' WHERE `mnu_id` in ('$mnuids')";
		$objdata=new CLS_MYSQL;
		$result=$objdata->query($sql);
	}
	//begin add new tuan ------------------------------------------------------------------------------------------
	function DeleteMenuItem($mnuitem_id)
	{
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		$sql = "select * from tbl_mnuitem where par_id = $mnuitem_id";
		$objdata->Query($sql);	
		while($rows=$objdata->FetchArray())
		{
			$id = $rows["mnuitem_id"];	
			$this->DeleteMenuItem($id);
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
	//end add new tuan  ------------------------------------------------------------------------------------------
	function Delete($mnuids){
		$objdata=new CLS_MYSQL;
		$objdata1=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		//delete menu item
		$sql = "SELECT * FROM `tbl_mnuitem` WHERE `mnu_id` = $mnuids ";
		$objdata->query($sql);
		while($rows=$objdata->FetchArray())
		{
			$id = $rows["mnuitem_id"];
			$this->DeleteMenuItem($id);
		}
		$sql1 = "DELETE FROM `tbl_mnuitem` WHERE `mnu_id` = $mnuids";
		$objdata1->query($sql1);
		//end delete menu item
		$sql="DELETE FROM `tbl_menus` WHERE `mnu_id` in ('$mnuids')";
		$result=$objdata->Query($sql);
		$sql="DELETE FROM `tbl_menus_text` WHERE `mnu_id` in ('$mnuids')";
		$result1=$objdata->Query($sql);
		
		if($result && $result1 ){
			$objdata->Query('COMMIT');
			$this->result = $result;
		}
		else {
			$objdata->Query('ROLLBACK');
		}
		return $this->result;
	}
}
?>