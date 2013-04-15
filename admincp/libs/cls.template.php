<?php
class CLS_TEMPLATE{
	var $pro_tem=array(
					  "ID"=>"1",
					  "Name"=>"default",
					  "Desc"=>"",
					  "Autho"=>"GF-TEAM",
					  "Email"=>"contact@glowfuture.com",
					  "isDefaul"=>1,
					  "isActive"=>1
					  );
	function CLS_TEMPLATE()
	{
		$this->Load_config_xml();
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_tem[$proname]))
		{
			return;
		}
		$this->pro_tem[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_tem[$proname]))
		{
			//$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->pro_tem[$proname];
	}
	function get_Parameter($name)
	{
	}
	function Load_Extension(){
		define("EDIT_FULL_PATH",EDI_PATH."innovar/scripts/innovaeditor.js");
	}
	// load defaut template
	function Load_defaul_tem($site='site'){
		$sql="SELECT * FROM `tbl_template` WHERE `isactive`=1 AND `site`='$site' AND`isdefault`=1";
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->query($sql);
		$rows=$objdata->FetchArray();
		$this->pro_tem["ID"]=$rows["tem_id"];
		$this->pro_tem["Name"]=$rows["name"];
		$this->pro_tem["Desc"]=$rows["desc"];
		$this->pro_tem["Author"]=$rows["author"];
		$this->pro_tem["Author_Email"]=$rows["author_email"];
		$this->pro_tem["Author_Site"]=$rows["author_site"];
		$this->pro_tem["isDefaul"]=$rows["isdefault"];
		$this->pro_tem["isActive"]=$rows["isactive"];
	}
	function Load_lang_default(){
		define("CURENT_LANG","vi");
		include_once(LAG_PATH.CURENT_LANG."/general.php");
	}
	function WapperTem(){
		if($this->error())
			return;
		include_once(THIS_TEM_ADMIN_PATH."home.php");
	}
	// Test template
	function error(){
		if(!is_file(THIS_TEM_ADMIN_PATH."template.xml"))
		{
			echo "template.xml isn't exist";
			return false;
		}
		if(!is_file(THIS_TEM_ADMIN_PATH."home.php"))
		{
			echo "home.php isn't exist";
			return false;
		}
	}
	// Check Module
	function isModule($position){
		$sql="SELECT * FROM tbl_modules WHERE `isactive`=1 AND `position`='$position' ORDER BY `order`,`title`";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		if($objdata->Numrows()>0)
			return true;
		else 
			return false;
	}
	// Load Module
	function loadModule($position,$site="site"){
		$position=trim($position);
		$site=trim($site);
		$sql="SELECT mod_id,type FROM tbl_modules WHERE `isactive`=1 AND `position`='$position'";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		while($rows=$objdata->FetchArray())
		{
			if(is_file(MOD_PATH."mod_".trim($rows["type"])."/layout.php")==true)			
				include(MOD_PATH."mod_".trim($rows["type"])."/layout.php");
			else
				echo "<br> Module isn't exist!";
		}
	}
	function getFullURL(){
		echo "<br>HostName:". $_SERVER['HTTP_HOST'];
		echo "<br>Rquest:". $_SERVER['QUERY_STRING'];
		echo "<br>Rquest URI:". $_SERVER['REQUEST_URI'];
		echo "<br>Script file:". $_SERVER['SCRIPT_FILENAME'];
	}
	// isfronpage
	function isfronpage(){
		if($_SERVER['QUERY_STRING']=="")
			return true;
		return false;
	}
	// iscomponent
	function isComponent($comname){
	}

	/*-------------------------------------------------------*/
	// load xml
	function Load_config_xml(){
		
	}
	// set active template
	function SetActive($temid)
	{
		$sql="UPDATE `tbl_template SET `isactive`=1 WHERE `tem_id`=$temid";
		$objdata=new CLS_MYSQL();
		$objdata->query($sql);
		return true;
	}
	// set default template
	function SetDefault($temid)
	{
		$sql="UPDATE `tbl_template SET `isdefault`=0";
		$objdata->query($sql);
		$sql="UPDATE `tbl_template SET `isdefault`=1 WHERE `tem_id`=$temid";
		$objdata=new CLS_MYSQL();
		$objdata->query($sql);
		return true;
	}
	function Addnew(){
		
	}
	function Update(){
		
	}
}
?>