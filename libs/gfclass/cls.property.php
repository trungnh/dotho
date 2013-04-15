<?php
	class CLS_PROPERTY{
		var $pro_property=array(
			"ID"=>"-1",
			"Name"=>"",
			"Proid"=>"0",
			"Description"=>"",
			"Order"=>"",
			"isActive"=>"1" // khon co day , o day
		);
		var $result;
		function CLS_PROPERTY(){
		}
		function __set($proname,$value){
			if(!isset($this->pro_property[$proname]))
			{
				echo ("Can't found $proname members");
				return;
			}
			$this->pro_property[$proname]=$value;
		}
		function __get($proname){
			if(!isset($this->pro_property[$proname]))
			{
				echo ("Can't found $proname member");
				return;
			}
			return $this->pro_property[$proname];// phai tra ve gia tri
		}
		function getProByID($id){
			$sql="SELECT *
					FROM tbl_property
					WHERE id=\"$id\" ";
			$objdata=new CLS_MYSQL;
			$objdata->Query($sql);
			if($objdata->Numrows()>0)
			{
				$rows=$objdata->FetchArray();
				$this->pro_property["ID"]=$rows["id"];
				$this->pro_property["Name"]=$rows["name"];
				$this->pro_property["Proid"]=$rows["product_id"];
				$this->pro_property["Description"]=stripslashes($rows["description"]);
				$this->pro_property["Order"]=$rows["order"];
				$this->pro_property["isActive"]=$rows["isactive"];
			}
		}
		function getAllList($strwhere=""){
			$sql=" SELECT * 
					FROM tbl_property
					WHERE $strwhere";
					//echo $sql;die();
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}	
		function listTablePro($strwhere=""){
			//$star=($page-1)*MAX_ROWS;
			//$leng=MAX_ROWS;
			$sql="	SELECT * FROM tbl_property WHERE  $strwhere ORDER BY `order`";
			//echo $sql;
			$objdata=new CLS_MYSQL();
			$objdata->Query($sql);
			$i=0;
			while($rows=$objdata->FetchArray())
			{	$i++;
				$id=$rows["id"];
				$name=$rows["name"];
				$description=$rows["description"];
				$order=$rows["order"];
				echo '<tr class="odd">
						<th class="label">'.$name.'</th>
						<td class="data last">'.$description.'</td>
					</tr>
				';
			}
		}
		function Numrows(){
			return mysql_num_rows($this->result);
		}
		function FecthArray(){
			
			return @mysql_fetch_array($this->result);
		}
	}
?>