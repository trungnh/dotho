<?php
class CLS_USERS{
	var $pro=array(
					  "ID"=>"-1",
					  "UserName"=>"",
					  "Password"=>"",
					  "FirstName"=>"",
					  "LastName"=>"",
					  "Birthday"=>"",
					  "Gender"=>"",
					  "Address"=>"",
					  "Phone"=>"",
					  "Mobile"=>"",
					  "Email"=>"",
					  "Joindate"=>"",
					  "LastLogin"=>"",
					  "Gmember"=>"",
					  "isActive"=>"1",
					  "par_id"=>""
					  );
 	var $num_rows;
	var $result;
	var $par_id = 12;
	var $business = 13;
	function CLS_USERS()
	{
		$this->Joindate=date("Y-m-d h:i:s");
		$this->LastLogin=date("Y-m-d h:i:s");
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro[$proname]))
		{
			echo "Error";
			return;
		}
		$this->pro[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro[$proname]))
		{
			//$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->pro[$proname];
	}
	function LOGIN($user,$pass){
		$flag=true;
		//$user=str_replace(" ","",$user);
		$user=str_replace("'","",$user);
		$pass=md5(sha1(trim($pass)));
		if($user=="" || $pass=="")
			$flag=false;
		
		$sql="SELECT * FROM `tbl_member` WHERE `username`='$user' AND  isactive=1 AND `gmem_id`<>12 "; //echo $sql;die;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			if($rows["password"]!=$pass)
			{
				$flag=false;
			}
		}
		else{
			$flag=false;
		}
		if($flag==true)
		{
			$_SESSION["IGFISLOGIN"]=true;
			$_SESSION["IGFUSERLOGIN"]=$rows["firstname"]." ".$rows["lastname"];
			
			$_SESSION["IGFUSERID"]=$rows["mem_id"];
			$_SESSION["IGFUSERNAME"]=$rows["username"];
			$_SESSION["IGFGROUPUSER"]=$rows["gmem_id"];
			$objlog =  new CLS_LOGIN;
			
			if($objlog->getCurrentLogID($_SESSION["IGFUSERID"])!=0){
				//delete log
				$objlog->deleteLog($objlog->getCurrentLogID($_SESSION["IGFUSERID"]));
			}
			$objlog->saveIp($objlog->getRealIpAddr(),$_SESSION["IGFUSERID"]);
			$_SESSION['IDLOG'] = $objlog->getCurrentLogID($rows["mem_id"]);
			$this->updateLogin($user,1);
		}
		return $flag;
	}
	function isLogin(){
		if(isset($_SESSION["IGFISLOGIN"]))
			$this->autoLogout($_SESSION["IGFUSERLOGIN"]);
		if(isset($_SESSION["IGFISLOGIN"]) && $_SESSION["IGFISLOGIN"]==true)
		{
			$this->updateLogin($_SESSION["IGFUSERLOGIN"],1);
			return true;
		}
		else
			return false;
	}
	function isAdmin() {
		// $_SESSION["IGFGROUPUSER"]=="1": quyen Super Admin
		if(isset($_SESSION["IGFGROUPUSER"]) && $_SESSION["IGFGROUPUSER"]=="1")
		{
			return true;
		}
		return false;
	}
	function LOGOUT(){
		$this->updateLogin($_SESSION["IGFUSERLOGIN"],0);
		$_SESSION["IGFISLOGIN"]=false;
		unset($_SESSION["IGFISLOGIN"]);
		unset($_SESSION["IGFUSERLOGIN"]);
		unset($_SESSION["IGFGROUPUSER"]);
		unset($_SESSION["IGFUSERID"]);
		unset($_SESSION["IGFUSERNAME"]);
	}
	function updateLogin($user,$flag){
		$value="";
		if($flag==1)
			$value=date("Y-m-d h:i:s");
		$sql="UPDATE `tbl_member` SET `lastLogin`='$value' WHERE `username`='$user'";
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
	}
	function autoLogout($user){
		if(!isset($user)||$user=="")
			return;
		$sql="SELECT `lastlogin` FROM `tbl_member` WHERE `username`=\"$user\" ";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$rows=$objdata->FetchArray();
		if($rows["lastlogin"]=="")
			return;
		$s=date("i")-date("i",strtotime($rows["lastlogin"]));
		//echo ($s);
		if($s>=300 || $s<-300){
			$this->LOGOUT();
			echo "<p align=\"center\">Hệ thống tự động đăng xuất sau 60 phút. Bạn vui lòng đăng nhập lại.</p>";
		}
		return;
	}
	function getMemberByID($memid){
		$sql="SELECT * FROM `tbl_member` WHERE `mem_id`=\"$memid\" ";
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->pro["ID"]=$rows["mem_id"];
			$this->pro["UserName"]=$rows["username"];
			$this->pro["Password"]=$rows["password"];
			$this->pro["FirstName"]=$rows["firstname"];
			$this->pro["LastName"]=$rows["lastname"];
			$this->pro["Birthday"]=$rows["birthday"];
			$this->pro["Gender"]=$rows["gender"];
			$this->pro["Address"]=$rows["address"];
			$this->pro["Phone"]=$rows["phone"];
			$this->pro["Mobile"]=$rows["mobile"];
			$this->pro["Email"]=$rows["email"];
			$this->pro["Joindate"]=date("d/m/Y",strtotime($rows["joindate"]));
			$this->pro["LastLogin"]=$rows["lastlogin"];
			$this->pro["Gmember"]=$rows["gmem_id"];
			$this->pro["isActive"]=$rows["isactive"];
			$this->pro["par_id"]=$rows["par_id"];
		}
	}
	function getAllList($where=""){
		$sql="SELECT * FROM `tbl_member` ".$where;
//		echo $sql."<br />";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$this->num_rows=$objdata->Numrows();
	}
	function checkUserExists($user){
		$sql = "select * from tbl_member where username ='$user'";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()>0) {
			return true;
		}
		return false;
	}
	function listTableMember($strwhere="",$page){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql = "SELECT * FROM `tbl_member` ".$strwhere ." LIMIT $star,$leng";
	   $objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		//echo $sql."<br /> $strwhere <br />";
		$i=0;
		while($rows=$objdata->FetchArray())
		{	$i++;
			$memid=$rows["mem_id"];
			$username=$rows["username"];
			$name=$rows["lastname"]." ".$rows["firstname"];
			if($rows["gender"]==0) $gender="Nam";
			else $gender="Nữ";
			$objmem = new CLS_GUSER();
			$gmember=$objmem->getName($rows["gmem_id"]); 
			$email=$rows["email"];
			$par_id = $rows["par_id"];
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" onclick=\"docheckonce('checkid');\" value=\"$memid\" />";
			echo "</label></td>";
			if($rows["gmem_id"]==$this->par_id && $par_id !=0 )
				echo "<td width=\"100\"><a href=\"index.php?com=".COMS."&amp;task=edit&amp;memid=$memid&amp;mode=child\">$username</a></td>";
			else
				echo "<td width=\"100\"><a href=\"index.php?com=".COMS."&amp;task=edit&amp;memid=$memid\">$username</a></td>";
			if($rows["gmem_id"]==$this->par_id && $par_id !=0 )
				echo "<td nowrap=\"nowrap\"><a href=\"index.php?com=".COMS."&amp;task=edit&amp;memid=$memid&amp;mode=child\">$name</a></td>";
			else
				echo "<td nowrap=\"nowrap\"><a href=\"index.php?com=".COMS."&amp;task=edit&amp;memid=$memid\">$name</a></td>";
			
			echo "<td nowrap=\"nowrap\">$email</td>";
			if($this->isAdmin()==true) {
				echo "<td align=\"center\"><a href=\"index.php?com=".COMS."&amp;task=changepass&amp;memid=$memid\">Đổi</a></td>";
				if($rows["gmem_id"]!=$this->par_id)
					echo "<td nowrap=\"nowrap\">$gmember</td>";
				echo "<td width=\"50\" align=\"center\">";
				echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;memid=$memid\">";
				showIconFun('publish',$rows["isactive"]);
				echo "</a>";
				
				echo "</td>";
				echo "<td width=\"50\" align=\"center\">";
				if($rows["gmem_id"]==$this->par_id && $par_id !=0 )
					echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;memid=$memid&amp;mode=child\">";
				else
					echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;memid=$memid\">";
				showIconFun('edit','');
				echo "</a>";
				
				echo "</td>";
				echo "<td width=\"50\" align=\"center\">";
				
				echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;memid=$memid')\">";
				showIconFun('delete','');
				echo "</a>";
				echo "</td>";
			}
		  	echo "</tr>";
		}
	}
	function Numrows() { 
		return $this->num_rows;
	}
	function Add_new(){
		echo "<script language=\"javascript\">alert($this->child]);</script>";
		$sql="INSERT INTO `tbl_member` (`username`,`password`,`firstname`,`lastname`,`birthday`,`gender`,`address`,`phone`,`mobile`,`email`,`joindate`,`gmem_id`,`isactive`,`par_id`) VALUES ";
		$sql.=" (\"".$this->pro["UserName"]."\",\"".md5(sha1(trim($this->pro["Password"])))."\",\"".$this->pro["FirstName"]."\",\"";
		$sql.=$this->pro["LastName"]."\",\"".$this->pro["Birthday"]."\",\"".$this->pro["Gender"]."\",\"".$this->pro["Address"]."\",\"";
		$sql.=$this->pro["Phone"]."\",\"".$this->pro["Mobile"]."\",\"".$this->pro["Email"]."\",\"";
		$sql.=$this->pro["Joindate"]."\",\"".$this->pro["Gmember"]."\",\"".$this->pro["isActive"]."\",\"".$this->child."\") ";
		
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
		return $this->result;
	}

	function Update(){		 
		$sql="UPDATE `tbl_member` SET `username`=\"".$this->pro["UserName"]."\",`firstname`=\"".$this->pro["FirstName"]."\",`lastname`=\"".$this->pro["LastName"]."\",`birthday`=\"".$this->pro["Birthday"]."\",`gender`=\"".$this->pro["Gender"]."\",`address`=\"".$this->pro["Address"]."\",`phone`=\"".$this->pro["Phone"]."\",`mobile`=\"".$this->pro["Mobile"]."\",`email`=\"".$this->pro["Email"]."\",`gmem_id`=\"".$this->pro["Gmember"]."\",`isactive`=\"".$this->pro["isActive"]."\" ";
		$sql.=" WHERE `mem_id`=\"".$this->pro["ID"]."\"";
		//echo $sql;die;
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
		return $this->result;
	}
	function ComparePass($user,$pass) {
		$sql="SELECT `password` FROM `tbl_member` WHERE `username`='$user'";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()>0) {
			$r = $objdata->FetchArray();
			if($r[0]==$pass)
				return true;
		}
		else 
			return false;
	}
	function ChangePass_User($user,$newpass) {
		$sql="UPDATE `tbl_member` SET `password`='".md5(sha1(trim($newpass)))."'";
		$sql.=" WHERE username='$user'"; 
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function ChangePass(){
		$sql="UPDATE `tbl_member` SET `password`='".md5(sha1(trim($this->pro["Password"])))."'";
		$sql.=" WHERE `mem_id`=\"".$this->pro["ID"]."\"";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
	}
	function ActiveOnce($memid){
		$sql="UPDATE `tbl_member` SET `isactive` = IF(isactive=1,0,1) WHERE `mem_id` in ('$memid')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function Publish($memid){
		$sql="UPDATE `tbl_member` SET `isactive` = \"1\" WHERE `mem_id` in ('$memid')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function UnPublish($memid){
		$sql="UPDATE `tbl_member` SET `isactive` = \"0\" WHERE `mem_id` in ('$memid')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function Delete($memid){
		$sql="DELETE FROM `tbl_member` WHERE `mem_id` in ('$memid')";
		
		
		$sql="DELETE FROM `tbl_member` WHERE `mem_id` in ('$memid')";
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
		return $this->result;
	}
	function isParent($memid){
		$sql="SELECT `gmem_id` FROM `tbl_member` WHERE `mem_id`='$memid'";
		$objdata=new CLS_MYSQL();
		if($objdata->Numrows()>0) {
			$r = $objdata->FetchArray();
				if($r['gmem_id']==$this->par_id) return true;
		}
		return false;
	}
	function getUserNameById($memid){
		$sql="SELECT `username` FROM `tbl_member` WHERE `mem_id`='$memid'";
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()>0){
			$r = $objdata->FetchArray();
				return $r[0];
		}else{
			return $objdata->Numrows();
		}
	}
}
?>