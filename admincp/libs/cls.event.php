<?php
	class CLS_EVENT{
		var $pro_event=array(
			"ID"=>"-1",
			"Name"=>"",
			"Intro"=>"",
			"Ismenu"=>"",
			"Icon"=>"",
			"isActive"=>"1" // khon co day , o day
		);
		var $result;
		function CLS_EVENT(){
		}
		function __set($proname,$value){
			if(!isset($this->pro_event[$proname]))
			{
				echo ("Can't found $proname members");
				return;
			}
			$this->pro_event[$proname]=$value;
		}
		function __get($proname){
			if(!isset($this->pro_event[$proname]))
			{
				echo ("Can't found $proname member");
				return;
			}
			return $this->pro_event[$proname];// phai tra ve gia tri
		}
		function getProByID($id){
			$sql="SELECT *
					FROM tbl_event
					WHERE id=\"$id\" ";
			$objdata=new CLS_MYSQL;
			$objdata->Query($sql);
			if($objdata->Numrows()>0)
			{
				$rows=$objdata->FetchArray();
				$this->pro_event["ID"]=$rows["id"];
				$this->pro_event["Name"]=$rows["name"];
				$this->pro_event["Intro"]=stripslashes($rows["intro"]);
				$this->pro_event["Ismenu"]=$rows["ismenu"];
				$this->pro_event["Icon"]=$rows["icon"];
				$this->pro_event["isActive"]=$rows["isactive"];
			}
		}
		function getEvent(){
		$sql="SELECT `name`,`id` FROM `tbl_event` where `isactive`='1'";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
			while($rows=$objdata->FetchArray())
			{
				$id=$rows["id"];
				$name=$rows["name"];
				echo "<option value=\"$id\">$name</option>";
			}
		}
		function getAllList($strwhere=""){
			$sql=" SELECT * 
					FROM tbl_event
					WHERE 1=1 $strwhere";
					//echo $sql;die();
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}
		function listTablePro($strwhere=""){
			//$star=($page-1)*MAX_ROWS;
			//$leng=MAX_ROWS;
			$sql="	SELECT * FROM tbl_event WHERE  1=1 $strwhere ORDER BY `id`";
			//echo $sql;
			$objdata=new CLS_MYSQL();
			$objdata->Query($sql);
			$i=0;
			while($rows=$objdata->FetchArray())
			{	$i++;
				$id=$rows["id"];
				$name=$rows["name"];
				$ismenu=$rows["ismenu"];
				$icon=$rows["icon"];
				echo "<tr name=\"trow\">";
				echo "<td width=\"30\" align=\"center\">$i</td>";
				echo "<td width=\"30\" align=\"center\"><label>";
				echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" onclick=\"docheckonce('checkid');\" value=\"$id\" />";
				echo "</label></td>";
				echo "<td width=\"200\"><a class=\"img-pro\" href=\"index.php?com=event&amp;task=edit&amp;eventid=$id\">$name</a></td>";
				echo "<td align=\"center\"><img src=\"../$icon\" width=\"50\" />";
				echo "</td>";
				echo "<td align=\"center\">";
				echo "<a href=\"index.php?com=event&amp;task=ismenu&amp;eventid=$id\">";
				showIconFun('publish',$rows["ismenu"]);
				echo "</a>";
			
				echo "</td>";
				echo "<td align=\"center\">";
			
				echo "<a href=\"index.php?com=event&amp;task=active&amp;eventid=$id\">";
				showIconFun('publish',$rows["isactive"]);
				echo "</a>";
			
				echo "</td>";
				echo "<td align=\"center\">";
			
				echo "<a href=\"index.php?com=event&amp;task=edit&amp;eventid=$id\">";
				showIconFun('edit','');
				echo "</a>";
			
				echo "</td>";
				echo "<td align=\"center\">";
			
				echo "<a href=\"javascript:detele_field('index.php?com=event&amp;task=delete&amp;eventid=$id')\" >";
				showIconFun('delete','');
				echo "</a>";
			
				echo "</td>";
		  		echo "</tr>";
			}
		}
		function Numrows(){
			return mysql_num_rows($this->result);
		}
		function FecthArray(){
			
			return @mysql_fetch_array($this->result);
		}
		function Add_new(){
			$sql="INSERT INTO tbl_event (`name`,`intro`,`ismenu`,`icon`,`isactive`) VALUES ";
			$sql.="('".addslashes($this->pro_event["Name"])."','".$this->pro_event["Intro"]."','".$this->pro_event["Ismenu"]."','".$this->pro_event["Icon"]."','";
			$sql.=$this->pro_event["isActive"]."')";
			//echo $sql; die();
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Update(){
			$sql="UPDATE tbl_event SET   `name`='".$this->pro_event["Name"]."', 
										 `intro`='".$this->pro_event["Intro"]."',
										 `ismenu`='".$this->pro_event["Ismenu"]."',
										 `icon`='".$this->pro_event["Icon"]."',
										 `isactive`='".$this->pro_event["isActive"]."' 
									WHERE `id`='".$this->pro_event["ID"]."'";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Delete($id){
			$sql="DELETE FROM `tbl_event` WHERE `id` in ('$id')";
			$objdata=new CLS_MYSQL;
			$result=$objdata->Query($sql);
		}
		function ActiveOne($id){
			$sql="UPDATE `tbl_event` SET `isactive` = IF(isactive=1,0,1) WHERE `id` in 	('$id')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function IsmenuOne($id){
			$sql="UPDATE `tbl_event` SET `ismenu` = IF(ismenu=1,0,1) WHERE `id` in ('$id')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Publish($id){
			$sql="UPDATE `tbl_event` SET `isactive` = \"1\" WHERE `id` in ('$id')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function UnPublish($id){
			$sql="UPDATE `tbl_event` SET `isactive` = \"0\" WHERE `id` in ('$id')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
	}
?>