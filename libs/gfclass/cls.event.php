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
		function listMenuTopEvent($strwhere)
	{
		$sql="SELECT * FROM tbl_event WHERE `isactive`=\"1\" $strwhere ";
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$i=0;
		$str="";
		if($objdata->Numrows()<=0) return;
		while($rows=$objdata->FetchArray())
		{
			$i++;
			if($i==1)
				$style="frist";
			else
				$style="";
			$id=$rows["id"];
			$name=$rows["name"];
			$icon='<img src="'.WEBSITE.$rows["icon"].'" height="23">';
			$str.='<a href="'.WEBSITE.'khuyenmai/'.$id.'/'.stripUnicode($name).'.html" title="'.$name.'">'.$icon.$name.'</a>';
		}
		return $str;
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
		function Numrows(){
			return mysql_num_rows($this->result);
		}
		function FecthArray(){
			
			return @mysql_fetch_array($this->result);
		}
		
	}
?>