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
			"Static"=>"",
            "Sale"=>"0",
			"LangID"=>"0",
			"IsActive"=>"1" // khon co day , o day
		);
		var $result;
		var $tong;
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
				$this->pro_product["Iscan"]=$rows["iscan"];
                $this->pro_product["Sale"]=$rows["sale"];
				$this->pro_product["Static"]=$rows["static"];
				$this->pro_product["isActive"]=$rows["isactive"];
			}
			$this->result=$objdata->Query($sql);
		}
		function getAllList($strwhere="",$lagid=0){
			$sql=" SELECT * 
					FROM view_products
					WHERE lag_id='$lagid' $strwhere";
					//echo $sql;die();
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}
		function getList($where=""){
			$sql="SELECT * FROM `view_products`  WHERE  isactive=1 ".$where;
			//echo $sql;
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
			
		}
		function getlistpage($strwhere="",$page,$dem){
			$star=($page-1)*$dem;
			$leng=$dem;
			$sql="SELECT * 
				FROM view_products
				WHERE isactive=1 $strwhere LIMIT $star,$leng";
			//echo $sql;
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
		}
		function getProEvent($eventid,$str){
		$sql="SELECT `pro_id` FROM `tbl_event_detail` where `event_id`='$eventid' $str";
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$id="";
			while($rows=$objdata->FetchArray())
			{
				$id.=$rows["pro_id"].",";	
			}
		return substr($id,0,strlen($id)-1);
		}
		function getProEventID($str,$eventid,$start,$leng){
		$sql="SELECT * FROM `tbl_event_detail` where `event_id`='$eventid' $str limit $start,$leng";
		//echo $sql;
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
		}
		function showCatalogs($str,$par_id=0,$limit=0) {
			$sql="SELECT name,cata_id FROM view_catalogs where par_id=0 AND  isactive=1 $str ";
			//echo $sql;
			$objdata = new CLS_MYSQL;
			$objdata->Query($sql); 
			if($objdata->Numrows()>0)
			{
				echo '<div class="featured-cat-block"><div class="featured-cat-content">';
				while ($rows = $objdata->FetchArray()) {
					$cataid = $rows["cata_id"];
					$name   = $rows["name"];
					
					echo '<div class="featured-cat list_product">';
					echo '<div class="cat-title"><a title="'.$name.'" href="danhmuc/'.$cataid.'-'.stripUnicode($name).'">'.$name.'</a>';
					echo '<span class="ViewAll">
							<a href="danhmuc/'.$cataid.'-'.stripUnicode($name).'.html" title="'.$name.'">Xem tất cả</a>
						</span>';
					echo '</div>';
					$cataids=$this->getChildID($cataid);
					$cataids=$cataid."','".$cataids;
					$cataids=substr($cataids,0,strlen($cataids)-3);
					$this->showPro("",$cataids,$limit);
					echo '</div>';
				}
				echo '</div></div>';
				
			}
		}
		function showCatalogsParid($str,$par_id=0,$limit=0) {
			$sql="SELECT name,cata_id FROM view_catalogs where cata_id='$par_id' AND  isactive=1 $str ";
			//echo $sql;
			$objdata = new CLS_MYSQL;
			$objdata->Query($sql); 
			if($objdata->Numrows()>0)
			{
				
				while ($rows = $objdata->FetchArray()) {
					$cataid = $rows["cata_id"];
                    $name=str_replace(" ","-",$rows["name"]);
                    $name=stripUnicode($rows["name"]);
					echo '<div class="featured-cat list_product">';
					echo '<div class="cat-title"><a href="'.WEBSITE.'danhmuc/'.$par_id.'-'.stripUnicode($name).'.html" title="'.$name.'">'.$rows["name"].'</a></div>';					
					$this->showPro("",$par_id,$limit);
					echo '<span class="ViewAll">
							<a href="'.WEBSITE.'danhmuc/'.$par_id.'-'.stripUnicode($name).'.html" title="'.$name.'">Xem tất cả</a>
						</span>';
					echo '</div>';
				}
				
			}
		}
		function getChildID($parid) {
			$sql = "SELECT cata_id FROM tbl_catalogs WHERE par_id IN ('$parid')"; 
			$objdata = new CLS_MYSQL; 
			$this->result = $objdata->Query($sql);
			
			$ids='';
			if($objdata->Numrows()>0) {
				while($r = $objdata->FetchArray()) {
					$ids.=$r[0]."','";
					$ids.=$this->getChildID($r[0]);
				}
			}
			return $ids;
		}
		function showProNew_Numrow($cataid=0) {
			$sql="SELECT pro_id,images,name FROM view_products where cata_id IN ('$cataid') AND isactive=1 ORDER BY pro_id DESC ";
			//echo $sql;
			$objdata = new CLS_MYSQL;
			$objdata->Query($sql);
			$this->result=$objdata->Query($sql);
		}
		function showProImagesThumb($pro_id=0) {
			$sql="SELECT id, pro_id, link FROM tbl_image where `pro_id`='$pro_id' and isactive=1 ORDER BY pro_id DESC ";
			//echo $sql;
			$objdata = new CLS_MYSQL;
			$objdata->Query($sql);
			if($objdata->Numrows()>0)
			{
				$rows = $objdata->FetchArray();
				$img=str_replace("images","images/thumb",$rows["link"]);
			}
			else
				$img="";
                        //return $rows["link"];
			return $img;
		}
		function showProImages($pro_id=0) {
			$sql="SELECT id, pro_id, link FROM tbl_image where `pro_id`='$pro_id' and isactive=1 ORDER BY pro_id DESC ";
			//echo $sql;
			$objdata = new CLS_MYSQL;
			$objdata->Query($sql);
			if($objdata->Numrows()>0)
			{
				$rows = $objdata->FetchArray();
				$img=$rows["link"];
			}
			else
				$img="";
			return $img;
		}
		function showPro($strwhere,$cataid=0,$limit=0) {
			$url=WEBSITE;
			$sql="SELECT * FROM view_products  where cata_id IN ('$cataid') AND isactive=1  $strwhere ORDER BY RAND() ";
			if($limit>0)
			$sql.="limit $limit";
			//echo $sql;
			$objdata = new CLS_MYSQL;
			$objdata->Query($sql);
			$i=0; 
			$static="";
			if($objdata->Numrows()>0)
			{
				echo "<ul class=\"list-item list-griditem\">";
				while ($rows = $objdata->FetchArray()) {
				$i++;
				$id=$rows["pro_id"];
				if($rows["quantity"] > 0)
					$static="Còn hàng";
				else
					$static="Hết hàng";
                $name=stripUnicode($rows["name"]);
				if($rows["cur_price"] < $rows["old_price"] && $rows["old_price"]!=0)
				{
					$giamtru=$rows["sale"];
					$sales='<div class="promotion-list"><span>-'.$giamtru.'%</span></div>';
					$gia='
						<p class="old-price">
							<span class="price-label">Giá cũ<span class="twodot">:</span></span>
							<span id="old-price-new" class="price">'.number_format($rows["old_price"]).'&nbsp;₫</span>
						</p>
						<p class="special-price">
							<span class="price-label">Giá mới<span class="twodot">:</span></span>
							<span id="product-price-new" class="price">'.number_format($rows["cur_price"]).'&nbsp;₫<span class="price-discount"> (-'.$giamtru.'%)</span></span>
							<span class="VAT-label"> (VAT: +10%)</span>
						</p>';
				}
				else
				{
					$sales="";
                                        $gia='
						<span class="regular-price" id="product-price-new">
						<span class="price">'.number_format($rows["cur_price"]).'&nbsp;₫</span></span>
						<span class="VAT-label"> (VAT: +10%)</span>';
                                        if(number_format($rows["cur_price"])==0) 
                                            $gia = '<span class="regular-price" id="product-price-new">
						<span class="price">Giá: Liên hệ</span></span>';
				}
				$imagethumb=$this->showProImagesThumb($rows["pro_id"]);	
				$image=$this->showProImages($rows["pro_id"]);
				echo '<li class="item-product griditem">'.$sales.'
					<a class="tooltip" style=" display: block; height: 135px; width: 160px;" href="'.$url.$id.'/'.$name.'.html" title="'.$rows["name"].'"><img src="'.$url.$imagethumb.'" width="135"  alt="'.$rows["name"].'" /></a>
					<div class="product-description">
						<p><a href="'.$url.$id.'/'.$name.'.html" title="'.$rows["name"].'">'.$rows["name"].'</a></p>
						<div class="price-box">'.$gia.'</div>

					</div>
					<pre class="hidden" style="display:none">
						<div class="name"><p>'.$rows["name"].'</p></div>
						<table>
							<tbody>
								<tr class="">
									<td class="label-row margin">Giá </td>
									<td class="value-row margin">:<span class="value" style=""> 
									<div class="price-box">'.$gia.'</div>
									</span></td>
								</tr>
								<tr class="">
									<td class="label-row margin">Trạng thái</td>
									<td class="value-row margin">:<span class="value"> '.$static.'</span></td>
								</tr>
								<tr class="">
									<td class="label-row margin">Vận chuyển</td>
									<td class="value-row margin">:<span class="value">Liên hệ</span></td>
								</tr>
							</tbody>
						</table>
						<div align="center"><img src="'.$url.$image.'" width="250"  alt="'.$rows["name"].'"/></div>
					</pre>
				</li>';
			}
		echo "</ul>";
			}
		}
		function showProPage($strwhere,$cur_page=1) {
			$start = ($cur_page-1)*20;
			$url=WEBSITE;
			$sql="SELECT * FROM view_products  where isactive=1  $strwhere LIMIT ".$start.',20'; 
			$objdata = new CLS_MYSQL;
			$objdata->Query($sql);
			$i=0; 
			$static="";
			if($objdata->Numrows()>0)
			{
				
				echo "<ul id=\"child-catalog\" class=\"list-item\">";
				while ($rows = $objdata->FetchArray()) {
				$i++;
				$id=$rows["pro_id"];
				if($rows["quantity"] > 0)
					$static="Còn hàng";
				else
					$static="Hết hàng";
				if($rows["cur_price"] < $rows["old_price"] && $rows["old_price"]!=0)
				{
					$giamtru=$rows["sale"];
					$sales='<div class="promotion-list"><span>-'.$giamtru.'%</span></div>';
					$gia='
						<p class="old-price">
							<span class="price-label">Giá cũ<span class="twodot">:</span></span>
							<span id="old-price-new" class="price">'.number_format($rows["old_price"]).'&nbsp;₫</span>
						</p>
						<p class="special-price">
							<span class="price-label">Giá mới<span class="twodot">:</span></span>
							<span id="product-price-new" class="price">'.number_format($rows["cur_price"]).'&nbsp;₫<span class="price-discount"> (-'.$giamtru.'%)</span></span>
							<span class="VAT-label"> (VAT: +10%)</span>
						</p>';
				}
				else
				{
					$sales="";
					$gia='
						<span class="regular-price" id="product-price-new">
						<span class="price">'.number_format($rows["cur_price"]).'&nbsp;₫</span></span>
						<span class="VAT-label"> (VAT: +10%)</span>';
                                        if(number_format($rows["cur_price"])==0) 
                                            $gia = '<span class="regular-price" id="product-price-new">
						<span class="price">Giá: Liên hệ</span></span>';
				}
					$sanhang="";
				$imagethumb=$this->showProImagesThumb($rows["pro_id"]);	
				$image=$this->showProImages($rows["pro_id"]);
				echo "<li class=\"item-product\">$sales"."".'
					<a class="tooltip" style=" display: block; height: 135px; width: 135px;" href="'.$url.$id .'/'.stripUnicode($rows["name"]).'.html"  title="'.$rows["name"].'"><img src="'.$url.$imagethumb.'" width="135"  alt="'.$rows["name"].'" /></a>
					<div class="product-description">
						<p><a href="'.$url.$id.'/'.stripUnicode($rows["name"]).'.html">'.$rows["name"].'</a></p>
						<div class="price-box">'.$gia.'</div>
					</div>
					<pre class="hidden" style="display:none">
						<div class="name"><p>'.$rows["name"].'</p></div>
						<table>
							<tbody>
								<tr class="">
									<td class="label-row margin">Giá </td>
									<td class="value-row margin">:<span class="value" style=""> 
									<div class="price-box">'.$gia.'</div>
									</span></td>
								</tr>
								<tr class="">
									<td class="label-row margin">Trạng thái</td>
									<td class="value-row margin">:<span class="value"> '.$static.'</span></td>
								</tr>
								'.$sanhang.'
								<tr class="">
									<td class="label-row margin">Vận chuyển</td>
									<td class="value-row margin">:<span class="value">Liên hệ</span></td>
								</tr>
							</tbody>
						</table>
						<div  align="center"><img src="'.$url.$image.'" width="250"  alt="'.$rows["name"].'"/></div>
					</pre>
				 </li>';
				}
				echo "</ul>";
			}
		}
		function getProViewCart($str){
		$sql="SELECT * FROM `tbl_event_detail` $str";
		//echo $sql;
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
		if($objdata->Numrows()<0)
		return 0;
		else
			{
			$row=$objdata->FetchArray();
			$price=$row["cur_price"];
			return $price;
			}
		}
		function viewShoppingCart($ids,$sls) {
		
		$arrids = explode(",",$ids);
		$arrsls = explode(",",$sls);
		$ids = str_replace(",","','",$ids);
		
		$sql = "SELECT pro_id,name,cur_price, old_price FROM `view_products` WHERE `pro_id` IN('".$ids."')";
		//echo $sql;
		$objdata= new CLS_MYSQL();
        $objdata->Query($sql);
		
		$str='';$total=0;
		while($row=$objdata->FetchArray())
        {
			$time=date("Y-m-d");
			$id=$row["pro_id"];
			$price=$this->getProViewCart("where pro_id = '$id' and  `end_date`> $time");
			//echo $objdata->Numrows();
			if($price>0)
			{
				$curprice=$price;
			}
			else
			$curprice=$row["cur_price"];
			$sl=1;
			for($i=0;$i<count($arrids);$i++) {
				if($arrids[$i]==$row["pro_id"])
					$sl=$arrsls[$i];
			}
			$img=$this->showProImages($row["pro_id"]);
				$img = '<img class="img_cart" src="'.$img.'" width="100" align="absmiddle"/>';	
			$total += $curprice*$sl;
			
			 $str.='<tr class="tr_viewcart">
				<td align="left"><div class="namepro_cart">'.$row["name"].'</div></td>
				<td><div class="imgcart">'.$img.'<div class="boximg-cart"><img height="300px" src="'.$img.'"  alt="'.$row["name"].'"/></div></div></td>
				<td align="center"><input name="txtsl[]" type="text" id="txtsl_'.$row["pro_id"].'" size="5" value="'.$sl.'" /><input type="hidden" name="txtid[]" id="txtid_'.$row["pro_id"].'" value="'.$row["pro_id"].'"/></td>
				<td align="center" style="color:#F00;">'.number_format($curprice).'</td>
				<td align="center" style="color:#F00;">'.number_format($curprice*$sl).'</td>
				<td align="center" style=\"color:#EEEEEE\"><a  title="'.$row["name"].'" href="remove-'.$row["pro_id"].'-'.$row["name"].'.html">Xóa</a></td>
			  </tr>';

		}
		if($str!="") {
			 $str.=' <tr>
				<td colspan="4" align="right"><strong>Tổng thành tiền(VNĐ)</strong></td>
				<td align="right"><strong style="color:#F00;">'.number_format($total).'</strong></td>
				<td align="right">&nbsp;</td>
			  </tr>';
		}
		echo $str;
	}
	function viewEmailCart($ids,$sls) {
		
		$arrids = explode(",",$ids);
		$arrsls = explode(",",$sls);
		$ids = str_replace(",","','",$ids);
		
		$sql = "SELECT pro_id,name,cur_price FROM `view_products` WHERE `pro_id` IN('".$ids."')";
		//echo $sql;
		$objdata= new CLS_MYSQL();
        $objdata->Query($sql);
		
		$str='';$total=0;
		while($row=$objdata->FetchArray())
        {
			$time=date("Y-m-d");
			$id=$row["pro_id"];
			$price=$this->getProViewCart("where pro_id = '$id' and  `end_date`> $time");
			if($price>0)
			{
				$curprice=$price;
			}
			else
			$curprice=$row["cur_price"];
			$sl=1;
			for($i=0;$i<count($arrids);$i++) {
				if($arrids[$i]==$row["pro_id"])
					$sl=$arrsls[$i];
			}
			$total += $curprice*$sl;
			
			 $str.='<tr class="tr_viewcart">
				<td align="left">'.$row["name"].'</td>
				<td align="center">'.$sl.'</td>
				<td align="center" style="color:#F00;">'.number_format($curprice).'</td>
				<td align="center" style="color:#F00;">'.number_format($curprice*$sl).'</td>
			  </tr>';

		}
		if($str!="") {
			 $str.=' <tr>
				<td colspan="4" align="right"><strong>Tổng tiền</strong></td>
				<td align="right"><strong style="color:#F00;">'.number_format($total).'</strong></td>
			  </tr>';
		}
		return $str;
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
				$this->pro_product["Joindate"]=date("d-m-Y",strtotime($rows["joindate"]));
				$this->pro_product["Creator"]=$rows["creator"];
				$this->pro_product["Cur_price"]=stripslashes($rows["cur_price"]);
				$this->pro_product["Old_price"]=stripslashes($rows["old_price"]);
				$this->pro_product["Images"]=$rows["images"];
				$this->pro_product["Quantity"]=$rows["quantity"];
				$this->pro_product["Unit"]=$rows["unit"];
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
		function getLastPro($str) {
			$sql="SELECT pro_id from view_products where isactive='1' ".$str;
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
			if($objdata->Numrows()>0) {
				$r=$objdata->FetchArray();
				return $r["pro_id"];
			}
		}
		function Numrows(){
			return mysql_num_rows($this->result);
		}
		function Fecth_Array(){
			
			return @mysql_fetch_array($this->result);
		}
		function UpdateStatic($proid){
			$sql="UPDATE tbl_products SET `static`=`static`+1 WHERE `pro_id` = '$proid'";
			//echo $sql; die();
			$objdata=new CLS_MYSQL;
			return $objdata->Query($sql);
		}
	}
?>