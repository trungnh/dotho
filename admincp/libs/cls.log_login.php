<?php
class CLS_LOGIN extends CLS_MYSQL{
	var $pro_log=array(
					  "	id"=>"-1",
					  "user_id"=>"0",
					  "ip_login"=>"",
					  "login_time"=>"",
					  "logout_time"=>"",
					  "loglogin"=>""
					  );
	function CLS_LOGIN()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_log[$proname]))
		{
			echo "Error";
			return;
		}
		$this->pro_log[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_log[$proname]))
		{
			$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->pro_log[$proname];
	}
	
	function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		//echo $ip;
		return $ip;
	}
	
	function saveIp($ip,$id_user){
		$sql= "INSERT INTO `tbl_login` ( `id` , `user_id` , `ip_login` , `login_time` , `logout_time` , `loglogin`) VALUES ( NULL , '$id_user', '$ip', NOW(), '', '' )";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		//echo $sql;
	}
	
	function saveTimeLogout($id_user){
		$sql= "UPDATE `tbl_login` SET logout_time`='NOW()'  WHERE `user_id` like '$id_user' and `logout_time` like ''";
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
	}
	
	function deleteLog($id){
		$sql= "DELETE FROM `tbl_login` WHERE `tbl_login`.`id` = $id";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
	}
	
	function getCurrentLogID($id_user){
		$sql ="SELECT * FROM `tbl_login` WHERE `user_id` = '$id_user' ORDER BY  `id` DESC LIMIT 0 , 1";
		//echo $sql."<br />";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			//echo $rows["id"]."<br />";
			return $rows["id"];		
		}else{
			return 0;
		}
	}
	
	function updateTimeLogin($id){
		$sql = "UPDATE `tbl_login` SET `login_time` = NOW()  WHERE `tbl_login`.`id` =$id";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
	}
	
	function updateTimeLogout(){
		$sql = "UPDATE `tbl_login` SET `logout_time` = NOW() WHERE NOW() > (`login_time` + INTERVAL 10 MINUTE)";
		//$sql = "UPDATE `tbl_login` SET `logout_time` = NOW() WHERE NOW() > (`login_time` + INTERVAL 10 Second)";
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		//echo $sql;
	}
	
	function checkTimeExpired($userID){
		$sql = "SELECT * FROM `tbl_login` WHERE `user_id` = '$userID' AND logout_time = '0000-00-00 00:00:00'";
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		
		if($objdata->Numrows()>0)
		{
			return false;
		}
		return true;
	}
	
	function checkAllLogin(){
		$sql = "";
	}
	function getAllList($where=""){
		$sql="SELECT * FROM `tbl_login` ".$where;
//		echo $sql."<br />";
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
		
		$result = mysql_query($sql);
		$rows=$objdata->FetchArray();
		return $rows;
	}
	
}
$objlog=new CLS_LOGIN();
?>