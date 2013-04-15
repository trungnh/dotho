
<?php
class CLS_ORDER{
	var $pro_order=array(
					  "ID"=>"-1",
					  "code"=>"",
					  "user_id"=>"",
					  "pay_id"=>"",
					  "create_date"=>"",
					  "note"=>"",
					  "city"=>"",
					  "name_buyer"=>"",
					  "phone_buyer"=>"",
					  "email_buyer"=>"",
					  "location_buyer"=>"",
					  "carriage"=>"",
					  "status"=>0
					  );
	var $result;
	var $review =1;
	var $paind = 3;
	var $arrPro = array();
	var	$arrCount = array();
	var $arrMoney = array();
	var $i=0;
	var $unpaind = 2;
	function CLS_ORDER()
	{
		$this->create_date=date("d-m-Y s:i:h");
		$this->review = 1;
		$this->paind = 3;
		$this->i=0;		
		$this->unpaind =2;
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_order[$proname]))
		{
			echo "Error";
			return;
		}
		$this->pro_order[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_order[$proname]))
		{
			$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->pro_order[$proname];
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
	function getListProduct($where=""){
		$sql="SELECT * FROM `tbl_order` inner join 	`tbl_order_detail` on `tbl_order`.`id`=`tbl_order_detail`.`order_id` ".$where;
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->query($sql);
	}

	function listTableOrder($strwhere="",$userid){
	   $sql="SELECT * FROM `tbl_order` where `user_id`='$userid' ".$strwhere." order by `id`";
		$objdata=new CLS_MYSQL;
		//$objdata2 =  new CLS_MYSQL;
		$objdata->query($sql);
		$i=0;
        if($objdata->Numrows()>0)
		{
            echo '<table class="tbl_history">
                    <tr>
                        <td><strong>STT</strong></td>
                        <td><strong>Ngày lập</strong></td>
                        <td><strong>Thanh toán</strong></td>
                        <td><strong>Chi tiết đơn hàng</strong></td>
                    </tr>';
    		while($rows=$objdata->FetchArray())
    		{	$i++;
    			$id=$rows["id"];
    			$user_id=$rows["user_id"];
    			$status=$rows["status"];
    			$create_date =date("d/m/Y",strtotime($rows["create_date"]));
    			$statusText="";
    			if($status == 0) $statusText = "Chưa thanh toán";
    			if($status==1) $statusText = "Đang thanh toán";
    			if($status==2) $statusText = "Đã thanh toán ";
    			if($status==3) $statusText = "Hủy thanh toán";
                echo '<tr name="trow">';
    			echo "<td width=\"30\" align=\"center\">$i</td>";
    			echo "<td width=\"100\">$create_date</td>";
    			echo "<td width=\"150\">$statusText</td>";
    			echo "<td width=\"150\" align=\"center\">";
    			echo "<a href=\"index.php?com=cart&do=list_order&id=$id\">";
                echo "Xem chi tiết";
    			echo "</a>";
    			echo "</td>";
    		  	echo "</tr></table>";
    		}
            echo "</table>";
        }
        else
        {
            echo "Bạn chưa mua hàng tại website";
        }
	}
	function getOrderByID($id){
		$sql="SELECT * FROM `tbl_order` WHERE `id` =$id ";
		$objdata=new CLS_MYSQL;
		$objdata->query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->pro_order["id"]=$rows["id"];
			$this->pro_order["user_id"]=$rows["user_id"];
			$this->pro_order["pay_id"]=$rows["pay_id"];
			$this->pro_order["create_date"]=$rows["create_date"];
			$this->pro_order["city"]=$rows["city"];
			$this->pro_order["name_buyer"]=$rows["name_buyer"];
			$this->pro_order["phone_buyer"]=$rows["phone_buyer"];
			$this->pro_order["email_buyer"]=$rows["email_buyer"];
			$this->pro_order["location_buyer"]=$rows["location_buyer"];
			$this->pro_order["carriage"]=$rows["carriage"];
			$this->pro_order["status"]=$rows["status"];
			$this->pro_order["note"]=$rows["note"];
		}
	}
	function getNameUser($user_id){
		$sql2 = "SELECT * FROM `tbl_member` WHERE `mem_id` = '$user_id'";
		$objdata2 =  new CLS_MYSQL;
		$objdata2->query($sql2);
			$name = "";
			if($rows2=$objdata2->FetchArray())
				$name = $rows2["firstname"]." ".$rows2["lastname"];
		return $name;
	}
	function getPaymentName($pay_id){
		$sql2 = "SELECT * FROM `tbl_payment` WHERE `id` = '$pay_id'";
		$objdata2 =  new CLS_MYSQL;
		$objdata2->query($sql2);
			$name = "";
			if($rows2=$objdata2->FetchArray())
				$name = $rows2["name"];
		return $name;
	}
	function changeStatus($id,$staus){
		$sql ="UPDATE `tbl_order` SET `status`=$staus WHERE `id` = $id";
		echo $sql; die();
		$objdata =  new CLS_MYSQL;
		$objdata->query($sql);
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
	function Fecth_Array(){	
		return @mysql_fetch_array($this->result);
	}
	function Add_new(){
		$sql="INSERT INTO tbl_order (`code`,`user_id`,`pay_id`,`create_date`,`note`,`city`,`name_buyer`,`phone_buyer`,`email_buyer`,`location_buyer`,`carriage`,`status`) VALUES ";
		$sql.="('".addslashes($this->pro_order["code"])."','".$this->pro_order["user_id"]."','".$this->pro_order["pay_id"]."','".$this->pro_order["create_date"]."','".$this->pro_order["note"]."','".$this->pro_order["city"]."','".$this->pro_order["name_buyer"]."','".$this->pro_order["phone_buyer"]."','".$this->pro_order["email_buyer"]."','".$this->pro_order["location_buyer"]."','".$this->pro_order["carriage"]."','";
		$sql.=$this->pro_order["status"]."')";
		//echo $sql; die();
		$objdata=new CLS_MYSQL;
		return $objdata->Query($sql);
	}
	function review($id){
		$sql="UPDATE `tbl_order` SET `status` = '1' WHERE `id` in ('$id')";
		//echo $sql;
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		return $this->result;
	}
	function unreview($id){
		$sql="UPDATE `tbl_order` SET `status` = \"0\" WHERE `id` in ('$id')";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		return $this->result;
	}
	function paind($id){
		$sql="UPDATE `tbl_order` SET `status` = \"3\" WHERE `id` in ('$id')";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		return $this->result;
	}
	function unpaind($id){
		$sql="UPDATE `tbl_order` SET `status` = \"2\" WHERE `id` in ('$id')";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		return $this->result;
	}
	function destroy($id){
		$sql="UPDATE `tbl_order` SET `status` = \"3\" WHERE `id` in ('$id')";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		return $this->result;
	}
	function getListProBuy($strwhere){
		if($strwhere!="")
			$sql="SELECT * FROM `tbl_order` ".$strwhere." AND status in ('".$this->review."','".$this->paind."')" ;
		else
			$sql="SELECT * FROM `tbl_order` where status in ('".$this->review."','".$this->paind."')" ;
		//echo $sql."<br />";
		$objdata=new CLS_MYSQL;
		$objdata2 =  new CLS_MYSQL;
		$objdata->query($sql);
		$this->i = 0;
		$this->arrPro = array();
	 	$this->arrCount = array();
	    $this->arrMoney = array();
		while($rows=$objdata->FetchArray()){
			$objdata2 = $this->getOrderDetail($rows['id']);
			while($row2 = $objdata2->FetchArray()){
				$this->arrPro[$this->i] = $row2['pro_id'];
				$this->arrCount[$this->i] = $row2['count'];
				$this->arrMoney[$this->i] = $row2['total'];
				$this->i++;
			}
		}
		$j=0;$k=0;
		for($j=0;$j<($this->i-1);$j++)
			for($k=($j+1);$k<$this->i;$k++)
				if($this->arrPro[$j] == $this->arrPro[$k] && $this->arrPro[$k]!="" && $this->arrPro[$j]!=""){
					$this->arrCount[$j] = $this->arrCount[$j] + $this->arrCount[$k];
					//echo "j = ".$j. " count :".$this->arrCount[$j]."<br />";
					$this->arrMoney[$j] = $this->arrMoney[$j] + $this->arrMoney[$k];
					$this->arrPro[$k] ="";
				}
		$k=1;
		$total=0;
		for($j=0;$j<$this->i;$j++){
			if($this->arrPro[$j] !=""){
				echo "<tr>";
				echo "<td >$k</td>";
				echo "<td>".$this->arrPro[$j]."</td>";
				echo "<td>".$this->arrCount[$j]."</td>";
				echo "<td align=\"right\">".number_format($this->arrMoney[$j])."</td>";			
				echo "</tr>";
				$total = $total+ $this->arrMoney[$j];
				$k++;
			}
		}
		echo "<tr><td colspan= '3' align=\"right\" > Sum : </td><td  align=\"right\">".number_format($total)."</td></tr>";
		return $k;
	}
	function getListProNotBuy($strwhere){
		if($strwhere!="")
			$sql="SELECT * FROM `tbl_order` ".$strwhere." AND status in ('".$this->unpaind."')" ;
		else
			$sql="SELECT * FROM `tbl_order` where status in ('".$this->unpaind."')" ;
		//echo $sql."<br />";
		$objdata=new CLS_MYSQL;
		$objdata2 =  new CLS_MYSQL;
		$objdata->query($sql);
		$this->i = 0;
		$this->arrPro = array();
	 	$this->arrCount = array();
	    $this->arrMoney = array();
		while($rows=$objdata->FetchArray()){
			$objdata2 = $this->getOrderDetail($rows['id']);
			while($row2 = $objdata2->FetchArray()){
				$this->arrPro[$this->i] = $row2['pro_id'];
				$this->arrCount[$this->i] = $row2['count'];
				$this->arrMoney[$this->i] = $row2['total'];
				$this->i++;
			}
		}
		$j=0;$k=0;
		for($j=0;$j<($this->i-1);$j++)
			for($k=($j+1);$k<$this->i;$k++)
				if($this->arrPro[$j] == $this->arrPro[$k] && $this->arrPro[$k]!="" && $this->arrPro[$j]!=""){
					$this->arrCount[$j] = $this->arrCount[$j] + $this->arrCount[$k];
					//echo "j = ".$j. " count :".$this->arrCount[$j]."<br />";
					$this->arrMoney[$j] = $this->arrMoney[$j] + $this->arrMoney[$k];
					$this->arrPro[$k] ="";
				}
		$k=1;
		$total=0;
		for($j=0;$j<$this->i;$j++){
			if($this->arrPro[$j] !=""){
				echo "<tr>";
				echo "<td >$k</td>";
				echo "<td>".$this->arrPro[$j]."</td>";
				echo "<td>".$this->arrCount[$j]."</td>";
				echo "<td  align=\"right\">".number_format($this->arrMoney[$j])."</td>";			
				echo "</tr>";
				$total = $total+ $this->arrMoney[$j];
				$k++;
			}
		}
		echo "<tr><td colspan= '3' align=\"right\" > Sum : </td><td  align=\"right\">".number_format($total)."</td></tr>";
		return $k;
	}
}
?>
