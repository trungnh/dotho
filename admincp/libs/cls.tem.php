<?php
class CLS_TEM{
	var $pro_tem=array(
					  "ID"=>"1",
					  "Name"=>"default",
					  "Desc"=>"",
					  "Author"=>"GF-TEAM",
					  "Email"=>"contact@glowfuture.com",
					  "ASite"=>"glowfuture.com",
					  "isDefaul"=>1,
					  "isActive"=>1
					  );
	function CLS_TEM()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_tem[$proname]))
		{
			return;
		}
		$this->pro_tem[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_tem[$proname]))
		{
			echo "Can't found $proname member";
			return;
		}
		return $this->pro_tem[$proname];
	}	// set active template
	// set default template
	function SetDefault($temid)
	{
		$objdata=new CLS_MYSQL();
		$sql="UPDATE `tbl_template SET `isdefault`=0";
		$objdata->query($sql);
		$sql="UPDATE `tbl_template SET `isdefault`=1 WHERE `tem_id`=$temid";
		$objdata->query($sql);
		return true;
	}
	function Numrows($where=""){
		$sql="SELECT * FROM `tbl_template` ".$where;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		return $objdata->Numrows();
	}
	function getTemById($temid){
		$sql="SELECT * FROM `tbl_template` WHERE `tem_id`='$temid'";
		$objdata=new CLS_MYSQL();
		$result=$objdata->Query($sql);
		if($objdata->Numrows()>0){
			$rows=$objdata->FetchArray();
			$this->pro_tem["ID"]=$rows["tem_id"];
			$this->pro_tem["Name"]=$rows["name"];
			$this->pro_tem["Desc"]=$rows["desc"];
			$this->pro_tem["Author"]=$rows["author"];
			$this->pro_tem["Email"]=$rows["author_email"];
			$this->pro_tem["ASite"]=$rows["author_site"];
			$this->pro_tem["isDefault"]=$rows["isdefault"];
			$this->pro_tem["isActive"]=$rows["isactive"];				
		}		
	}
	function listTableTem($strwhere="",$page){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM `tbl_template` $strwhere LIMIT $star,$leng";
		//echo $sql; 
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
		$i=0;
		while($rows=$objdata->FetchArray())
		{	$i++;
			$temid=$rows["tem_id"];	
			$name=$rows["name"];
			$author=$rows["author"];
			$author_email=$rows["author_email"]; 
			$author_site=$rows["author_site"];
			
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" onclick=\"docheckonce('checkid');\" value=\"$temid\" />";
			echo "</label></td>";
			echo "<td>$name</td>";
			echo "<td width=\"75\">$author</td>";
			echo "<td width=\"75\">$author_email</td>";
			echo "<td width=\"75\">$author_site</td>";
			
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=default&amp;temid=$temid\">";
			showIconFun('publish',$rows["isdefault"]);
			echo "</a>";
			echo "</td>";
			
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;temid=$temid\">";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			echo "</td>";
			
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;temid=$temid\">";
			showIconFun('edit','');
			echo "</a>";
			echo "</td>";
			
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"index.php?com=".COMS."&amp;task=delete&amp;temid=$temid\">";
			showIconFun('delete','');
			echo "</a>";
			
			echo "</td>";
		  	echo "</tr>";
		}
	}
	function Addnew(){
		
	}
	function Update(){
		
		if($this->Default==1)
		$this->SetDefault($temid);	
	}
	function ActiveOnce($temid){
		$sql="UPDATE `tbl_template` SET `isactive` = IF(isactive=1,0,1) WHERE `tem_id` in ('$temid')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function Publish($temid){
		$sql="UPDATE `tbl_template` SET `isactive` = \"1\" WHERE `tem_id` in ('$temid')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function UnPublish($temid){
		$sql="UPDATE `tbl_template` SET `isactive` = \"0\" WHERE `tem_id` in ('$temid')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function Delete($temid){
		$sql="DELETE FROM `tbl_template` WHERE `tem_id` in ('$temid')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
}
?>