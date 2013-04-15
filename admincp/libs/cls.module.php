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
	var $result1;
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
		$sql="	SELECT * 
				FROM view_module
				WHERE mod_id=\"$modid\" AND `lag_id`='$lagid'";
		
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
		$sql=" SELECT * 
				FROM view_module
				WHERE lag_id='$lagid' $strwhere";
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
		$sql="	SELECT * 
				FROM view_module
				WHERE lag_id='$lagid' $strwhere ORDER BY `order` LIMIT $star,$leng";
		//echo $sql; 
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$i=0;
		while($rows=$objdata->FetchArray())
		{	$i++;
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
			
			echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;modid=".$modid."');\" >";
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
	function Fetch_Array(){
		return @mysql_fetch_array($this->result);
	}
	function Add_new(){
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		$sql="INSERT INTO tbl_modules (`type`,viewtitle,mnu_id,cat_id,theme,`position`,mnuids,class,isactive) VALUES ";
		$sql.="('".$this->pro_module["Type"]."','".$this->pro_module["ViewTitle"]."','".$this->pro_module["MnuID"]."','".$this->pro_module["CatID"]."','".$this->pro_module["Theme"]."','".$this->pro_module["Position"]."','".$this->pro_module["Mnuids"]."','".$this->pro_module["Class"]."','".$this->pro_module["isActive"]."')";
		
		$result=$objdata->Query($sql);
		$mod_id=$objdata->LastInsertID();
		
		$sql="INSERT INTO tbl_modules_text (mod_id,title,content,lag_id) VALUES ('$mod_id','".$this->pro_module["Title"]."','".$this->pro_module["HTML"]."','".$this->pro_module["LangID"]."')";
		//echo "$sql";
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
		$sql="UPDATE tbl_modules SET `type`='".$this->pro_module["Type"]."',`viewtitle`='".$this->pro_module["ViewTitle"]."',`mnu_id`='".$this->pro_module["MnuID"]."',`cat_id`='".$this->pro_module["CatID"]."',`theme`='".$this->pro_module["Theme"]."',`position`='".$this->pro_module["Position"]."',`mnuids`='".$this->pro_module["Mnuids"]."',`class`='".$this->pro_module["Class"]."',`isactive`='".$this->pro_module["isActive"]."' WHERE `mod_id`='".$this->pro_module["ID"]."'";
		$result=$objdata->Query($sql);
		
		$sql="UPDATE tbl_modules_text SET `title`='".$this->pro_module["Title"]."',`content`='".$this->pro_module["HTML"]."' WHERE `mod_id`='".$this->pro_module["ID"]."' AND  `lag_id`='".$this->pro_module["LangID"]."'";
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
	function Order($modid,$order){
		$objdata=new CLS_MYSQL;
		$sql="UPDATE tbl_modules SET `order`='".$order."' WHERE `mod_id`='".$modid."'";	
		//echo $sql;die();
		$objdata->Query($sql);	
	}
    function Orders($arids,$arods){
			for($i=0;$i<count($arids);$i++)
			{
				//$this->Order($arids[$i],$i);
				$this->Order($arids[$i],$arods[$i]);
				
			}
		}
	function ActiveOnce($modid){
		$sql="UPDATE `tbl_modules` SET `isactive` = IF(isactive=1,0,1) WHERE `mod_id` in ('$modid')";
		$objdata=new CLS_MYSQL;
		return $objdata->Query($sql);
	}
	function Publish($modid){
		$sql="UPDATE `tbl_modules` SET `isactive` = \"1\" WHERE `mod_id` in ('$modid')";
		$objdata=new CLS_MYSQL;
		return $objdata->Query($sql);
	}
	function UnPublish($modid){
		$sql="UPDATE `tbl_modules` SET `isactive` = \"0\" WHERE `mod_id` in ('$modid')";
		$objdata=new CLS_MYSQL;
		return $objdata->Query($sql);
	}
	function Delete($modid){
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		$sql="DELETE FROM `tbl_modules` WHERE `mod_id` in ('$modid')";
		$result=$objdata->Query($sql);
		$sql="DELETE FROM `tbl_modules_text` WHERE `mod_id` in ('$modid')";
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