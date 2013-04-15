<?php include("helper.php");
$theme = 'brow1';
if($objmodule->Theme!='') 
$theme = $objmodule->Theme;
?>
<div class="module<?php echo " ".$objmodule->Class;?>">
	<?php if($objmodule->ViewTitle==1){?>
	<h2 class="title"><?php echo $objmodule->Title;?></h2>
    <?php }?>
    <div class="content">
        <?php include(MOD_PATH."mod_mainmenu/brow/".$theme.".php"); ?>
    </div>
</div>
<?php unset($objmodule);?>