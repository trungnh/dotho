<div class="rw-wrapper" id="rvi_panel">
	<div class="recently-viewed">
		<div class="title-btnHide">
			<div class="rw-title">Có thể bạn quan tâm</div>
		</div>
			<div class="viewed-products">
				<div class="js clearfix" id="home-manufacturers">
					<ul class="list-item">                        
						<?php
                            //$ids=$_SESSION["PRODUCT"];
							$url=WEBSITE;
							if(!isset($objproduct))
							$objproduct = new CLS_PRODUCTS();
						    $objproduct->getList(" and `iscan`= '1' order by `pro_id` desc limit 0,15");	
                           // $objproduct->getList(" and `pro_id` in ($ids) limit 0,15");		 
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
								}
								$imagethumb=$objproduct->showProImagesThumb($rows["pro_id"]);	
								$image=$objproduct->showProImages($rows["pro_id"]);
								echo "<li class=\"item-product griditem\">$sales
									<a class=\"tooltip\" style=\" display: block; height: 135px; width: 160px;\" href=\"$url$id/$name.html\" title=\"".$rows["name"]."\"><img src=\"$url$imagethumb\" width=\"135\"  alt=\"".$rows["name"]."\" /></a>";
                                echo '
									<div class="product-description">
										<p><a href="'.$url.$id.'/'.$name.'.html" title="'.$rows["name"].'"  title="'.$rows["name"].'">'.$rows["name"].'</a></p>
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
										<div align="center"><img src="'.$url.$image.'" width="250"  alt="'.$rows["name"].'" /></div>
									</pre>
								</li>';
							}
						?>
					</ul>														  
				</div>
			</div>
		</div>    
	</div>
<script type="text/javascript" src="<?php echo WEBSITE;?>js/jquery_004.js"></script>
<script type="text/javascript" src="<?php echo WEBSITE;?>js/carousel.js"></script>
<script type="text/javascript" src="<?php echo WEBSITE;?>js/jquery_005.js"></script>
<script type="text/javascript">  
 
jQuery.noConflict();
(function($) {                    
    $(function(){    
        $('#home-manufacturers').carouselcus({ 
            loop: true ,
            dispItems: 5,
            equalWidths:false, 
            autoSlide: true ,
            autoSlideInterval: 8000,
            nextBtn: '<a href="javascript:void(0);">Next</a>',
            prevBtn: '<a href="javascript:void(0);">Previous</a>',
            delayAutoSlide: false,
            animSpeed:800,
            pagination:true,
            effect:"slide"
        });
    });
})(jQuery);
</script>
