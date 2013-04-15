<?php
class CLS_COMM{
	var $procomm=array
	(
		"comm_id"=>"-1",
		"par_id"=>"",
		"con_id"=>"",
		"pro_id"=>"",
		"username"=>"",
		"joindate"=>"",
		"Content"=>"",
		"LangID"=>"0",
		"isactive"=>"0"
	);
	var $result;
	function CLS_COMM()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->procomm[$proname]))
		{
			echo "Error";
			return;
		}
		$this->procomm[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->procomm[$proname]))
		{
			//$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->procomm[$proname];
	}
	function getCommentByID($comm_id){
		$sql="SELECT * FROM `view_comments` WHERE `comm_id` ='$comm_id' ";
		$objdata=new CLS_MYSQL;
		$objdata->query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->procomm["comm_id"]=$rows["comm_id"];
			$this->procomm["par_id"]=$rows["par_id"];
			$this->procomm["con_id"]=$rows["con_id"];
			$this->procomm["pro_id"]=$rows["pro_id"];
			$this->procomm["username"]=$rows["username"];
			$this->procomm["joindate"]=$rows["joindate"];
			$this->procomm["isactive"]=$rows["isactive"];
			$this->procomm["Content"]=$rows["content"];
		}
	}
	function getAllList($where=""){
		$sql="SELECT * FROM `view_comments` ".$where;
		//echo $sql;
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
	}
	function getAllListdisplay($where=""){
		$sql="SELECT * FROM `view_comments` where isactive=1 ".$where;
		//echo $sql;
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
	}
	function getList($where=""){
		$sql="SELECT * FROM `view_comments`  WHERE  isactive=1 ".$where;
		//echo $sql;
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
	}
	function getListComment($where =""){
		$sql="SELECT * FROM `view_comments` ".$where;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			return $rows;
		}
		else{
			return "No record";
		}
	}
	function listTableCommentNews($strwhere="",$page){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM `view_comments` ".$strwhere ." LIMIT $star,$leng";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$i=0;
		while($rows=$objdata->FetchArray())
		{	$i++;
			$comm_id=$rows["comm_id"];
			$par_id=$rows["par_id"];
			$con_id=$rows["con_id"];
			$pro_id=$rows["pro_id"];
			$username=$rows["username"];
			$joindate=$rows["joindate"];
			$isactive=$rows["isactive"];
			$sql2="SELECT * FROM `tbl_content_text` WHERE `con_id` = $con_id";
			$objdata1=new CLS_MYSQL();
			$objdata1->Query($sql2);
			$rows1=$objdata1->FetchArray();
			$newsName = $rows1['title'];
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" onclick=\"docheckonce('checkid');\" value=\"$comm_id\" />";
			echo "</label></td>";
			echo "<td >$comm_id</td>";
			echo "<td width=\"100\">$newsName</td>";
			echo "<td nowrap=\"nowrap\">$username</td>";
			echo "<td width=\"100\" align=\"center\">$par_id</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;comm_id=$comm_id\">";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;comm_id=$comm_id\">";
			showIconFun('edit','');
			echo "</a>";
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;comm_id=$comm_id')\">";
			showIconFun('delete','');
			echo "</a>";
			echo "</td>";
		  	echo "</tr>";
		}
	}
	function Numrows() { 
		if(mysql_num_rows($this->result))
			return @mysql_num_rows($this->result);
		return 0;
	}
	function Fecth_Array(){
			
		return @mysql_fetch_array($this->result);
	}
	function Add_new(){
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		$sql="INSERT INTO `tbl_comment`(`par_id`,`con_id`,`pro_id`,`username`,`joindate`,`isactive`) VALUES ";
		$sql.=" (\"".$this->procomm["par_id"]."\",\"".$this->procomm["con_id"]."\",\"".$this->procomm["pro_id"]."\",\"".$this->procomm["username"]."\",\"".$this->procomm["joindate"]."\",\"".$this->procomm["isactive"]."\") ";
		//echo $sql; die();
		$result=$objdata->Query($sql);
		if(!$result)
		{return ;} 
		
		$comm_id=$objdata->LastInsertID();
		
		$sql=" INSERT INTO `tbl_comment_text`(`comm_id`,`content`,`lag_id`) VALUES";
		$sql.="('$comm_id',N'".$this->procomm["Content"]."','".$this->procomm["LangID"]."')";
		
		$result1=$objdata->Query($sql);
		if($result && $result1) {
			$objdata->Query("COMMIT");
			return $result;
		}
		else
			$objdata->Query("ROLLBACK");	
	}
	function Update(){
		$objdata=new CLS_MYSQL;
		$objdata->Query("BEGIN");
		
		$sql = "UPDATE tbl_comment SET par_id='".$this->procomm["par_id"]."',con_id='".$this->procomm["con_id"]."',pro_id='".$this->procomm["pro_id"]."',username='".$this->procomm["username"]."',`isactive`='".$this->procomm["isactive"]."' WHERE comm_id='".$this->procomm["comm_id"]."'";
		$result=$objdata->Query($sql);
		if(!$result)
		{return ;} 
		
		$sql = "UPDATE `tbl_comment_text` SET `lag_id`='".$this->procomm["LangID"]."',`content`=N'".$this->procomm["Content"]."' ";
		$sql.=" WHERE `comm_id`=\"".$this->procomm["comm_id"]."\"";
		$result1=$objdata->Query($sql);
		if(!$result1) {
			$objdata->Query("ROLLBACK");
			return;
		}
		else
			$objdata->Query("COMMIT");
		return $result;	
	}
	function Delete($commid){
		$objdata = new CLS_MYSQL; 
		$objdata->Query("BEGIN");
		
		$sql = "SELECT * FROM `tbl_comment` WHERE `par_id` = $commid";
		$objdata->Query($sql);	
		while($rows=$objdata->FetchArray())
		{
			$id = $rows["comm_id"];	
			$this->Delete($id);
		}
		$sql="DELETE FROM `tbl_comment` WHERE `comm_id` in ('$commid')";
		$result=$objdata->Query($sql);
		if(!$result)
		{return ;} 
		$sql="DELETE FROM `tbl_comment_text` WHERE `comm_id` in ('$commid')";
		//echo $sql; die();
		$result1=$objdata->Query($sql);
		
		if($result && $result1) {
			$objdata->Query("COMMIT");
			return $result;
		}
		else
			$objdata->Query("ROLLBACK");	
	}
	function DeleteById($comm_id){
		$sql = "SELECT * FROM `tbl_comment` WHERE `par_id` ='$comm_id'";
		$objdata=new CLS_MYSQL;
		$objdata->query($sql);
		if($objdata->Numrows()>0){
			return "notok";
		}else{
			$sql="DELETE FROM `tbl_comment` WHERE `comm_id` in ('$comm_id')";
			$objdata=new CLS_MYSQL();
			return "ok";
		}
	}
}
?>