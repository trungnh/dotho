<form name="frmMain" class="search-form" action="danhmuc-sanpham.html" method="post">
	<?php unset($_SESSION["PRICE_PRO"]); ?>
    <div class="nav-category">
		<h4>Danh mục sản phẩm</h4>						
	</div>
	<div class="box-form-search">
		<div class="text-search">
			<span class="pre-search">Tìm kiếm</span>
			<div id="box-textarea-search" class="textarea-search">
				<a id="change_key_Status" onclick="changeKeyboard('keyStatus')" href="javascript:void(0);">
					<img src="<?php echo WEBSITE; ?>image/vn.png" id="keyStatus" class="searchLeftOn" border="0" height="14" width="15">
				</a>
				<input id="input_searchword" name="txtsearchpro" value="Nhập từ khóa tìm kiếm" class="input-text ac_input" autocomplete="off" onfocus="if(this.value='Nhập từ khóa tìm kiếm') this.value=''" onblur="if(!this.value) this.value='Nhập từ khóa tìm kiếm'" type="text">
				<a class="button-s" href="#" id="submit" onclick="document.frmMain.submit(); return false;">
				</a>                                        
			</div>
		</div>                    
	</div>
	<script language="javascript">
		function changeKeyboard(id) {
			if (document.getElementById(id).className == "searchLeftOff"){
				//setMethod(1);
				Mudim.SetMethod(2);
				document.getElementById(id).className = "searchLeftOn";
				document.getElementById(id).setAttribute('src', "<?php echo WEBSITE.THIS_TEM_PATH; ?>images/vn.png")
			}
			else{
				//setMethod(-1);
				Mudim.SetMethod(0);
				document.getElementById(id).className = "searchLeftOff";
				document.getElementById(id).setAttribute('src', "<?php echo WEBSITE.THIS_TEM_PATH; ?>images/en.png")
			}
			return true;
		}
	</script>
	<?php 
		$cart_num=0;
		if(isset($_SESSION["PROIDS"])){
			//echo $_SESSION["PROIDS"];
			$arr = explode(",",$_SESSION["PROIDS"]);
			$cart_num= count($arr)-1;
			//echo $cart_num;
		}
	?>
	<div class="box-button-search"  id="shopcart">
		<a href="viewcart.html" class="btn btn-cart">
			<i class="nicon-cart"></i>
			Giỏ hàng (<span class="amount-cart"><?php echo $cart_num; ?></span>)
		</a>
	</div>
</form>  