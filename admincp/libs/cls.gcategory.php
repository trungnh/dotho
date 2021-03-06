<?php
class CLS_GCATE{
	var $pro_cate=array(
					  "ID"=>"-1",
					  "ParID"=>"0",
					  "Name"=>"",
					  "Desc"=>"",
					  "order"=>"0",
					  "creator"=>"",
					  "joindate"=>"",
					  "isActive"=>1
					  );
	var $result;
	function CLS_CATE()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_cate[$proname]))
		{
			echo "Error";
			return;
		}
		$this->pro_cate[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_cate[$proname]))
		{
			$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->pro_cate[$proname];
	}
	function getCateByID($catid){
		$sql="SELECT * FROM tbl_game_category WHERE `id`=\"$catid\" ";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->pro_cate["ID"]=$rows["id"];
			$this->pro_cate["ParID"]=$rows["par_id"];
			$this->pro_cate["Name"]=$rows["name"];
			$this->pro_cate["Desc"]=$rows["desc"];
			$this->pro_cate["order"]=$rows["order"];
			$this->pro_cate["creator"]=$rows["creator"];
			$this->pro_cate["joindate"]=$rows["joindate"];
			$this->pro_cate["isActive"]=$rows["isactive"];
		}
	}
	function getAllList($where=""){
		$sql="SELECT * FROM tbl_game_category where 1=1 ".$where;
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
	}	
	function getCateByParent($par_id){
		$sql="SELECT * FROM tbl_game_category WHERE `par_id`=\"$par_id\"";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
	}
	function getListCate($parid=0,$level=0)
	{
		$sql="SELECT id,par_id,name FROM tbl_game_category WHERE `par_id`=\"$parid\" AND `isactive`=\"1\" ";
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
			$catid=$rows["id"];
			$parid=$rows["par_id"];
			$name=$rows["name"];
			echo "<option value=\"$catid\">$char $name</option>";
			if($parid==0) $level=1;
			if($this->haveChild($catid)!='') $level++;
			$this->getListCate($catid,$level);
		}
	}

	function getListCateSubCurrentCate($parid=0,$level=0,$id=0){
		$sql="SELECT * FROM tbl_game_category WHERE `par_id`=\"$parid\"  AND `isactive`=\"1\" AND id !=\"$id\" "." ORDER BY `order`" ;

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
			$catid=$rows["id"];
			$name=$rows["name"];
			echo "<option value=\"$catid\">$char $name</option>";
			$this->getListCateSubCurrentCate($catid,$level++,$id);
		}
	}
	function getCate(){
		$sql="SELECT `name` FROM `tbl_game_category`";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		while($rows=$objdata->FetchArray())
		{
			$catid=$rows["name"];
			echo "<option value=\"$catid\">$catid</option>";
		}
	}
	function listTableCate($strwhere="",$page,$parid,$level,$rowcount){
		global $rowcount;
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		if($strwhere!='' && $parid == ''){
			//$sql="SELECT * FROM view_cate where 1=1 ".$strwhere ." LIMIT $star,$leng";
			$sql="SELECT * FROM tbl_game_category where 1=1 ".$strwhere." ORDER BY `order`"  ;
		}else{
			//$sql="SELECT * FROM view_cate WHERE `par_id`=\"$parid\" ".$strwhere ." LIMIT $star,$leng";
			$sql="SELECT * FROM tbl_game_category WHERE `par_id`=\"$parid\" ".$strwhere ." ORDER BY `order`" ;
		}
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$str_space="";
		
		if($level!=0)
		{	
			for($i=2;$i<=$level;$i++){
				$str_space.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			} 
			$str_space.="|--- ";
		}
		$i=0;
		$save = $parid;
		while($rows=$objdata->FetchArray())
		{	
			$rowcount++;
			$catid=$rows["id"];
			$parid=$rows["par_id"];
			$name=Substring($rows["name"],0,10);
			$desc=$rows["desc"];
			$creator=$rows["creator"];
			$joindate=$rows["joindate"];
			$joindate = date("d-m-Y",strtotime($joindate));
			$order=$rows["order"];
			$sql2 = "SELECT *  FROM `tbl_member` where `mem_id` = $creator";
			$objdata2=new CLS_MYSQL();
			$objdata2->Query($sql2);
			$uname = "";
			while($rows2=$objdata2->FetchArray())
			{
				 $uname=$rows2["lastname"]." ".$rows2["firstname"];
			}
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$rowcount</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" onclick=\"docheckonce('checkid');\" value=\"$catid\" />";
			echo "</label></td>";
			echo "<td width=\"50\" align=\"center\">$parid</td>";
			echo "<td nowrap=\"nowrap\">$str_space$name</td>";
			echo "<td nowrap=\"nowrap\">$uname</td>";
			echo "<td nowrap=\"nowrap\">$joindate</td>";
			echo "<td align=\"center\"><input type=\"text\" name=\"txtorder\" id=\"txtorder\" value=\"$order\" size=\"4\" class=\"order\"></td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;catid=$catid\">";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;catid=$catid\">";
			showIconFun('edit','');
			echo "</a>";
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			//echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;catid=$catid')\">";
			$sql2 = "SELECT * FROM `tbl_content` WHERE `cat_id` = '$catid'";
			$objdata2=new CLS_MYSQL;
			$objdata2->query($sql2);
			if($objdata2->Numrows()<=0)
				echo "<a href=\"index.php?com=".COMS."&amp;task=delete&amp;catid=$catid\" onclick=\"return confirm('".CF_DELETE01."');\">";
			else
				echo "<a href=\"index.php?com=".COMS."&amp;task=delete&amp;catid=$catid\" onclick=\"return confirm('".CF_CT_DELETE01."');\">";		
			showIconFun('delete','');
			echo "</a>";
			
			echo "</td>";
		  	echo "</tr>";
			if($strwhere!='' && $save == ''){
				echo '';
			}
			else
			{
				if($parid==0) $level=0;
				$this->listTableCate($strwhere,$page,$catid,++$level,$rowcount);
			}
		}
	}
	function ListCategory($minus_catid=0,$cur_parid=0,$parid=0,$level=0,$strwhere)
	{
		$sql="SELECT id,par_id,name, isactive FROM tbl_game_category WHERE `par_id`='$parid' ".$strwhere;//AND cat_id!=$minus_catid";
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
			$catid=$rows["id"];
			$parid=$rows["par_id"];
			$name=$rows["name"];
			
			$str='';
			if($catid==$cur_parid) $str=' selected="selected" ';
				
			if($rows["isactive"]==0)
				echo '<option value="'.$catid.'" style="color:red"'.$str.'>'.$char." ".$name.'</option>';
			else
				echo '<option value="'.$catid.'"'.$str.'>'.$char." ".$name.'</option>';
			
			if($parid==0) $level=1;
			if($this->haveChild($catid)!='') $level++;
			$this->ListCategory($minus_catid,$cur_parid,$catid,$level,$strwhere);
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
		$sql="INSERT INTO `tbl_game_category` (`id`, `par_id`, `name`, `desc`, `order`, `creator`, `joindate`, `isactive`) VALUES (NULL, '".$this->pro_cate["ParID"]."', N'".$this->pro_cate["Name"]."', N'".$this->pro_cate["Desc"]."', '".$this->pro_cate["order"]."', '".$this->pro_cate["creator"]."', NOW(), b'".$this->pro_cate["isActive"]."');";
		$result=$objdata->Query($sql);
		if(!$result)
		{return ;} 
		if($result ) {
			$objdata->Query("COMMIT");
			return $result;
		}
		else
			$objdata->Query("ROLLBACK");	
	}
	function Update(){
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		$sql = "UPDATE `tbl_game_category` SET `par_id` = '".$this->pro_cate["ParID"]."', `name` = N'".$this->pro_cate["Name"]."', `desc` = N'".$this->pro_cate["Desc"]."', `order` = '".$this->pro_cate["order"]."', `creator` = '".$this->pro_cate["creator"]."', `isactive` = '".$this->pro_cate["isActive"]."' WHERE `id` =".$this->pro_cate["ID"];
		//$sql = "UPDATE `db_serverdc`.`tbl_game_category` SET `par_id` = '1', `name` = N'".$this->pro_cate["Name"]."', `desc` = N'".$this->pro_cate["Desc"]."', `order` = '".$this->pro_cate["order"]."', `creator` = '".$this->pro_cate["creator"]."', `joindate` = '".$this->pro_cate["joindate"]."', `isactive` = b '".$this->pro_cate["isActive"]."' WHERE `id` =".$this->pro_cate["ID"];
		//$sql = "'UPDATE tbl_game_category SET par_id='".$this->pro_cate["ParID"]."',`isactive`='".$this->pro_cate["isActive"]."' WHERE cat_id='".$this->pro_cate["ID"]."";
		$result=$objdata->Query($sql);
		//echo $sql;
		if(!$result)
		{return ;} 
		else
			$objdata->Query("COMMIT");
		return $result;	
		//$sql = "UPDATE `tbl_category_text` SET `lag_id`='".$this->pro_cate["LangID"]."',`name`=N'".$this->pro_cate["Name"]."',`desc`=N'".$this->pro_cate["Desc"]."' ";
		//$sql.=" WHERE `cat_id`=\"".$this->pro_cate["ID"]."\"";
		//$result1=$objdata->Query($sql);
		
		
	}
	function haveChild($parid) {
		$sql = "SELECT id FROM tbl_game_category  WHERE par_id IN ('$parid')"; 
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		
		if($objdata->Numrows()>0) {
			return $objdata->Numrows();
		}
		return 0;
	}
	function getChildID($parid) {
		$sql = "SELECT id FROM tbl_game_category WHERE par_id IN ('$parid')"; 
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
		$sql = "SELECT isactive FROM tbl_game_category WHERE id =$id";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		if($objdata->Numrows()>0) {
			$r = $objdata->FetchArray();
			return $r[0];
		}
		return '';
	}
	function ActiveOnce($catid){
		if($this->isActiveID($catid)==1) {
			$child = $this->getChildID($catid);
			if($child!='')
				$catid.="','".$child;
			$sql="UPDATE `tbl_game_category` SET `isactive` = 0 WHERE `id` in ('$catid')";
		}
		else 
			$sql="UPDATE `tbl_game_category` SET `isactive` = IF(isactive=1,0,1) WHERE `id` in ('$catid')";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		return $this->result;
	}
	function Publish($catid){
		$sql="UPDATE `tbl_game_category` SET `isactive` = \"1\" WHERE `id` in ('$catid')";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		return $this->result;
	}
	function UnPublish($catid){
		$child = $this->getChildID($catid);
		if($child!='')
			$catid.="','".$child;
		$sql="UPDATE `tbl_game_category` SET `isactive` = \"0\" WHERE `id` in ('$catid')";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		return $this->result;
	}
	
	function Delete($catid){
		$objdata = new CLS_MYSQL; 
		$objdata->Query("BEGIN");
		$sql = "SELECT * FROM `tbl_game_category` WHERE `par_id` = '$catid'";
		$objdata->Query($sql);	
		while($rows=$objdata->FetchArray())
		{
			$id = $rows["id"];	
			$this->Delete($id);
		}
		$sql="DELETE FROM `tbl_game_category` WHERE `id` in ('$catid')";
		//echo $sql."<br />";
		$result=$objdata->Query($sql);
		if(!$result)
		{return ;} 
		//nead change ...
		/*$sql ="UPDATE `tbl_content` SET `cat_id`='0' WHERE  `cat_id` = $catid";
		$objdata->Query($sql);
		$sql="DELETE FROM `tbl_category_text` WHERE `cat_id` in ('$catid')";
		$result1=$objdata->Query($sql);*/
		if($result) {
			$objdata->Query("COMMIT");
			return $result;
		}
		else
			$objdata->Query("ROLLBACK");	
	}
	
	function Orders($arids,$arods){
		for($i=0;$i<count($arids);$i++)
		{
			$this->Order($arids[$i],$arods[$i]);
		}
	}
	function Order($conid,$order){
			$objdata=new CLS_MYSQL;
			$sql="UPDATE tbl_game_category SET `order`='".$order."' WHERE `id`='".$conid."'";	
			//echo $sql;die();
			$objdata->Query($sql);	
	}
}
?>