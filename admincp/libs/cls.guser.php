<?php
class CLS_GUSER extends CLS_MYSQL{
	var $pro_cate=array(
					  "ID"=>"-1",
					  "ParID"=>"0",
					  "Name"=>"",
					  "Intro"=>"",
					  "isAdmin"=>"1",
					  "isActive"=>1
					  );
	function CLS_GUSER()
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
	function getCateByID($id){
		$sql="SELECT * FROM `tbl_gmember` WHERE `gmem_id`=\"$id\" ";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->pro_cate["ID"]=$rows["gmem_id"];
			$this->pro_cate["ParID"]=$rows["par_id"];
			$this->pro_cate["Name"]=stripslashes($rows["name"]);
			$this->pro_cate["Intro"]=stripslashes(uncodeHTML($rows["intro"]));
			$this->pro_cate["isAdmin"]=$rows["isadmin"];
			$this->pro_cate["isActive"]=$rows["isactive"];
		}
	}
	function getAllList($where=""){
		$sql="SELECT * FROM `tbl_gmember` ".$where;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
	}
	function getCateByParent($par_id){
		$sql="SELECT * FROM `tbl_gmember` WHERE `par_id`=\"$par_id\"";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
	}
	function getName($id){
		$sql="SELECT name FROM `tbl_gmember` WHERE `gmem_id`=".$id;
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()>0){
			$r=$objdata->FetchArray();
			return $r[0];
		}
		return '';
	}
	function haveChild($parid) {
		$sql = "SELECT gmem_id FROM tbl_gmember WHERE par_id IN ('$parid')"; 
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		
		if($objdata->Numrows()>0) {
			return $objdata->Numrows();
		}
		return 0;
	}
	function getName_ID($minus_id=0,$curid=0,$par_id=0,$level=''){
		$sql="SELECT name,gmem_id FROM `tbl_gmember` WHERE `par_id`=".$par_id." AND gmem_id!=$minus_id ORDER BY `gmem_id` ASC";
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()>0){
			while($r=$objdata->FetchArray()) {
				$style='';
				if($par_id==0) $style = ' style="background-color:#eeeeee;"';
				
				if($r["gmem_id"]==$curid) 
					echo '<option value="'.$r["gmem_id"].'" selected="selected" '.$style.'>'.$level.$r["name"].'</option>';
				else 
					echo '<option value="'.$r["gmem_id"].'" '.$style.'>'.$level.$r["name"].'</option>';
				
				$this->getName_ID($minus_id,$curid,$r["gmem_id"],$level."..... ");
			}
		}
	}
	
	function getListCate($parid,$level)
	{
		$sql="SELECT * FROM `tbl_gmember` WHERE `par_id`=\"$parid\" AND `isactive`=\"1\" ";
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
			$id=$rows["gmem_id"];
			$name=$rows["name"];
			echo "<option value=\"$id\">$char$name</option>";
			$this->getListCate($id,$level++);
		}
	}
	function listTableGUser($strwhere="",$page,$parid,$level){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM `tbl_gmember` WHERE `par_id`=\"$parid\" ".$strwhere ." LIMIT $star,$leng";
		$objdata=new CLS_MYSQL();
		$objuser = new CLS_USERS();
		$objdata->Query($sql);
		$str_space="";
		if($level!=0)
		{
			for($i=1;$i<$level;$i++)
				$str_space.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$str_space.="|--- ";
		}

		$i=0;
		while($rows=$objdata->FetchArray())
		{	$i++;
			$id=$rows["gmem_id"];
			$parid=$rows["par_id"];
			$name=$rows["name"];
			$intro= stripslashes(uncodeHTML($rows["intro"]));
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" onclick=\"docheckonce('checkid');\" value=\"$id\" />";
			echo "</label></td>";
			echo "<td width=\"50\" align=\"center\">$parid</td>";
			echo "<td nowrap=\"nowrap\"><a href=\"index.php?com=".COMS."&amp;task=edit&amp;id=$id\">$str_space$name</a></td>";
			echo "<td nowrap=\"nowrap\">$intro &nbsp;</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;id=$id\">";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;id=$id\">";
			showIconFun('edit','');
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			if($id==$objuser->par_id ||$id==$objuser->business || $id == '1')
				echo "";
			else{
				echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;id=$id')\">";
				showIconFun('delete','');
				echo "</a>";
			}
			echo "</td>";
		  	echo "</tr>";
			
			$this->listTableGUser($strwhere,$page,$id,$level+1);
		}
	}
	
	function getChildID($parid) {
		$sql = "SELECT gmem_id FROM tbl_gmember WHERE par_id IN ('$parid')"; 
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
		$sql = "SELECT isactive FROM tbl_gmember WHERE gmem_id =$id";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		if($objdata->Numrows()>0) {
			$r = $objdata->FetchArray();
			return $r[0];
		}
		return '';
	}
	
	function Numrows() { 
		return parent::Numrows();
	}
	function Add_new(){
		$sql="INSERT INTO `tbl_gmember`(`par_id`,`name`,`intro`,`isadmin`,`isactive`) VALUES ";
		$sql.=" (\"".$this->pro_cate["ParID"]."\",\"".$this->pro_cate["Name"]."\",\"".$this->pro_cate["Intro"]."\",\"".$this->pro_cate["isAdmin"]."\",\"".$this->pro_cate["isActive"]."\") ";
		//echo $sql;die;
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function Update(){
		$sql="UPDATE `tbl_gmember` SET `par_id`=\"".$this->pro_cate["ParID"]."\",`name`=\"".$this->pro_cate["Name"]."\",`intro`=\"".$this->pro_cate["Intro"]."\",`isadmin`=\"".$this->pro_cate["isAdmin"]."\",`isactive`=\"".$this->pro_cate["isActive"]."\" ";
		$sql.=" WHERE `gmem_id`=\"".$this->pro_cate["ID"]."\"";
		//echo $sql;die;
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function ActiveOnce($id){
		if($this->isActiveID($id)==1) {
			$child = $this->getChildID($id);
			if($child!='')
				$id.="','".$child;
			$sql="UPDATE `tbl_gmember` SET `isactive` = 0 WHERE `gmem_id` in ('$id')";
		}
		else 
			$sql="UPDATE `tbl_gmember` SET `isactive` = IF(isactive=1,0,1) WHERE `gmem_id` in ('$id')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function Publish($id){
		$sql="UPDATE `tbl_gmember` SET `isactive` = \"1\" WHERE `gmem_id` in ('$id')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function UnPublish($id){
		$sql="UPDATE `tbl_gmember` SET `isactive` = \"0\" WHERE `gmem_id` in ('$id')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function Delete($id){
		$sql="DELETE FROM `tbl_gmember` WHERE `gmem_id` in ('$id')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
}
?>