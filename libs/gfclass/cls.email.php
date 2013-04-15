<?php
	class CLS_EMAIL{
		var $pro_event=array(
			"ID"=>"-1",
			"Email"=>"" // khon co day , o day
		);
		var $result;
		function CLS_EMAIL(){
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
		function getEmailByID($id){
			$sql="SELECT *
					FROM tbl_email
					WHERE id=\"$id\" ";
			$objdata=new CLS_MYSQL;
			$objdata->Query($sql);
			if($objdata->Numrows()>0)
			{
				$rows=$objdata->FetchArray();
				$this->pro_event["ID"]=$rows["id"];
				$this->pro_event["Email"]=$rows["email"];
			}
		}
		function getAllList($strwhere=""){
			$sql=" SELECT * FROM tbl_email $strwhere";
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}
		function Numrows(){
			return mysql_num_rows($this->result);
		}
		function FecthArray(){
			
			return @mysql_fetch_array($this->result);
		}
        	function Add_new(){
			$sql="INSERT INTO tbl_email (`email`) VALUES ";
			$sql.="('".addslashes($this->pro_event["Email"])."')";
			//echo $sql; die();
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		
	}
?>