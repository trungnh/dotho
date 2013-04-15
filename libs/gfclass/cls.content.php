<?php
	class CLS_CONTENTS{
		var $pro_content=array(
			"ID"=>"-1",
			"Code"=>"0",
			"CatID"=>"0",
			"Title"=>"",
			"Intro"=>"",
			"Fulltext"=>"",
			"CreateDate"=>"",
			"ModifyDate"=>"",
			"Author"=>"",
			"GmID"=>"",
			"MetaKey"=>"",
			"MetaDesc"=>"",
			"Visited"=>"",
			"Order"=>"",
			"IsActive"=>"1" // khon co day , o day
		);
		var $result;
		function CLS_CONTENTS(){
		}
		function __set($proname,$value){
			if(!isset($this->pro_content[$proname]))
			{
				echo ("Can't found $proname member");
				return;
			}
			$this->pro_content[$proname]=$value;
		}
		function __get($proname){
			if(!isset($this->pro_content[$proname]))
			{
				echo ("Can't found $proname member");
				return;
			}
			return $this->pro_content[$proname];// phai tra ve gia tri
		}
		function getConByID($conid,$lagid=0){
			$sql="SELECT *
					FROM view_content
					WHERE con_id=\"$conid\" AND `lag_id`='$lagid'";
			$objdata=new CLS_MYSQL;
			$objdata->Query($sql);
			if($objdata->Numrows()>0)
			{
				$rows=$objdata->FetchArray();
				$this->pro_content["ID"]=$rows["con_id"];
				$this->pro_content["Code"]=$rows["code"];
				$this->pro_content["CatID"]=$rows["cat_id"];
				$this->pro_content["Title"]=stripslashes($rows["title"]);
				$this->pro_content["Intro"]=stripslashes($rows["intro"]);
				$this->pro_content["Fulltext"]=stripslashes($rows["fulltext"]);
				$this->pro_content["CreateDate"]=date("d-m-Y",strtotime($rows["creatdate"]));
				$this->pro_content["ModifyDate"]=date("d-m-Y",strtotime($rows["modifydate"]));
				$this->pro_content["Author"]=$rows["author"];
				$this->pro_content["GmID"]="".$rows["gmem_id"];
				$this->pro_content["MetaKey"]=$rows["metakey"];
				$this->pro_content["MetaDesc"]=$rows["metadesc"];
				$this->pro_content["Visited"]=$rows["visited"];
				$this->pro_content["Order"]=$rows["order"];
				$this->pro_content["isActive"]=$rows["isactive"];
				unset($rows);
			}
		}
		
		function getAllList($strwhere="",$lagid=0){
			$sql=" SELECT * 
					FROM view_content
					WHERE lag_id='$lagid' $strwhere"; 
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}
		function getCatIDChild($catid) {
			$sql = 'SELECT catid FROM tbl_category WHERE par_id=$catid AND isactive=1';
			$objdata=new CLS_MYSQL;
			$str='';
			$objdata->Query($sql);
			if($objdata->Numrows()>0) {
				while ($rows=$objdata->FetchArray()) {
					$str.=$rows["catid"]."','";
				}
			}
			return $str;
		}
		function ListCearhPaging($where="",$cur_page=1){
			$start = ($cur_page-1)*MAX_ROWS_INDEX;
			$sql="SELECT * FROM `view_content`  WHERE isactive=1 ".$where." LIMIT ".$start.','.MAX_ROWS_INDEX; 
			//echo $sql;
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}
		function ListByPaging($catid,$where="",$cur_page=1){
			$start = ($cur_page-1)*MAX_ROWS_INDEX;
			$sql="SELECT * FROM `view_content`  WHERE `cat_id`='$catid' AND isactive=1 ".$where." LIMIT ".$start.','.MAX_ROWS_INDEX; 
			//echo $sql;
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}
		function getList($cata,$where=""){
			$sql="SELECT * FROM `view_content`  WHERE `cat_id`='$cata' AND isactive=1 ".$where; 
			//echo $sql;
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}
		function getListSearch($where=""){
			$sql="SELECT * FROM `view_content` ".$where; 
			//echo $sql;
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}
		function ListSearchPaging($where="",$cur_page=1){
			$start = ($cur_page-1)*MAX_ROWS_INDEX;
			$sql="SELECT * FROM `view_content` ".$where." LIMIT ".$start.','.MAX_ROWS_INDEX; 
			//echo $sql;
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}
		function getListCont($conid,$where=""){
			if($where!="")
			$where=" WHERE `con_id`='$conid' AND ".$where;
			$sql="SELECT * FROM `view_content` ".$where;
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}
		function AddVisited($id) {
			$sql="UPDATE `tbl_content` SET `visited`=`visited`+1 WHERE con_id=".$id;
			$objdata=new CLS_MYSQL();
			$objdata->Query($sql);
		}
		function LoadConType(){
			$sql="SELECT * FROM `tbl_gmember` ".strwhere;
			$objdata=new CLS_MYSQL();
			$objdata->Query($sql);
			while($rows=$objdata->FetchArray())
			{
				$modid=$rows["gmem_id"];
				
				$name=$rows["name"];
				echo "<option value=\"$modid\">$name</option>";
			}
		}
		function Numrows(){
			return @mysql_num_rows($this->result);
		}
		function FetchArray(){
			return @mysql_fetch_array($this->result);
		}
	}
?>