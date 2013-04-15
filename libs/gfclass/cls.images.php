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
		function listFristPro($strwhere=""){
			$sql="	SELECT * FROM tbl_image WHERE  $strwhere ORDER BY `order`";
			$objdata=new CLS_MYSQL();
			$objdata->Query($sql);
			$i=0;
			if($objdata->Numrows()>0)
			{
				$rows=$objdata->FetchArray();
					$id=$rows["id"];
					$link=$rows["link"];
					$order=$rows["order"];
					echo '<a href="'.WEBSITE.$link.'" class="cloud-zoom" id="zoom1" rel="adjustX: 10, adjustY:-51, zoomWidth:500, zoomHeight:500" style="position: relative; display: block;">
							<img style="display: block;" src="'.WEBSITE.$link.'" />    
						</a>';
			}
		}
		function listTablePro($strwhere=""){
			$url=WEBSITE;
			//$star=($page-1)*MAX_ROWS;
			//$leng=MAX_ROWS;
			$sql="	SELECT * FROM tbl_image WHERE  $strwhere ORDER BY `order`";
			//echo $sql;
			$objdata=new CLS_MYSQL();
			$objdata->Query($sql);
			$i=0;
			if($objdata->Numrows()>0)
			{
			echo '<div tabindex="0" class="more-views mor-image-control js" id="list-mor-img" style="margin-top: 10px;width: 350px;overflow: hidden;">	  
						<ul style="position: absolute; top: 0px; width: 275px;">';
				while($rows=$objdata->FetchArray())
				{	$i++;
					$id=$rows["id"];
					$link=$rows["link"];
					$order=$rows["order"];
					//$link=str_replace("images","images/thumb",$link);
					echo '<li style="height: 50px;">';
					echo 	"<a href=\"$url$link\" imgfull=\"$url$link\" class=\"cloud-zoom-gallery popup cboxElement\" rel=\"productlist\" reldes=\"useZoom: 'zoom1', smallImage: '$url$link' \" title=\"\">
								<img src=\"$url$link\" alt=\"\" height=\"44\" width=\"44\"></a>
							</li>";		        
				}
			echo '</ul>
					</div>';
			}
		}
		function Numrows(){
			return mysql_num_rows($this->result);
		}
		function FecthArray(){
			
			return @mysql_fetch_array($this->result);
		}
	}
?>