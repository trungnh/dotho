<?php
class CLS_CONFIGCONTENT{
	var $pro_menu=array(
					  "ID"=>"-1",
					  "Name"=>"",
					  "Icon"=>"",
					  "ShowName"=>"",
					  "ShowIcon"=>"",
					  "LangID"=>"0",
					  "isActive"=>1
					  );
	var $result;
	var $result1;
	function CLS_CONFIGCONTENT()
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
	function getMenuByID($id){
		$sql="SELECT * FROM `tbl_configcontent` WHERE `id`='$id' ";
		$objdata=new CLS_MYSQL;
		$objdata->query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->pro_menu["ID"]=$rows["id"];
			$this->pro_menu["Name"]=$rows["name"];
			$this->pro_menu["Icon"]=$rows["icon"];
			$this->pro_menu["ShowName"]=$rows["show_name"];
			$this->pro_menu["ShowIcon"]=$rows["show_icon"];
			$this->pro_menu["LangID"]=$rows["lang_id"];
			$this->pro_menu["isActive"]=$rows["isactive"];
		}
	}
	function getList($where=""){
		$sql="SELECT * FROM `tbl_configcontent` ".$where;
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->query($sql);
	}
	function Numrows(){
		if(@mysql_num_rows($this->result)>0)
			return @mysql_num_rows($this->result);
		else 
			return 0;
	}
	function FetchArray() {
		return @mysql_fetch_array($this->result);
	}
}
?>