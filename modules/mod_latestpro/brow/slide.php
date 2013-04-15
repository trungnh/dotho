<div class="module <?php echo $objmodule->Class; ?>">
<?php
if($objmodule->ViewTitle==1)
	{
		echo '<span class="title">'.$objmodule->Title.'</span>';
	}
	$i=0; $style="";
	?>
<div class="box_items clearfix"><?php
$objcatalog=new CLS_PRODUCTS();
$objcatalog->showProNew_Is_Can(" AND `is_can`= 1 ");
?>
</div>
</div>