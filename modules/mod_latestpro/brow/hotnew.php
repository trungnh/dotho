<div class="module box-module module-support">
<h3><span>Sản phẩm bán chạy nhất</span></h3>
<div class="list_product">
<ul class="list-item">                        
	<?php
		$url=WEBSITE;
		if(!isset($objproduct))
		$objproduct = new CLS_PRODUCTS();
		$objproduct->getList(" order by static desc limit 0,5");			 
		$i=0; 
		$static="";
		while ($rows = $objproduct->Fecth_Array()) {
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
				$gia='
					<span class="regular-price" id="product-price-new">
					<span class="price">'.number_format($rows["cur_price"]).'&nbsp;₫</span></span>
					<span class="VAT-label"> (VAT: +10%)</span>';
                                if(number_format($rows["cur_price"])==0) 
                                    $gia = '<span class="regular-price" id="product-price-new">
                                        <span class="price">Giá: Liên hệ</span></span>';
			}
			$imagethumb=$objproduct->showProImagesThumb($rows["pro_id"]);	
			$image=$objproduct->showProImages($rows["pro_id"]);
			echo '<li class="item">
				<a class="tooltip" style=" display: block; height: 135px; width: 160px;" href="'.$url.$id.'/'.$name.'.html" title="'.$rows["name"].'"><img src="'.$url.$imagethumb.'" width="135"  alt="'.$rows["name"].'" /></a>
                <div class="product-description">
					<p><a href="'.$url.$id.'/'.stripUnicode($rows["name"]).'.html" title="'.$rows["name"].'">'.$rows["name"].'</a></p>
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
					<div align="center"><img src="'.WEBSITE.$image.'" width="250" alt="'.$rows["name"].'"/></div>
				</pre>
			</li>';
		}
	//echo "</ul>";
	?>
</ul>	
</div>		
</div>											  
<?php
unset($objpro);
unset($objmodule);
?>