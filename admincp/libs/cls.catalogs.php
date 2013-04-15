<?php
class CLS_CATALOG{
	var $pro_catalog=array(
					  "ID"=>"-1",
					  "ParID"=>"0",
					  "Name"=>"",
					  "Intro"=>"",
					  "LangID"=>"0",
					  "isActive"=>1
					  );
	var $result;
	function CLS_CATALOG()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_catalog[$proname]))
		{
			echo "Error";
			return;
		}
		$this->pro_catalog[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_catalog[$proname]))
		{
			$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->pro_catalog[$proname];
	}
	function getCatalogByID($cataid){
		$sql="SELECT * FROM view_catalogs WHERE `cata_id`=\"$cataid\" ";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->pro_catalog["ID"]=$rows["cata_id"];
			$this->pro_catalog["ParID"]=$rows["par_id"];
			$this->pro_catalog["Name"]=$rows["name"];
			$this->pro_catalog["Intro"]=$rows["intro"];
			$this->pro_catalog["isActive"]=$rows["isactive"];
		}
	}
	function getAllList($where=""){
		$sql="SELECT * FROM view_catalogs where 1=1 ".$where;
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
	}	
	function getAllListAdmin($where="", $parid){
		$sql="SELECT * FROM view_catalogs where `par_id`=\"$parid\" ".$where;
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
	}	
	function getCatalogByParent($par_id){
		$sql="SELECT * FROM view_catalogs WHERE `par_id`=\"$par_id\"";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
	}
	function getListCatalog($parid=0,$level=0)
	{
		$sql="SELECT cata_id,par_id,name FROM view_catalogs WHERE `par_id`=\"$parid\" AND `isactive`=\"1\" ";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		
		$char="";
		if($level!=0)
		{
			for($i=1;$i<=$level;$i++)
				$char.=".....  ";
		}
		if($objdata->Numrows()<=0) return;
		while($rows=$objdata->FetchArray())
		{
			$cataid=$rows["cata_id"];
			$parid=$rows["par_id"];
			$name=$rows["name"];
			echo "<option value=\"$cataid\">$char $name</option>";
			if($parid==0) $level=1;
			if($this->haveChild($cataid)!='') 
			$level++;
			$this->getListCatalog($cataid,$level);
		}
	}
	/*change -------------------------------------------------------------------------*/
	function getListCatalogSubCurrentCate($parid=0,$level=0,$id=0){
		$sql="SELECT * FROM view_catalogs WHERE `par_id`=\"$parid\" AND `isactive`=\"1\" AND cata_id !=\"$id\" ";

		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$char="";
		if($level>0)
		{
			for($i=0;$i<$level;$i++)
				$char.="--";
				$char.="";
		}
		while($rows=$objdata->FetchArray())
		{
			$cataid=$rows["cata_id"];
			$name=$rows["name"];
			echo "<option value=\"$cataid\">$char $name</option>";
			$this->getListCateSubCurrentCate($cataid,$level++,$id);
		}
	}
	function getCate(){
		$sql="SELECT `name` FROM `view_catalogs`";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		while($rows=$objdata->FetchArray())
		{
			$cataid=$rows["name"];
			echo "<option value=\"$cataid\">$cataid</option>";
		}
	}
	
	
	function listTableCatalog($strwhere="",$page,$parid,$level,$rowcount){
		global $rowcount;
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		if($strwhere!='' && $parid == ''){
			$sql="SELECT * FROM view_catalogs where 1=1 ".$strwhere ." ORDER BY `order` LIMIT $star,$leng";
		}else{
			$sql="SELECT * FROM view_catalogs WHERE `par_id`=\"$parid\" ".$strwhere ." ORDER BY `order` LIMIT $star,$leng";
		}
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$str_space="";
		
		if($level!=0)
		{
			for($i=1;$i<$level;$i++)
				$str_space.="&nbsp;";
			$str_space.="|--";
		}
		$i=0;
		$save = $parid;
		while($rows=$objdata->FetchArray())
		{	$rowcount++; $i++;
			$cataid=$rows["cata_id"];
			$parid=$rows["par_id"];
			$name=Substring($rows["name"],0,10);
			$order=$rows["order"];
			//$type=$rows["type"];
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" onclick=\"docheckonce('checkid');\" value=\"$cataid\" />";
			echo "</label></td>";
			echo "<td width=\"50\" align=\"center\">$parid</td>";
			echo "<td>$str_space$name</td>";

			echo "<td align=\"center\"><input type=\"text\" name=\"txtorder\" id=\"txtorder\" value=\"$order\" size=\"4\" class=\"order\"></td>";
			
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;cataid=$cataid\">";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;cataid=$cataid\">";
			showIconFun('edit','');
			echo "</a>";
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;cataid=$cataid')\">";
			showIconFun('delete','');
			echo "</a>";
			
			echo "</td>";
		  	echo "</tr>";
			if($strwhere!='' && $save == ''){
				echo '';
			}else{
				$this->listTableCatalog($strwhere,$page,$cataid,++$level,$rowcount);
			}
		}
	}
		/*end change -------------------------------------------------------------------------*/
	function ListCatalog($minus_cataid=0,$cur_parid=0,$parid=0,$level=0,$strwhere)
	{
		$sql="SELECT cata_id,par_id,name, isactive FROM view_catalogs WHERE `par_id`='$parid' ".$strwhere;//AND cata_id!=$minus_cataid";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$char="";
		if($level!=0)
		{
			for($i=1;$i<=$level;$i++)
				$char.="... ";
		}
		if($objdata->Numrows()<=0) return;
		while($rows=$objdata->FetchArray())
		{
			$cataid=$rows["cata_id"];
			$parid=$rows["par_id"];
			$name=$rows["name"];
			
			$str='';
			if($cataid==$cur_parid) $str=' selected="selected" ';
				
			if($rows["isactive"]==0)
				echo '<option value="'.$cataid.'" style="color:red"'.$str.'>'.$char." ".$name.'</option>';
			else
				echo '<option value="'.$cataid.'"'.$str.'>'.$char." ".$name.'</option>';
			
			if($parid==0) $level=1;
			if($this->haveChild($cataid)!='') $level++;
			$this->ListCatalog($minus_cataid,$cur_parid,$cataid,$level,$strwhere);
		}
	}
	function Numrows() { 
		if(mysql_num_rows($this->result))
			return @mysql_num_rows($this->result);
		return 0;
	}
	function Fecth_Array(){
			
		return @mysql_fetch_array($this->result);
	}
	function Add_new(){
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		$sql="INSERT INTO `tbl_catalogs`(`par_id`,`isactive`) VALUES ";
		$sql.=" (\"".$this->pro_catalog["ParID"]."\",\"".$this->pro_catalog["isActive"]."\") ";
		
		$result=$objdata->Query($sql);
		if(!$result)
		{return ;} 
		
		$cata_id=$objdata->LastInsertID();
		
		$sql=" INSERT INTO `tbl_catalogs_text`(`cata_id`,`name`,`intro`,`lag_id`) VALUES";
		$sql.="('$cata_id',N'".$this->pro_catalog["Name"]."',N'".$this->pro_catalog["Intro"]."','".$this->pro_catalog["LangID"]."')";
		
		$result1=$objdata->Query($sql);
		if($result && $result1) {
			$objdata->Query("COMMIT");
			return $result;
		}
		else
			$objdata->Query("ROLLBACK");	
	}
	function Update(){
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		
		$sql = "UPDATE tbl_catalogs SET par_id='".$this->pro_catalog["ParID"]."', `isactive`='".$this->pro_catalog["isActive"]."' WHERE cata_id='".$this->pro_catalog["ID"]."'";
		$result=$objdata->Query($sql);
		if(!$result)
		{return ;} 
		
		$sql = "UPDATE `tbl_catalogs_text` SET `lag_id`='".$this->pro_catalog["LangID"]."',`name`=N'".$this->pro_catalog["Name"]."',`intro`=N'".$this->pro_catalog["Intro"]."' ";
		$sql.=" WHERE `cata_id`=\"".$this->pro_catalog["ID"]."\"";
		$result1=$objdata->Query($sql);
		if(!$result1) {
			$objdata->Query("ROLLBACK");
			return;
		}
		else
			$objdata->Query("COMMIT");
		return $result;	
	}
	function haveChild($parid) {
		$sql = "SELECT cata_id FROM tbl_catalogs WHERE par_id IN ('$parid')"; 
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		
		if($objdata->Numrows()>0) {
			return $objdata->Numrows();
		}
		return 0;
	}
	function getChildID($parid) {
		$sql = "SELECT cata_id FROM tbl_catalogs WHERE par_id IN ('$parid')"; 
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
		$sql = "SELECT isactive FROM tbl_catalogs WHERE cata_id =$id";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		if($objdata->Numrows()>0) {
			$r = $objdata->FetchArray();
			return $r[0];
		}
		return '';
	}
	function ActiveOnce($cataid){
		if($this->isActiveID($cataid)==1) {
			$child = $this->getChildID($cataid);
			if($child!='')
				$cataid.="','".$child;
			$sql="UPDATE `tbl_catalogs` SET `isactive` = 0 WHERE `cata_id` in ('$cataid')";
		}
		else 
			$sql="UPDATE `tbl_catalogs` SET `isactive` = IF(isactive=1,0,1) WHERE `cata_id` in ('$cataid')";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		return $this->result;
	}
	function Publish($cataid){
		$sql="UPDATE `tbl_catalogs` SET `isactive` = \"1\" WHERE `cata_id` in ('$cataid')";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		return $this->result;
	}
	function UnPublish($cataid){
		$child = $this->getChildID($cataid);
		if($child!='')
			$cataid.="','".$child;
			
		$sql="UPDATE `tbl_catalogs` SET `isactive` = \"0\" WHERE `cata_id` in ('$cataid')";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		return $this->result;
	}
	function Order($cataid,$order){
	$objdata=new CLS_MYSQL;
	$sql="UPDATE tbl_catalogs SET `order`='".$order."' WHERE `cata_id`='".$cataid."'";	
	//echo $sql;die();
	$objdata->Query($sql);	
	}
	function Orders($arids,$arods){
		for($i=0;$i<count($arids);$i++)
		{
			$this->Order($arids[$i],$arods[$i]);
			//$this->Order($arids[$i],$i);//
		}
	}
	function Delete($cataid){
		$objdata = new CLS_MYSQL; 
		$objdata->Query("BEGIN");
		
		$sql = "SELECT * FROM `tbl_catalogs` WHERE `par_id` = $cataid";
		$objdata->Query($sql);	
		while($rows=$objdata->FetchArray())
		{
			$id = $rows["cata_id"];	
			$this->Delete($id);
		}
		$sql="DELETE FROM `tbl_catalogs` WHERE `cata_id` in ('$cataid')";
		$result=$objdata->Query($sql);
		if(!$result)
		{return ;} 
		$sql ="UPDATE `tbl_products` SET `cata_id`= '0' WHERE  `cata_id` = $cataid";
		$objdata->Query($sql);
		$sql="DELETE FROM `tbl_catalogs_text` WHERE `cata_id` in ('$cataid')";
		//echo $sql; die();
		$result1=$objdata->Query($sql);
		
		if($result && $result1) {
			$objdata->Query("COMMIT");
			return $result;
		}
		else
			$objdata->Query("ROLLBACK");	
	}
	
}
?>