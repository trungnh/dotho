<?php
	class CLS_PRODUCTS{
		var $pro_product=array(
			"ID"=>"-1",
			"CataID"=>"0",
			"Video"=>"",
			"Cur_price"=>"",
			"Old_price"=>"",
			"Quantity"=>"",
			"Joindate"=>"",
			"Creator"=>"",
			"Name"=>"",
			"Intro"=>"",
			"Fulltext"=>"",
			"Iscan"=>"iscan",
			"Unit"=>"",
                        "Sale"=>"0",
			"LangID"=>"0",
			"IsActive"=>"1",
                        "isEdit"=>"0"//create column in db isedt default=1
		);
                var $lastProId;
		var $result;
		function CLS_PRODUCTS(){
		}
		function __set($proname,$value){
			if(!isset($this->pro_product[$proname]))
			{
				echo ("Can't found $proname members");
				return;
			}
			$this->pro_product[$proname]=$value;
		}
		function __get($proname){
			if(!isset($this->pro_product[$proname]))
			{
				echo ("Can't found $proname member");
				return;
			}
			return $this->pro_product[$proname];// phai tra ve gia tri
		}
		function getProByID($proid,$lagid=0){
			$sql="SELECT *
					FROM view_products
					WHERE pro_id=\"$proid\" AND `lag_id`='$lagid'";
			$objdata=new CLS_MYSQL;
			$objdata->Query($sql);
			if($objdata->Numrows()>0)
			{
				$rows=$objdata->FetchArray();
				$this->pro_product["ID"]=$rows["pro_id"];
				$this->pro_product["CataID"]=$rows["cata_id"];
				$this->pro_product["Name"]=stripslashes($rows["name"]);
				$this->pro_product["Intro"]=stripslashes($rows["intro"]);
				$this->pro_product["Fulltext"]=stripslashes($rows["fulltext"]);
				$this->pro_product["Joindate"]=date("d-m-Y",strtotime($rows["joindate"]));
				$this->pro_product["Creator"]=$rows["creator"];
				$this->pro_product["Cur_price"]=stripslashes($rows["cur_price"]);
				$this->pro_product["Old_price"]=stripslashes($rows["old_price"]);
				$this->pro_product["Video"]=$rows["video"];
				$this->pro_product["Quantity"]=$rows["quantity"];
				$this->pro_product["Unit"]=$rows["unit"];
                $this->pro_product["Sale"]=$rows["sale"];
				$this->pro_product["Iscan"]=$rows["iscan"];
				$this->pro_product["isActive"]=$rows["isactive"];
			}
		}
		function getAllList($strwhere="",$lagid=0){
			$sql=" SELECT * 
					FROM view_products
					WHERE lag_id='$lagid' $strwhere";
					//echo $sql;die();
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}
		function getProByCataID($cataid){
			$sql="SELECT *
					FROM view_products
					WHERE cata_id in('$cataid') ";
			//echo $sql; die();
			$objdata=new CLS_MYSQL;
			$objdata->Query($sql);
			if($objdata->Numrows()>0)
			{
				$rows=$objdata->FetchArray();
				$this->pro_product["ID"]=$rows["pro_id"];
				$this->pro_product["CataID"]=$rows["cata_id"];
				$this->pro_product["Name"]=stripslashes($rows["name"]);
				$this->pro_product["Intro"]=stripslashes($rows["intro"]);
				$this->pro_product["Fulltext"]=stripslashes($rows["fulltext"]);
				$this->pro_product["Joindate"]=date("d-m-Y",strtotime($rows["joindate"]));
				$this->pro_product["Creator"]=$rows["creator"];
				$this->pro_product["Cur_price"]=stripslashes($rows["cur_price"]);
				$this->pro_product["Old_price"]=stripslashes($rows["old_price"]);
				$this->pro_product["Video"]=$rows["video"];
				$this->pro_product["Quantity"]=$rows["quantity"];
				$this->pro_product["Unit"]=$rows["unit"];
				$this->pro_product["Iscan"]=$rows["iscan"];
                $this->pro_product["Sale"]=$rows["sale"];
				$this->pro_product["isActive"]=$rows["isactive"];
				return true;
			}
			else
				return false;
		}	
		
		function getCataName($cataid) {
			$sql="SELECT name from tbl_catalogs_text where cata_id=$cataid";
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
			if($objdata->Numrows()>0) {
				$r=$objdata->FetchArray();
				return $r[0];
			}
		}	
		function listTablePro($strwhere="",$page,$lagid=0){
			$flag = 0;
			if($lagid==-1){
				$flag = 1;
				$lagid = 0;
			}
			$star=($page-1)*MAX_ROWS;
			$leng=MAX_ROWS;
			$sql="	SELECT * 
				FROM view_products
				WHERE lag_id='$lagid' $strwhere ORDER BY `order` LIMIT $star,$leng";
			//echo $sql;
			$objdata=new CLS_MYSQL();
			$objdata->Query($sql);
			$i=0;
			while($rows=$objdata->FetchArray())
			{	$i++;
				$proid=$rows["pro_id"];
				$name=Substring(stripslashes($rows["name"]),0,10);
				//$intro = Substring(stripslashes($rows["intro"]),0,10);
				$creator=$rows["creator"]; $order=$rows["order"];
				$catalog = $this->getCataName($rows["cata_id"]);
				$quantity=$rows["quantity"];
				echo "<tr name=\"trow\">";
				echo "<td width=\"30\" align=\"center\">$i</td>";
				if($flag != 1)
				echo "<td width=\"30\" align=\"center\"><label>";
				if($flag != 1)
				echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" 	 onclick=\"docheckonce('checkid');\" value=\"$proid\" />";
				if($flag != 1)
				echo "</label></td>";
				echo "<td width=\"100\"><a href=\"index.php?com=products&amp;task=edit&amp;proid=$proid\">$name</a></td>";
				//echo "<td width=\"15\">$intro</td>";
				if($flag != 1)
				//echo "<td>$intro</td>";
				echo "<td>$catalog</td>";
				echo "<td width=\"30\">$creator</td>";
				
				echo "<td width=\"30\">$quantity</td>";
				echo "<td align=\"center\"><input type=\"text\" name=\"txtorder\" id=\"txtorder\" value=\"$order\" size=\"4\" class=\"order\"></td>";
				if($flag != 1)
				echo "<td>";
				if($flag != 1)
				echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;proid=$proid\">";
				if($flag != 1)
				showIconFun('publish',$rows["isactive"]);
				if($flag != 1)
				echo "</a>";
				if($flag != 1)
				echo "</td>";
				if($flag != 1)
				echo "<td align=\"center\">";
				if($flag != 1)
				echo "<a href=\"index.php?com=products&amp;task=edit&amp;proid=$proid\">";
				if($flag != 1)
				showIconFun('edit','');
				if($flag != 1)
				echo "</a>";
				if($flag != 1)
				echo "</td>";
				if($flag != 1)
				echo "<td align=\"center\">";
				if($flag != 1)
				echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;proid=$proid')\" >";
				if($flag != 1)
				showIconFun('delete','');
				if($flag != 1)
				echo "</a>";
				if($flag != 1)
				echo "</td>";
				if($flag == 1){
					$count=0;
					$sql2= "SELECT * FROM `tbl_order_detail` WHERE  `pro_id` = $proid";
					$objdata2=new CLS_MYSQL();
					$objdata2->Query($sql2);
					while($rows2=$objdata2->FetchArray()){
						$order_id = $rows2["order_id"];
						$sql3 = "SELECT * FROM `tbl_order` where `id` = $order_id";
						$objdata3=new CLS_MYSQL();
						$objdata3->Query($sql3);
						while($rows3=$objdata3->FetchArray()){
							if($rows3['status']==1){
								$count = $count + $rows2['count'];
							}
						}
					}
				echo "<td>$count</td>";
				}
		  		echo "</tr>";
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
			$sql="INSERT INTO tbl_products (`video`,`cata_id`,`iscan`,`joindate`,`creator`,`cur_price`,`old_price`,`quantity`,`isactive`,`sale`,`isedit`) VALUES ";
			$sql.="('".addslashes($this->pro_product["Video"])."','".$this->pro_product["CataID"]."','".$this->pro_product["Iscan"]."','";
			$sql.=$this->pro_product["Joindate"]."','".$this->pro_product["Creator"]."','".$this->pro_product["Cur_price"]."','";
			$sql.=($this->pro_product["Old_price"])."','".($this->pro_product["Quantity"])."','".$this->pro_product["IsActive"]."','".$this->pro_product["Sale"]."','".$this->pro_product["isEdit"]."')";
			$result=$objdata->Query($sql);
                        
			$proid=$objdata->LastInsertID();
                        $this->lastProId = $proid;
			$sql="INSERT INTO tbl_products_text (`pro_id`,`intro`,`fulltext`,`name`,`unit`,`lag_id`) VALUES";
			$sql.="('$proid','".($this->pro_product["Intro"])."','".($this->pro_product["Fulltext"])."','".($this->pro_product["Name"])."','";
			$sql.=$this->pro_product["Unit"]."','".$this->pro_product["LangID"]."')";
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
			$sql="UPDATE tbl_products SET `cata_id`='".$this->pro_product["CataID"]."', 
										 `iscan`='".$this->pro_product["Iscan"]."',
                                                                                `sale`='".$this->pro_product["Sale"]."', 
										 `joindate`='".$this->pro_product["Joindate"]."',
										 `video`='".$this->pro_product["Video"]."',
										 `creator`='".$this->pro_product["Creator"]."',
										 `cur_price`='".($this->pro_product["Cur_price"])."',
										 `old_price`='".($this->pro_product["Old_price"])."',
										 `quantity`='".($this->pro_product["Quantity"])."',
										 `isactive`='".$this->pro_product["IsActive"]."',
                                                                                  `isedit`='1'
									WHERE `pro_id`='".$this->pro_product["ID"]."'";
			$result = $objdata->Query($sql);
                        
			
			$sql="UPDATE tbl_products_text SET `name`='".($this->pro_product["Name"])."',
											  `intro`='".($this->pro_product["Intro"])."',
											  `fulltext`='".($this->pro_product["Fulltext"])."',
											  `unit`='".($this->pro_product["Unit"])."'
									WHERE `pro_id`='".$this->pro_product["ID"]."' AND 
										  `lag_id`='".$this->pro_product["LangID"]."'";
			$result1 = $objdata->Query($sql);
			
			if($result && $result1 ){
				$objdata->Query('COMMIT');
				return $result;
			}
			else
				$objdata->Query('ROLLBACK');
		}
		function Delete($proid){
			$objdata=new CLS_MYSQL;
			$objdata->Query("BEGIN");
			$sql="DELETE FROM `tbl_products` WHERE `pro_id` in ('$proid')";
			$result=$objdata->Query($sql);
			$sql="DELETE FROM `tbl_products_text` WHERE `pro_id` in ('$proid')";
			$result1=$objdata->Query($sql);
			//echo $sql;die();
			if($result && $result1 ){
				$objdata->Query('COMMIT');
				return $result;
			}else
				$objdata->Query('ROLLBACK');
		}
		function ActiveOne($proid){
			$sql="UPDATE `tbl_products` SET `isactive` = IF(isactive=1,0,1) WHERE `pro_id` in 	('$proid')";
			
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Publish($proid){
			$sql="UPDATE `tbl_products` SET `isactive` = \"1\" WHERE `pro_id` in ('$proid')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function UnPublish($proid){
			$sql="UPDATE `tbl_products` SET `isactive` = \"0\" WHERE `pro_id` in ('$proid')";
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
		function Order($proid,$order){
			$objdata=new CLS_MYSQL;
			$sql="UPDATE tbl_products SET `order`='".$order."' WHERE `pro_id`='".$proid."'";	
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