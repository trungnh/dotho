<?php include("helper.php");
$theme = 'brow1';
if($objmodule->Theme!='') 
$theme = $objmodule->Theme;
?>
<div class="module module-<?php echo $objmodule->Class;?>">
	<?php if($objmodule->ViewTitle==1){?>
	<h3><span><?php echo $objmodule->Title;?></span></h3>
    <?php } ?>
<?php include(MOD_PATH."mod_catalog/brow/".$theme.".php"); ?>
<?php unset($objmodule);?>
</div>