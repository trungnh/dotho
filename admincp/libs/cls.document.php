<?php
class CLS_DOCUMENT extends CLS_MYSQL{
	var $obj=array(
					  "ID"=>"-1",
					  "ParID"=>"0",
					  "Loai"=>"0",
					  "Code"=>"",
					  "Name"=>"",
					  "Intro"=>"",
					  "Urlfile"=>"tailieu/",
					  "Outsite"=>"",
					  "Type"=>"",
					  "FileSize"=>"",
					  "CreateDate"=>"",
					  "ModifyDate"=>"",
					  "Author"=>"",
					  "Assign"=>"",
					  "Downloads"=>"0",
					  "Lag_id"=>"0",
					  "isActive"=>1
					  );
	var $result;
	function CLS_DOCUMENT()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->obj[$proname]))
		{
			echo "Error";
			return;
		}
		$this->obj[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->obj[$proname]))
		{
			$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->obj[$proname];
	}
	
	function getURL ($docid) {
		$sql="SELECT code,par_id FROM `view_document` WHERE `doc_id`='$docid'";
		//echo $sql;
		$this->result=$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		
		$url='';
		
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$url.=$rows["code"]."/";
			$url=$this->getURL($rows["par_id"]).$url;
			if($rows["par_id"]==0)
				$url="tailieu/".$url;
		}
		
		return $url;
	}
	
	function getCateByID($id){
		$sql="SELECT * FROM `view_document` WHERE `doc_id`='$id' ";
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->obj["ID"]=$rows["doc_id"];
			$this->obj["ParID"]=$rows["par_id"];
			$this->obj["Loai"]=$rows["loai"];
			$this->obj["Code"]=$rows["code"];
			$this->obj["Name"]=$rows["name"];
			$this->obj["Intro"]=$rows["intro"];
			$this->obj["Urlfile"]=$rows["urlfile"];
			$this->obj["Outsite"]=$rows["outsite"];
			$this->obj["Type"]=$rows["type"];
			$this->obj["FileSize"]=$rows["file_size"];
			$this->obj["CreateDate"]=$rows["create_date"];
			$this->obj["ModifyDate"]=$rows["modify_date"];
			$this->obj["Author"]=$rows["author"];
			$this->obj["Assign"]=$rows["assign"];
			$this->obj["Downloads"]=$rows["downloads"];
			$this->obj["Lag_id"]=$rows["lag_id"];
			$this->obj["isActive"]=$rows["isactive"];
		}
	}
	function getAllList($where=""){
		$sql="SELECT * FROM `view_document` ".$where;
		//echo $sql;
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
	}

	function getListDoc($parid=0,$level=0,$select='')
	{
		$sql="SELECT * FROM `view_document` WHERE `par_id`='$parid' AND loai=1";
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
		$char="";
		if($level>0)
		{
			for($i=0;$i<$level;$i++)
				$char.=".....";
				$char.="";
		}
		while($rows=$objdata->FetchArray())
		{
			$catid=$rows["doc_id"];
			$name=$rows["name"];
			if($rows["doc_id"]==$select)
				echo "<option value=\"$catid\" selected=\"selected\">$char$name</option>";
			else echo "<option value=\"$catid\">$char$name</option>";
			$this->getListDoc($catid,$level+1,$select);
		}
	}
	
	function getURLdoc($id) {
		$sql="SELECT urlfile FROM `view_document` WHERE `doc_id`='$id'";
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
		$str='';
		$rows=$objdata->FetchArray();
		$str=$rows["urlfile"];

		return $str;
	}
	function haveChild($id) {
		$sql="SELECT doc_id FROM `view_document` WHERE `par_id`='$id'"; //echo $sql;die;
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
		if($objdata->Numrows()>0)
			return $objdata->Numrows();
		else 
			return 0;
	}
	function getCode($code) {
		$sql="SELECT code FROM `view_document` WHERE `code`='$code'"; //echo $sql;die;
		$objdata=new CLS_MYSQL();
		$this->result==$objdata->Query($sql);
		if($objdata->Numrows()>0)
			return $objdata->Numrows();
		else 
			return 0;
	}
	function Numrows(){
		return mysql_num_rows($this->result);
	}
	function Fecth_Array(){
		
		return @mysql_fetch_array($this->result);
	}
	function Add_new(){
			$objdata=new CLS_MYSQL;
			$objdata->Query("BEGIN");
			$sql="INSERT INTO tbl_document (`code`,`par_id`,`loai`,`urlfile`,`outsite`,`type`,`file_size`,`create_date`,`modify_date`,`author`,`assign`,`isactive`) VALUES ";
			$sql.="('".addslashes($this->obj["Code"])."','".$this->obj["ParID"]."','".$this->obj["Loai"]."','".$this->obj["Urlfile"]."','".$this->obj["Outsite"]."','".$this->obj["Type"]."','".$this->obj["FileSize"]."','";
			$sql.=$this->obj["CreateDate"]."','".$this->obj["ModifyDate"]."','".$this->obj["Author"]."','";
			$sql.=$this->obj["Assign"]."','".$this->obj["isActive"]."')";
			//echo $sql; die();
			$result=$objdata->Query($sql);
			
			$docid=$objdata->LastInsertID();
			$sql="INSERT INTO tbl_document_text (`doc_id`,`intro`,`name`,`lag_id`) VALUES";
			$sql.="('$docid','".($this->obj["Intro"])."','".($this->obj["Name"])."','";
			$sql.=$this->obj["Lag_id"]."')";
			$result1=$objdata->Query($sql);
			if($result && $result1 ){
				$objdata->Query('COMMIT');
				return $result;
			}
			else
				$objdata->Query('ROLLBACK');
		}
	function Update(){
			$objdata=new CLS_MYSQL;
			$objdata->Query("BEGIN");
			$sql="UPDATE tbl_document SET `code`='".($this->obj["Code"])."',
										 `par_id`='".$this->obj["ParID"]."', 
										 `type`='".($this->obj["Type"])."',
										 `outsite`='".$this->obj["Outsite"]."', 
										 `Urlfile`='".($this->obj["Urlfile"])."',
										 `file_size`='".$this->obj["FileSize"]."', 
										 `create_date`='".$this->obj["CreateDate"]."',
										 `modify_date`='".$this->obj["ModifyDate"]."',
										 `author`='".$this->obj["Author"]."',
										 `assign`='".($this->obj["Assign"])."',
										 `isactive`='".$this->obj["isActive"]."' 
									WHERE `doc_id`='".$this->obj["ID"]."'";
			$result = $objdata->Query($sql);
			
			$sql="UPDATE tbl_document_text SET `name`='".($this->obj["Name"])."',
											  `intro`='".($this->obj["Intro"])."'
									WHERE `doc_id`='".$this->obj["ID"]."' AND 
										  `lag_id`='".$this->obj["Lag_ID"]."'";
			$result1 = $objdata->Query($sql);
			
			if($result && $result1 ){
				$objdata->Query('COMMIT');
				return $result;
			}
			else
				$objdata->Query('ROLLBACK');
		}
	function ActiveOnce($id){
		$sql="UPDATE `tbl_document` SET `isactive` = IF(isactive=1,0,1) WHERE `doc_id` in ('$id')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function Publish($id){
		$sql="UPDATE `tbl_document` SET `isactive` = \"1\" WHERE `doc_id` in ('$id')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function UnPublish($id){
		$sql="UPDATE `tbl_document` SET `isactive` = \"0\" WHERE `doc_id` in ('$id')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	
	function getFileSize($size, $retstring = null)
	{
		$sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
		if ($retstring === null) { $retstring = '%01.2f %s'; }
		$lastsizestring = end($sizes);
		foreach ($sizes as $sizestring) {
				if ($size < 1024) { break; }
				if ($sizestring != $lastsizestring) { $size /= 1024; }
		}
		if ($sizestring == $sizes[0]) { $retstring = '%01d %s'; } // Bytes aren't normally fractional
		return sprintf($retstring, $size, $sizestring);
	}


	function getFileType($file="") {
		
		// get file name 
		$filearray = explode("/", $file);
		$filename = array_pop($filearray);
		
		// condition : if no file extension, return
		if(strpos($filename, ".") === false) return false;
		
		// get file extension
		$filenamearray = explode(".", $filename);
		$extension = $filenamearray[(count($filenamearray) - 1)];
		return $extension;
	
	}

	
	function fileName($id,$HOST_URL=HOST_URL){
		$sql = "SELECT loai,code,urlfile FROM `view_document` WHERE `doc_id`=$id";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$rows=$objdata->FetchArray();
		
		//loai=1: kieu thu muc, loai=0: kieu tep tin
		$dirname = $HOST_URL.$rows["urlfile"].$rows["code"];
		return $dirname;
	}
	function Delete($id,$HOST_URL="/home/hmongbee/public_html/"){
		//chmod thu muc chua tai lieu download
		//chmod("/home/hmongbee/public_html/tailieu",0777);
		
		$dirname = $this->fileName($id,"/home/hmongbee/public_html/"); 
		chmod($dirname, 0777);
		
		if(is_dir($dirname)) { 
			rmdir($dirname);
		}
		if(is_file($dirname) && file_exists($dirname)) {
			unlink($dirname);
		}
		// Read and write for owner, read for everybody else
		//chmod("/home/hmongbee/public_html/tailieu",0644);
		$objdata=new CLS_MYSQL;
			$objdata->Query("BEGIN");
		$sql="DELETE FROM `tbl_document` WHERE `doc_id` in ('$id')";
		//echo $sql; die();
		$result=$objdata->Query($sql);
		$sql="DELETE FROM `tbl_document_text` WHERE `doc_id` in ('$id')";
			$result1=$objdata->Query($sql);
			//echo $sql;die();
			if($result && $result1 ){
				$objdata->Query('COMMIT');
				return $result;
			}else
				$objdata->Query('ROLLBACK');
	}	 
	function DeleteFile($id) {
		$sql = "DELETE FROM tbl_document WHERE doc_id=$id";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
}
?>