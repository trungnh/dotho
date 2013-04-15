<h3>Xem theo giá</h3>
<?php
	$price_pro="all";
	if(isset($_SESSION["PRICE_PRO"]))
		$price_pro=$_SESSION["PRICE_PRO"];
?>
<form name="frm_searchpice"  method="post" action="<?php echo WEBSITE; ?>danhmuc-sanpham.html">
	<select name="cbo_price" id="cbo_price" onchange="document.frm_searchpice.submit();">
		<option value="all">Chọn khoảng giá</option>
		<option value="50000-1000000">50,000 - 1,000,000</option>
		<option value="1000000-5000000">1000,000 - 5,000,000</option>
		<option value="5000000-10000000">5,000,000 - 10,000,000</option>
		<option value="10000000-30000000">10,000,000 - 30,000,000</option>
	</select>
	<script language="javascript">
		cbo_Selected('cbo_price','<?php echo $price_pro;?>');
	</script>
	<input type="submit" name="btnsearch_price" style="display: none;" />
</form>