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
					  "Langid"=>"",
					  "Website"=>"",
					  "Banner"=>"",
					  "Logo"=>"",
					  "Contact"=>"",
					  "Footer"=>"",
					  "Temid"=>"",
					  "Nickyahoo"=>"",
					  "Nameyahoo"=>""
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
	
	function Update(){
		$sql = "UPDATE tbl_configsite SET ";
		$sql .="title='".$this->pro_conf["Title"]."',";
		$sql .="company_name='".$this->pro_conf["CompanyName"]."',";
		$sql .="intro='".$this->pro_conf["Intro"]."',";
		$sql .="address='".$this->pro_conf["Address"]."',";
		$sql .="phone='".$this->pro_conf["Phone"]."',";
		$sql .="fax='".$this->pro_conf["Fax"]."',";
		$sql .="email='".$this->pro_conf["Email"]."',";
		
		$sql .="meta_keyword='".$this->pro_conf["Meta_keyword"]."',";
		$sql .="meta_descript='".$this->pro_conf["Meta_descript"]."',";
		
		$sql .="lang_id='".$this->pro_conf["Langid"]."',";
		
		$sql .="website='".$this->pro_conf["Website"]."',";
		$sql .="banner='".$this->pro_conf["Banner"]."',";
		$sql .="contact='".$this->pro_conf["Contact"]."',";
		$sql .="logo='".$this->pro_conf["Logo"]."',";
		$sql .="tem_id='".$this->pro_conf["Temid"]."',";
		$sql .="nick_yahoo='".$this->pro_conf["Nickyahoo"]."',";
		$sql .="name_yahoo='".$this->pro_conf["Nameyahoo"]."',";
		$sql .="footer='".$this->pro_conf["Footer"]."' WHERE config_id=1";

		//echo $sql; die;
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
}
?>