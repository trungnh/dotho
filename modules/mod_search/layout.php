<?php include("helper.php");
$theme = 'brow1';
if($objmodule->Theme!='') 
$theme = $objmodule->Theme;
?>
	<?php if($objmodule->ViewTitle==1){?>
	<h3><span><?php echo $objmodule->Title;?></span></h3>
    
        <?php } include(MOD_PATH."mod_search/brow/".$theme.".php"); ?>
<?php unset($objmodule);?>