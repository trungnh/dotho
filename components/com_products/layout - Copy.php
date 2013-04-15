    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
        <script type="text/javascript">
    $(function() {
        $('#gallery a').lightBox();
    });
    </script>
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
	$soluong=$objproduct->Quantity - $objproduct->Quantity_buy;
	//$marid=$objproduct->MartID;
	//$strwhere="AND `mart_id`='$marid' AND `pro_id` not in('$id')";
?>
<div class="pro-detail mod-pro box-module clearfix">
<?php 
 $imgs=explode(",",$objproduct->Images); 
   $n = count($imgs)-1; ?>
   <div class="box_imgdetail">
        <div class="imgdetail">
            <img src="<?php echo $imgs[0]; ?>" alt="<?php $imgs[0] ?>" /> </div> 
                <?php
				   echo' <div id="gallery">
							<ul>';
							for($i=1;$i<$n; $i++)
								 {
							   echo ' <li>
											<a href="'.$imgs[$i].'" title="'.$objproduct->Name.'">
												<img src="'.$imgs[$i].'" width="72" height="72" alt="" />
											</a>
									 </li> '; 
								 }
						   echo ' </ul>
						</div>';
                 ?>
       </div> 
    <div class="box-pro-detail">
		<?php 
    $today = date("Y-m-d");
    $another_date = $objproduct->End_date;
?>
		<h4 class="news_title"><?php echo $objproduct->Name;?></h4>
		<?php if( $objproduct->Sales_price!=0 && $objproduct->Sales_price!=10 && strtotime($today) < strtotime($another_date) ) {?>
		<p style="font-weight: bold; margin: 10px 0 0 0;">Giá cũ: <span style="text-decoration: line-through; color: #919191; font-weight: normal;"><?php echo number_format($objproduct->Old_price); ?></span>&nbsp;₫</p>
		<p style="font-weight: bold; margin: 5px 0 5px 0;">Giá mới: <?php echo number_format($objproduct->Cur_price); ?>&nbsp;₫ (-<?php echo $objproduct->Sales_price; ?>%)</p>
		<?php } else { ?>
		<p style="font-weight: bold; margin: 5px 0 5px 0;">Giá: <?php echo number_format($objproduct->Cur_price); ?>&nbsp;₫</p>
		<?php }	 ?>
		<p style="font-weight: bold; margin: 5px 0 5px 0;">Tình trạng: <span><?php if($soluong>0) echo "Còn hàng"; else echo "Hết hàng";  ?></span></p>
		<p style="font-weight: bold; margin: 5px 0 5px 0;">Vận chuyển: <span>Liên hệ</span></p>
		<a onclick="openBoxAddPro('components/com_cart/tem/add2cart.php?ItemID=<?php echo $id; ?>&amp;Title=<?php echo $objproduct->Name; ?>')" href="#" class="addcart"><span> Mua hàng</span></a>
	</div>
    <div class="content" style=" clear: both; margin: 15px 0;">
		<h3><span class="title">Chi tiết sản phẩm</span></h3>
		<div class="infor-detail"><?php echo $objproduct->Intro; ?></div>
	</div>
</div>
<?php $this->loadModule("user3");?> 