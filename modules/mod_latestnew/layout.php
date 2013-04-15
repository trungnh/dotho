<?php include("helper.php");
$theme = 'default';
if($objmodule->Theme!='') $theme = $objmodule->Theme;
 include_once(MOD_PATH."mod_latestnew/brow/".$theme.".php");
unset($objmodule);?>