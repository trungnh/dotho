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
			"LangID"=>"0",
			"IsActive"=>"1" // khon co day , o day
		);
		var $result;
		function CLS_CONTENTS(){
		}
		function __set($proname,$value){
			if(!isset($this->pro_content[$proname]))
			{
				echo ("Can't found $proname members");
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
				$this->pro_content["Code"]=stripslashes($rows["code"]);
				$this->pro_content["CatID"]=$rows["cat_id"];
				$this->pro_content["Title"]=stripslashes($rows["title"]);
				$this->pro_content["Intro"]=stripslashes($rows["intro"]);
				$this->pro_content["Fulltext"]=stripslashes($rows["fulltext"]);
				$this->pro_content["CreateDate"]=date("d-m-Y",strtotime($rows["creatdate"]));
				$this->pro_content["ModifyDate"]=date("d-m-Y",strtotime($rows["modifydate"]));
				$this->pro_content["Author"]=$rows["author"];
				$this->pro_content["GmID"]="".$rows["gmem_id"];
				$this->pro_content["MetaKey"]=stripslashes($rows["metakey"]);
				$this->pro_content["MetaDesc"]=stripslashes($rows["metadesc"]);
				$this->pro_content["Visited"]=$rows["visited"];
				$this->pro_content["Order"]=$rows["order"];
				$this->pro_content["isActive"]=$rows["isactive"];
			}
		}
		function getAllList($strwhere="",$lagid=0){
			$sql=" SELECT * 
					FROM view_content
					WHERE lag_id='$lagid' $strwhere";
					//echo $sql;
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}
		
		function getCatName($catid) {
			$sql="SELECT name from tbl_category_text where cat_id=$catid";
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
			if($objdata->Numrows()>0) {
				$r=$objdata->FetchArray();
				return $r[0];
			}
		}
		function getConByCateID($cateid){
			$sql="SELECT *
					FROM view_content
					WHERE cat_id in('$cateid') ";
			//echo $sql; die();
			$objdata=new CLS_MYSQL;
			$objdata->Query($sql);
			if($objdata->Numrows()>0)
			{
				$rows=$objdata->FetchArray();
				$this->pro_content["ID"]=$rows["con_id"];
				$this->pro_content["Code"]=stripslashes($rows["code"]);
				$this->pro_content["CatID"]=$rows["cat_id"];
				$this->pro_content["Title"]=stripslashes($rows["title"]);
				$this->pro_content["Intro"]=stripslashes($rows["intro"]);
				$this->pro_content["Fulltext"]=stripslashes($rows["fulltext"]);
				$this->pro_content["CreateDate"]=date("d-m-Y",strtotime($rows["creatdate"]));
				$this->pro_content["ModifyDate"]=date("d-m-Y",strtotime($rows["modifydate"]));
				$this->pro_content["Author"]=$rows["author"];
				$this->pro_content["GmID"]="".$rows["gmem_id"];
				$this->pro_content["MetaKey"]=stripslashes($rows["metakey"]);
				$this->pro_content["MetaDesc"]=stripslashes($rows["metadesc"]);
				$this->pro_content["Visited"]=$rows["visited"];
				$this->pro_content["Order"]=$rows["order"];
				$this->pro_content["isActive"]=$rows["isactive"];
				return true;
			}
			else
				return false;
		}		
		function listTableCon($strwhere="",$page,$lagid=0){
			$star=($page-1)*MAX_ROWS;
			$leng=MAX_ROWS;
			$sql="	SELECT * 
				FROM view_content
				WHERE lag_id='$lagid' $strwhere ORDER BY `order` DESC LIMIT $star,$leng";
			
			$objdata=new CLS_MYSQL();
			$objdata->Query($sql);
			$i=0;
			while($rows=$objdata->FetchArray())
			{	$i++;
				$conid=$rows["con_id"];
				$title=Substring(stripslashes($rows["title"]),0,10);
				
				$intro = stripslashes($rows["intro"]);
				$intro = str_get_html($intro)->plaintext;
				$intro = Substring($intro,0,15);
				$author=$rows["author"];
				$category = $this->getCatName($rows["cat_id"]);
				
				$visited=$rows["visited"];
				$order=$rows["order"];
				echo "<tr name=\"trow\">";
				echo "<td width=\"30\" align=\"center\">$i</td>";
				echo "<td width=\"30\" align=\"center\"><label>";
				echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" 	 onclick=\"docheckonce('checkid');\" value=\"$conid\" />";
				echo "</label></td>";
				echo "<td width=\"100\">$title</td>";
				//echo "<td width=\"15\">$intro</td>";
				
				echo "<td>$intro</td>";
				echo "<td>$category</td>";
				echo "<td width=\"30\">$author</td>";
				
				echo "<td width=\"30\" align=\"center\">$visited</td>";
				echo "<td align=\"center\"><input type=\"text\" name=\"txtorder\" id=\"txtorder\" value=\"$order\" size=\"4\" class=\"order\"></td>";
				echo "<td align=\"center\">";
			
				echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;conid=$conid\">";
				showIconFun('publish',$rows["isactive"]);
				echo "</a>";
			
				echo "</td>";
				echo "<td align=\"center\">";
			
				echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;conid=$conid\">";
				showIconFun('edit','');
				echo "</a>";
			
				echo "</td>";
				echo "<td align=\"center\">";
			
				echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;conid=$conid')\" >";
				showIconFun('delete','');
				echo "</a>";
			
				echo "</td>";
		  		echo "</tr>";
			}
		}
		function LoadConType($cur_id=0,$par_id=0,$space=''){
			$sql="SELECT * FROM `tbl_gmember` WHERE par_id=$par_id";
			$objdata=new CLS_MYSQL();
			$objdata->Query($sql);
			while($rows=$objdata->FetchArray())
			{
				$modid=$rows["gmem_id"];
				$name=$rows["name"];
				if($cur_id==$modid)
					echo "<option value=\"$modid\" selected=\"selected\">$space $name</option>";
				else
					echo "<option value=\"$modid\">$space $name</option>";
				$this->LoadConType($cur_id,$modid,$space."-- ");
			}
		}
		function LoadConTypes(){
			$sql="SELECT * FROM `view_content` ".strwhere;
			$objdata=new CLS_MYSQL();
			$objdata->Query($sql);
			while($rows=$objdata->FetchArray())
			{
				$conid=$rows["con_id"];
				
				$title=$rows["title"];
				echo "<option value=\"$conid\">$title</option>";
			}
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
			$sql="INSERT INTO tbl_content (`code`,`cat_id`,`creatdate`,`modifydate`,`gmem_id`,`metakey`,`metadesc`,`isactive`) VALUES ";
			$sql.="('".addslashes($this->pro_content["Code"])."','".$this->pro_content["CatID"]."','";
			$sql.=$this->pro_content["CreateDate"]."','".$this->pro_content["ModifyDate"]."','".$this->pro_content["GmID"]."','";
			$sql.=($this->pro_content["MetaKey"])."','".($this->pro_content["MetaDesc"])."','".$this->pro_content["IsActive"]."')";
			$result=$objdata->Query($sql);
			
			$conid=$objdata->LastInsertID();
			$sql="INSERT INTO tbl_content_text (`con_id`,`intro`,`title`,`fulltext`,`author`,`lag_id`) VALUES";
			$sql.="('$conid','".($this->pro_content["Intro"])."','".($this->pro_content["Title"])."','";
			$sql.=addslashes($this->pro_content["Fulltext"])."','".$this->pro_content["Author"]."','".$this->pro_content["LangID"]."')";
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
			$sql="UPDATE tbl_content SET `code`='".($this->pro_content["Code"])."',
										 `cat_id`='".$this->pro_content["CatID"]."', 
										 `creatdate`='".$this->pro_content["CreateDate"]."',
										 `modifydate`='".$this->pro_content["ModifyDate"]."',
										 `gmem_id`='".$this->pro_content["GmID"]."',
										 `metakey`='".($this->pro_content["MetaKey"])."',
										 `metadesc`='".($this->pro_content["MetaDesc"])."',
										 `isactive`='".$this->pro_content["IsActive"]."' 
									WHERE `con_id`='".$this->pro_content["ID"]."'";
			$result = $objdata->Query($sql);
			
			$sql="UPDATE tbl_content_text SET `title`='".($this->pro_content["Title"])."',
											  `intro`='".($this->pro_content["Intro"])."',
											  `fulltext`='".($this->pro_content["Fulltext"])."',
											  `author`='".$this->pro_content["Author"]."'
									WHERE `con_id`='".$this->pro_content["ID"]."' AND 
										  `lag_id`='".$this->pro_content["LangID"]."'";
			$result1 = $objdata->Query($sql);
			
			if($result && $result1 ){
				$objdata->Query('COMMIT');
				return $result;
			}
			else
				$objdata->Query('ROLLBACK');
		}
		function Delete($conid){
			$objdata=new CLS_MYSQL;
			$objdata->Query("BEGIN");
			$sql="DELETE FROM `tbl_content` WHERE `con_id` in ('$conid')";
			$result=$objdata->Query($sql);
			$sql="DELETE FROM `tbl_content_text` WHERE `con_id` in ('$conid')";
			$result1=$objdata->Query($sql);
			//echo $sql;die();
			if($result && $result1 ){
				$objdata->Query('COMMIT');
				return $result;
			}else
				$objdata->Query('ROLLBACK');
		}
		function Order($conid,$order){
			$objdata=new CLS_MYSQL;
			$sql="UPDATE tbl_content SET `order`='".$order."' WHERE `con_id`='".$conid."'";	
			//echo $sql;die();
			$objdata->Query($sql);	
		}
		function ActiveOne($conid){
			$sql="UPDATE `tbl_content` SET `isactive` = IF(isactive=1,0,1) WHERE `con_id` in 	('$conid')";
			
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Publish($conid){
			$sql="UPDATE `tbl_content` SET `isactive` = \"1\" WHERE `con_id` in ('$conid')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function UnPublish($conid){
			$sql="UPDATE `tbl_content` SET `isactive` = \"0\" WHERE `con_id` in ('$conid')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Orders($arids,$arods){
			for($i=0;$i<count($arids);$i++)
			{
				//$this->Order($arids[$i],$i);
				$this->Order($arids[$i],$arods[$i]);
				
			}
		}
	}
?>