<script type="text/javascript" src="js/cloud-zoom.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo THIS_TEM_PATH; ?>css/cloud-zoom.css">
<script type="text/javascript" src="js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo THIS_TEM_PATH; ?>css/colorbox.css">
 <?php
    if(!isset($objproduct))
	$objproduct = new CLS_PRODUCTS();
	$id=""; 
	if(!isset($_SESSION["PRODUCT"]))
	$_SESSION["PRODUCT"]=$_GET["ItemID"];
	else
	$_SESSION["PRODUCT"].=",".$_GET["ItemID"];
	if(isset($_GET["ItemID"]));
		$id=$_GET["ItemID"];
	//$objproduct->UpdateStatic($id);
	$objproduct->getProByID($id);
	//$marid=$objproduct->MartID;
	//$strwhere="AND `mart_id`='$marid' AND `pro_id` not in('$id')";
	if($objproduct->Quantity > 0)
		$static="Còn hàng";
	else
		$static="Hết hàng";
	if($objproduct->Cur_price < $objproduct->Old_price && $objproduct->Old_price!=0)
	{
		$giamtru=100-(((int)$objproduct->Cur_price / (int)$objproduct->Old_price)*100);
		$sales='<div class="promotion-list"><span>-'.round($giamtru).'%</span></div>';
		$gia='
			<p class="old-price">
				<span class="price-label">Giá cũ<span class="twodot">:</span></span>
				<span id="old-price-new" class="price">'.number_format($objproduct->Old_price).'&nbsp;₫</span>
			</p>
			<p class="special-price">
				<span class="price-label">Giá mới<span class="twodot">:</span></span>
				<span id="product-price-new" class="price">'.number_format($objproduct->Cur_price).'&nbsp;₫<span class="price-discount"> (-'.round($giamtru).'%)</span></span>
				<span class="VAT-label"> (VAT: +10%)</span>
			</p>';
	}
	else
	{
		$sales="";
		$gia='
			<span class="regular-price" id="product-price-new">
			<span class="price">'.number_format($objproduct->Cur_price).'&nbsp;₫</span></span>
			<span class="VAT-label"> (VAT: +10%)</span>';
                if(number_format($objproduct->Cur_price)==0) 
                    $gia = '<span class="regular-price" id="product-price-new">
                        <span class="price">Giá: Liên hệ</span></span>';
	}
?>
<div style="overflow: visible;" class="col-main">                       
	<div class="product-view">
		<div class="product-essential">
				<div class="no-display">
					<input name="product" value="4010" id="current-product" type="hidden">
					<input name="related_product" id="related-products-field" value="" type="hidden">
					<input name="only_add_related" value="0" id="only-add-related" type="hidden">
				</div>
				<div style="width: 659px;" class="product-shop">
					<!--addToBox add to cart-->
					<div id="addtoCart-wrapper">
						<div id="product-shop-view-addtoCart">
							<div class="add-to-box">
								<div class="add-to-cart">
									<div id="qty">
										<p class="label"><span> <label for="qty">Số lượng:</label></span></p>
										<div id="qty-input-div">
											<select name="qty" class="input-text" id="qty_input">
												<option selected="selected" value="1" title="Số lượng">1</option>
											</select>
										</div>
									</div>
									<div class="link-add-cart" id="Buynow">
										<a title="Click mua ngay" onclick="onlyCurrentProduct();buyNow();productAddToCartForm.submit(this)"><span>Mua ngay</span> </a>
									</div>
									<p class="label" id="label-or"><span class="or">Hoặc</span></p>
									<div class="link-add-cart " id="add-to-cart">
										<a onclick="openBoxAddPro('components/com_cart/tem/add2cart.php?ItemID=<?php echo $id; ?>&amp;Title=<?php echo $objproduct->Name; ?>')" href="#"><span>Cho vào giỏ hàng</span></a>
										
									</div>
									<div class="link-login-register">
										<a href="index.php?com=user">Đăng nhập</a> hoặc <a href="index.php?com=user">Đăng ký</a> để mua hàng thuận tiện và nhiều ưu đãi hơn                                    
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--EndaddToBox add to cart-->
					<div style="width: 425px;" id="product-shop-view-content">
						<div class="product-name">
							<h1><?php echo $objproduct->Name; ?></h1>
						</div>
						<div id="product-shop-view-detail">
							<div class="price-box">
								<?php echo $gia; ?>
							</div>
							<p class="availability in-stock">
								<span class="label-attribute">Tình trạng </span><span class="value-attribute">:&nbsp;&nbsp;&nbsp;<?php echo $static; ?></span>
							</p>
							<p><span class="label-attribute">Chất lượng </span><span class="value-attribute">:&nbsp;&nbsp;&nbsp;Mới</span></p>
							<p><span class="label-attribute">Nguồn hàng </span><span class="value-attribute">:&nbsp;&nbsp;&nbsp;Hàng công ty </span></p>
							<p><span class="label-attribute">Vận chuyển </span><span class="value-attribute">:&nbsp;&nbsp;&nbsp;Liên hệ</span></p>
							<div class="infor-teech">
								<a class="link-inforteech" href="#" onclick="auto_scroll('.box-additional')"> Thông số kỹ thuật</a> 
							</div>
							<script type="text/javascript">
								function auto_scroll(anchor) {
									var target = jQuery(anchor);
									target = target.length && target || jQuery('[name=' + anchor.slice(1) + ']');
									if (target.length) {
										var targetOffset = target.offset().top;
										jQuery('html,body').animate({scrollTop: targetOffset},10);
										return false;
									}
								}
							</script> 
							<div class="short-description contact " style="padding-top:20px;padding-bottom: 0px;">                                                        
								<p>
									Hỗ trợ trực tuyến:
									<a href="ymsgr:SendIM?banhang_nhanh"><img src="images/yahoo.png"></a>
									<a href="skype:huongntl_nhanh?chat"><img src="images/skype.png"></a>
									&nbsp;&nbsp;&nbsp;&nbsp;
								   
									&nbsp;&nbsp;&nbsp;&nbsp;
									<img src="images/email.gif">&nbsp;
									<span class="email-information">
									Email:<a href="mailto:nhanhhcm@nhanh.vn" class="information">nhanhhcm@nhanh.vn</a></span>
								</p>
																						
								<p>
									<img src="images/icon_phone.png" height="13px" width="16px">&nbsp;
									Điện thoại: <span class="information">08.3849.7899 - 08.3849.6863 - Hotline: 0937.863.889 </span>
								</p>						 
							</div>                                        
							<div class="clear"></div>
						</div>
					</div>
				</div>
												<!--Image-->
			<?php if(!isset($objimage)) 
				$objimage=new CLS_IMAGES();
				$objimage->getAllList("`pro_id` = $id ");
				if($objimage->Numrows()>0)
				{
			?>
				<div class="product-img-box">
					<p class="product-image">
						<?php $objimage->listFristPro("`pro_id` = $id "); ?>
						<a class="pre-zoom" href="javascript:void(0);"></a>
						<a class="next-zoom" href="javascript:void(0);"></a>
					</p>
					<?php $objimage->listTablePro("`pro_id` = $id "); ?>
					<script type="text/javascript">
						jQuery(function(){
							jQuery("div.mor-image-control").carousel({ loop: true , dispItems: 5, animSpeed: 300, nextBtn: '<a href="javascript:void(0);"></a>', prevBtn:'<a href="javascript:void(0);"></a>' });
							jQuery("a[rel='productlist']").colorbox({slideshow:false});
						});
					</script>
				</div>
			<?php } ?>
				<div class="clearer"></div>
		</div>
		<!--Detail info-->
		<div class="product-collateral">
			<div class="tab-header-menu">
				<ul class="tabmenu" style="display:inline">
					<li class="active">
						<a href="javascript:void(0);" id="tab-product-detail" class="active" title="chi tiết sản phẩm">
							<span>Chi tiết sản phẩm</span>
						</a>
					</li>
				</ul>
			</div>
			<div class="line-header"></div>

			<div class="tab-content" id="content-tab-product-detail" style="clear:both;padding-top: 10px; width:100%;">
				<div class="std">
					<?php echo $objproduct->Intro; ?>
					<p style="text-align: center;">
						<span style="color: #800000; font-size: medium;"><strong><em><br></em></strong></span>
					</p>
					<div><span style="font-size: medium;"><br></span></div>    
				</div>
			</div>
						
			<script type="text/javascript">
				jQuery(function() {
					jQuery('.all-vendors').click(function(){
						hideAllMenu();
						jQuery('#tab-other-vendors').parent().addClass('active');
						jQuery('#tab-other-vendors').addClass('active');
						jQuery('#content-tab-other-vendors').show();
					});
					jQuery('.tabmenu li a').each(function(){
						jQuery(this).click(function(event){
						  event.preventDefault();
						  hideAllMenu();
						  jQuery(this).parent().addClass('active');
						  jQuery(this).addClass('active');
						  jQuery('#content-'+jQuery(this).attr('id')).show();
						})
					});
					function hideAllMenu(){
						jQuery('.tabmenu li a').each(function(){
							jQuery(this).removeClass('active');
							jQuery(this).parent().removeClass('active');
							jQuery('#content-'+jQuery(this).attr('id')).hide();
						})
					}
				});
			</script>
			<?php if(!isset($objproperty))
				$objproperty= new CLS_PROPERTY();
				$objproperty->getAllList("`product_id` = $id ");
				if($objproperty->Numrows()>0)
				{
			?>
				<div class="box-collateral box-additional">
					<h2>Thông số kỹ thuật</h2>
					<table class="data-table" id="product-attribute-specs-table" cellpadding="0" cellspacing="0">
						<colgroup><col width="25%"><col></colgroup>
						<tbody>
							<tr class="first odd">
								<th class="label">Tên sản phẩm</th>
								<td class="data last"><?php echo $objproduct->Name;  ?></td>
							</tr>
							<?php $objproperty->listTablePro("`product_id` = $id "); ?>
						</tbody>
					</table>
					<script type="text/javascript">decorateTable('product-attribute-specs-table')</script>
				</div>
			<?php } ?>				
			<div class="box-collateral box-reviews" id="customer-reviews"></div>
		</div>
		<!--End Detail info-->
	</div>	
</div>