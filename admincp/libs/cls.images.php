<?php
	class CLS_IMAGES{
		var $pro_images=array(
			"ID"=>"-1",
			"Proid"=>"0",
			"Link"=>"",
			"Order"=>"",
			"isActive"=>"1" // khon co day , o day
		);
		var $result;
		function CLS_IMAGES(){
		}
		function __set($proname,$value){
			if(!isset($this->pro_images[$proname]))
			{
				echo ("Can't found $proname members");
				return;
			}
			$this->pro_images[$proname]=$value;
		}
		function __get($proname){
			if(!isset($this->pro_images[$proname]))
			{
				echo ("Can't found $proname member");
				return;
			}
			return $this->pro_images[$proname];// phai tra ve gia tri
		}
		function getProByID($id){
			$sql="SELECT *
					FROM tbl_image
					WHERE id=\"$id\" ";
			$objdata=new CLS_MYSQL;
			$objdata->Query($sql);
			if($objdata->Numrows()>0)
			{
				$rows=$objdata->FetchArray();
				$this->pro_images["ID"]=$rows["id"];
				$this->pro_images["Proid"]=$rows["pro_id"];
				$this->pro_images["Link"]=stripslashes($rows["link"]);
				$this->pro_images["Order"]=$rows["order"];
				$this->pro_images["isActive"]=$rows["isactive"];
			}
		}
		function getAllList($strwhere=""){
			$sql=" SELECT * 
					FROM tbl_image
					WHERE $strwhere";
					//echo $sql;die();
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}	
		function listTablePro($strwhere=""){
			//$star=($page-1)*MAX_ROWS;
			//$leng=MAX_ROWS;
			$sql="	SELECT * FROM tbl_image WHERE  $strwhere ORDER BY `order`";
			//echo $sql;
			$objdata=new CLS_MYSQL();
			$objdata->Query($sql);
			$i=0;
			while($rows=$objdata->FetchArray())
			{	$i++;
				$id=$rows["id"];
				$link=$rows["link"];
				$order=$rows["order"];
				echo "<tr name=\"trow\">";
				echo "<td width=\"30\" align=\"center\">$i</td>";
				echo "<td width=\"200\"><a class=\"img-pro\" href=\"index.php?com=images&amp;task=edit&amp;imgid=$id\"><img src=\"../$link\" height=\"100\" alt=\"\" /></a></td>";
				echo "<td align=\"center\">";
			
				echo "<a href=\"index.php?com=images&amp;task=active&amp;imgid=$id\">";
				showIconFun('publish',$rows["isactive"]);
				echo "</a>";
			
				echo "</td>";
				echo "<td align=\"center\">";
			
				echo "<a href=\"index.php?com=images&amp;task=edit&amp;imgid=$id\">";
				showIconFun('edit','');
				echo "</a>";
			
				echo "</td>";
				echo "<td align=\"center\">";
			
				echo "<a href=\"javascript:detele_field('index.php?com=images&amp;task=delete&amp;imgid=$id')\" >";
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
			$sql="INSERT INTO tbl_image (`pro_id`,`link`,`isactive`) VALUES ";
			$sql.="('".addslashes($this->pro_images["Proid"])."','".$this->pro_images["Link"]."','";
			$sql.=$this->pro_images["isActive"]."')";
			//echo $sql; die();
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Update(){
			$sql="UPDATE tbl_image SET `pro_id`='".$this->pro_images["Proid"]."', 
										 `link`='".$this->pro_images["Link"]."',
										 `isactive`='".$this->pro_images["isActive"]."' 
									WHERE `id`='".$this->pro_images["ID"]."'";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Delete($id){
			$sql="DELETE FROM `tbl_image` WHERE `id` in ('$id')";
			$objdata=new CLS_MYSQL;
			$result=$objdata->Query($sql);
		}
		function ActiveOne($id){
			$sql="UPDATE `tbl_image` SET `isactive` = IF(isactive=1,0,1) WHERE `id` in 	('$id')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Publish($id){
			$sql="UPDATE `tbl_image` SET `isactive` = \"1\" WHERE `id` in ('$id')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function UnPublish($id){
			$sql="UPDATE `tbl_image` SET `isactive` = \"0\" WHERE `id` in ('$id')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Order($id,$order){
			$objdata=new CLS_MYSQL;
			$sql="UPDATE tbl_image SET `order`='".$order."' WHERE `id`='".$id."'";	
			echo $sql;die();
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