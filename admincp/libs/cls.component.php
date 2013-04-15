<?php
class CLS_COMS{
	var $pro_com=array(
					  "ID"=>"-1",
					  "Code"=>"default",
					  "Name"=>"default",
					  "Desc"=>"",
					  "Site"=>"",
					  "isActive"=>1
					  );
	var $result;
	function CLS_COMS()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_com[$proname]))
		{
			echo "Error";
			return;
		}
		$this->pro_com[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_com[$proname]))
		{
			$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->pro_com[$proname];
	}
	function getComByID($comid){
		$sql="SELECT * FROM `tbl_component` WHERE `com_id`='$comid' ";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->pro_com["ID"]=$rows["com_id"];
			$this->pro_com["Code"]=$rows["code"];
			$this->pro_com["Name"]=$rows["name"];
			$this->pro_com["Desc"]=$rows["desc"];
			$this->pro_com["Site"]=$rows["site"];
			$this->pro_com["isActive"]=$rows["isactive"];
		}
	}
	function getList($where=""){
		$sql="SELECT * FROM `tbl_component` ".$where;
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
	}
	
	function getListCom($type)
	{
		$this->getList(" WHERE `isactive`='1'");
		if($this->Numrows()<=0)
			return;
		$str="";
		while($rows=$objdata->FetchArray())
		{
			if($type=="list")
			$str.="<li>".$rows["name"]."</li>";
			else if($type=="option")
			$str.="<option value=\"".$rows["com_id"]."\">".$rows["name"]."</option>";
			else 
			$str.=$rows["name"];
		}
		return $str;
	}
	function listTableCom($strwhere="",$page){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM `tbl_component` ".$strwhere ." LIMIT $star,$leng";
		//echo $sql; exit();
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		$i=0;
		while($rows=$objdata->FetchArray())
		{	$i++;
			$comid=$rows["com_id"];$code=$rows["code"];$name=Substring($rows["name"],0,10);$desc=$rows["desc"];
			$site=$rows["site"];
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" onclick=\"docheckonce('checkid');\" value=\"$comid\" />";
			echo "</label></td>";
			echo "<td width=\"75\">$code</td>";
			echo "<td>$name</td>";
			echo "<td>$desc &nbsp;</td>";
			echo "<td width=\"50\" align=\"center\">$site &nbsp;</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=components&amp;task=active&amp;comid=$comid\">";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=components&amp;task=edit&amp;comid=$comid\">";
			showIconFun('edit','');
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;comid=".$comid."')\">";
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
		$sql="INSERT INTO `tbl_component`(`code`,`name`,`desc`,`site`,`isactive`) VALUES ";
		$sql.=" ('".$this->pro_com["Code"]."','".$this->pro_com["Name"]."','".$this->pro_com["Desc"]."','".$this->pro_com["Site"]."','".$this->pro_com["isActive"]."') ";
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
		return $this->result;
	}
	function Update(){
		$sql="UPDATE `tbl_component` SET `code`='".$this->pro_com["Code"]."',`name`='".$this->pro_com["Name"]."',`desc`='".$this->pro_com["Desc"]."',`site`='".$this->pro_com["Site"]."',`isactive`='".$this->pro_com["isActive"]."' ";
		$sql.=" WHERE `com_id`='".$this->pro_com["ID"]."'";
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
		return $this->result;
	}
	function ActiveOnce($comids){
		$sql="UPDATE `tbl_component` SET `isactive` = IF(isactive=1,0,1) WHERE `com_id` in ('$comids')";
		//echo $sql; exit();
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
		return $this->result;
	}
	function Publish($comids){
		$sql="UPDATE `tbl_component` SET `isactive` = '1' WHERE `com_id` in ('$comids')";
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
		return $this->result;
	}
	function UnPublish($comids){
		$sql="UPDATE `tbl_component` SET `isactive` = '0' WHERE `com_id` in ('$comids')";
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
		return $this->result;
	}
	function Delete($comids){
		$sql="DELETE FROM `tbl_component` WHERE `com_id` in ('$comids')";
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
		return $this->result;
	}
}
?>