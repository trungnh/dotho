<?php
class CLS_MODULE{
	var $pro_module=array(
					  "ID"=>"-1",
					  "Title"=>"default",
					  "Type"=>"menu",
					  "ViewTitle"=>"1",
					  "MnuID"=>"0",
					  "CatID"=>"0",
					  "Theme"=>"",
					  "HTML"=>"",
					  "Position"=>"left",
					  "Mnuids"=>"",
					  "Class"=>"",
					  "LangID"=>"0",
					  "Order"=>"",
					  "isActive"=>1
					  );
	var $result;
	function CLS_MODULE()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_module[$proname]))
		{
			echo "Can't found $proname member";
			return;
		}
		$this->pro_module[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_module[$proname]))
		{
			echo "Can't found $proname member";
			return;
		}
		return $this->pro_module[$proname];
	}
	function getModByID($modid,$lagid=0){
		$sql="	SELECT tbl_modules.*,tbl_modules_text.title,tbl_modules_text.content 
				FROM tbl_modules INNER JOIN tbl_modules_text ON tbl_modules.mod_id= tbl_modules_text.mod_id
				WHERE tbl_modules.mod_id=\"$modid\" AND `lag_id`='$lagid'";
		//echo $sql;
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->pro_module["ID"]=$rows["mod_id"];
			$this->pro_module["Title"]=$rows["title"];
			$this->pro_module["ViewTitle"]=$rows["viewtitle"];
			$this->pro_module["Type"]=$rows["type"];
			$this->pro_module["MnuID"]=$rows["mnu_id"];
			$this->pro_module["CatID"]=$rows["cat_id"];
			$this->pro_module["Theme"]=$rows["theme"];
			$this->pro_module["HTML"]="".$rows["content"];
			$this->pro_module["Position"]=$rows["position"];
			$this->pro_module["Mnuids"]=$rows["mnuids"];
			$this->pro_module["Class"]=$rows["class"];
			$this->pro_module["Order"]=$rows["order"];
			$this->pro_module["isActive"]=$rows["isactive"];
			unset($rows);
		}
	}
	function getAllList($strwhere="",$lagid=0){
		$sql=" SELECT tbl_modules.*,tbl_modules_text.title,tbl_modules_text.content 
				FROM tbl_modules INNER JOIN tbl_modules_text ON tbl_modules.mod_id= tbl_modules_text.mod_id
				WHERE tbl_modules_text.lag_id='$lagid' $strwhere";
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
	}
	function getPosition(){
		$sql="SELECT DISTINCT `position` FROM `tbl_modules`";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		while($rows=$objdata->FetchArray())
		{
			$pos=$rows["position"];
			echo "<option value=\"$pos\">$pos</option>";
		}
	}
	function LoadModType(){
		$sql="SELECT * FROM `tbl_modtype` ".strwhere;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		while($rows=$objdata->FetchArray())
		{
			$modid=$rows["modtypeid"];
			$code=$rows["code"];
			$name=$rows["name"];
			echo "<option value=\"$code\">$name</option>";
		}
	}
	function getListMod($strwhere)
	{
		$sql="SELECT * FROM `tbl_modules` ".strwhere;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		while($rows=$objdata->FetchArray())
		{
			$modid=$rows["mod_id"];
			$name=$rows["title"];
			echo "<option value=\"$modid\">$title</option>";
		}
	}
	function listTableMod($strwhere="",$page,$lagid=0){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="	SELECT tbl_modules.*,tbl_modules_text.title,tbl_modules_text.content 
				FROM tbl_modules INNER JOIN tbl_modules_text ON tbl_modules.mod_id= tbl_modules_text.mod_id
				WHERE tbl_modules_text.lag_id='$lagid' $strwhere ORDER BY `order` LIMIT $star,$leng";
		//echo $sql; 
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$i=0;
		while($rows=$objdata->FetchArray())
		{	
			$i++;
			$modid=$rows["mod_id"];	
			$title=Substring($rows["title"],0,10);
			$type=$rows["type"];
			$position=$rows["position"]; 
			$order=$rows["order"];
			
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" onclick=\"docheckonce('checkid');\" value=\"$modid\" />";
			echo "</label></td>";
			echo "<td nowrap=\"nowrap\">$title</td>";
			echo "<td width=\"75\">$type</td>";
			echo "<td width=\"75\" align=\"center\" >$position</td>";
			echo "<td width=\"50\" align=\"center\"><input type=\"text\" name=\"txtorder\" id=\"txtorder\" value=\"$order\" size=\"4\" class=\"order\"></td>";
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;modid=$modid\">";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;modid=$modid\">";
			showIconFun('edit','');
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"index.php?com=".COMS."&amp;task=delete&amp;modid=$modid\" onclick=\"return confirm('Do you want to delete this record?');\" >";
			showIconFun('delete','');
			echo "</a>";
			
			echo "</td>";
		  	echo "</tr>";
		}
	}
	function Numrows() {
		return mysql_num_rows($this->result);
	}
	function Fetch_Array(){
		return @mysql_fetch_array($this->result);
	}
}
?>