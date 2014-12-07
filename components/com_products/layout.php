<script type="text/javascript" src="<?php echo WEBSITE; ?>js/cloud-zoom.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE.THIS_TEM_PATH; ?>css/colorbox.css">
<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE.THIS_TEM_PATH; ?>css/cloud-zoom.css">
<div id="catdown">
<?php $this->loadModule("top"); ?>
</div>
<div class="breadcrumbs">
	<div class="bread-left"></div>
    <ul>
    <?php
		if(!isset($objproduct))
		$objproduct = new CLS_PRODUCTS();
		$item=$_GET["ItemID"];
		$objproduct->getProByID($item);
		if($objproduct->Numrows()<0)
		echo "<script language=\"javascript\">window.location='index.php'</script>";
		if(!isset($objcata))
		$objcata=new CLS_CATALOG();
		$objcata->getCatalogByID($objproduct->CataID);
		$name1=$objcata->Name;
		$link1=$objcata->ID;
		$objcata->getCatalogByID($objcata->ParID);
		$name2=$objcata->Name;
		$link2=$objcata->ID;
		
	?>
        <li class="category126 item-cat-1">
            <a class="item-link-cat-1" href="<?php echo WEBSITE."danhmuc/".$link2."-".stripUnicode($name2).".html"; ?>"><?php echo $name2; ?></a>
        </li>
        <li class="category126">
            <a title="" class="" href="<?php echo WEBSITE."danhmuc/".$link1."-".stripUnicode($name1).".html"; ?>"><?php echo $name1; ?></a>
        </li>
        <li class="category126">
            <a title="" class="" href="#"> > <?php echo $objproduct->Name; ?></a>
        </li>
	</ul>
    <div class="bread-right"></div>
</div>
 <?php
 //echo $_GET["ItemID"]."<br>";
    if(!isset($objproduct))
	$objproduct = new CLS_PRODUCTS();
	$id=""; 
	if(!isset($_SESSION["PRODUCT"]))
	$_SESSION["PRODUCT"]=$_GET["ItemID"];
	else
	$_SESSION["PRODUCT"].=",".$_GET["ItemID"];
	if(isset($_GET["ItemID"]));
		$id=$_GET["ItemID"];
	$objproduct->UpdateStatic($id);
	$objproduct->getProByID($id);
	//$marid=$objproduct->MartID;
	//$strwhere="AND `mart_id`='$marid' AND `pro_id` not in('$id')";
	if($objproduct->Quantity > 0)
		$static="Còn hàng";
	else
		$static="Hết hàng";
	if($objproduct->Cur_price < $objproduct->Old_price && $objproduct->Old_price!=0)
	{
		$giamtru=$objproduct->Sale;
		$sales='<div class="promotion-list"><span>-'.$giamtru.'%</span></div>';
		$gia='
			<p class="old-price">
				<span class="price-label">Giá cũ<span class="twodot">:</span></span>
				<span id="old-price-new" class="price">'.number_format($objproduct->Old_price).'&nbsp;₫</span>
			</p>
			<p class="special-price">
				<span class="price-label">Giá mới<span class="twodot">:</span></span>
				<span id="product-price-new" class="price">'.number_format($objproduct->Cur_price).'&nbsp;₫<span class="price-discount"> (-'.$giamtru.'%)</span></span>
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
		<div class="product-essential clearfix">
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
				</div>
			<?php } ?>
				<div style="width: 610px;" class="product-shop">
					<div id="addtoCart-wrapper">
						<div id="product-shop-view-addtoCart">
							<div class="add-to-box">
								<div class="add-to-cart">
									<div class="link-add-cart " id="add-to-cart">
										<a onclick="openBoxAddPro('<?php echo WEBSITE; ?>components/com_cart/tem/add2cart.php?ItemID=<?php echo $id; ?>&amp;Title=<?php echo $objproduct->Name; ?>')" href="#"><span>Cho vào giỏ hàng</span></a>
									</div>
									<div class="link-login-register">
										<a href="<?php echo WEBSITE; ?>login.html">Đăng nhập</a> hoặc <a href="<?php echo WEBSITE; ?>register.html">Đăng ký</a> để mua hàng thuận tiện và nhiều ưu đãi hơn                                    
									</div>
								</div>
							</div>
						</div>
					</div>
					<div style="width: 390px;" id="product-shop-view-content" class="clearfix">
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
									<a href="mailto:khanhhungdj@gmail.com" title="Mua hàng"><img src="<?php echo WEBSITE; ?>images/email.gif" alt="Mua hàng" /></a>
					
									
								</p>
								<span class="email-information">
									Email:<a href="mailto:muahang@tienichgiadinh.vn">khanhhungdj@gmail.com</a></span>
								<p>
									<img src="<?php echo WEBSITE; ?>images/icon_phone.png" height="13px" width="16px" />&nbsp;
									Điện thoại: <span class="">Hotline: 0986.957.881 </span>
								</p>
								<div>                                                        	
									<div class="clear"></div>
								</div>						 
							</div>                                        
							<div class="clear"></div>
						</div>
					</div>
				</div>
				<div class="clearer"></div>
		</div>
		<div class="product-collateral">
			<div class="tab-header-menu">
				<ul class="tabmenu" style="display:inline">
					<li class="active">
						<a href="javascript:void(0);" id="tab-product-detail" class="active">
							<span>Chi tiết sản phẩm</span>
						</a>
					</li>
				</ul>
			</div>
			<div class="line-header"></div>

			<div class="tab-content" id="content-tab-product-detail" style="clear:both;padding-top: 10px; width:900px; margin: 0 auto;">
				<div class="std">
					<?php echo $objproduct->Intro; ?>
				</div>
			</div>
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
				</div>
			<?php } ?>				
			<div class="box-collateral box-reviews" id="customer-reviews"></div>
		</div>
	</div>	
</div>
