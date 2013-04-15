<?php
class CLS_LANGUAGE{
	var $pro_name=array("ID"=>"-1",
						"_Code"=>"",
						"_Name"=>"",
						"_Flag"=>"",
						"_Site"=>"front_end",
						"isDefault"=>"0",
						"isActive"=>"");
	var $result;
	function __set($proname,$value){
		if(!isset($this->pro_name[$proname])){
			echo "$proname isn't member of CLS_LANGUAGE";
			return;
		}
		$this->pro_name[$proname]=$value;
	}
	function __get($proname){
		if(!isset($this->pro_name[$proname])){
			echo "$proname isn't member of CLS_LANGUAGE";
			return;
		}
		return $this->pro_name[$proname];
	}
	function getLagByID($lagid){
		$sql="SELECT * FROM `tbl_language` WHERE `lag_id`='$lagid'";	
		$objdata=new CLS_MYSQL;		
		$objdata->Query($sql);
		if($objdata->Numrows()==1){
			$rows=$objdata->FetchArray();
			$this->pro_name["ID"]=$rows["lag_id"];
			$this->pro_name["_Code"]=$rows["code"];
			$this->pro_name["_Name"]=$rows["name"];
			$this->pro_name["_Flag"]=$rows["flag"];
			$this->pro_name["_Site"]=$rows["site"];
			$this->pro_name["isDefault"]=$rows["isdefault"];
			$this->pro_name["isActive"]=$rows["isactive"];
		}
		else{
			return false;
		}
	}
	function getList($strwhere=""){
		$sql="SELECT * FROM `tbl_language` ".$strwhere;
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
		
	}
	function Numrows(){
		if(@mysql_num_rows($this->result)>0)
			return @mysql_num_rows($this->result);
		else 
			return 0;
	}
	function FetchArray(){
		return @mysql_fetch_array($this->result);
	}
	function setCookie_LagID($lagid,$site){
		$value=$lagid;	
	    if (!isset($_COOKIE["COOKIE_LAG_ID_".$site])) 
			setcookie("COOKIE_LAG_ID_".$site,$lagid, time()+3600*24*30);	
	}
	function getCookie_LagID($site){
		$lagid="";
		if(isset($_COOKIE["COOKIE_LAG_ID_".$site]))
			$lagid=$_COOKIE["COOKIE_LAG_ID_".$site];
		return $lagid;
	}
	function setDefault($lagid,$site){
		$objdata=new CLS_MYSQL;
		// check lang
		$flag=false;
		$sql="SELECT * FROM `tbl_language` WHERE `isactive`='1' AND `lag_id`='$lagid'";
		$objdata->Query($sql);
		if($objdata->Numrows()==1){
			$flag=true;
		}
		// set dèault
		if($flag==true){
			$sql="UPDATE `tbl_language` SET `isdefault`=0 WHERE `isactive`='1' AND `site`='$site'";
			$objdata->Query($sql);
			$sql="UPDATE `tbl_language` SET `isdefault`=1 WHERE `lag_id`='$lagid'";
			$objdata->Query($sql);
			return true;
		}else{
			return false;
		}
	}
	function getDefault($site="front_end"){
		$objdata=new CLS_MYSQL;
		$sql="SELECT `lag_id` FROM `tbl_language` WHERE `isactive`='1' AND `isdefault`='1' AND `site`='$site'";
		$objdata->Query($sql);
		$rows=$objdata->FetchArray();
		return $rows["lag_id"];
	}
	function curent_lang($site="front_end"){
		$lagid="";
		if($this->getCookie_LagID($site)!=""){
			$lagid=$this->getCookie_LagID($site);
		}
		else{
			$lagid=$this->getDefault($site);
		}
		$this->setCookie_LagID($lagid,$site);
		$this->getLagByID($lagid);
		return $lagid;
	}
	function ActiveOnce($lagid){
		$sql="UPDATE `tbl_language` SET `isactive` = IF(isactive=1,0,1) WHERE `lag_id` in ('$lagid')";
		$objdata=new CLS_MYSQL;
		return $objdata->Query($sql);
	}
	function Add_new(){
		$sql="INSERT INTO `tbl_language` (`code`,`name`,`flag`,`site`,`isactive`) VALUES ('".$this->pro_name["_Code"]."','".$this->pro_name["_Name"]."','".$this->pro_name["_Code"].".png','".$this->pro_name["_Site"]."','".$this->pro_name["isActive"]."')";
		$objdata=new CLS_MYSQL;
		$this->result = $objdata->Query($sql);
		return $this->result;	
	}
	function Update(){
		$sql="UPDATE `tbl_language` SET `code`='".$this->pro_name["_Code"]."', `name`='".$this->pro_name["_Name"]."', 
			`flag`='".$this->pro_name["_Code"].".png', `site`='".$this->pro_name["_Site"]."', `isactive`='".$this->pro_name["isActive"]."' WHERE lag_id='".$this->pro_name["ID"]."'";
		$objdata=new CLS_MYSQL;
		$this->result = $objdata->Query($sql);
		return $this->result;
	}
	function Delete(){
		$sql="DELETE FROM `tbl_language` WHERE lag_id='".$this->pro_name["ID"]."'";
		$objdata=new CLS_MYSQL;
		$this->result = $objdata->Query($sql);
		return $this->result;
	}
}
?>