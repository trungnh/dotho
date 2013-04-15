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
				echo "<tr name=\"trow\">";
				echo "<td width=\"30\" align=\"center\">$i</td>";
				echo "<td width=\"200\"><a class=\"img-pro\" href=\"index.php?com=property&amp;task=edit&amp;imgid=$id\">$name</a></td>";
				echo "<td width=\"200\">$description</td>";
				echo "<td align=\"center\">";
			
				echo "<a href=\"index.php?com=property&amp;task=active&amp;imgid=$id\">";
				showIconFun('publish',$rows["isactive"]);
				echo "</a>";
			
				echo "</td>";
				echo "<td align=\"center\">";
			
				echo "<a href=\"index.php?com=property&amp;task=edit&amp;imgid=$id\">";
				showIconFun('edit','');
				echo "</a>";
			
				echo "</td>";
				echo "<td align=\"center\">";
			
				echo "<a href=\"javascript:detele_field('index.php?com=property&amp;task=delete&amp;imgid=$id')\" >";
				showIconFun('delete','');
				echo "</a>";
			
				echo "</td>";
		  		echo "</tr>";
			}
		}
		function Numrows(){
			return mysql_num_rows($this->result);
		}
		function FecthArray(){
			
			return @mysql_fetch_array($this->result);
		}
		function Add_new(){
			$sql="INSERT INTO tbl_property (`name`,`product_id`,`description`,`isactive`) VALUES ";
			$sql.="('".$this->pro_property["Name"]."','".addslashes($this->pro_property["Proid"])."','".$this->pro_property["Description"]."','".$this->pro_property["isActive"]."') ";
			
			//echo $sql; die();
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Update(){
			$sql="UPDATE tbl_property SET `name`='".$this->pro_property["Name"]."',
										 `description`='".$this->pro_property["Description"]."',
										 `isactive`='".$this->pro_property["isActive"]."' 
									WHERE `id`='".$this->pro_property["ID"]."'";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Delete($id){
			$sql="DELETE FROM `tbl_property` WHERE `id` in ('$id')";
			$objdata=new CLS_MYSQL;
			$result=$objdata->Query($sql);
		}
		function ActiveOne($id){
			$sql="UPDATE `tbl_property` SET `isactive` = IF(isactive=1,0,1) WHERE `id` in 	('$id')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Publish($id){
			$sql="UPDATE `tbl_property` SET `isactive` = \"1\" WHERE `id` in ('$id')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function UnPublish($id){
			$sql="UPDATE `tbl_property` SET `isactive` = \"0\" WHERE `id` in ('$id')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Order($id,$order){
			$objdata=new CLS_MYSQL;
			$sql="UPDATE tbl_property SET `order`='".$order."' WHERE `id`='".$id."'";	
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