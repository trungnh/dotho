
<?php
class CLS_ORDER_DETAIL{
	var $pro_orderdetail=array(
					  "order_id"=>"",
					  "pro_id"=>"",
					  "price"=>"",
					  "Count"=>"",
					  "total"=>""
					  );
	var $result;
	function CLS_ORDER_DETAIL()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_orderdetail[$proname]))
		{
			echo "Error";
			return;
		}
		$this->pro_orderdetail[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_orderdetail[$proname]))
		{
			$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->pro_orderdetail[$proname];
	}
	
	function Numrows(){
		if(@mysql_num_rows($this->result)>0)
			return @mysql_num_rows($this->result);
		else 
			return 0;
	}
	function getList($where=""){
		$sql="SELECT * FROM `tbl_order`".$where;
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->query($sql);
	}
	function getOrderDetail($id){
		$sql ="SELECT * FROM `tbl_order_detail` WHERE `order_id` =  $id";
		$objdata =  new CLS_MYSQL;
		$objdata->query($sql);
		if($objdata->Numrows()>0){
			return $objdata;
		}else{
			return 0;
		}
	}
	function getProductName($id){
		$sql="SELECT * FROM `tbl_products_text` where pro_id  = $id";
		$objdata =  new CLS_MYSQL;
		$objdata->query($sql);
		if($rows=$objdata->FetchArray()){
			return $rows["name"];
		}else{
			return "";
		}
	}
	function getOrderIDlast(){
		$sql="SELECT * FROM `tbl_order` order by `id` DESC";
		//echo $sql;
		$objdata =  new CLS_MYSQL;
		$objdata->query($sql);
		$rows=$objdata->FetchArray();
			return $rows["id"];
	}
	function Add_new(){
		$sql="INSERT INTO tbl_order_detail (`order_id`,`pro_id`,`price`,`count`,`total`) VALUES ";
		$sql.="('".addslashes($this->pro_orderdetail["order_id"])."','".$this->pro_orderdetail["pro_id"]."','".$this->pro_orderdetail["price"]."','".$this->pro_orderdetail["Count"]."','".$this->pro_orderdetail["total"]."')";
		//echo $sql; die();
		$objdata=new CLS_MYSQL;
		return $objdata->Query($sql);
	}

}
?>
