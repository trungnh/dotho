<?php
$mess =''; $message_box =''; $message_icon='';
if(isset($_GET["mess"])) $mess = $_GET["mess"];
if(!isset($obj_laglang)) $obj_laglang=new LANG_LANGUAGE;

switch($mess) {
	case 'A01': $message_box=$obj_laglang->LANG_A01; $message_icon='ok'; 	break;
	case 'A02': $message_box=$obj_laglang->LANG_A02; $message_icon='error'; break;
	case 'U01': $message_box=$obj_laglang->LANG_U01; $message_icon='ok'; 	break;
	case 'U02': $message_box=$obj_laglang->LANG_U02; $message_icon='error'; break;
	case 'U03': $message_box=$obj_laglang->LANG_U03; $message_icon='error'; break;
	case 'D01': $message_box=$obj_laglang->LANG_D01; $message_icon='ok'; 	break;
	case 'D02': $message_box=$obj_laglang->LANG_D02; $message_icon='error'; break;
	case 'D03': $message_box=$obj_laglang->LANG_D03; $message_icon='error'; break;
}
if($message_icon=="ok") {
	$message_img = '<img src="images/publish.png" width="20" align="absmiddle"/> ';
	echo '<div class="message_ok">'.$message_img.$message_box.'</div>';
}
if($message_icon=="error") {
	$message_img = '<img src="images/delete.png" width="20" align="absmiddle"/> ';
	echo '<div class="message_error">'.$message_img.$message_box.'</div>';
}
?>