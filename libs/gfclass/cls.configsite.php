<?php
class CLS_CONFIG extends CLS_MYSQL {
	var $pro_conf=array(
					  "ID"=>"-1",
					  "Title"=>"",
					  "CompanyName"=>"",
					  "Intro"=>"",
					  "Address"=>"",
					  "Phone"=>"",
					  "Fax"=>"",
					  "Email"=>"",
					  "Meta_keyword"=>"",
					  "Meta_descript"=>"",
					  "Langid"=>"0",
					  "Website"=>"",
					  "Banner"=>"",
					  "Logo"=>"",
					  "Contact"=>"",
					  "Footer"=>"",
					  "Temid"=>"0"
					  );
	function CLS_CONFIG()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_conf[$proname]))
		{
			echo "Error";
			return;
		}
		$this->pro_conf[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_conf[$proname]))
		{
			$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->pro_conf[$proname];
	}
	
	function show(){
		$sql="SELECT * FROM `tbl_configsite` WHERE `config_id`=1";
		$objdata = new CLS_MYSQL();
		$objdata->Query($sql); 
		return $objdata;
	}
}
?>