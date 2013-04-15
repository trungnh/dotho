<?php include("helper.php");
$theme = 'default';
if($objmodule->Theme!='') 
$theme = $objmodule->Theme;
?>
<div class="module module-<?php echo $objmodule->Class;?>">
	<?php if($objmodule->ViewTitle==1){?>
	<h3><span><?php echo $objmodule->Title;?></span></h3>
    <?php } 
 include(MOD_PATH."mod_html/brow/".$theme.".php");
unset($objmodule);?>
</div>