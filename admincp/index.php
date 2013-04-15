<?php
session_start();
// include config
define("incl_path","../includes/");
define("libs_path","libs/");
require_once(incl_path."gfconfig.php");
require_once(incl_path."gfinnit.php");
require_once(incl_path."gffunction.php");
// include libs
require_once(libs_path."cls.data.php");
require_once(libs_path."cls.component.php");
require_once(libs_path."cls.category.php");
require_once(libs_path."cls.general.php");
require_once(libs_path."cls.template.php");
require_once(libs_path."cls.tem.php");
require_once(libs_path."cls.menu.php");
require_once(libs_path."cls.menuitem.php");
require_once(libs_path."cls.category.php");
require_once(libs_path."cls.language.php");
require_once(libs_path."cls.module.php");
require_once(libs_path."cls.content.php");
require_once(libs_path."cls.configsite.php");
require_once(libs_path."cls.users.php");
require_once(libs_path."cls.log_login.php");
require_once(libs_path."cls.product.php");
require_once(libs_path."cls.catalogs.php");
//require_once(libs_path."cls.order.php");
require_once(libs_path."cls.comment.php");


require_once(libs_path."cls.product.php");
require_once(libs_path."cls.images.php");
require_once(libs_path."cls.property.php");
require_once(libs_path."cls.event.php");
require_once(libs_path."cls.event_detail.php");
require_once("includes/simple_html_dom.php");
// include language
$tmp=new CLS_TEMPLATE();
$tmp->Load_defaul_tem('admin');
$tmp->Load_lang_default();
$tmp->Load_Extension();
$this_tem_path=TEM_PATH.$tmp->Name."/";
// Define this template path
$UserLogin=new CLS_USERS();
define("ISHOME",true);
define("THIS_TEM_ADMIN_PATH",$this_tem_path);

// Getinfo
$tmp->WapperTem();
?>