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
            "Sales"=>"sales",
            "Time"=>"time",
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
		function listTablePro($strwhere="",$page){
			$star=($page-1)*MAX_ROWS;
			$leng=MAX_ROWS;
			$sql="	SELECT * 
				FROM tbl_event_detail inner join `tbl_event` on `tbl_event`.`id`=`tbl_event_detail`.`event_id`
				WHERE 1='1' $strwhere ORDER BY `order` LIMIT $star,$leng";
			//echo $sql;
			$objdata=new CLS_MYSQL();
			$objdata->Query($sql);
			$i=0;
			while($rows=$objdata->FetchArray())
			{	$i++;
				$id=$rows["id_event_detail"];
				$proid=$this->getProName($rows["pro_id"]);
				$eventid=$this->getEventName($rows["event_id"]);

				$startdate=$rows["start_date"];
				$enddate=$rows["end_date"];
				$order=$rows["order"];
				$price = $rows["cur_price"];
				$quantity=$rows["quantity"];
				echo "<tr name=\"trow\">";
				echo "<td width=\"30\" align=\"center\">$i</td>";
				echo "<td width=\"30\" align=\"center\"><label>";
				echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" 	 onclick=\"docheckonce('checkid');\" value=\"$id\" />";
				echo "</label></td>";
				echo "<td width=\"300\">$proid</td>";
				echo "<td>$eventid</td>";
				echo "<td align=\"center\">";
				echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;id=$id')\" >";
				showIconFun('delete','');
				echo "</a>";
				echo "</td>";
		  		echo "</tr>";
			}
		}
		function Numrows(){
			return mysql_num_rows($this->result);
		}
		function Fecth_Array(){
			
			return @mysql_fetch_array($this->result);
		}
		function Add_new(){
			$sql="INSERT INTO tbl_event_detail (`pro_id`,`event_id`,`start_date`,`end_date`,`cur_price`,`old_price`,`quantity`,`sales`,`time`,`intro`) VALUES ";
			$sql.="('".addslashes($this->event_detail["ProID"])."','".$this->event_detail["EventID"]."','".$this->event_detail["Start_date"]."','".$this->event_detail["End_date"]."','";
			$sql.=$this->event_detail["Cur_price"]."','";
			$sql.=($this->event_detail["Old_price"])."','".($this->event_detail["Quantity"])."','".$this->event_detail["Sales"]."','".$this->event_detail["Time"]."','".$this->event_detail["Intro"]."')";
			//echo $sql; die();
			$objdata=new CLS_MYSQL;
			$result=$objdata->Query($sql);
		}
		function Update(){
			$sql="UPDATE tbl_event_detail SET `event_id`='".$this->event_detail["EventID"]."', 
										 `start_date`='".$this->event_detail["Start_date"]."',
										 `end_date`='".$this->event_detail["End_date"]."',
                                         `sales`='".$this->event_detail["Sales"]."',
										 `time`='".$this->event_detail["Time"]."',
                                         `intro`='".$this->event_detail["Intro"]."',
										 `cur_price`='".($this->event_detail["Cur_price"])."',
										 `old_price`='".($this->event_detail["Old_price"])."',
										 `quantity`='".($this->event_detail["Quantity"])."'
									WHERE `id_event_detail`='".$this->event_detail["ID"]."'";
				//echo $sql; die();
			$objdata=new CLS_MYSQL;
			$result = $objdata->Query($sql);
		}
		function Delete($id){
			$objdata=new CLS_MYSQL;
			$sql="DELETE FROM `tbl_event_detail` WHERE `id_event_detail` in ('$id')";
			$result=$objdata->Query($sql);
		}
		function ActiveOne($id){
			$sql="UPDATE `tbl_event_detail` SET `isactive` = IF(isactive=1,0,1) WHERE `id_event_detail` in 	('$id')";
			
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Publish($id){
			$sql="UPDATE `tbl_event_detail` SET `isactive` = \"1\" WHERE `id_event_detail` in ('$id')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function UnPublish($id){
			$sql="UPDATE `tbl_event_detail` SET `isactive` = \"0\" WHERE `id_event_detail` in ('$id')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Order($id,$order){
			$objdata=new CLS_MYSQL;
			$sql="UPDATE tbl_event_detail SET `order`='".$order."' WHERE `id_event_detail`='".$id."'";	
			//echo $sql;die();
			$objdata->Query($sql);	
		}
		function Orders($arids,$arods){
			for($i=0;$i<count($arids);$i++)
			{
				$this->Order($arids[$i],$arods[$i]);
				//$this->Order($arids[$i],$i);//
			}
		}
	}
?>