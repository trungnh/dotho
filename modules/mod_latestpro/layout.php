<?php include("helper.php");
$theme = 'default';
if($objmodule->Theme!='') $theme = $objmodule->Theme;
 include(MOD_PATH."mod_latestpro/brow/".$theme.".php");
unset($objmodule);?>