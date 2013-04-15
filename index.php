<?php
session_start();
// include config
define("incl_path","includes/");
define("libs_path","libs/");

require_once(incl_path."simple_html_dom.php");
require_once(incl_path."gfconfig.php");
require_once(incl_path."gfinnit.php");
require_once(incl_path."gffunction.php");
// include libs
require_once(libs_path."innit_libs.php");
// include language

//include_once("libs/cls.configsite.php");
$conf = new CLS_CONFIG();
if(!isset($objdata)) $ojbdata = new CLS_MYSQL();
	 
	$objdata = $conf->show(); //print_r $result; die;
	$r = $objdata->FetchArray();

	define("WEBTITLE",stripslashes($r["title"]));
	define("WEBDESC",stripslashes($r["meta_descript"]));
	define("WEBKEYWORDS",stripslashes($r["meta_keyword"]));
	define("FAX",stripslashes($r["fax"]));
	define("PHONE",stripslashes($r["phone"]));
	
	define("EMAILCONTACT",$r["email"]);
	define("LOGO",stripslashes($r["logo"]));
	define("NICKYAHOO",stripslashes($r["nick_yahoo"]));
	define("NAMEYAHOO",stripslashes($r["name_yahoo"]));
	
	define("CONTACT",stripslashes($r["contact"]));
	define("FOOTER",stripslashes($r["footer"]));
	
	unset($objdata);
unset($conf);
$UserLogin=new CLS_USERS();

$tmp=new CLS_TEMPLATE();
$tmp->Load_defaul_tem('site');
$this_tem_path=TEM_PATH.$tmp->Name."/";
// Define this template path
define("THIS_TEM_PATH",$this_tem_path);
$tmp->WapperTem();
?>