<?php
class CLS_CATE{
	var $pro_cate=array(
					  "ID"=>"-1",
					  "ParID"=>"0",
					  "Name"=>"default",
					  "Desc"=>"",
					  "isActive"=>1
					  );
	var $result;
	function CLS_CATE()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_cate[$proname]))
		{
			echo "Error";
			return;
		}
		$this->pro_cate[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_cate[$proname]))
		{
			$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->pro_cate[$proname];
	}
	function getCateByID($catid){
		$sql="SELECT * FROM `view_category` WHERE `cat_id`=\"$catid\" ";
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->pro_cate["ID"]=$rows["cat_id"];
			$this->pro_cate["ParID"]=$rows["par_id"];
			$this->pro_cate["Name"]=$rows["name"];
			$this->pro_cate["Desc"]=$rows["desc"];
			$this->pro_cate["isActive"]=$rows["isactive"];
		}
	}
	function getNameCate($catid) {
		$sql="SELECT name FROM `view_category` WHERE `cat_id`=\"$catid\" ";
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			return $rows["name"];
		}
		return '';
	}
	function getAllList($where=""){
		$sql="SELECT * FROM `tbl_category` ".$where;
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
	}
	function getCatIDChild($where=""){
		$sql="SELECT * FROM `view_cate` ".$where;
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
	}
	function getCateByParent($par_id){
		$sql="SELECT * FROM `tbl_category` WHERE `par_id`=\"$par_id\"";
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
	}
	function Numrows(){
		return @mysql_num_rows($this->result);
	}
	function Fecth_Array(){
		return @mysql_fetch_array($this->result);
	}

}
?>