<div class="module box-module clearfix <?php echo $styletop; ?>">
<?php
if($objmodule->ViewTitle==1)
	{
		echo '<h3><span>'.$objmodule->Title.'</span></h3>';
	}
	$i=0; $style="";
	?>
<div class="box_items clearfix"><?php
$objcatalog=new CLS_PRODUCTS();
$objcatalog->showProNew_home(" ORDER BY pro_id DESC ",13,3);
?>
</div>
</div>