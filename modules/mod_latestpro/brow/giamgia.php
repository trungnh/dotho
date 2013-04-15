<div class="module mod-sales">
<?php
	$datetime=date("Y-m-d");
	$url=WEBSITE;
	if(!isset($objorder))
	$objorder = new CLS_ORDER();
	if(!isset($objorderdetail))
	$objorderdetail = new CLS_ORDER_DETAIL();
	if(!isset($objproduct))
	$objproduct = new CLS_PRODUCTS();
	$objproduct->getProEventID(" and `end_date` >= '$datetime' ",5,0,1);
	if($objproduct->Numrows()>0)
	{
		$rows = $objproduct->Fecth_Array();
		$idpro=$rows["pro_id"];
		//echo $idpro;
		$cur_price=number_format($rows["cur_price"]);
		$old_price=number_format($rows["old_price"]);
		if($rows["cur_price"] < $rows["old_price"] && $rows["old_price"]!=0)
			{
				$giamtru=$rows["sales"];
			}	
		$imagethumb=$objproduct->showProImagesThumb($rows["pro_id"]);	
		$objorder->getListProduct(" where `status`='2' and `pro_id`='$idpro' ");
		$sl=0;
		while($rows1 = $objorder->Fecth_Array())
		{
			$sl+=$rows1["count"];
		}
		$objproduct->getProByID($idpro,0);
		echo '<div class="sales-left">
			<span class="sales-price">-'.$giamtru.'<span class="rate">%</span></span>
			<a class="img-sales" href="'.$url.$idpro.'/'.stripUnicode($objproduct->Name).'.html" title="'.$objproduct->Name.'"><img src="'.$url.$imagethumb.'" alt="'.$objproduct->Name.'" height="56" /></a>
		</div>
		<div class="box-sales">
		<h2><a href="khuyenmai/5/chuong-trinh-gio-vang.html">Chương trình giờ vàng</a></h2>
		<h3>Từ '.date("d/m",strtotime($rows["start_date"])).' đến '.date("d/m",strtotime($rows["end_date"])).'</h3>
<a class="title" href="'.$url.$rows["pro_id"].'/'.stripUnicode($objproduct->Name).'.html">'.$objproduct->Name.'</a>
<p>Giá cũ: <span>'.$old_price.'&nbsp;₫</span></p>
<p class="price-dow">Giá mới: <span>'.$cur_price.'&nbsp;₫</span></p>
</div>';
	}
	else
		echo "Sản phẩm đang cập nhật";
?>	
</div>											  
<?php
unset($objpro);
unset($objmodule);
?>