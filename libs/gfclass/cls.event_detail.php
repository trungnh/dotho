<?php
	class CLS_EVENT_DETAIL{
		var $event_detail=array(
			"ID"=>"-1",
			"ProID"=>"0",
			"EventID"=>"0",
			"Cur_price"=>"",
			"Old_price"=>"",
			"Quantity"=>"",
			"Start_date"=>"",
			"End_date"=>"",
            "Sales"=>"",
            "Time"=>"",
            "Intro"=>"",
			"Order"=>"0"
		);
		var $result;
		function CLS_EVENT_DETAIL(){
		}
		function __set($proname,$value){
			if(!isset($this->event_detail[$proname]))
			{
				echo ("Can't found $proname members");
				return;
			}
			$this->event_detail[$proname]=$value;
		}
		function __get($proname){
			if(!isset($this->event_detail[$proname]))
			{
				echo ("Can't found $proname member");
				return;
			}
			return $this->event_detail[$proname];// phai tra ve gia tri
		}
		function getProID($proid,$str){
		$sql="SELECT DISTINCT(cata_id) from `view_products` where `pro_id` in ($proid) $str ";
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$id="";
			while($rows=$objdata->FetchArray())
			{
				$id.=$rows["cata_id"].",";	
			}
		return substr($id,0,strlen($id)-1);
		}
		function getProEventID($str,$eventid){
		$sql="SELECT * FROM `tbl_event_detail` where `event_id`='$eventid' $str";
		//echo $sql;
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
		}
		function getProEvent($eventid,$str){
		$sql="SELECT `pro_id` FROM `tbl_event_detail` where `event_id`='$eventid' $str";
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$id="";
			while($rows=$objdata->FetchArray())
			{
				$id.=$rows["pro_id"].",";	
			}
		return substr($id,0,strlen($id)-1);
		}
		function getProByID($id){
			$sql="SELECT *
					FROM tbl_event_detail
					WHERE id_event_detail=\"$id\"";
				//echo $sql;
			$objdata=new CLS_MYSQL;
			$objdata->Query($sql);
			if($objdata->Numrows()>0)
			{
				$rows=$objdata->FetchArray();
				$this->event_detail["ID"]=$rows["id_event_detail"];
				$this->event_detail["ProID"]=$rows["pro_id"];
				$this->event_detail["EventID"]=$rows["event_id"];
				$this->event_detail["Cur_price"]=stripslashes($rows["cur_price"]);
				$this->event_detail["Old_price"]=stripslashes($rows["old_price"]);
				$this->event_detail["Start_date"]=stripslashes($rows["start_date"]);
				$this->event_detail["End_date"]=stripslashes($rows["end_date"]);
				$this->event_detail["Quantity"]=$rows["quantity"];
				$this->event_detail["Order"]=$rows["order"];
                $this->event_detail["Sales"]=$rows["sales"];
                $this->event_detail["Time"]=$rows["time"];
                $this->event_detail["Intro"]=$rows["intro"];
			}
		}
		function getAllList($strwhere=""){
			$sql=" SELECT * 
					FROM tbl_event_detail
					WHERE 1='1' $strwhere";
					//echo $sql;die();
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}
		function getProByCataID($proid){
			$sql="SELECT *
					FROM tbl_event_detail
					WHERE pro_id in('$proid') ";
			//echo $sql; die();
			$objdata=new CLS_MYSQL;
			$objdata->Query($sql);
			if($objdata->Numrows()>0)
			{
				$rows=$objdata->FetchArray();
				$this->event_detail["ID"]=$rows["id_event_detail"];
				$this->event_detail["ProID"]=$rows["pro_id"];
				$this->event_detail["EventID"]=$rows["event_id"];
				$this->event_detail["Cur_price"]=stripslashes($rows["cur_price"]);
				$this->event_detail["Old_price"]=stripslashes($rows["old_price"]);
				$this->event_detail["Start_date"]=stripslashes($rows["start_date"]);
				$this->event_detail["End_date"]=stripslashes($rows["end_date"]);
				$this->event_detail["Quantity"]=$rows["quantity"];
				$this->event_detail["Order"]=$rows["order"];
                $this->event_detail["Sales"]=$rows["sales"];
                $this->event_detail["Time"]=$rows["time"];
                $this->event_detail["Intro"]=$rows["intro"];
				return true;
			}
			else
				return false;
		}
		function getProName($proid) {
			$sql="SELECT name from tbl_products_text where pro_id=$proid";
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
			if($objdata->Numrows()>0) {
				$r=$objdata->FetchArray();
				return $r[0];
			}
		}
		function getEventName($eventid) {
			$sql="SELECT name from tbl_event where id=$eventid";
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
			if($objdata->Numrows()>0) {
				$r=$objdata->FetchArray();
				return $r[0];
			}
		}
		function Numrows(){
			return mysql_num_rows($this->result);
		}
		function Fecth_Array(){
			
			return @mysql_fetch_array($this->result);
		}
	}
?>